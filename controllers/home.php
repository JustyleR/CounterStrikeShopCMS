<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main() {
    if (isset($_SESSION['user_logged'])) {
		// Include the template file
        template('home');
    } else {
		// Redirect to a page
        core_header('login');
		
		// Include the template file
        template('login');
    }
}
