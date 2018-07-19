<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main($conn) {
	$content = template($conn, 'admin/home');
	$content = home($conn, $content);
	
	echo $content;
}


function home($conn, $content) {
	
	$users		= query($conn, "SELECT user_id FROM "._table('users')."");
	$users		= num_rows($users);
	
	$servers	= query($conn, "SELECT server_id FROM "._table('servers')."");
	$servers	= num_rows($servers);
	
	$flags		= query($conn, "SELECT flag_id FROM "._table('flags')."");
	$flags		= num_rows($flags);
	
	$codes		= query($conn, "SELECT sms_code_id FROM "._table('sms_codes')."");
	$codes		= num_rows($codes);
	
	$replace	= ['{COUNT_USERS}', '{COUNT_SERVERS}', '{COUNT_FLAGS}', '{COUNT_CODES}'];
	$with		= [$users, $servers, $flags, $codes];
	
	return $content	= str_replace($replace, $with, $content);
	
}