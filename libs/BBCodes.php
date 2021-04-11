<?php

// Simple library for some bbcodes

if (!defined('file_access')) {
    die();
}

function bbcode_preview($text) {

	$find = array(
		'/\[b\](.+?)\[\/b\]/is',
		'/\[i\](.+?)\[\/i\]/is',
		'/\[small\](.+?)\[\/small\]/is',
		'/\[color\=(.+?)\](.+?)\[\/color\]/is',
		'/\[url\=(.+?)\](.+?)\[\/url\]/is',
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

function bbcode_brFix($text) {
	$text = str_replace('\r', '', $text);
	$text = str_replace('\n', PHP_EOL, $text);
	$text = str_replace('<br />', PHP_EOL, $text);
	return $text;
}

function bbcode_save($text) {
	$text = str_replace('\r', '', $text);
	$text = str_replace('\n', '<br />', $text);
	return $text;
}
