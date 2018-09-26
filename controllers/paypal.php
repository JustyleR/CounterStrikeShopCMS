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
	
	$content = template($conn, 'paypal');
	
	if(paypal_type == 'test') { $link = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; }
	else { $link = 'https://www.paypal.com/cgi-bin/webscr'; }
	
	$content = str_replace('{PAYPAL_LINK}', $link, $content);
	
	$content = str_replace('{INFO_USER_EMAIL}', paypal_email, $content);
	
	echo $content;
}