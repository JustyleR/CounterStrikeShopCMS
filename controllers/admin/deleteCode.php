<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('deleteCode', '{NUMBER}');
}

// Main function
function main() {
	// Pages
	$page = core_page();
	// Check if we have the flag id set
    if ($page[2]	!= NULL) {
        $codeID		= core_POSTP($page[2]);
        $checkCode = query("SELECT sms_code_id FROM sms_codes WHERE sms_code_id='$codeID'");
        if (num_rows($checkCode) > 0) {
            query("DELETE FROM sms_codes WHERE sms_code_id='$codeID'");
			// Redirect to a page
            core_header('!admin/allCodes');
        } else {
			// Redirect to a page
            core_header('!admin/home');
        }
    } else {
		// Redirect to a page
        core_header('!admin/home');
    }
}
