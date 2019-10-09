<?php

/*
	Home page
*/

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('paypal');
}

// Main function
function main($conn) {

	if(!isset($_SESSION['user_logged'])) { core_header('login'); }
	if(paypal_enabled == 0) { core_header('home'); }

  // Load the template
  $template = template($conn, 'paypal');
  // Load the default template variables
  $vars = template_vars($conn);

  if(paypal_type == 'test') { $link = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; }
	else { $link = 'https://www.paypal.com/cgi-bin/webscr'; }

	$vars['paypal_link'] = $link;
  $vars['paypal_email'] = paypal_email;

	echo $template->render($vars);
}
