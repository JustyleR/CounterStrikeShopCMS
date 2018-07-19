<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('register');
}

// Main function
function main($conn) {
	// Check if we are not logged in
    core_check_logged('user');
	
	$content = template($conn, 'register');
	$content = register($conn, $content);
	
	echo $content;
}

function register($conn, $content) {
	$message = '';
	
    if (isset($_POST['register'])) {
        $email     = core_POSTP($conn, $_POST['email']);
        $password  = core_POSTP($conn, $_POST['password']);
        $cpassword = core_POSTP($conn, $_POST['cpassword']);

        if (empty($email) || (empty($password)) || (empty($cpassword))) {
			// Set the output message
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
            if ($password === $cpassword) {
                $checkEmail = query($conn, "SELECT email FROM "._table('users')." WHERE email='". $email ."'");
                if (num_rows($checkEmail) > 0) {
					// Set the output message
                    $message = language($conn, 'messages', 'EMAIL_ALREADY_IN_USE');
                } else {
                    $ipAdress = $_SERVER['REMOTE_ADDR'];
                    $checkIP  = query($conn, "SELECT ipAdress FROM "._table('users')." WHERE ipAdress = '". $ipAdress ."'");
                    if (num_rows($checkIP) > 0) {
						// Set the output message
                        $message = language($conn, 'messages', 'IP_ALREADY_IN_USE');
                    } else {
						// Hash the password
                        $password     = password_hash($password, PASSWORD_DEFAULT);
						// Get the current date
                        $registerDate = core_date();
                        $lang         = default_language;

                        query($conn, "INSERT INTO "._table('users')." (email,password,registerDate,ipAdress,lang) VALUES ('$email', '$password', '$registerDate', '$ipAdress','$lang')");
						addLog($conn, $email, language($conn, 'logs', 'SUCCESSFULLY_REGISTERED'));
						// Set the output message
                        $message = language($conn, 'messages', 'SUCCESSFULLY_REGISTERED');
						
						$_SESSION['user_logged'] = $email;
						
						core_header('home', 2);
                    }
                }
            } else {
				// Set the output message
                $message = language($conn, 'messages', 'THE_PASSWORDS_DOESNT_MATCH');
            }
        }
    }
	
	return $content = str_replace('{REGISTER_MESSAGE}', $message, $content);
}
