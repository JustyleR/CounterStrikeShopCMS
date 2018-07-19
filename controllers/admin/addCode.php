<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('addCode');
}

// Main function
function main($conn) {
	
	$content = template($conn, 'admin/addCode');
	$content = addCode($conn, $content);
	
	echo $content;
}

function addCode($conn, $content) {
	$message = core_message('addCode');
	if(isset($_SESSION['sms_success']) && (isset($_SESSION['sms_code']))) {
		
		$success	= $_SESSION['sms_success'];
		$code		= $_SESSION['sms_code'];
		
		unset($_SESSION['sms_success']); 
		unset($_SESSION['sms_code']); 
		
	} else { $success = 0; }
	
	$comment = comment('SHOW CODE', $content);
	
    if(isset($_POST['add'])) {
		
		$balance	= core_POSTP($conn, $_POST['code']);
		$code		= random(6, 1);
		
		if(empty($balance)) {
			
			$message = language($conn, 'messages', 'FILL_THE_FIELDS');
			
		} else {
			$_SESSION['sms_success']	= 1;
			$_SESSION['sms_code']		= $code;
			
			query($conn, "INSERT INTO "._table('sms_codes')." (code, balance) VALUES ('$code','$balance')");
			
			$message = language($conn, 'messages', 'SUCCESSFULLY_CREATED_CODE');
		}
		
		core_message_set('addCode', $message);
		core_header('!admin/addCode');
	}
	
	if($success == 1) {
		
		$content = str_replace('{CODE}', $code, $content);
		
	} else {
		
		$content = str_replace($comment, '', $content);
		
	}
	
	return $content = str_replace('{SHOW_MESSAGE}', $message, $content);
}
