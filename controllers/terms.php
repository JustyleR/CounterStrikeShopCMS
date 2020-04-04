<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('terms');
}

// Main function
function main($conn) {
	// Check if we are logged in
  core_check_logged('user');

  // Load the template
  $template = template($conn, 'terms');
  // Load the default template variables
  $vars = template_vars($conn);

  $vars['terms'] = getTerms($conn);

  echo $template->render($vars);
}

function getTerms($conn) {

	$query = query($conn, "SELECT terms FROM "._table('sms_text')."");
	if(num_rows($query) > 0) {

		$text = bbcode_preview(fetch_assoc($query)['terms']);

		return $text;

	}
}