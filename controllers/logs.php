<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('logs', '{STRING}', '{NUMBER}');
}

// Main function
function main($conn) {
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
	$content = template($conn, 'logs');
	$content = show_logs($conn, $content);
	
	echo $content;
}

function show_logs($conn, $content) {
	
	$cFlags		= comment('SHOW LOGS INFO', $content);
	$cText		= comment('SHOW NO LOGS TEXT', $content);
	$user		= user_info($conn, $_SESSION['user_logged']);
	$content	= str_replace('{LOGS_TITLE}', language($conn, 'titles', 'LOGS'), $content);
	
	$getLogs = pagination($conn, "SELECT * FROM logs WHERE user='" . $_SESSION['user_logged'] . "' ORDER BY log_id DESC", 14);
	if($getLogs != NULL) {
		
		$content 	= str_replace($cText, '', $content);
		$comment	= comment('SHOW LOGS', $content);
		$list		= "";
		
		foreach($getLogs[1] as $log) {
			
			$replace	= ['{LOG_TEXT}', '{LOG_DATE}'];
			$with		= [$log['log'], $log['date']];
			$list		.= str_replace($replace, $with, $comment);
		}
		
		$content = str_replace($comment, $list, $content);
		
		$pages = $getLogs[0];
		
		if($pages['prev'] != 0) {
			$prev = url . 'logs/cPage/' . $pages['prev'];
		} else {
			$prev = '';
		}
		
		if($pages['next'] - 1 != $pages['max']) {
			$next = url . 'logs/cPage/' . $pages['next'];
		} else {
			$next = '';
		}
		
		$replace	= ['{PREVIOUS_PAGE_LINK}', '{PREVIOUS_PAGE_NAME}', '{NEXT_PAGE_LINK}', '{NEXT_PAGE_NAME}'];
		$with		= [$prev, language($conn, 'others', 'PAGINATION_PREVIOUS'), $next, language($conn, 'others', 'PAGINATION_NEXT')];
		$content	= str_replace($replace, $with, $content);
		
	} else {
		
		$content = str_replace($cFlags, '', $content);
		$content = str_replace('{NO_LOGS_TEXT}', language($conn, 'messages', 'NO_LOGS'), $content);
		
	}
	
	return $content;
}