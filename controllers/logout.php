<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('login');
}

// Main function
function main($conn) {
	// Check if we are not logged in
    core_check_logged('user', 'logged');
	
    unset($_SESSION['user_logged']);
    unset($_SESSION['admin_logged']);
	core_header('login');
	exit();
}