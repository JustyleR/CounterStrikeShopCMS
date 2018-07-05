<?php

/*
 * Library to get the basic stuff from CSBans
 */

if (!defined('file_access')) {
    header('Location: home');
}

function csbans_serverInfo($serverID) {
    $get = query("SELECT * FROM " . prefix . "serverinfo WHERE id='$serverID'");
    if (num_rows($get) > 0) {

        return fetch_assoc($get);
    } else {
        return false;
    }
}

function csbans_all_admins($sql = '') {

    $get = query("SELECT * FROM " . prefix . "amxadmins " . $sql);
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

function csbans_getadminID($servername) {
    $getServerID = query("SELECT csbans_id FROM servers WHERE shortname='$servername'");
    if (num_rows($getServerID) > 0) {

        $serverID  = fetch_assoc($getServerID)['csbans_id'];
        $admins    = csbans_all_admins("WHERE nickname='" . user_info($_SESSION['user_logged'])['nickname'] . "'");
        $getAdmins = query("SELECT * FROM " . prefix . "admins_servers WHERE server_id='$serverID'");

        if ($admins != NULL) {
            foreach ($admins as $admin) {
                if (num_rows($getAdmins) > 0) {
                    while ($row = fetch_assoc($getAdmins)) {
                        if ($row['admin_id'] === $admin['id']) {
                            return $admin['id'];
                        }
                    }
                }
            }
        }
    } else {
        return false;
    }
}

function csbans_createAdmin($servername) {
    $checkServer = query("SELECT csbans_id FROM servers WHERE shortname='$servername'");
    if (num_rows($checkServer) > 0) {

        $userInfo  = user_info($_SESSION['user_logged']);
        $nickname  = $userInfo['nickname'];
        $serverID  = fetch_assoc($checkServer)['csbans_id'];
        if(md5_enc != 0) {$password  = md5($userInfo['nick_pass']); } else { $password  = $userInfo['nick_pass']; }
        $adminID   = csbans_getadminID($servername);
        $getAdmins = query("SELECT * FROM " . prefix . "admins_servers WHERE admin_id='$adminID' AND server_id='$serverID'");
        if (num_rows($getAdmins) == 0) {
            $addAdmin    = query("INSERT INTO " . prefix . "amxadmins (username,password,access,flags,steamid,nickname,ashow,created,expired,days) VALUES 
			('','$password','','a','$nickname','$nickname','0','" . time() . "','0','0')");
            $getAdminsID = query("SELECT * FROM " . prefix . "amxadmins ORDER BY id DESC LIMIT 1");
            $id          = fetch_assoc($getAdminsID)['id'];
            query("INSERT INTO " . prefix . "admins_servers (admin_id,server_id,use_static_bantime) VALUES ('$id','$serverID','no')");
        }
    }
}


/*
A very stupid way to do this function but..
Basically check if there are any servers in the csbans servers table and put them in the sms servers table
(I WILL UPDATE THIS FUNCTION IN THE FUTURE)
*/
function csbans_checkServers() {

    $getServers  = query("SELECT * FROM " . prefix . "serverinfo");
    $getServers2 = query("SELECT * FROM servers");

    if (num_rows($getServers) > 0) {

        while ($row = fetch_assoc($getServers)) {

            if (num_rows($getServers2) > 0) {

                while ($row2 = fetch_assoc($getServers2)) {

                    while ($row = fetch_assoc($getServers)) {

                        if ($row['id'] != $row2['csbans_id']) {

                            query("INSERT INTO servers (csbans_id,shortname) VALUES ('" . $row['id'] . "','server" . $row['id'] . "')");
                        }
                    }
                }
            } else {

                query("INSERT INTO servers (csbans_id,shortname) VALUES ('" . $row['id'] . "','server" . $row['id'] . "')");
            }
        }
    }
}
