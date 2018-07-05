<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('logout');
}

// Main function
function main() {
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
    unset($_SESSION['user_logged']);
    unset($_SESSION['admin_logged']);
	
	//Redirect to a page
    core_header('login');
}
