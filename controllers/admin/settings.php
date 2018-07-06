<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('settings');
}

// Main function
function main() {
	// Pages
	$page = core_page();
	
	// Include the template file
	template('admin/settings');
}

// Get the information about the settings from the database
function getSettings() {
    $query = query("SELECT * FROM settings");
    return $row = fetch_assoc($query);
}

// Call the function after the submit button
function settings_submit() {
    if (isset($_POST['edit'])) {
        $lang		= core_POSTP($_POST['lang']);
		$temp		= core_POSTP($_POST['template']);
		$md5		= core_POSTP($_POST['md5']);
		$radmins	= core_POSTP($_POST['reloadadmins']);
		$id1		= core_POSTP($_POST['id120']);
		$id2		= core_POSTP($_POST['id240']);
		$id3		= core_POSTP($_POST['id480']);
		$id4		= core_POSTP($_POST['id600']);
		$b1			= core_POSTP($_POST['b120']);
		$b2			= core_POSTP($_POST['b240']);
		$b3			= core_POSTP($_POST['b480']);
		$b4			= core_POSTP($_POST['b600']);
		

		query("UPDATE settings SET template='$temp', language='$lang', md5_enc='$md5', reloadadmins='$radmins', servID1='$id1', servID2='$id2', servID3='$id3', servID4='$id4', 
		balance1='$b1', balance2='$b2', balance3='$b3', balance4='$b4'");
		// Set the output message
		core_message_set('settings', language('messages', 'SUCCESSFULLY_UPDATED_THE_FLAG'));
		// Redirect to a page after 1 seconds
		core_header('!admin/settings', 0);
    }
}
