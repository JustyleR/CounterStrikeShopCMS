<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('addCode');
}

// Main function
function main() {
	template('admin/addCode');
}

function addCode() {
    if(isset($_POST['add'])) {
	
		$balance	= core_POSTP($_POST['code']);
		$code		= random(6, 1);
		
		if(empty($balance)) {
			
			core_message_set('addCode', language('messages', 'FILL_THE_FIELDS'));
			
		} else {
			
			query("INSERT INTO sms_codes (code, balance) VALUES ('$code','$balance')");
			
			core_message_set('addCode', language('messages', 'SUCCESSFULLY_CREATED_CODE') . '<br /> <strong>'. $code .'</strong>');
			
		}
		
	}
}
