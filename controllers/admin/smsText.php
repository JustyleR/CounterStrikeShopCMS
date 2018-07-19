<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('smsText');
}

// Main function
function main($conn) {
	
	$content = template($conn, 'admin/smsText');
	$content = showText($conn, $content);
	$content = smsText($conn, $content);
	
	echo $content;
}

function showText($conn, $content) {
	
	$query = query($conn, "SELECT text FROM "._table('sms_text')."");
	if(num_rows($query) > 0) {
		
		$content = str_replace('{INFO_TEXT}', bbcode_brFix(fetch_assoc($query)['text']), $content);
		
	}
	
	return $content;
}

function smsText($conn, $content) {
	$message = core_message('smsText');
    if(isset($_POST['edit'])) {
		
		$text = bbcode_save(core_POSTP($conn, $_POST['smsText']));
		
		$get = query($conn, "SELECT text FROM "._table('sms_text')."");
		if(num_rows($get) > 0) {
			
			query($conn, "UPDATE "._table('sms_text')." SET text='". $text ."'");
			
		} else {
			
			query($conn, "INSERT INTO "._table('sms_text')." (text) VALUES ('". $text ."')");
			
		}
		
		core_message_set('text', language($conn, 'messages', 'CHANGES_SAVED'));
		core_header('!admin/smsText');
		
	}
	
	return $content = str_replace('{SHOW_MESSAGE}', $message, $content);
}
