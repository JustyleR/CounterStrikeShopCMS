<?php
if(date('H:i') > '00:00' && date('H:i') < '00:2') {
	define('file_access', TRUE);
	
	$base = dirname(dirname(__FILE__));
	require($base . '/config/config.php');
	require($base . '/libs/Core.php');
	require($base . '/libs/CSBans.php');

	$conn = connect();
	$get = query($conn, "SELECT * FROM "._table('flag_history')."");
	if (num_rows($get) > 0) {
		$date = strtotime(core_date('date'));
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