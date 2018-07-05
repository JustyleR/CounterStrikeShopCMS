<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('logs', '{STRING}', '{NUMBER}');
}

// Main function
function main() {
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
	// Include the template file
    template('logs');
}
