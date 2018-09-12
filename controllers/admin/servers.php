<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('servers', '{STRING}', '{EVERYTHING}');
}

// Main function
function main($conn) {
	$page = core_page();
	
	if($page[2] == 'add') {
		
		$id = (int)$page[3];
		$check = query($conn, "SELECT id,hostname FROM ". prefix ."serverinfo WHERE id='". $id ."'");
		if(num_rows($check) > 0) {
			
			query($conn, "INSERT INTO "._table('servers')." (csbans_id,shortname) VALUES ('". $id ."','server". $id ."')");
			
			core_header('!admin/servers/home/');
			
		} else { core_header('!admin/home/'); }
		
	} else if($page[2] == 'remove') {
		
		$id = (int)$page[3];
		$check = query($conn, "SELECT csbans_id FROM "._table('servers')." WHERE csbans_id='". $id ."'");
		if(num_rows($check) > 0) {
			
			query($conn, "DELETE FROM "._table('servers')." WHERE csbans_id='". $id ."'");
			
			core_header('!admin/servers/home/');
			
		} else { core_header('!admin/home/'); }
		
	} else if($page[2] == 'home') {
		
		$content = template($conn, 'admin/servers');
		$content = servers($conn, $content);
		
		echo $content;
		
	} else { core_header('!admin/home'); }
}


function servers($conn, $content) {
	$next = 0;
	
	$amxServers	= query($conn, "SELECT id,hostname FROM ". prefix ."serverinfo");
	if(!$amxServers) { $next = 0; } else { $next = 1; }
	
	$cServers	= comment('SHOW ALL AMXBANS SERVERS', $content);
	$tServers	= comment('SHOW NO AMXBANS SERVERS', $content);
	
	if($next == 1 && num_rows($amxServers) > 0) {
		
		$comment	= comment('SHOW AMXBANS SERVERS', $content);
		$list		= "";
		
		while($row = fetch_assoc($amxServers)) {
			
			$checkServer = query($conn, "SELECT csbans_id FROM "._table('servers')." WHERE csbans_id='". $row['id'] ."'");
			if(num_rows($checkServer) == 0) {
				$content	= str_replace($tServers, '', $content);
				$replace 	= ['{AMXBANS_SERVER_ID}', '{AMXBANS_SERVER_NAME}'];
				$with		= [$row['id'], $row['hostname']];
				$list		.= str_replace($replace, $with, $comment);
			}
		}
		
		$content = str_replace($comment, $list, $content);
		
	} else {
		
		$content = str_replace($cServers, '', $content);
		$content = str_replace($tServers, language($conn, 'messages', 'NOTHING_ADDED'), $content);
		
	}
	
	$servers	= query($conn, "SELECT * FROM "._table('servers')."");
	$cServers	= comment('SHOW ALL ADDED SERVERS', $content);
	$tServers	= comment('SHOW NO ADDED SERVERS', $content);
	
	if(num_rows($servers) > 0) {
		
		$content	= str_replace($tServers, '', $content);
		$comment	= comment('SHOW ADDED SERVERS', $content);
		$list		= "";
		
		while($row = fetch_assoc($servers)) {
			
			$checkServer = query($conn, "SELECT id,hostname FROM ". prefix ."serverinfo WHERE id='". $row['csbans_id'] ."'");
			if(num_rows($checkServer) > 0) {
				
				$row2		= fetch_assoc($checkServer);
				$replace 	= ['{INFO_SERVER_ID}', '{INFO_SERVER_NAME}'];
				$with		= [$row2['id'], $row2['hostname']];
				$list		.= str_replace($replace, $with, $comment);
			}
		}
		
		$content = str_replace($comment, $list, $content);
		
	} else {
		
		$content = str_replace($cServers, '', $content);
		$content = str_replace($tServers, language($conn, 'messages', 'NOTHING_ADDED'), $content);
		
	}
	
	
	return $content;
	
}