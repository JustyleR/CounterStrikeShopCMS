<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('register');
}

// Main function
function main() {
	// Check if we are not logged in
    core_check_logged('user');
	
	// Include the template file
    template('register');
}

function register() {
    if (isset($_POST['register'])) {
        $email     = core_POSTP($_POST['email']);
        $password  = core_POSTP($_POST['password']);
        $cpassword = core_POSTP($_POST['cpassword']);

        if (empty($email) || (empty($password)) || (empty($cpassword))) {
			// Set the output message
            core_message_set('register', language('messages', 'FILL_THE_FIELDS'));
        } else {
            if ($password === $cpassword) {
                $checkEmail = query("SELECT email FROM users WHERE email='$email'");
                if (num_rows($checkEmail) > 0) {
					// Set the output message
                    core_message_set('register', language('messages', 'EMAIL_ALREADY_IN_USE'));
                } else {
                    $ipAdress = $_SERVER['REMOTE_ADDR'];
                    $checkIP  = query("SELECT ipAdress FROM users WHERE ipAdress = '$ipAdress'");
                    if (num_rows($checkIP) > 0) {
						// Set the output message
                        core_message_set('register', language('messages', 'IP_ALREADY_IN_USE'));
                    } else {
						// Hash the password
                        $password     = password_hash($password, PASSWORD_DEFAULT);
						// Get the current date
                        $registerDate = core_date();
                        $lang         = default_language;

                        query("INSERT INTO users (email,password,registerDate,ipAdress,lang) VALUES ('$email', '$password', '$registerDate', '$ipAdress','$lang')");
						query("INSERT INTO logs (user,date,log) VALUES ('$email','". core_date() ."','". language('logs', 'SUCCESSFULLY_REGISTERED') ."')");
						
						// Set the output message
                        core_message_set('register', language('messages', 'SUCCESSFULLY_REGISTERED'));
						
						$_SESSION['user_logged'] = $email;
						
						core_header('home', 2);
                    }
                }
            } else {
				// Set the output message
                core_message_set('register', language('messages', 'THE_PASSWORDS_DOESNT_MATCH'));
            }
        }
    }
}
