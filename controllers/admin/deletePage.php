<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('deletePage', '{NUMBER}');
}

// Main function
function main() {
	// Pages
	$page = core_page();
	// Check if we have the flag id set
    if ($page[2] != NULL) {
        $pageID      = core_POSTP($page[2]);
        $checkFlag = query("SELECT page_id FROM pages WHERE page_id='$pageID'");
        if (num_rows($checkFlag) > 0) {
            query("DELETE FROM pages WHERE page_id='". $page[2] ."'");
			// Redirect to a page
            core_header('!admin/allPages/cPage/1');
        } else {
			// Redirect to a page
            core_header('!admin/home');
        }
    } else {
		// Redirect to a page
        core_header('!admin/home');
    }
}
