<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('lostPassword', '{STRING}');
}

// Main function
function main($conn) {
	$page = core_page();

	// Check if we are logged in
  core_check_logged('user');

	// Include the template file
  if($page[1] != NULL) {
    // Load the template
    $template = template($conn, 'lostPasswordChange');
    // Load the default template variables
    $vars = template_vars($conn);

    $vars['message'] = lostPasswordChange($conn);

    echo $template->render($vars);

	} else {
    // Load the template
    $template = template($conn, 'lostPassword');
    // Load the default template variables
    $vars = template_vars($conn);

  	$vars['message'] = lostPassword($conn);

  	echo $template->render($vars);
	}
}

function lostPassword($conn) {
	$message = '';
    if (isset($_POST['lostPassword'])) {
        $email = core_POSTP($conn, $_POST['email']);

        if (empty($email)) {
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
            $check = query($conn, "SELECT email FROM "._table('users')." WHERE email='". $email ."'");
            if (num_rows($check) > 0) {
              $row	= fetch_assoc($check);
              $key	= random(30, 1);
              $date	= core_date('all', '60 minutes');
              $iQuery = 1;
              $iEmail = 1;

              $keyQ = query($conn, "SELECT * FROM "._table('password_keys')." WHERE email='". $email ."'");
              if(num_rows($keyQ) > 0) {
              	$r = fetch_assoc($keyQ);
              	if($r['expireDate'] <= core_date()) {
              		query("DELETE FROM "._table('password_keys')." WHERE email='". $email ."'");
              		$iQuery = 1;
              		$iEmail = 1;
              	} else {
              		$message = language($conn, 'messages', 'LOST_PASSWORD_EMAIL_ALREADY_SENT');

              		$key = $r['password_key'];

              		$iEmail = 1;
              		$iQuery = 0;
              	}
              	$iQuery = 0;
              }

      				if($iQuery == 1) {
      					query($conn, "INSERT INTO "._table('password_keys')." (email, password_key, expireDate) VALUES ('". $row['email'] ."', '". $key ."', '". $date ."')");
      					$message = language($conn, 'messages', 'LOST_PASSWORD_EMAIL_SENT');
      				}

      				if($iEmail == 1) {
      					$body = 'Lost password, '. url .'lostPassword/'. $key .'';
      					if(isset($_SESSION['pass_email'])) {
      						if($_SESSION['pass_email'] <= core_date()) {
      							mail($row['email'], 'Lost password', $body);
      							$_SESSION['pass_email'] = core_date('all', '5 minutes');
      						}
      					} else {
      						mail($row['email'], 'Lost password', $body);
      						$_SESSION['pass_email'] = core_date('all', '5 minutes');
      					}
      				}

            } else {
              $message = language($conn, 'messages', 'EMAIL_DOESNT_EXISTS');
            }
        }
    }

	return $message;
}

function lostPasswordChange($conn) {
	$message = '';
	$key = core_page()[1];
	$query = query($conn, "SELECT * FROM "._table('password_keys')." WHERE password_key='". $key ."'");
	if(num_rows($query) > 0) {
		if(isset($_POST['changePassword'])) {
			$password  = core_POSTP($conn, $_POST['password']);
			$cpassword = core_POSTP($conn, $_POST['cpassword']);

			if ((empty($password)) || (empty($cpassword))) {
				// Set the output message
				$message = language($conn, 'messages', 'FILL_THE_FIELDS');
			} else {
				if ($password === $cpassword) {
					$row = fetch_assoc($query);

					$password	= password_hash($password, PASSWORD_DEFAULT);

					query($conn, "UPDATE "._table('users')." SET password='". $password ."' WHERE email='". $row['email'] ."'");
					addLog($conn, $row['email'], language($conn, 'logs', 'LOST_PASSWORD_CHANGED'));
					query($conn, "DELETE FROM "._table('password_keys')." WHERE email='". $row['email'] ."'");

					if(isset($_SESSION['pass_key'])) {
						unset($_SESSION['pass_key']);
					}

					$message = language($conn, 'messages', 'SUCCESSFULLY_CHANGED_PASSWORD');
				} else {
					$message = language($conn, 'messages', 'THE_PASSWORDS_DOESNT_MATCH');
				}
			}
		}
	} else {
		core_header('home');
	}

	return $message;
}
