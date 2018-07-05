<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('homeText', '{STRING}');
}

// Main function
function main() {
	// Pages
    $page = core_page();

	// Check if its defined preview
    if ($page[2] != NULL) {
        $string	= core_POSTP($page[2]);
		if($string === 'preview') {
			template('admin/homeTextPreview');
		} else {
			core_header('!admin/homeText');
		}
        
    } else {
		// Include the template file
        template('admin/homeText');
    }
}

function homeText() {
    if(isset($_POST['edit'])) {
		
		$text = bbcode_save(core_POSTP($_POST['homeText']));
		
		$get = query("SELECT * FROM sms_text");
		if(num_rows($get) > 0) {
			
			query("UPDATE sms_text SET home='$text'");
			
		} else {
			
			query("INSERT INTO sms_text (home) VALUES ('$text')");
			
		}
		
		core_header('!admin/homeText/');
		
	}
	if(isset($_POST['preview'])) {
		
		$text = core_POSTP($_POST['homeText']);
		$_SESSION['preview'] = $text;
		
		core_header('!admin/homeText/preview');
		
	}
	if(isset($_POST['clearPreview'])) {
		
		unset($_SESSION['preview']);
		core_header('!admin/homeText/');
	}
}
