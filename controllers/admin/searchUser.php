<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('searchUser', '{EVERYTHING}');
}

// Main function
function main() {
	// Pages
	$page = core_page();
	// Check if we have the user email adress set
    if ($page[2] == NULL) {
		// Include the template file
        template('admin/searchUser');
    } else {
		// Include the template file
        template('admin/viewUser');
    }
}

function editUser() {
    if (isset($_POST['edit'])) {
        $email          = core_POSTP($_POST['email']);
        $password       = core_POSTP($_POST['password']);
        $nickname       = core_POSTP($_POST['nickname']);
        $nickname_pass  = core_POSTP($_POST['nickname_pass']);
		if(md5_enc != 0) {$nickname_npass  = md5($nickname_pass); } else { $nickname_npass  = $nickname_pass; }
        $balance        = core_POSTP($_POST['balance']);
        $type           = core_POSTP($_POST['type']);
        $user           = user_info($_SESSION['original_email']);
        unset($_SESSION['original_email']);

        if (empty($email) || (empty($nickname)) || (empty($nickname_pass))) {
			// Set the output message
            core_message_set('edit_user', language('messages', 'FILL_THE_FIELDS'));
        } else {
			// Set next to 0 so the script cannot continue
            $next = 0;

            if ($type != $user['type']) {
                query("UPDATE users SET type='$type' WHERE email='" . $user['email'] . "'");
				// Set next to 1 so the script can continue
                $next = 1;
            }

            if ($email != $user['email']) {
                $checkEmail = query("SELECT email FROM users WHERE email='$email'");
                if (num_rows($checkEmail) > 0) {
					// Set the output message
                    core_message_set('edit_user', language('messages', 'EMAIL_ALREADY_IN_USE'));
                    $next = 0;
                } else {
                    if ($user['email'] === $_SESSION['user_logged']) {
                        unset($_SESSION['user_logged']);
                        $_SESSION['user_logged'] = $email;
                    }
                    query("UPDATE users SET email='$email' WHERE email='" . $user['email'] . "'");
                    query("UPDATE logs SET email='$email' WHERE email='" . $user['email'] . "'");
                    $next = 1;
                }
            }

            if ($password != NULL) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                if ($password != $user['password']) {
                    query("UPDATE users SET password='$password' WHERE email='" . $user['email'] . "'");
                    $next = 1;
                }
            }

            if ($nickname_pass != $user['nick_pass']) {
                query("UPDATE users SET nicknamePass='$nickname_pass' WHERE email='" . $user['email'] . "'");
                query("UPDATE " . prefix . "amxadmins SET password='$nickname_npass' WHERE nickname='" . $user['nickname'] . "'");
                $next = 1;
            }

            if ($nickname != $user['nickname']) {
                if (preg_match("/[^a-zA-Z0-9.!@#$%^&*()_+-=<>?` ]/i", $nickname)) {
					// Set the output message
                    core_message_set('settings', language('messages', 'CONTAINS_UNAUTHORIZED_CHARACTERS'));
                    $next = 0;
                } else {
                    $checkNickname = query("SELECT nickname FROM users WHERE nickname='$nickname'");
                    if (num_rows($checkNickname) > 0) {
						// Set the output message
                        core_message_set('edit_user', language('messages', 'NICKNAME_ALREADY_IN_USE'));
                        $next = 0;
                    } else {
                        query("UPDATE users SET nickname='$nickname' WHERE email='" . $user['email'] . "'");
                        query("UPDATE " . prefix . "amxadmins SET nickname='$nickname', steamid='$nickname' 
						WHERE nickname='" . $user['nickname'] . "'");
                        query("UPDATE flag_history SET nickname='$nickname' WHERE nickname='" . $user['nickname'] . "'");
                        $next = 1;
                    }
                }
            }

            if ($balance != $user['balance']) {
                query("UPDATE users SET balance='$balance' WHERE email='" . $user['email'] . "'");
                $next = 1;
            }

            if ($next === 1) {
				// Redirect to a page after 0 seconds
                core_header('!admin/searchUser/' . $email, 0);
            }
        }
    }
	if(isset($_POST['delete'])) {
		query("DELETE FROM users WHERE email='". core_page()[2] ."'");
		core_header('!admin/allUsers/cPage/1');
	}
}
