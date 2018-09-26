<?php
/*
	Custom Library
	File for custom functions
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

// Check for the flags that are expired and remove them from the admin access flags
function expire_flags($conn) {
	$get = query($conn, "SELECT * FROM "._table('flag_history')."");
	if (num_rows($get) > 0) {
		$date = strtotime(core_date());
		while($row = fetch_assoc($get)) {
			$expireDate = strtotime($row['dateExpire']);
			if($date >= $expireDate) {
				$getServer = query($conn, "SELECT * FROM "._table('servers')." WHERE shortname='". $row['server'] ."'");
				if(num_rows($getServer) > 0) {
					$row2     = fetch_assoc($getServer);
					$serverID = $row2['csbans_id'];
					$admins   = csbans_all_admins($conn, "WHERE nickname='" . $row['nickname'] . "'");
					foreach ($admins as $admin) {
						$check = query($conn, "SELECT * FROM " . prefix . "admins_servers WHERE server_id='". $serverID ."' AND admin_id='" . $admin['id'] ."'");
						if(num_rows($check) > 0) {
							$flags = str_replace($row['flag'], '', $admin['access']);
							query($conn, "UPDATE " . prefix . "amxadmins SET access='". $flags ."' WHERE id='". $admin['id'] ."'");
							query($conn, "DELETE FROM "._table('flag_history')." WHERE flag_id='". $row['flag_id'] ."'");
							
							$getFlags = query($conn, "SELECT access FROM ". prefix ."amxadmins WHERE id='". $admin['id'] ."'");
							$row3  = fetch_assoc($getFlags);
							
							if(empty($row3['access'])) {
								query($conn, "DELETE FROM ". prefix ."amxadmins WHERE id='". $admin['id'] ."'");
							}
						}
					}
				}
			}
		}
	}
}

function template_show_servers($conn, $content) {
	
	$cServers	= comment('SHOW SERVERS', $content);
	$cText		= comment('NO SERVERS TEXT', $content);
	$content	= str_replace('{CHOOSE_SERVER_TITLE}', language($conn, 'titles', 'CHOOSE_SERVER'), $content);
	
	$get = mysqli_query($conn, "SELECT * FROM "._table('servers')."");
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