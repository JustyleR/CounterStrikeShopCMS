<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('logs', '{STRING}', '{NUMBER}');
}

// Main function
function main($conn) {
	
	$content = template($conn, 'admin/logs');
	$content = allLogs($conn, $content);
	
	echo $content;
}

function allLogs($conn, $content) {
	
	$getCodes 	= pagination($conn, "SELECT * FROM logs ORDER BY log_id DESC", 14);
	$cLogs		= comment('SHOW LOGS', $content);
	$cPages		= comment('SHOW PAGES', $content);
	$cText		= comment('SHOW NOTHING ADDED', $content);
	
	if($getCodes != NULL) {
		
		$list		= "";
		
		foreach ($getCodes[1] as $code) {
			
			$replace	= ['{INFO_LOG_DATE}', '{INFO_LOG_USER}', '{INFO_LOG}'];
			$with		= [$code['date'], $code['user'], $code['log']];
			$list		.= str_replace($replace, $with, $comment);
			
		}
		
		$content	= str_replace($comment, $list, $content);
		$content	= str_replace($cText, '', $content);
		$pages		= $getCodes[0];
		$comment	= comment('SHOW PAGES', $content);
		
		if($pages['max'] == 1) {
			
			$content = str_replace($comment, '', $content);
			
		} else {
			
			if($pages['prev'] != 0) {
				$prev = url . '!admin/logs/cPage/' . $pages['prev'];
			} else {
				$prev = '';
			}
			
			if($pages['next'] - 1 != $pages['max']) {
				$next = url . '!admin/logs/cPage/' . $pages['next'];
			} else {
				$next = '';
			}
			
			$replace 	= ['{PREV_PAGE_LINK}', '{NEXT_PAGE_LINK}'];
			$with		= [$prev, $next];
			$content 	= str_replace($replace, $with, $content);
			
		}
	} else {
		
		$content	= str_replace($cLogs, '', $content);
		$content	= str_replace($cPages, '', $content);
		
	}
	
	return $content;
}