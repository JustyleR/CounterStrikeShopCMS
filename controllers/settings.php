<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('settings');
}

function main() {
    core_check_logged('user', 'logged');
    template('settings');
}

function settings() {
    $checkUser = query("SELECT * FROM users WHERE email='" . $_SESSION['user_logged'] . "'");
    if (num_rows($checkUser) > 0) {
        $row = fetch_assoc($checkUser);
        if (isset($_POST['save'])) {
            $npassword = core_POSTP($_POST['npassword']);
            $cpassword = core_POSTP($_POST['cpassword']);
            $user      = user_info($_SESSION['user_logged']);
            $email     = $user['email'];
            $nickname  = core_POSTP($_POST['nickname']);
            $nick_pass = core_POSTP($_POST['nick_password']);
			$nick_npass = md5($nick_pass);
            $lang      = core_POSTP($_POST['lang']);
            $next      = 0;
            if (!empty($npassword)) {
                if (empty($cpassword)) {
                    core_message_set('settings', language('messages', 'TYPE_OLD_PASSWORD'));
                    $next = 0;
                } else {
                    $changepass = 1;
                }
            } else if (!empty($cpassword)) {
                if (empty($npassword)) {
                    core_message_set('settings', language('messages', 'TYPE_NEW_PASSWORD'));
                    $next = 0;
                } else {
                    $changepass = 1;
                }
            }

            if (isset($changepass) && $changepass == 1) {
                if ($npassword === $cpassword) {
                    core_message_set('settings', language('messages', 'TYPE_DIFFERENT_PASSWORD'));
                } else {
                    if (password_verify($cpassword, $user['password'])) {
                        $npassword = password_hash($npassword, PASSWORD_BCRYPT);
                        query("UPDATE users SET password='$npassword' WHERE email='" . $user['email'] . "'");
                        $next      = 1;
                    } else {
                        core_message_set('settings', language('messages', 'PASSWORD_IS_INCORRECT'));
                        $next = 0;
                    }
                }
            }

            if ($user['nickname'] != $nickname) {
                if (preg_match("/[^a-zA-Z0-9.!@#$%^&*()_+-=<>?` ]/i", $nickname)) {
                    core_message_set('settings', language('messages', 'CONTAINS_UNAUTHORIZED_CHARACTERS'));
                    $next = 0;
                } else {
                    $checkNick = query("SELECT nickname FROM users WHERE nickname='$nickname'");
                    if (num_rows($checkNick) > 0) {
                        core_message_set('settings', language('messages', 'NICKNAME_ALREADY_IN_USE'));
                        $next = 0;
                    } else {
						query("UPDATE ". prefix ."amxadmins SET nickname='$nickname', steamid='$nickname' 
						WHERE nickname='". $user['nickname'] ."'");
						query("UPDATE flag_history SET nickname='$nickname' WHERE nickname='" . $user['nickname'] . "'");
                        query("UPDATE users SET nickname='$nickname' WHERE email='" . $user['email'] . "'");
						$next = 1;
                    }
                }
            }

            if ($user['nick_pass'] != $nick_pass) {
                query("UPDATE users SET nicknamePass='$nick_pass' WHERE email='" . $user['email'] . "'");
				query("UPDATE ". prefix ."amxadmins SET password='$nick_npass' WHERE nickname='" . $user['nickname'] . "'");
                $next = 1;
            }

            if (!file_exists('templates/' . template . '/assets/img')) {
                mkdir('templates/' . template . '/assets/img', 0777, true);
            }

            if (!file_exists('templates/' . template . '/assets/img/avatars')) {
                mkdir('templates/' . template . '/assets/img/avatars', 0777, true);
            }

            $avatarDir       = 'templates/' . template . '/assets/img/avatars/';
            $avatarMaxSize   = 1048576;
            $avatarMaxWidth  = avatar_w;
            $avatarMaxHeight = avatar_h;
            if (isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != NULL) {
                if ($_FILES['avatar']['type'] === 'image/png' || $_FILES['avatar']['type'] === 'image/jpg' || $_FILES['avatar']['type'] === 'image/jpeg') {
                    if ($_FILES['avatar']['size'] > $avatarMaxSize) {
                        core_message_set('settings', language('messages', 'AVATAR_SIZE_NOT_ALLOWED'));
                        $next = 0;
                    } else {
                        $avatarInfo = getimagesize($_FILES['avatar']['tmp_name']);
                        if ($avatarInfo[0] > $avatarMaxWidth) {
                            core_message_set('settings', language('messages', 'AVATAR_WIDTH_NOT_ALLOWED'));
                            $next = 0;
                        } else if ($avatarInfo[1] > $avatarMaxHeight) {
                            core_message_set('settings', language('messages', 'AVATAR_HEIGHT_NOT_ALLOWED'));
                            $next = 0;
                        } else {
                            $avatarName = core_if_file_exists($avatarDir, $_FILES['avatar']['name']);
                            $getAvatar  = query("SELECT avatar_link FROM users WHERE email='" . $_SESSION['user_logged'] . "'");
                            if (num_rows($getAvatar) > 0) {
                                $row = fetch_assoc($getAvatar);
                                if ($row['avatar_link'] != NULL) {
                                    if (file_exists($avatarDir . $row['avatar_link'])) {
                                        unlink($avatarDir . $row['avatar_link']);
                                    }
                                }
                            }
                            query("UPDATE users SET avatar_link='$avatarName' WHERE email='" . $_SESSION['user_logged'] . "'");
                            move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarDir . '/' . $avatarName);
                            $next = 1;
                        }
                    }
                } else {
                    core_message_set('settings', language('messages', 'AVATAR_INVALIDE_FILE_FORMAT'));
                    $next = 0;
                }
            }
            
            if($user['language'] != $lang) {
                query("UPDATE users SET lang='$lang' WHERE email='". $_SESSION['user_logged'] ."'");
            }
            
            if ($next == 1) {
                core_message_set('settings', language('messages', 'CHANGES_SAVED'));
                core_header('settings', 2);
            }
        }
    } else {
        core_header('home');
    }
}
