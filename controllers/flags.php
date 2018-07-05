<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('flags', '{EVERYTHING}');
}

// Main function
function main() {
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
	// Pages
    $page = core_page();

	// Check if we have the servername set
    if ($page[1] != NULL) {
        $serverName  = core_POSTP($page[1]);
        $checkServer = query("SELECT * FROM servers WHERE shortname='$serverName'");
        if (num_rows($checkServer) > 0) {
			// Include the template file
            template('flags');
        } else {
			// Include the template file
            template('chooseServer');
        }
    } else {
		// Include the template file
        template('chooseServer');
    }
}
