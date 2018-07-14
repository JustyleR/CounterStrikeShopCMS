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
	
	$content = template($conn, 'paypal');
	$content = str_replace('{INFO_USER_EMAIL}', paypal_email, $content);
	
	echo $content;
}