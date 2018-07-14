<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('deleteFlag', '{EVERYTHING}', '{NUMBER}');
}

// Main function
function main($conn) {
	// Pages
	$page = core_page();
	// Check if we have the flag id set
    if ($page[3] != NULL) {
        $flagID		= core_POSTP($conn, $page[3]);
        $checkFlag	= query($conn, "SELECT flag_id FROM flags WHERE flag_id='". $flagID ."'");
        if (num_rows($checkFlag) > 0) {
            query($conn, "DELETE FROM flags WHERE flag_id='". $flagID ."'");
			
            core_header('!admin/allFlags/' . $page[2]);
        } else {core_header('!admin/home');}
    } else { core_header('!admin/home'); }
}