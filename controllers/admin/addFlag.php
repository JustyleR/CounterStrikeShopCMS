<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('addFlag', '{EVERYTHING}');
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
            template('admin/addFlag');
        } else {
			// Include the template file
            template('admin/chooseServer');
        }
    } else {
		// Include the template file
        template('admin/chooseServer');
    }
}

function addFlag() {
    if (isset($_POST['add'])) {
        $flag      = core_POSTP($_POST['flag']);
        $flagDesc  = core_POSTP($_POST['flagDesc']);
        $flagPrice = core_POSTP($_POST['flagPrice']);
        $server    = core_page()[2];

        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
			// Set the output message
            core_message_set('addFlag', language('messages', 'FILL_THE_FIELDS'));
        } else {
            $checkData = query("SELECT flag_id FROM flags WHERE flag='$flag'");
            if (num_rows($checkData) > 0) {
				// Set the output message
                core_message_set('addFlag', language('messages', 'FLAG_ALREADY_EXISTS'));
            } else {
                query("INSERT INTO flags (flag,flagDesc,price,server) VALUES ('$flag','$flagDesc','$flagPrice','$server')");
				// Set the output message
                core_message_set('addFlag', language('messages', 'SUCCESSFULLY_CREATED_FLAG'));
            }
        }
    }
}
