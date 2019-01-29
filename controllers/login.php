<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('login');
}

// Main function
function main($conn) {
	// Check if we are not logged in
  core_check_logged('user');

  // Load the template
  $template = template($conn, 'login');
  // Load the default template variables
  $vars = template_vars($conn);

	$vars['message'] = login($conn);

	echo $template->render($vars);
}

function login($conn) {
	$message = '';
    if (isset($_POST['login'])) {
        $email    = core_POSTP($conn, $_POST['email']);
        $password = core_POSTP($conn, $_POST['password']);

        if (empty($email) || (empty($password))) {
            $message = language($conn,'messages', 'FILL_THE_FIELDS');
        } else {
            $check = query($conn, "SELECT email,password FROM "._table('users')." WHERE email='". $email ."'");
            if (num_rows($check) > 0) {
                $row = fetch_assoc($check);
                if (password_verify($password, $row['password'])) {
                    $user = user_info($conn, $email);
                    if ($user['type'] == 0) {
                        $message = language($conn,'messages', 'YOUR_ACCOUNT_IS_BANNED');
                    } else {
                        $_SESSION['user_logged'] = $email;
                        if ($user['type'] == 2) {
                            $_SESSION['admin_logged'] = TRUE;
                        }
                        $message = language($conn, 'messages', 'SUCCESSFULLY_LOGGED_IN');
                        core_header('home', 2);
                    }
                } else {
                    $message = language($conn,'messages', 'INVALID_LOGIN_DATA');
                }
            } else {
                $message = language($conn,'messages', 'INVALID_LOGIN_DATA');
            }
        }
    }

	return $message;
}
