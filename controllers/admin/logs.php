<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
	// !admin / 1 logs / 2 cPage / 3 currenct page (int) / 4 user (all / user email) / 5 sort by (date / user) / 6 asc/desc order
    return array('logs', '{STRING}', '{NUMBER}','{STRING}','{STRING}','{STRING}');
}

// Main function
function main($conn) {
	$pages = core_page();
	$logsLimit = 14;
	
	// Load the template
	$template = template($conn, 'admin/logs');
	// Load the default template variables
	$vars = template_vars($conn);
	
	switch($pages[5]) {
		
		case 'date':
			$sort = 'date';
		break;
		
		case 'user':
			$sort = 'user';
		break;
		
		default: 
			$sort = 'log_id';
		break;
	}
	
	if(($pages[6] != 'asc') && ($pages[6] != 'desc')) { core_header('!admin/home'); }
	
	if($pages[4] == 'all') {
		$getLogs = pagination($conn, "SELECT * FROM " . _table('logs') . " ORDER BY ". $sort ." ". $pages[6] ."", $logsLimit);
		$vars['logs'] = $getLogs;
	} else {
		$user = core_POSTP($conn, $pages[4]);
		$getLogs = pagination($conn, "SELECT * FROM " . _table('logs') . " WHERE user='". $user ."' ORDER BY ". $sort ." ". $pages[6] ."", $logsLimit);
		if($getLogs != NULL) {
			$vars['logs'] = $getLogs;
		}
	}

	echo $template->render($vars);
}
