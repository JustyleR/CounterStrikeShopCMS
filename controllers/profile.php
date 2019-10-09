<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('profile', '{NUMBER}');
}

// Main function
function main($conn) {
	$page = core_page();

	// Check if we are logged in
  core_check_logged('user', 'logged');

	$user = user_info($conn, $page[1], 'id');

	if(!empty($user)) {

    // Load the template
    $template = template($conn, 'profile');
    // Load the default template variables
    $vars = template_vars($conn);

    $vars['profile'] = $user;
    $vars['profile_group'] = user_group($conn, $user['type']);

	  echo $template->render($vars);

	} else {

		template_error($conn, language($conn, 'messages', 'USER_NOT_FOUND'), 'error', 0);

	}
}
