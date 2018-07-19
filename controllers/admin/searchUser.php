<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('searchUser', '{EVERYTHING}');
}

// Main function
function main($conn) {
	// Pages
	$page = core_page();
	
    if ($page[2] == NULL) {
		$content = template($conn, 'admin/searchUser');
		
		if(isset($_POST['search'])) {
			
			$email = core_POSTP($conn, $_POST['email']);
			
			if(!empty($email)) { core_header('!admin/searchUser/' . $email); }
			
		}
		
		echo $content;
    } else {
		$content = template($conn, 'admin/viewUser');
		$content = getUserInfo($conn, $content);
		$content = editUser($conn, $content);
		
		echo $content;
    }
}

function getUserInfo($conn, $content) {
	
	$email = core_POSTP($conn, core_page()[2]);
	$query = query($conn, "SELECT * FROM "._table('users')." WHERE email LIKE '". $email ."%'");
	if(num_rows($query) > 0) {
		
		$row = fetch_assoc($query);
		
		$replace	= ['{INFO_EMAIL}', '{INFO_NICKNAME}', '{INFO_INGAME_PASSWORD}', '{INFO_BALANCE}'];
		$with		= [$row['email'], $row['nickname'], $row['nicknamePass'], $row['balance']];
		$content	= str_replace($replace, $with, $content);
		
		$groups		= array(0 => language($conn, 'groups', 'banned'), 1 => language($conn, 'groups', 'member'), 2 => language($conn, 'groups', 'admin'));
		$comment	= comment('SHOW GROUPS', $content);
		$list		= "";
		
		foreach($groups as $id=>$group) {
			
			if($row['type'] == $id) { $selected = 'selected'; } else { $selected = ''; }
			
			$replace	= ['{GROUP_ID}', '{GROUP_NAME}', '{SELECTED}'];
			$with		= [$id, $group, $selected];
			
			$list		.= str_replace($replace, $with, $comment);
			
		}
		
		$content = str_replace($comment, $list, $content);
		
		$_SESSION['original_email'] = $row['email'];
		
		if(core_page()[2] != $row['email']) { core_header('!admin/searchUser/' . $row['email']); }
		
	} else { core_header('!admin/searchUser/'); }
	
	return $content;
}

function editUser($conn, $content) {
	$message = core_message('viewUser');
	
    if (isset($_POST['edit'])) {
        $email          = core_POSTP($conn, $_POST['email']);
        $password       = core_POSTP($conn, $_POST['password']);
        $nickname       = core_POSTP($conn, $_POST['nickname']);
        $nickname_pass  = core_POSTP($conn, $_POST['nickname_pass']);
		if(md5_enc		!= 0) {$nickname_npass  = md5($nickname_pass); } else { $nickname_npass  = $nickname_pass; }
        $balance        = core_POSTP($conn, $_POST['balance']);
        $type           = core_POSTP($conn, $_POST['type']);
        $user           = user_info($conn, $_SESSION['original_email']);
        unset($_SESSION['original_email']);

        if (empty($email) || (empty($nickname)) || (empty($nickname_pass))) {
			// Set the output message
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
			// Set next to 0 so the script cannot continue
            $next = 0;

            if ($type != $user['type']) {
                query($conn, "UPDATE "._table('users')." SET type='$type' WHERE email='". $user['email'] ."'");
				// Set next to 1 so the script can continue
                $next = 1;
            }
            if ($email != $user['email']) {
                $checkEmail = query($conn, "SELECT email FROM "._table('users')." WHERE email='". $email ."'");
                if (num_rows($checkEmail) > 0) {
					// Set the output message
                    $next = 0;
                } else {
                    if ($user['email'] === $_SESSION['user_logged']) {
                        unset($_SESSION['user_logged']);
                        $_SESSION['user_logged'] = $email;
                    }
                    query($conn, "UPDATE "._table('users')." SET email='". $email ."' WHERE email='". $user['email'] ."'");
                    query($conn, "UPDATE "._table('logs')." SET email='". $email ."' WHERE email='". $user['email'] ."'");
                    $next = 1;
                }
            }
			
            if ($password != NULL) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                if ($password != $user['password']) {
                    query($conn, "UPDATE "._table('users')." SET password='". $password ."' WHERE email='". $user['email'] ."'");
                    $next = 1;
                }
            }

            if ($nickname_pass != $user['nick_pass']) {
                query($conn, "UPDATE "._table('users')." SET nicknamePass='". $nickname_pass ."' WHERE email='". $user['email'] ."'");
                query($conn, "UPDATE ". prefix ."amxadmins SET password='". $nickname_npass ."' WHERE nickname='". $user['nickname'] ."'");
                $next = 1;
            }
			
            if ($nickname != $user['nickname']) {
                if (preg_match("/[^a-zA-Z0-9.!@#$%^&*()_+-=<>?` ]/i", $nickname)) {
					// Set the output message
                    $message = language($conn, 'messages', 'CONTAINS_UNAUTHORIZED_CHARACTERS');
                    $next = 0;
                } else {
                    $checkNickname = query($conn, "SELECT nickname FROM "._table('users')." WHERE nickname='". $nickname ."'");
                    if (num_rows($checkNickname) > 0) {
						// Set the output message
                        $message = language($conn, 'messages', 'NICKNAME_ALREADY_IN_USE');
                        $next = 0;
                    } else {
                        $checkNick2 = query($conn, "SELECT nickname FROM ".prefix."amxadmins WHERE nickname='". $nickname ."'");
						if(num_rows($checkNick2) > 0) {
							// Set the output message
							$message = language($conn, 'messages', 'NICKNAME_ALREADY_IN_USE');
							$next = 0;
						} else {
							
							query($conn, "UPDATE "._table('users')." SET nickname='". $nickname ."' WHERE email='" . $user['email'] . "'");
							query($conn, "UPDATE " . prefix . "amxadmins SET nickname='". $nickname ."', steamid='". $nickname ."' 
							WHERE nickname='" . $user['nickname'] . "'");
							query($conn, "UPDATE "._table('flag_history')." SET nickname='". $nickname ."' WHERE nickname='". $user['nickname'] ."'");
							$next = 1;
							
						}
                    }
                }
            }

            if ($balance != $user['balance']) {
                query($conn, "UPDATE "._table('users')." SET balance='". $balance ."' WHERE email='". $user['email'] ."'");
                $next = 1;
            }
			
            if ($next == 1) {
                $message = language($conn, 'messages', 'CHANGES_SAVED');
            }
        }
		
		if($email == NULL) { $email = core_page()[2]; }
		
		core_message_set('viewUser', $message);
		core_header('!admin/searchUser/' . $email);
    } else if(isset($_POST['delete'])) {
		query($conn, "DELETE FROM "._table('users')." WHERE email='". core_page()[2] ."'");
		core_header('!admin/allUsers/cPage/1');
	}
	
	return $content = str_replace('{SHOW_MESSAGE}', $message, $content);
}