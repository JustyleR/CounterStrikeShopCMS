<?php

/*
	Home page
*/

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main($conn) {
    
	if(!isset($_SESSION['user_logged'])) { core_header('login'); }
	
	$content = template($conn, 'home');
	$content = show_site_text($conn, $content);
	
	echo $content;
}

function show_site_text($conn, $content) {
	
	$query	= query($conn, "SELECT * FROM sms_text");
	$text	= bbcode_preview(fetch_assoc($query)['home']);
	
	return str_replace('{HOME_PAGE_TEXT}', $text, $content);
}