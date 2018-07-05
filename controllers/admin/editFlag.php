<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('editFlag', '{NUMBER}');
}

// Main function
function main() {
	// Pages
	$page = core_page();
	// Check if we have the flag id set
    if ($page[2] != NULL) {
        $flagID        = core_POSTP($page[2]);
        $checkServer = query("SELECT flag_id FROM flags WHERE flag_id='$flagID'");
        if (num_rows($checkServer) > 0) {
			// Include the template file
            template('admin/editFlag');
        } else {
			// Include the template file
            template('admin/home');
        }
    } else {
		// Include the template file
        template('admin/home');
    }
}

// Get the information about a flag from the database
function editFlag() {
    $page  = core_page()[2];
    $query = query("SELECT * FROM flags WHERE flag_id='$page'");
    return $row   = fetch_assoc($query);
}

// Call the function after the submit button
function editFlag_submit() {
    if (isset($_POST['edit'])) {
        $flag      = core_POSTP($_POST['flag']);
        $flagDesc  = core_POSTP($_POST['flagDesc']);
        $flagPrice = core_POSTP($_POST['flagPrice']);
        $flagID    = core_page()[2];

        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
			// Set the output message
            core_message_set('editFlag', language('messages', 'FILL_THE_FIELDS'));
        } else {
            query("UPDATE flags SET flag='$flag', flagDesc='$flagDesc', price='$flagPrice' WHERE flag_id='$flagID'");
			// Set the output message
            core_message_set('editFlag', language('messages', 'SUCCESSFULLY_UPDATED_THE_FLAG'));
			// Redirect to a page after 1 seconds
            core_header('', 1);
        }
    }
}
