<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('profile', '{NUMBER}');
}

// Main function
function main() {
    if (isset($_SESSION['user_logged'])) {
		// Page
		$page = core_page();
		if(isset($page[1])) {
			
			$check = query("SELECT * FROM users WHERE user_id='". $page[1] ."'");
			if(num_rows($check) > 0) {
				
				// Include the template file
				template('profile');
				
			} else {
				
				core_header('home');
				
			}
			
		}
		
    } else {
		// Redirect to a page
        core_header('login');
		
		// Include the template file
        template('login');
    }
}
