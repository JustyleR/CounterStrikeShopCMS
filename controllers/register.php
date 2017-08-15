<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('register');
}

function main() {
    core_check_logged('user');
    template('register');
}

function register() {
    if (isset($_POST['register'])) {
        $email     = core_POSTP($_POST['email']);
        $password  = core_POSTP($_POST['password']);
        $cpassword = core_POSTP($_POST['cpassword']);

        if (empty($email) || (empty($password)) || (empty($cpassword))) {
            core_message_set('register', language('messages', 'FILL_THE_FIELDS'));
        } else {
            if ($password === $cpassword) {
                $checkEmail = query("SELECT email FROM users WHERE email='$email'");
                if (num_rows($checkEmail) > 0) {
                    core_message_set('register', language('messages', 'EMAIL_ALREADY_IN_USE'));
                } else {
                        $ipAdress = $_SERVER['REMOTE_ADDR'];
                        $checkIP  = query("SELECT ipAdress FROM users WHERE ipAdress = '$ipAdress'");
                        if (num_rows($checkIP) > 0) {
                            core_message_set('register', language('messages', 'IP_ALREADY_IN_USE'));
                        } else {
                            $password     = password_hash($password, PASSWORD_DEFAULT);
                            $registerDate = core_date();
                            $lang         = default_language;

                            query("INSERT INTO users (email,password,registerDate,ipAdress,lang) VALUES ('$email', '$password', '$registerDate', '$ipAdress','$lang')");

                            core_message_set('register', language('messages', 'SUCCESSFULLY_REGISTERED'));
                        }
                }
            } else {
                core_message_set('register', language('messages', 'THE_PASSWORDS_DOESNT_MATCH'));
            }
        }
    }
}
