<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('logs', '{STRING}', '{NUMBER}');
}

// Main function
function main($conn) {
	// Check if we are logged in
  core_check_logged('user', 'logged');

  // Load the template
  $template = template($conn, 'logs');
  // Load the default template variables
  $vars = template_vars($conn);

	$vars['logs'] = show_logs($conn);

	echo $template->render($vars);
}

function show_logs($conn) {
	$user		= user_info($conn, $_SESSION['user_logged']);

	$getLogs = pagination($conn, "SELECT * FROM "._table('logs')." WHERE user='" . $_SESSION['user_logged'] . "' ORDER BY log_id DESC", 14);

  return $getLogs;
}
