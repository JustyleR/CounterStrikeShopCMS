<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('settings');
}

// Main function
function main() {
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
	// Include the template file
    template('settings');
}

function settings() {
    $checkUser = query("SELECT * FROM users WHERE email='" . $_SESSION['user_logged'] . "'");
    if (num_rows($checkUser) > 0) {
        $row = fetch_assoc($checkUser);
        if (isset($_POST['save'])) {
            $npassword  = core_POSTP($_POST['npassword']);
            $cpassword  = core_POSTP($_POST['cpassword']);
            $user       = user_info($_SESSION['user_logged']);
            $email      = $user['email'];
            $nickname   = core_POSTP($_POST['nickname']);
            $nick_pass  = core_POSTP($_POST['nick_password']);
			if(md5_enc != 0) {$nick_npass  = md5($nick_pass); } else { $nick_npass  = $nick_pass; }
            $lang       = core_POSTP($_POST['lang']);
            $next       = 0;
			
            if (!empty($npassword)) {
                if (empty($cpassword)) {
					// Set the output message
                    core_message_set('settings', language('messages', 'TYPE_OLD_PASSWORD'));
					// Set next to 0 so the script cannot continue
                    $next = 0;
                } else {
					// Set the changepass to 1 so we can know that the password needs to be changed
                    $changepass = 1;
                }
            } else if (!empty($cpassword)) {
                if (empty($npassword)) {
					// Set the output message
                    core_message_set('settings', language('messages', 'TYPE_NEW_PASSWORD'));
					// Set next to 0 so the script cannot continue
                    $next = 0;
                } else {
					// Set the changepass to 1 so we can know that the password needs to be changed
                    $changepass = 1;
                }
            }

            if (isset($changepass) && $changepass == 1) {
                if ($npassword === $cpassword) {
					// Set the output message
                    core_message_set('settings', language('messages', 'TYPE_DIFFERENT_PASSWORD'));
                } else {
                    if (password_verify($cpassword, $user['password'])) {
                        $npassword = password_hash($npassword, PASSWORD_BCRYPT);
                        query("UPDATE users SET password='$npassword' WHERE email='" . $user['email'] . "'");
						// Set next to 1 so the script can continue
                        $next      = 1;
                    } else {
						// Set the output message
                        core_message_set('settings', language('messages', 'PASSWORD_IS_INCORRECT'));
                        $next = 0;
                    }
                }
            }

            if ($user['nickname'] != $nickname) {
				// Check if there are any symbols that are not allowed
                if (preg_match("/[^a-zA-Z0-9.!@#$%^&*()_+-=<>?` ]/i", $nickname)) {
					// Set the output message
                    core_message_set('settings', language('messages', 'CONTAINS_UNAUTHORIZED_CHARACTERS'));
                    $next = 0;
                } else {
                    $checkNick = query("SELECT nickname FROM users WHERE nickname='$nickname'");
                    if (num_rows($checkNick) > 0) {
						// Set the output message
                        core_message_set('settings', language('messages', 'NICKNAME_ALREADY_IN_USE'));
                        $next = 0;
                    } else {
                        query("UPDATE " . prefix . "amxadmins SET nickname='$nickname', steamid='$nickname' 
						WHERE nickname='" . $user['nickname'] . "'");
                        query("UPDATE flag_history SET nickname='$nickname' WHERE nickname='" . $user['nickname'] . "'");
                        query("UPDATE users SET nickname='$nickname' WHERE email='" . $user['email'] . "'");
                        $next = 1;
                    }
                }
            }

            if ($user['nick_pass'] != $nick_pass) {
                query("UPDATE users SET nicknamePass='$nick_pass' WHERE email='" . $user['email'] . "'");
                query("UPDATE " . prefix . "amxadmins SET password='$nick_npass' WHERE nickname='" . $user['nickname'] . "'");
                $next = 1;
            }

            if ($user['language'] != $lang) {
                query("UPDATE users SET lang='$lang' WHERE email='" . $_SESSION['user_logged'] . "'");
            }

            if ($next == 1) {
                core_message_set('settings', language('messages', 'CHANGES_SAVED'));
				// Redirect to a page after 2 seconds
                core_header('settings', 2);
            }
        }
    } else {
		// Redirect to a page
        core_header('home');
    }
}
