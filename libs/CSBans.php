<?php
/*
	CSBans Library
	Functions to get information from CSBANS/AMXBANS
*/

if (!defined('file_access')) {
    header('Location: home');
}

function csbans_serverInfo($conn, $serverID) {
    $get = query($conn, "SELECT * FROM " . prefix . "serverinfo WHERE id='". $serverID ."'");
    if (num_rows($get) > 0) {

        return fetch_assoc($get);
    } else {
        return false;
    }
}

function csbans_all_admins($conn, $sql = '') {
	
    $get = query($conn, "SELECT * FROM " . prefix . "amxadmins " . $sql);
    if (num_rows($get) > 0) {
        $array = array();

        while ($row = fetch_assoc($get)) {

            $array[] = $row;
        }
        return $array;
    } else {
        return false;
    }
}

function csbans_getadminID($conn, $servername) {
    $getServerID = query($conn, "SELECT csbans_id FROM "._table('servers')." WHERE shortname='". $servername ."'");
    if (num_rows($getServerID) > 0) {
 
        $serverID  = fetch_assoc($getServerID)['csbans_id'];
        $admins    = csbans_all_admins($conn, "WHERE nickname='" . user_info($conn, $_SESSION['user_logged'])['nickname'] . "'");
        $getAdmins = query($conn, "SELECT * FROM " . prefix . "admins_servers WHERE server_id='". $serverID ."'");
       
        if (num_rows($getAdmins) > 0)
        {
            $array_get = array();
           
            while ($row = fetch_assoc($getAdmins))
            {
                $array_get[] = $row;
            }
        }
        if ($admins != NULL)
        {
            foreach ($admins as $admin)
            {
                foreach ($array_get as $admin2)
                {
                    if ($admin2['admin_id'] === $admin['id'])
                    {
                        return $admin['id'];
                    }
                   
                }
            }
        }
    } else {
        return false;
    }
}

function csbans_createAdmin($conn, $servername) {
    $checkServer = query($conn, "SELECT csbans_id FROM "._table('servers')." WHERE shortname='". $servername ."'");
    if (num_rows($checkServer) > 0) {

        $userInfo  = user_info($conn, $_SESSION['user_logged']);
        $nickname  = $userInfo['nickname'];
        $serverID  = fetch_assoc($checkServer)['csbans_id'];
        if(md5_enc != 0) {$password  = md5($userInfo['nick_pass']); } else { $password  = $userInfo['nick_pass']; }
        $adminID   = csbans_getadminID($conn, $servername);
        $getAdmins = query($conn, "SELECT * FROM " . prefix . "admins_servers WHERE admin_id='$adminID' AND server_id='$serverID'");
        if (num_rows($getAdmins) == 0) {
            $addAdmin    = query($conn, "INSERT INTO " . prefix . "amxadmins (username,password,access,flags,steamid,nickname,ashow,created,expired,days) VALUES 
			('','$password','','a','$nickname','$nickname','0','" . time() . "','0','0')");
            $getAdminsID = query($conn, "SELECT * FROM " . prefix . "amxadmins ORDER BY id DESC LIMIT 1");
            $id          = fetch_assoc($getAdminsID)['id'];
            query($conn, "INSERT INTO " . prefix . "admins_servers (admin_id,server_id,use_static_bantime) VALUES ('$id','$serverID','no')");
        }
    }
}

function csbans_checkBan($conn, $content) {
	
	$comment = comment('IF USER IS BANNED', $content);
	
	$checkBan = query($conn, "SELECT player_ip FROM ". prefix ."bans WHERE player_ip='". $_SERVER['REMOTE_ADDR'] ."' AND expired='0'");
	if(num_rows($checkBan) == 0) {
		$content = str_replace($comment, '', $content);
	}
	
	return $content;
}

function csbans_userBanned($conn) {
	$checkBan = query($conn, "SELECT player_ip FROM ". prefix ."bans WHERE player_ip='". $_SERVER['REMOTE_ADDR'] ."' AND expired='0'");
	
	return num_rows($checkBan);
}

function csbans_removeBan($conn, $ip) {
 	
	query($conn, "UPDATE ". prefix ."bans SET expired='1' WHERE player_ip='". $ip ."'");
	
}