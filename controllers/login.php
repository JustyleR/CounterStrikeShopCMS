<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('login');
}

function main() {
    core_check_logged('user');
    template('login');
}

function login() {
    if (isset($_POST['login'])) {
        $email    = core_POSTP($_POST['email']);
        $password = core_POSTP($_POST['password']);
        
        if (empty($email) || (empty($password))) {
            core_message_set('login', language('messages', 'FILL_THE_FIELDS'));
        } else {
            $check = query("SELECT email,password FROM users WHERE email='$email'");
            if (num_rows($check) > 0) {
                $row = fetch_assoc($check);
                if (password_verify($password, $row['password'])) {
                    $user = user_info($email);
                    if ($user['type'] == 0) {
                        core_message_set('login', language('messages', 'YOUR_ACCOUNT_IS_BANNED'));
                    } else {
                        $_SESSION['user_logged'] = $email;
                        if ($user['type'] == 2) {
                            $_SESSION['admin_logged'] = TRUE;
                        }
                        core_message_set('login', language('messages', 'SUCCESSFULLY_LOGGED_IN'));
                        core_header('home', 2);
                    }
                } else {
                    core_message_set('login', language('messages', 'INVALID_LOGIN_DATA'));
                }
            } else {
                core_message_set('login', language('messages', 'INVALID_LOGIN_DATA'));
            }
        }
    }
}
