#include <ZumoMotors.h>
#include <ZumoBuzzer.h>
#include <Pushbutton.h>
#include <Wire.h>
#include <LSM303.h>


#define SPEED          400
#define ANGLE_INTERVAL 20


#define CALIBRATION_SAMPLES 100  // Number of compass readings to take when calibrating
#define CRB_REG_M_2_5GAUSS 0x60 // CRB_REG_M value for magnetometer +/-2.5 gauss full scale
#define CRA_REG_M_220HZ    0x1C // CRA_REG_M value for magnetometer 220 Hz update rate

// Allowed deviation (in degrees) relative to target angle that must be achieved before driving straight
#define DEVIATION_THRESHOLD 10

ZumoBuzzer buzzer;
ZumoMotors motors;
Pushbutton button(ZUMO_BUTTON);
LSM303 compass;
boolean is_running = false;

// Setup will calibrate our compass by finding maximum/minimum magnetic readings
void setup(){
	buzzer.play(">g32>>c32"); // Play a little welcome song

	COMPASS_calibrate();

	// Play music and wait for it to finish before we start driving.
	buzzer.play(">g32>>c32");
	while(buzzer.isPlaying());
}

void loop(){
	if(is_running){
		// Heading is given in degrees away from the magnetic vector, increasing clockwise
		float heading = averageHeading();

		motors.setSpeeds(SPEED*.25, SPEED*.25);
		delay(500);

		int direction = (heading > 180) ? 1 : -1;
		motors.setSpeeds(direction*SPEED, -direction*SPEED);

		if(heading >= -ANGLE_INTERVAL*.5 && heading <= ANGLE_INTERVAL*.5){
			buzzer.play("L16 cdegreg4");
			motors.setSpeeds(400, 400);
			while(buzzer.isPlaying());

			// randomize function
			motors.setSpeeds(-400, 400);
			delay(random(200, 1000));
			motors.setSpeeds(400, 400);
			delay(300);

			is_running = false;
		}
	}else{
		// arrête toi !
		motors.setSpeeds(0, 0);
		// attendre button pour la reprise de la boucle
		button.waitForButton();
		buzzer.play(">g32>>c32");
		is_running = true;
	}

}


void COMPASS_calibrate(){
	// The highest possible magnetic value to read in any direction is 2047
	// The lowest possible magnetic value to read in any direction is -2047
	LSM303::vector<int16_t> running_min = {32767, 32767, 32767}, running_max = {-32767, -32767, -32767};

	Wire.begin();// Initiate the Wire library and join the I2C bus as a master
	compass.init();// Initiate LSM303
	compass.enableDefault();// Enables accelerometer and magnetometer
	compass.writeReg(LSM303::CRB_REG_M, CRB_REG_M_2_5GAUSS); // +/- 2.5 gauss sensitivity to hopefully avoid overflow problems
	compass.writeReg(LSM303::CRA_REG_M, CRA_REG_M_220HZ);    // 220 Hz compass update rate

	unsigned char index;

	button.waitForButton();


	// To calibrate the magnetometer, the Zumo spins to find the max/min
	// magnetic vectors. This information is used to correct for offsets
	// in the magnetometer data.
	motors.setLeftSpeed(SPEED*.5);
	motors.setRightSpeed(-SPEED*.5);

	for(index = 0; index < CALIBRATION_SAMPLES; index ++){
		// Take a reading of the magnetic vector and store it in compass.m
		compass.read();

		running_min.x = min(running_min.x, compass.m.x);
		running_min.y = min(running_min.y, compass.m.y);

		running_max.x = max(running_max.x, compass.m.x);
		running_max.y = max(running_max.y, compass.m.y);

		delay(50);
	}

	motors.setLeftSpeed(0);
	motors.setRightSpeed(0);

	// Set calibrated values to compass.m_max and compass.m_min
	compass.m_max.x = running_max.x;
	compass.m_max.y = running_max.y;
	compass.m_min.x = running_min.x;
	compass.m_min.y = running_min.y;
}





// Converts x and y components of a vector to a heading in degrees.
// This function is used instead of LSM303::heading() because we don't
// want the acceleration of the Zumo to factor spuriously into the
// tilt compensation that LSM303::heading() performs. This calculation
// assumes that the Zumo is always level.
template <typename T> float heading(LSM303::vector<T> v){
	float x_scaled =  2.0*(float)(v.x - compass.m_min.x) / ( compass.m_max.x - compass.m_min.x) - 1.0;
	float y_scaled =  2.0*(float)(v.y - compass.m_min.y) / (compass.m_max.y - compass.m_min.y) - 1.0;

	float angle = atan2(y_scaled, x_scaled)*180 / M_PI;
	if (angle < 0) angle += 360;
	return angle;
}

// Yields the angle difference in degrees between two headings
float relativeHeading(float heading_from, float heading_to){
	float relative_heading = heading_to - heading_from;

	// constrain to -180 to 180 degree range
	if (relative_heading > 180) relative_heading -= 360;
	if (relative_heading < -180) relative_heading += 360;

	return relative_heading;
}

// Average 10 vectors to get a better measurement and help smooth out
// the motors' magnetic interference.
float averageHeading(){
	LSM303::vector<int32_t> avg = {0, 0, 0};

	for(int i = 0; i < 10; i ++){
		compass.read();
		avg.x += compass.m.x;
		avg.y += compass.m.y;
	}

	avg.x /= 10.0;
	avg.y /= 10.0;

	// avg is the average measure of the magnetic vector.
	return heading(avg);
}