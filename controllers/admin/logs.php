<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('logs', '{STRING}', '{NUMBER}');
}

// Main function
function main() {
	template('admin/logs');
}