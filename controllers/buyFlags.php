<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('buyFlags', '{EVERYTHING}');
}

// Main function
function main($conn) {
	// Check if we are logged in
    core_check_logged('user', 'logged');

	// Pages
    $page = core_page();

	// Check if we have the servername set
    if ($page[1] != NULL) {
      $serverName  = core_POSTP($conn, $page[1]);
      $checkServer = query($conn, "SELECT * FROM "._table('servers')." WHERE shortname='". $serverName ."'");
      if (num_rows($checkServer) > 0) {

        // Load the template
        $template = template($conn, 'buyFlags');
        // Load the default template variables
        $vars = template_vars($conn);

      	$vars['user_banned'] = csbans_userBanned($conn);
        $vars['flags'] = get_flags($conn);
      	$vars['message'] = submit_flags($conn);

      	echo $template->render($vars);

      } else { core_header('buyFlags/'); }
    } else {
      // Load the template
      $template = template($conn, 'chooseServer');
      // Load the default template variables
      $vars = template_vars($conn);

    	$vars['servers'] = get_all_servers($conn);

    	echo $template->render($vars);

      if(isset($_POST['choose'])) { core_header($page[0] . '/' . $_POST['server']); }
    }
}

function get_flags($conn) {

	$server		= core_page()[1];

	$getFlags = query($conn, "SELECT * FROM "._table('flags')." WHERE server='". $server ."'");
	if(mysqli_num_rows($getFlags) > 0) {

		$adminID = csbans_getadminID($conn, $server);

		$getAdminInfo = query($conn, "SELECT * FROM ". prefix ."amxadmins WHERE id='$adminID'");
		$row = fetch_assoc($getAdminInfo);

		$flags = array();

		while($row2 = fetch_assoc($getFlags)) {

			if (strpos($row['access'], $row2['flag']) === FALSE) {
        $arr = array();
        $arr['flag'] = $row2['flag'];
        $arr['price'] = $row2['price'];
        $arr['desc'] = $row2['flagDesc'];
        $flags[] = $arr;
			}
		}

    return $flags;
	} else {
    return 'EMPTY';
	}
}

function submit_flags($conn) {
	$message = core_message('buy');

	if (isset($_POST['buy'])) {

		$server = core_page()[1];

        if (isset($_POST['flag'])) {
            $flag = core_POSTP($conn, $_POST['flag']);
        } else {
            core_header('buyFlags/' . $server);
			exit();
        }

        $user   = user_info($conn, $_SESSION['user_logged']);

        $checkFlag = query($conn, "SELECT * FROM "._table('flags')." WHERE flag='". $flag ."' AND server='". $server ."'");
        if (num_rows($checkFlag) > 0) {

            $row = fetch_assoc($checkFlag);
            if ($row['price'] > $user['balance']) {
                $message = language($conn, 'messages', 'NO_MONEY_TO_BUY_FLAG');
            } else {

				// Get the Admin ID from the database
				$adminID = csbans_getadminID($conn, $server);
        
				if($adminID == NULL) {
					csbans_createAdmin($conn, $server);
					$adminID = csbans_getadminID($conn, $server);
				}

        $getUserFlags = query($conn, "SELECT access FROM " . prefix . "amxadmins WHERE id='$adminID'");

				$row2 = fetch_assoc($getUserFlags);

				// Check if we have the flag in our access field in the table (amxadmins)
				if (strpos($row2['access'], $flag) === FALSE) {
					$hasFlag = 0;
				} else {
					$hasFlag = 1;
				}

                if ($hasFlag == 0) {
                    $dateBought = core_date();
                    $dateExpire = core_date('all', '30 days');
                    $money      = $user['balance'] - $row['price'];
                    $flags      = $row2['access'] . $flag;

                    query($conn, "INSERT INTO "._table('flag_history')." (nickname,flag,dateBought,dateExpire,server) VALUES ('" . $user['nickname'] . "','$flag','$dateBought', '$dateExpire','$server')");
                    query($conn, "UPDATE "._table('users')." SET balance='$money' WHERE email='" . $user['email'] . "'");
                    query($conn, "UPDATE " . prefix . "amxadmins SET access = '$flags' WHERE id='$adminID'");
                    addLog($conn, $_SESSION['user_logged'], language($conn, 'logs', 'SUCCESSFULLY_BOUGHT_FLAG') . " {$flag}");
					if(amx_reloadadmins != 0) {
						$info = query($conn, "SELECT * FROM "._table('servers')." WHERE shortname='". $server ."'");
						$row = fetch_assoc($info);
						$info = query($conn, "SELECT * FROM ". prefix ."serverinfo WHERE id='". $row['csbans_id'] ."'");
						$row = fetch_assoc($info);
						if($row['rcon'] != NULL) {
							$rcon = new RCon($row['address'], $row['rcon']);
							$rcon->Connect();
							$rcon->Command('amx_reloadadmins');
							$rcon->Disconnect();
						}
					}
					$message = language($conn, 'messages', 'SUCCESSFULLY_BOUGHT_FLAG');
					core_header('buyFlags/' . core_page()[1], 2);
                } else {
                    $message = language($conn, 'messages', 'ALREADY_HAS_THE_FLAG');
                }
            }
        } else {
            $message = language($conn, 'messages', 'FLAG_DOESNT_EXISTS');
        }

		core_message_set('buy', $message);
		core_header(core_page()[0] . '/' . $server);
    }

	return $message;

}
