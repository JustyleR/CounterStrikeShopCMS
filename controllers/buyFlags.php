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
			
			$content = template($conn, 'buyFlags');
			$content = show_flags($conn, $content);
			$content = submit_flags($conn, $content);
			
			echo $content;
			
        } else { core_header('buyFlags/'); }
    } else {
		$content = template($conn, 'chooseServer');
		$content = template_show_servers($conn, $content);
		
		if(isset($_POST['choose'])) {
			$page = core_page();
			
			core_header($page[0] . '/' . $_POST['server']);
		}
		
		echo $content;
    }
}

function show_flags($conn, $content) {
	
	$cFlags	= comment('SHOW ALL FLAGS', $content);
	$cText	= comment('SHOW NO FLAGS TEXT', $content);
	$server	= core_page()[1];
	
	$getFlags = query($conn, "SELECT * FROM "._table('flags')." WHERE server='". $server ."'");
	if(mysqli_num_rows($getFlags) > 0) {
		
		$adminID = csbans_getadminID($conn, $server);
		if($adminID != NULL) {
			
			$getAdminInfo = query($conn, "SELECT * FROM ". prefix ."amxadmins WHERE id='$adminID'");
			$row = fetch_assoc($getAdminInfo);
			
			$comment	= comment('SHOW FLAGS', $content);
			$list		= "";
			
			while($row2 = fetch_assoc($getFlags)) {
				
				if (strpos($row['access'], $row2['flag']) === FALSE) {
					
					$replace	= ['{FLAG_VALUE}', '{FLAG_PRICE}', '{FLAG_DESCRIPTION}'];
					$with		= [$row2['flag'], $row2['price'], $row2['flagDesc']];
					
					$list .= str_replace($replace, $with, $comment);
					
					$_SESSION['has_flag'] = TRUE;
					
				}
				
			}
			
			if (isset($_SESSION['has_flag'])) {
				$content	= str_replace($cText, '', $content);
				$content = str_replace($comment, $list, $content);
				unset($_SESSION['has_flag']);
			} else {
				$content = str_replace($cFlags, '', $content);
				$content = str_replace('{NO_FLAGS_TEXT}', language($conn, 'messages', 'NO_MORE_FLAGS_TO_BUY'), $content);
			}
			
		} else {
			csbans_createAdmin($conn, $server);
			core_header('buyFlags/' . $server);
		}
		
	} else {
		
		$content = str_replace($cFlags, '', $content);
		$content = str_replace('{NO_FLAGS_TEXT}', language($conn, 'messages', 'NO_FLAGS_ADDED'), $content);
		
	}
	
	return $content;
	
}

function submit_flags($conn, $content) {
	$message = core_message('buy');
	
	if (isset($_POST['buy'])) {
		
        if (isset($_POST['flag'])) {
            $flag = core_POSTP($conn, $_POST['flag']);
        } else {
            return false;
        }

        $user   = user_info($conn, $_SESSION['user_logged']);
        $server = core_page()[1];
		
		// Get the Admin ID from the database
        $adminID = csbans_getadminID($conn, $server);
		
        $checkFlag = query($conn, "SELECT * FROM "._table('flags')." WHERE flag='". $flag ."' AND server='". $server ."'");
        if (num_rows($checkFlag) > 0) {

            $row = fetch_assoc($checkFlag);
            if ($row['price'] > $user['balance']) {
                $message = language($conn, 'messages', 'NO_MONEY_TO_BUY_FLAG');
            } else {

                $getUserFlags = query($conn, "SELECT access FROM " . prefix . "amxadmins WHERE id='$adminID'");
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
                    csbans_createAdmin($conn, $server);
                }

                if ($hasFlag == 0) {
                    $dateBought = core_date();
                    $dateExpire = core_date('all', '30 days');
                    $money      = $user['balance'] - $row['price'];
                    $flags      = $row2['access'] . $flag;

                    query($conn, "INSERT INTO "._table('flag_history')." (nickname,flag,dateBought,dateExpire,server) VALUES ('" . $user['nickname'] . "','$flag','$dateBought', '$dateExpire','$server')");
                    query($conn, "UPDATE "._table('users')." SET balance='$money' WHERE email='" . $user['email'] . "'");
                    query($conn, "UPDATE " . prefix . "amxadmins SET access = '$flags' WHERE id='$adminID'");
                    addLog($conn, $_SESSION['user_logged'], language($conn, 'logs', 'SUCCESSFULLY_BOUGHT_FLAG'));
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
	
	return $content = str_replace('{BUY_FLAGS_MESSAGE}', $message, $content);
	
}