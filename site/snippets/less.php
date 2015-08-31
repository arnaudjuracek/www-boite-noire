<?php

/**
* Less snippet
*
* @author    Bart van de Biezen <bart@bartvandebiezen.com>
* @link      https://github.com/bartvandebiezen/kirby-v2-lessphp
* @return    CSS and HTML
* @version   1.0
*/

// Using 'realpath' seems to work best in different situations.
$root = realpath(__DIR__ . "/../..");

// Your final CSS file.
$compiledFile = $root . "/assets/css/style.css";

// lister les fichiers LESS
$sourceFiles = glob($root . '/assets/less/*.less');

$moreRecent = false;
foreach( $sourceFiles as $sourceFile) {
	if( !file_exists($compiledFile) or filemtime($sourceFile) > filemtime($compiledFile))	{
		$moreRecent = true;
	}
}

if ( $moreRecent) {

	// Set compression provided by library.
	$options = array('compress'=>true);

	// Activate library.
	require "site/plugins/lessphp/Less.php";
	$parser = new Less_Parser($options);

	// Compile content in buffer
	$parser->parseFile($sourceFile);
	$buffer = $parser->getCss();

	// Remove all CSS comments.
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

	// Remove lines and tabs.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $buffer);

	// Remove unnecessary spaces.
	$buffer = preg_replace('!\s+!', ' ', $buffer);
	$buffer = str_replace(': ', ':', $buffer);
	$buffer = str_replace('} ', '}', $buffer);
	$buffer = str_replace('{ ', '{', $buffer);
	$buffer = str_replace('; ', ';', $buffer);
	$buffer = str_replace(', ', ',', $buffer);
	$buffer = str_replace(' }', '}', $buffer);
	$buffer = str_replace(' {', '{', $buffer);
	$buffer = str_replace(' )', ')', $buffer);
	$buffer = str_replace(' (', '(', $buffer);
// 		$buffer = str_replace(') ', ')', $buffer);
	$buffer = str_replace('( ', '(', $buffer);
	$buffer = str_replace(' ;', ';', $buffer);
	$buffer = str_replace(' ,', ',', $buffer);

	// Fix spacing in media queries.
	$buffer = str_replace('and(', 'and (', $buffer);
	$buffer = str_replace(')and', ') and', $buffer);

	// Remove last semi-colon within a CSS rule.
	$buffer = str_replace(';}', '}', $buffer);

	// Update your CSS file.
	file_put_contents($compiledFile, $buffer);
} ?>
<link rel="stylesheet" href="<?php echo url('assets/css/style.css') ?>">

