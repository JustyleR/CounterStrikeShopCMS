<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('homeText');
}

// Main function
function main($conn) {
	
	$content = template($conn, 'admin/homeText');
	$content = showText($conn, $content);
	$content = homeText($conn, $content);
	
	echo $content;
}

function showText($conn, $content) {
	
	$query = query($conn, "SELECT home FROM sms_text");
	if(num_rows($query) > 0) {
		
		$content = str_replace('{INFO_TEXT}', bbcode_brFix(fetch_assoc($query)['home']), $content);
		
	}
	
	return $content;
}

function homeText($conn, $content) {
	$message = core_message('text');
    if(isset($_POST['edit'])) {
		
		$text = bbcode_save(core_POSTP($conn, $_POST['homeText']));
		
		$get = query($conn, "SELECT home FROM sms_text");
		if(num_rows($get) > 0) {
			
			query($conn, "UPDATE sms_text SET home='". $text ."'");
			
		} else {
			
			query($conn, "INSERT INTO sms_text (home) VALUES ('". $text ."')");
			
		}
		
		core_message_set('text', language($conn, 'messages', 'CHANGES_SAVED'));
		core_header('!admin/homeText');
		
	}
	
	return $content = str_replace('{SHOW_MESSAGE}', $message, $content);
}
