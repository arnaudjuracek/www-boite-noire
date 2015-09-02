<?php


/**
 * IFTTT BOT plugin
 * v 0.1
 * c::set('routes', array(
 *   array(
 *       'pattern' => 'bot/add/',
 *       'action'  => function() {
 *
 *       }
 *   ),
 * ));
 *
 */

function create_post($page, $blueprint, $data){
	$PATH = get_content_path($page);
	$SLUG = str::slug($data["title"]);

	$dir = $PATH . DS . $SLUG;
	$dir_matches = glob($PATH . DS . "*" . $SLUG . "*");

	if(count($dir_matches) > 0){
		$dir .= "_" . count($dir_matches);
		$data['title'] .= "_" . count($dir_matches);
	}

	mkdir($dir, 0777, true);

	$filename = $blueprint . ".fr.txt";

	$file = fopen($dir . DS . $filename, 'w');
	if(flock($file, LOCK_EX)) {
		fwrite($file, parse_data(get_blueprint($blueprint), $data));
		flock($file, LOCK_EX);
	}
	fclose($file);
}

function parse_data($blueprint, $data){
	$separator = "\n\n----\n\n";

	$output = "";
	foreach($blueprint['fields'] as $key => $value){
		$output .= $separator;
		$output .= ucfirst($key) . ": " . $data[$key];
	}

	$output = trim($output, $separator);

	return $output;
}


function get_content_path($page){
	$path = kirby()->roots()->content() . DS;
	$dir = glob($path . "*" . $page);

	if(count($dir)==1) return $dir[0];
	else return false;
}


function get_blueprint_path($blueprint){
	$path = kirby()->roots->blueprints() . DS;
	$file = glob($path . $blueprint . '.php');

	if(count($file)==1) return $file[0];
	else return false;
}

function get_blueprint($blueprint){
	$file = get_blueprint_path($blueprint);

	if($file) return yaml::read($file);
	else return false;
}