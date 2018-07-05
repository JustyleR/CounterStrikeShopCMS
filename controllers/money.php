<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('money');
}

// Main function
function main() {
	// Check if we are logged in
    core_check_logged('user', 'logged');
	
	// Include the template file
    template('money');
}

function money() {
    if (isset($_POST['add'])) {

        $code = core_POSTP($_POST['code']);
        $pay  = 0.00;

		// Check if the code is valid and set the money for the correct servID
        if (mobio_check(servID120, $code) === 1) {
            $pay = money120;
        } else if (mobio_check(servID240, $code)) {
            $pay = money240;
        } else if (mobio_check(servID480, $code)) {
            $pay = money480;
        } else if (mobio_check(servID600, $code)) {
            $pay = money600;
        } else {
            $query = query("SELECT * FROM sms_codes WHERE code='$code'");
			if(num_rows($query) > 0) {
				$pay = fetch_assoc($query)['balance'];
				$db = 1;
			} else {
				core_message_set('money', language('messages', 'THE_CODE_IS_NOT_VALID'));
			}
        }

        if ($pay > 0) {
			// Get the user information
            $user    = user_info($_SESSION['user_logged']);
            $balance = $user['balance'] + $pay;
			
			if(isset($db)) {
				query("DELETE FROM sms_codes WHERE code='$code'");
			}
            query("UPDATE users SET balance='$balance' WHERE email='" . $user['email'] . "'");
			// Set the output message
            core_message_set('money', language('messages', 'SUCCESSFULLY_REDEEMED_MONEY'));
			// Redirect to a page
            core_header('money', 2);
        }
    }
}

// Function to check the code with the servID
function mobio_check($servID, $code, $debug = 0) {
    $res_lines = file("http://www.mobio.bg/code/checkcode.php?servID={$servID}&code={$code}");

    $ret = 0;
    if ($res_lines) {
        if (strstr($res_lines[0], "PAYBG=OK")) {
            $ret = 1;
        } else {
            if ($debug)
                echo $res_lines[0] . "\n";
        }
    }
    else {
        if ($debug)
            echo "Unable to connect to mobio.bg server.\n";
        $ret = 0;
    }

    return $ret;
}
