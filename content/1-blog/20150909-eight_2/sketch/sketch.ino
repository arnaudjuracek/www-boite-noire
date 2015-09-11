#include <ZumoMotors.h>
#include <ZumoBuzzer.h>
#include <Pushbutton.h>

#define SPEED          400

ZumoBuzzer buzzer;
ZumoMotors motors;
Pushbutton button(ZUMO_BUTTON);

boolean is_running = false;

void setup(){
	buzzer.play(">g32>>c32");
	while(buzzer.isPlaying());
}


void loop(){
	if(is_running){
		for(int i=0; i<10; i++){
			motors.setSpeeds(SPEED, 0);
			delay(2000);
			motors.setSpeeds(0, SPEED);
			delay(2000);
		}
		is_running = false;
	}else{
		// arrête toi !
		motors.setSpeeds(0, 0);
		button.waitForButton();
		buzzer.play(">g32>>c32");
		is_running = true;
	}
}