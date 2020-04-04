<?php
/*
	Users Library
	File to get some user information
*/

if (!defined('file_access')) {
    header('Location: home');
}

// Get user info from the database
function user_info($conn, $user, $type = 'email') {
	if($type === 'email') { $checkUser = query($conn, "SELECT * FROM "._table('users')." WHERE email='". $user ."'"); }
	else if($type === 'id') { $checkUser = query($conn, "SELECT * FROM "._table('users')." WHERE user_id='". $user ."'"); }
    
    if (num_rows($checkUser) > 0) {
        $row   = fetch_assoc($checkUser);
		
        return array(
            "id"            => $row['user_id'],
            "nickname"      => $row['nickname'],
            "email"         => $row['email'],
            "ip"            => $row['ipAdress'],
            "register_date" => $row['registerDate'],
            "balance"       => $row['balance'],
            "type"          => $row['type'],
            "password"      => $row['password'],
            "nick_pass"     => $row['nicknamePass'],
            "language"      => $row['lang']
        );
    } else {
		return false;
	}
}

// On login check if the user is banned of admin, if it is an admin then create special session
function checkUser($conn) {
    if(isset($_SESSION['user_logged'])) {
		$user = user_info($conn, $_SESSION['user_logged']);
		if($user == FALSE) { unset($_SESSION['user_logged']); header('Location: ' . url . 'logout'); }
        $checkUser = query($conn, "SELECT user_id FROM "._table('users')." WHERE email='" . $_SESSION['user_logged'] . "'");
        if (num_rows($checkUser) > 0) {

            if ($user['type'] == 0) {
                core_header('logout');
            } else if ($user['type'] == 1) {
                if (isset($_SESSION['admin_logged'])) {
                    unset($_SESSION['admin_logged']);
                }
            } else if ($user['type'] == 2) {
                if (!isset($_SESSION['admin_logged'])) {
                    $_SESSION['admin_logged'] = TRUE;
                }
            }
        } else { header('Location: ' . url . 'logout'); }
		
		if(core_page()[0] != 'settings' && $user['type'] != 2) {
			if($user['nickname'] == NULL || $user['nick_pass'] == NULL) {
				core_header('settings');
			}
		}
    }
}

// Change the type to a group name
function user_group($conn, $type) {

	$group = '';

	switch($type) {

		case 0: {
			$group = language($conn, 'groups', 'banned');
			break;
		}
		case 1: {
			$group = language($conn, 'groups', 'member');
			break;
		}
		case 2: {
			$group = language($conn, 'groups', 'admin');
			break;
		}

	}

	return $group;
}

function user_get_groups($conn) {
	$array = array('0' => language($conn, 'groups', 'banned'), '1' => language($conn, 'groups', 'member'), '2' => language($conn, 'groups', 'admin'));
	
	return $array;
}