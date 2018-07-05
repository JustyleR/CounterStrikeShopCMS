<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('allPages', '{EVERYTHING}', '{NUMBER}');
}

// Main function
function main() {
	template('admin/allPages');
}