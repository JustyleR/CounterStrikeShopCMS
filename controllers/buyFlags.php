<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('buyFlags', '{EVERYTHING}');
}

function main() {
    core_check_logged('user', 'logged');
    $page = core_page();

    if ($page[1] != NULL) {
        $page        = core_POSTP($page[1]);
		
        $checkServer = query("SELECT * FROM servers WHERE shortname='$page'");
        if (num_rows($checkServer) > 0) {
            template('buyFlags');
        } else {
            template('chooseServer');
        }
    } else {
        template('chooseServer');
    }
}

function buyFlags() {
    if(isset($_POST['buy'])) {
		
		if (isset($_POST['flag'])) {
            $flag = core_POSTP($_POST['flag']);
        } else {
            return false;
        }
		
		$user   = user_info($_SESSION['user_logged']);
        $server = core_page()[1];
		
		$adminID = csbans_getadminID($server);
		
		$checkFlag = query("SELECT * FROM flags WHERE flag='$flag' AND server='$server'");
		if (num_rows($checkFlag) > 0) {
			
			$row = fetch_assoc($checkFlag);
                if ($row['price'] > $user['balance']) {
                    core_message_set('flag', language('messages', 'NO_MONEY_TO_BUY_FLAG'));
                } else {
					
					$getUserFlags = query("SELECT access FROM ". prefix ."amxadmins WHERE id='$adminID'");
					if (num_rows($getUserFlags) > 0) {
                        $row2 = fetch_assoc($getUserFlags);
                        if (strpos($row2['access'], $flag) === FALSE) {
                            $hasFlag = 0;
                        } else {
                            $hasFlag = 1;
                        }
                    } else {
						csbans_createAdmin($server);
					}
					
					if ($hasFlag == 0) {
                        $dateBought = core_date();
                        $dateExpire = core_date('all', '30 days');
                        $money      = $user['balance'] - $row['price'];
                        $flags      = $row2['access'] . $flag;

                        query("INSERT INTO flag_history (nickname,flag,dateBought,dateExpire,server) VALUES ('" . $user['nickname'] . "','$flag','$dateBought', '$dateExpire','$server')");
                        query("UPDATE users SET balance='$money' WHERE email='" . $user['email'] . "'");
                        query("UPDATE ". prefix ."amxadmins SET access = '$flags' WHERE id='$adminID'");
                        query("INSERT INTO logs (user,date,log) VALUES ('" . $_SESSION['user_logged'] . "','$dateBought','" . language('logs', 'SUCCESSFULLY_BOUGHT_FLAG') . "')");
                        core_message_set("flag", language('messages', 'SUCCESSFULLY_BOUGHT_FLAG'));
                        core_header('', 1);
                    } else {
                        core_message_set('flag', language('messages', 'ALREADY_HAS_THE_FLAG'));
                    }
				}
			
		} else {
                core_message_set('flag', language('messages', 'FLAG_DOESNT_EXISTS'));
            }
		
	}
}
