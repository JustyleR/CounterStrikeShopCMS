<?php

/*
	Home page
*/

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main($conn) {

	if(!isset($_SESSION['user_logged'])) { core_header('login'); }

  // Load the template
  $template = template($conn, 'home');
  // Load the default template variables
  $vars = template_vars($conn);
  $text = '';

  $query	= query($conn, "SELECT home FROM "._table('text')."");
	if(num_rows($query) > 0) {
		$text	= bbcode_preview($query['home']);
	}
  
  $vars['site_index'] = $text;

  echo $template->render($vars);
}
