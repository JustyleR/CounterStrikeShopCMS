<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('profile', '{NUMBER}');
}

// Main function
function main($conn) {
	$page = core_page();
	
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
	$user = user_info($conn, $page[1], 'id');
	
	if(!empty($user)) {
		
		$content = template($conn, 'profile');
		$content = show_user_profile($conn, $content, $user);
		
		echo $content;
		
	} else {
		
		template_error($conn, language($conn, 'messages', 'USER_NOT_FOUND'));
		
	}
}

function show_user_profile($conn, $content, $user) {
	
	$group = '';
	
	switch($user['type']) {
		
		case 0: {
			$group = language($conn, 'groups', 'banned');
			break;
		}
		case 1: {
			$group = language($conn, 'groups', 'member');
			break;
		}
		case 2: {
			$group = language($conn, 'groups', 'admin');
			break;
		}
		
	}
	
	$replace = [
	'{EMAIL}',
	'{NICKNAME}',
	'{BALANCE}',
	'{LANG}',
	'{GROUP}',
	'{IP}',
	'{REGISTER_DATE}'
	];
	
	$with = [
	$user['email'],
	$user['nickname'],
	$user['balance'],
	$user['language'],
	$group,
	$user['ip'],
	$user['register_date']
	];
	
	return $content = str_replace($replace, $with, $content);
	
}