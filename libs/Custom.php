<?php
/*
	Custom Library
	File for custom functions
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

function template_show_servers($conn, $content) {
	
	$cServers	= comment('SHOW SERVERS', $content);
	$cText		= comment('NO SERVERS TEXT', $content);
	$content	= str_replace('{CHOOSE_SERVER_TITLE}', language($conn, 'titles', 'CHOOSE_SERVER'), $content);
	
	$get = mysqli_query($conn, "SELECT * FROM servers");
	if(num_rows($get) > 0) {
		
		$content	= str_replace($cText, '', $content);
		$list		= "";
		$comment = comment('GET SERVERS', $content);
		
		while($row = fetch_assoc($get)) {
			
			$csbans = csbans_serverInfo($conn, $row['csbans_id']);
			
			$replace	= ['{SERVER}', '{SERVER_NAME}'];
			$with		= [$row['shortname'], $csbans['hostname']];
			
			$list .= str_replace($replace, $with, $comment);
			
		}
		
		$content = str_replace($comment, $list, $content);
		
	} else {
		
		$content = str_replace($cServers, '', $content);
		
	}
	
	return $content;
	
}