<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('allFlags', '{EVERYTHING}');
}

// Main function
function main() {
	// Pages
    $page = core_page();
	
	// Check if we have the servername set
    if ($page[2] != NULL) {
        $serverName        = core_POSTP($page[2]);
        $checkServer = query("SELECT * FROM servers WHERE shortname='$serverName'");
        if (num_rows($checkServer) > 0) {
			// Include the template file
            template('admin/allFlags');
        } else {
			// Include the template file
            template('admin/chooseServer');
        }
    } else {
		// Include the template file
        template('admin/chooseServer');
    }
}

function allFlags() {
    $page = core_page()[2];

    $getFlags = query("SELECT * FROM flags WHERE server='$page'");
    if (num_rows($getFlags) > 0) {
        $array = array();
        while ($row   = fetch_assoc($getFlags)) {
            $array[] = $row;
        }
        return $array;
    } else {
		// Return a language text
        return language('messages', 'NOTHING_ADDED');
    }
}
