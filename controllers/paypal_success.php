<?php

/*
	Home page
*/

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('paypal_success');
}

// Main function
function main($conn) {
    
	if(!isset($_SESSION['user_logged'])) { core_header('login'); }
	
	$content = template($conn, 'paypal_success');
	$content = str_replace('{BALANCE}', $_SESSION['paypal_succes'], $content);
	
	echo $content;
}