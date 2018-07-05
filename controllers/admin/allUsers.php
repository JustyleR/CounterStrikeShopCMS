<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('allUsers', '{EVERYTHING}', '{NUMBER}');
}

// Main function
function main() {
	// Include the template file
	template('admin/allUsers');
}