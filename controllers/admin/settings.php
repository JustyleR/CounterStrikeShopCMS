<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('settings');
}

// Main function
function main($conn) {
  // Load the template
  $template = template($conn, 'admin/settings');
  // Load the default template variables
  $vars = template_vars($conn);

	$vars['message'] = settings_submit($conn);
  $vars['languages'] = get_languages();
  $vars['templates'] = get_templates();
  $vars['settings'] = getSettings($conn);

	echo $template->render($vars);
}

// Get the information about the settings from the database
function getSettings($conn) {
    $query = query($conn, "SELECT * FROM "._table('settings')."");
    if(num_rows($query) > 0) {
  		$row    = fetch_assoc($query);
      return $row;
	} else {

		template_error($conn, language('errors', 'EMPTY_SETTINGS_TABLE'), 'admin/error', 1);

	}
}

// Call the function after the submit button
function settings_submit($conn) {
	$message = core_message('settings');
    if (isset($_POST['edit'])) {
		$title		= core_POSTP($conn, $_POST['site_title']);
        $lang		= core_POSTP($conn, $_POST['lang']);
		$temp		= core_POSTP($conn, $_POST['template']);
		$md5		= core_POSTP($conn, $_POST['md5']);
		$radmins	= core_POSTP($conn, $_POST['reloadadmins']);
		$id1		= core_POSTP($conn, $_POST['id120']);
		$id2		= core_POSTP($conn, $_POST['id240']);
		$id3		= core_POSTP($conn, $_POST['id480']);
		$id4		= core_POSTP($conn, $_POST['id600']);
		$b1			= core_POSTP($conn, $_POST['b120']);
		$b2			= core_POSTP($conn, $_POST['b240']);
		$b3			= core_POSTP($conn, $_POST['b480']);
		$b4			= core_POSTP($conn, $_POST['b600']);


		query($conn, "UPDATE "._table('settings')." SET site_title='". $title ."', template='". $temp ."', language='". $lang ."', md5_enc='". $md5 ."', reloadadmins='". $radmins ."', servID1='". $id1 ."',
		servID2='". $id2 ."', servID3='". $id3 ."', servID4='". $id4 ."',
		balance1='". $b1 ."', balance2='". $b2 ."', balance3='". $b3 ."', balance4='". $b4 ."'");

		$message = language($conn, 'messages', 'CHANGES_SAVED');

		core_message_set('settings', $message);
		core_header('!admin/settings');
    }

	return $message;
}
