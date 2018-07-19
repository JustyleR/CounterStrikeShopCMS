<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('allUsers', '{EVERYTHING}', '{NUMBER}');
}

// Main function
function main($conn) {
	
	$content = template($conn, 'admin/allUsers');
	$content = allUsers($conn, $content);
	
	echo $content;
}

function allUsers($conn, $content) {
	$allUsers = pagination($conn, "SELECT * FROM "._table('users')."", 10);
	if($allUsers != NULL) {
		
		$comment	= comment('SHOW USERS', $content);
		$list		= "";
		
		foreach ($allUsers[1] as $user) {
			
			$replace	= ['{INFO_EMAIL}', '{INFO_DATE_REGISTER}'];
			$with		= [$user['email'], $user['registerDate']];
			$list		.= str_replace($replace, $with, $comment);
		}
		
		$content	= str_replace($comment, $list, $content);
		$pages		= $allUsers[0];
		$comment	= comment('SHOW PAGES', $content);
		
		if($pages['max'] == 1) {
			
			$content = str_replace($comment, '', $content);
			
		} else {
			
			if($pages['prev'] != 0) {
				$prev = url . '!admin/allUsers/cPage/' . $pages['prev'];
			} else {
				$prev = '';
			}
			
			if($pages['next'] - 1 != $pages['max']) {
				$next = url . '!admin/allUsers/cPage/' . $pages['next'];
			} else {
				$next = '';
			}
			
			$replace 	= ['{PREV_PAGE_LINK}', '{NEXT_PAGE_LINK}'];
			$with		= [$prev, $next];
			$content 	= str_replace($replace, $with, $content);
		}
	}
	
	return $content;
}