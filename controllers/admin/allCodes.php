<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('allCodes', '{STRING}', '{NUMBER}');
}

// Main function
function main($conn) {
	
	$content = template($conn, 'admin/allCodes');
	$content = allCodes($conn, $content);
	
	echo $content;
}

function allCodes($conn, $content) {
	
	$getCodes 	= pagination($conn, "SELECT * FROM sms_codes", 10);
	$cCodes		= comment('SHOW CODES', $content);
	$cPages		= comment('SHOW PAGES', $content);
	$cText		= comment('SHOW NOTHING ADDED', $content);
	
	if($getCodes != NULL) {
		
		$list		= "";
		
		foreach ($getCodes[1] as $code) {
			
			$replace	= ['{INFO_SMS_CODE}', '{INFO_SMS_BALANCE}', '{INFO_SMS_CODE_ID}', '{INFO_CPAGE}'];
			$with		= [$code['code'], $code['balance'], $code['sms_code_id'], core_page()[3]];
			$list		.= str_replace($replace, $with, $cCodes);
			
		}
		
		$content	= str_replace($cCodes, $list, $content);
		$content	= str_replace($cText, '', $content);
		$pages		= $getCodes[0];
		
		if($pages['max'] == 1) {
			
			$content = str_replace($cPages, '', $content);
			
		} else {
			
			if($pages['prev'] != 0) {
				$prev = url . '!admin/allCodes/cPage/' . $pages['prev'];
			} else {
				$prev = '';
			}
			
			if($pages['next'] - 1 != $pages['max']) {
				$next = url . '!admin/allCodes/cPage/' . $pages['next'];
			} else {
				$next = '';
			}
			
			$replace 	= ['{PREV_PAGE_LINK}', '{NEXT_PAGE_LINK}'];
			$with		= [$prev, $next];
			$content 	= str_replace($replace, $with, $content);
			
		}
		
	} else {
		
		$content	= str_replace($cCodes, '', $content);
		$content	= str_replace($cPages, '', $content);
		
	}
	
	return $content;
}