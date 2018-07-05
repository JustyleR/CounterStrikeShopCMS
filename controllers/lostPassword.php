<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('lostPassword', '{STRING}');
}

// Main function
function main() {
	$page = core_page();
	
	// Check if we are logged in
    core_check_logged('user');
	
	// Include the template file
    if($page[1] != NULL) {
		template('lostPasswordChange');
	} else {
		template('lostPassword');
	}
}

function lostPassword() {
    if (isset($_POST['lostPassword'])) {
        $email = core_POSTP($_POST['email']);

        if (empty($email)) {
            core_message_set('lostPassword', language('messages', 'FILL_THE_FIELDS'));
        } else {
            $check = query("SELECT email FROM users WHERE email='$email'");
            if (num_rows($check) > 0) {
                $row	= fetch_assoc($check);
				$key	= random(30, 1);
				$date	= core_date('all', '60 minutes');
				$iQuery = 1;
				$iEmail = 1;
				
				$keyQ = query("SELECT * FROM password_keys WHERE email='$email'");
				if(num_rows($keyQ) > 0) {
					$r = fetch_assoc($keyQ);
					if($r['expireDate'] <= core_date()) {
						query("DELETE FROM password_keys WHERE email='$email'");
						$iQuery = 1;
						$iEmail = 1;
					} else {
						core_message_set('lostPassword', language('messages', 'LOST_PASSWORD_EMAIL_ALREADY_SENT'));
						
						$key = $r['password_key'];
						
						$iEmail = 1;
						$iQuery = 0;
					}
					$iQuery = 0;
				}
				
				if($iQuery == 1) {
					query("INSERT INTO password_keys (email, password_key, expireDate) VALUES ('". $row['email'] ."', '$key', '$date')");
					core_message_set('lostPassword', language('messages', 'LOST_PASSWORD_EMAIL_SENT'));
				}
				
				if($iEmail == 1) {
					if(isset($_SESSION['pass_email'])) {
						if($_SESSION['pass_email'] <= core_date()) {
							//mail($row['email'], 'Lost password', 'Key: $key');
							$_SESSION['pass_email'] = core_date('all', '5 minutes');
						}
					} else {
						//mail($row['email'], 'Lost password', 'Key: $key');
						$_SESSION['pass_email'] = core_date('all', '5 minutes');
					}
				}
				
            } else {
                core_message_set('lostPassword', language('messages', 'EMAIL_DOESNT_EXISTS'));
            }
        }
    }
}

function lostPasswordChange() {
	$key = core_page()[1];
	$query = query("SELECT * FROM password_keys WHERE password_key='$key'");
	if(num_rows($query) > 0) {
		if(isset($_POST['changePassword'])) {
			$password  = core_POSTP($_POST['password']);
			$cpassword = core_POSTP($_POST['cpassword']);

			if ((empty($password)) || (empty($cpassword))) {
				// Set the output message
				core_message_set('lostPasswordChange', language('messages', 'FILL_THE_FIELDS'));
			} else {
				if ($password === $cpassword) {
					$row = fetch_assoc($query);
					
					$password	= password_hash($password, PASSWORD_DEFAULT);
					
					query("UPDATE users SET password='$password' WHERE email='". $row['email'] ."'");
					query("INSERT INTO logs (user,date,log) VALUES ('". $row['email'] ."','". core_date() ."','". language('logs', 'LOST_PASSWORD_CHANGED') ."')");
					query("DELETE FROM password_keys WHERE email='". $row['email'] ."'");
					
					if(isset($_SESSION['pass_key'])) {
						unset($_SESSION['pass_key']);
					}
					
					core_message_set('lostPasswordChange', language('messages', 'SUCCESSFULLY_CHANGED_PASSWORD'));
				} else {
					core_message_set('lostPasswordChange', language('messages', 'THE_PASSWORDS_DOESNT_MATCH'));
				}
			}
		}
	} else {
		core_header('home');
	}
}