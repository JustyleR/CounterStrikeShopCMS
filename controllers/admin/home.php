<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main() {
	// Include the template file
    template('admin/home');
	
	// Check the servers
	csbans_checkServers();
}
