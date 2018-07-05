<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('deleteFlag', '{NUMBER}');
}

// Main function
function main() {
	// Pages
	$page = core_page();
	// Check if we have the flag id set
    if ($page[2] != NULL) {
        $flagID      = core_POSTP($page[2]);
        $checkFlag = query("SELECT flag_id FROM flags WHERE flag_id='$flagID'");
        if (num_rows($checkFlag) > 0) {
            query("DELETE FROM flags WHERE flag_id='$flagID'");
			// Redirect to a page
            core_header('!admin/allFlags/');
        } else {
			// Redirect to a page
            core_header('!admin/home');
        }
    } else {
		// Redirect to a page
        core_header('!admin/home');
    }
}
