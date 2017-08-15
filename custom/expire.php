<?php

if (!defined('file_access')) {
    header('Location: home');
}

$get = query("SELECT * FROM flag_history");
if(num_rows($get) > 0) {
	
	$date = strtotime(core_date());
	while($row = fetch_assoc($get)) {
		
		$expireDate = strtotime($row['dateExpire']);
		if($date >= $expireDate) {
			
			$getServer = query("SELECT * FROM servers WHERE shortname='". $row['server'] ."'");
			if(num_rows($getServer) > 0) {
				
				$row2 = fetch_assoc($getServer);
				$serverID = $row2['csbans_id'];
				$admins = csbans_all_admins("WHERE nickname='". $row['nickname'] ."'");
				foreach($admins as $admin) {
					
					$check = query("SELECT * FROM ". prefix ."admins_servers WHERE server_id='$serverID' AND admin_id='". $admin['id'] ."'");
					if(num_rows($check) > 0) {
						
						$row3 = fetch_assoc($getFlags);
						$flags = str_replace($row['flag'], '', $row3['flags']);
						query("UPDATE ". prefix ."amxadmins SET access='$flags' WHERE id='". $admin['id'] ."'");
						query("DELETE FROM flag_history WHERE flag_id='". $row['flag_id'] ."'");
						
					}
					
				}
				
			}
			
		}
		
	}
	
}