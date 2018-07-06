<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('buyFlags', '{EVERYTHING}');
}

// Main function
function main() {
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
	// Pages
    $page = core_page();

	// Check if we have the servername set
    if ($page[1] != NULL) {
        $serverName = core_POSTP($page[1]);

        $checkServer = query("SELECT * FROM servers WHERE shortname='$serverName'");
        if (num_rows($checkServer) > 0) {
			// Include the template file
            template('buyFlags');
        } else {
			// Include the template file
            template('chooseServer');
        }
    } else {
		// Include the template file
        template('chooseServer');
    }
}

function buyFlags() {
    if (isset($_POST['buy'])) {
		
        if (isset($_POST['flag'])) {
            $flag = core_POSTP($_POST['flag']);
        } else {
            return false;
        }

        $user   = user_info($_SESSION['user_logged']);
        $server = core_page()[1];
		
		// Get the Admin ID from the database
        $adminID = csbans_getadminID($server);
		
        $checkFlag = query("SELECT * FROM flags WHERE flag='$flag' AND server='$server'");
        if (num_rows($checkFlag) > 0) {

            $row = fetch_assoc($checkFlag);
            if ($row['price'] > $user['balance']) {
                core_message_set('flag', language('messages', 'NO_MONEY_TO_BUY_FLAG'));
            } else {

                $getUserFlags = query("SELECT access FROM " . prefix . "amxadmins WHERE id='$adminID'");
                if (num_rows($getUserFlags) > 0) {
                    $row2 = fetch_assoc($getUserFlags);
					// Check if we have the flag in our access field in the table (amxadmins)
                    if (strpos($row2['access'], $flag) === FALSE) {
                        $hasFlag = 0;
                    } else {
                        $hasFlag = 1;
                    }
                } else {
					// Create an admin without any access flags to the database (amxadmins)
                    csbans_createAdmin($server);
                }

                if ($hasFlag == 0) {
                    $dateBought = core_date();
                    $dateExpire = core_date('all', '30 days');
                    $money      = $user['balance'] - $row['price'];
                    $flags      = $row2['access'] . $flag;

                    query("INSERT INTO flag_history (nickname,flag,dateBought,dateExpire,server) VALUES ('" . $user['nickname'] . "','$flag','$dateBought', '$dateExpire','$server')");
                    query("UPDATE users SET balance='$money' WHERE email='" . $user['email'] . "'");
                    query("UPDATE " . prefix . "amxadmins SET access = '$flags' WHERE id='$adminID'");
                    addLog($_SESSION['user_logged'], language('logs', 'SUCCESSFULLY_BOUGHT_FLAG'));
					if(amx_reloadadmins != 0) {
						$info = query("SELECT * FROM servers WHERE shortname='$server'");
						$row = fetch_assoc($info);
						$info = query("SELECT * FROM ". prefix ."serverinfo WHERE id='". $row['csbans_id'] ."'");
						$row = fetch_assoc($info);
						if($row['rcon'] != NULL) {
							$rcon = new RCon($row['address'], $row['rcon']);
							$rcon->Connect();
							$rcon->Command('amx_reloadadmins');
							$rcon->Disconnect();
						}
					}
					echo language('messages', 'SUCCESSFULLY_BOUGHT_FLAG');
					core_header('buyFlags/' . core_page()[1], 2);
                } else {
                    core_message_set('flag', language('messages', 'ALREADY_HAS_THE_FLAG'));
                }
            }
        } else {
            core_message_set('flag', language('messages', 'FLAG_DOESNT_EXISTS'));
        }
    }
}
