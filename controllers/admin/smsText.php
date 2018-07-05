<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('smsText', '{STRING}');
}

// Main function
function main() {
	// Pages
    $page = core_page();

	// Check if its defined preview
    if ($page[2] != NULL) {
        $string	= core_POSTP($page[2]);
		if($string === 'preview') {
			template('admin/smsTextPreview');
		} else {
			core_header('!admin/smsText');
		}
        
    } else {
		// Include the template file
        template('admin/smsText');
    }
}

function smsText() {
    if(isset($_POST['edit'])) {
		
		$text = bbcode_save(core_POSTP($_POST['smsText']));
		
		$get = query("SELECT * FROM sms_text");
		if(num_rows($get) > 0) {
			
			query("UPDATE sms_text SET text='$text'");
			
		} else {
			
			query("INSERT INTO sms_text (text) VALUES ('$text')");
			
		}
		
		core_header('!admin/smsText/');
		
	}
	if(isset($_POST['preview'])) {
		
		$text = core_POSTP($_POST['smsText']);
		$_SESSION['preview'] = $text;
		
		core_header('!admin/smsText/preview');
		
	}
	if(isset($_POST['clearPreview'])) {
		
		unset($_SESSION['preview']);
		core_header('!admin/smsText/');
	}
}
