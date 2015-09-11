#include <ZumoMotors.h>
#include <ZumoBuzzer.h>
#include <Pushbutton.h>

#define SPEED          400
#define ANGLE_INTERVAL 20

ZumoBuzzer buzzer;
ZumoMotors motors;
Pushbutton button(ZUMO_BUTTON);

boolean is_running = false;
boolean invert = false;

int s_left = 0;
int s_right = 0;
int n_turns = 20;
float n_pressed = 0;


void setup(){
	buzzer.play(">g32>>c32");
	while(buzzer.isPlaying());
}


void loop(){
	if(is_running){
		if(n_turns>40 - n_pressed) is_running = false;

		if(!invert){
			s_left -= n_turns;
			s_right += n_turns;
		}else{
			s_left += n_turns;
			s_right -=n_turns;
		}

		motors.setSpeeds(s_left, s_right);

		if(s_left<0 || s_right>SPEED){
			invert = true;
			n_turns++;
		}
		if(s_right<0 || s_left>SPEED) invert = false;
	}else{

		// arrête toi !
		motors.setSpeeds(0, 0);
		button.waitForButton();
		buzzer.play(">g32>>c32");

		is_running = true;
		s_left = SPEED;
		s_right = 0;
		n_turns = 10;
		n_pressed += .5;
	}
	delay(5);
}