#include <ZumoMotors.h>
#include <ZumoBuzzer.h>
#include <Pushbutton.h>

ZumoBuzzer buzzer;
ZumoMotors motors;
Pushbutton button(ZUMO_BUTTON);

int DELAY, STATE = 0;
long PREVIOUS_MILLIS;

void setup(){
	pinMode(2, INPUT); // set tilt antenna
	button.waitForButton();
}


void loop(){
	switch(STATE){
		// TILTED CASE
		case -1 :
			buzzer.play(">g32>>c32");
			motors.setSpeeds(100, -100);
			DELAY = 2000;
			break;

		case 0 :
			motors.setSpeeds(400, 400);
			DELAY = 2000;
			break;

		// LOOP WHEN STATE++ > DEFINED CASES
		default:
			STATE = 0;
			break;
	}

	update_timer();
}

void update_timer(){
	if(millis() - PREVIOUS_MILLIS > DELAY){
		PREVIOUS_MILLIS = millis();
		STATE++;
	}

	if(tilted()) STATE = -1;
}


boolean tilted(){
	return (digitalRead(2) == LOW);
}