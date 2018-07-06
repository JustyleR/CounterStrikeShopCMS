<?php

/*
 * Simple library for the users stuff
 */

if (!defined('file_access')) {
    header('Location: home');
}

function user_info($email) {
    $checkUser = query("SELECT * FROM users WHERE email='" . $email . "'");
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
		if(isset($_SESSION['user_logged'])) {
			unset($_SESSION['user_logged']);
			core_header('logout');
		}
	}
}

function checkUser() {
    if(isset($_SESSION['user_logged'])) {
        $checkUser = query("SELECT user_id FROM users WHERE email='" . $_SESSION['user_logged'] . "'");
        if (num_rows($checkUser) > 0) {
            $user = user_info($_SESSION['user_logged']);

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
        } else {
            core_header('logout');
        }
		$user = user_info($_SESSION['user_logged']);
		if(core_page()[0] != 'settings' && $user['type'] != 2) {
			if($user['nickname'] == NULL || $user['nick_pass'] == NULL) {
				core_header('settings');
			}
		}
    }
}
