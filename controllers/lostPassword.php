<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('lostPassword');
}

function main() {
    core_check_logged('user');
    template('lostPassword');
}

function login() {
    if (isset($_POST['login'])) {
        $email    = core_POSTP($_POST['email']);

        if (empty($email)) {
            core_message_set('lostPassword', language('messages', 'FILL_THE_FIELDS'));
        } else {
            $check = query("SELECT email FROM users WHERE email='$email'");
            if (num_rows($check) > 0) {
                $row = fetch_assoc($check);
                
            } else {
                core_message_set('login', language('messages', 'EMAIL_DOESNT_EXISTS'));
            }
        }
    }
}
