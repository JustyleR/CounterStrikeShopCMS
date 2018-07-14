<?php
/*
	BBCodes Library
	Some simple functions to convert tags into html tags
*/


// Convert tags into html tags
function bbcode_preview($text) {
	
	$find = array(
		'/\[b\](.+?)\[\/b\]/is',
		'/\[i\](.+?)\[\/i\]/is',
		'/\[small\](.+?)\[\/small\]/is',
		'/\[font\=(.+?)\](.+?)\[\/font\]/is',
		'/\[url=(.+?)\](.+?)\[\/url\]/',
		'/\\\\n/',
		'/\\\\r/'
	);
	
	$replace = array(
		'<strong>$1</strong>',
		'<i>$1</i>',
		'<small>$1</small>',
		'<font color="$1">$2</font>',
		'<a href="\1">\2</a>',
		'<br />',
		''
	);
	
	$text = preg_replace($find, $replace, $text);
	return $text;
}

// Fix the new line
function bbcode_brFix($text) {
	$text = str_replace('\r', '', $text);
	$text = str_replace('\n', PHP_EOL, $text);
	$text = str_replace('<br />', PHP_EOL, $text);
	return $text;
}

// After saving the next make the new line into <br /> tag
function bbcode_save($text) {
	$text = str_replace('\r', '', $text);
	$text = str_replace('\n', '<br />', $text);
	return $text;
}