<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('money');
}

function main() {
    core_check_logged('user', 'logged');
    template('money');
}

function money() {
    if (isset($_POST['add'])) {

        $code = core_POSTP($_POST['code']);
        $pay  = 0.00;

        if (mobio_check(servID120, $code) === 1) {
            $pay = money120;
        } else if (mobio_check(servID240, $code)) {
            $pay = money240;
        } else if (mobio_check(servID480, $code)) {
            $pay = money480;
        } else if (mobio_check(servID600, $code)) {
            $pay = money600;
        } else {
            core_message_set('money', language('messages', 'THE_CODE_IS_NOT_VALID'));
        }

        if ($pay > 0) {
            $user    = user_info($_SESSION['user_logged']);
            $balance = $user['balance'] + $pay;

            query("UPDATE users SET balance='$balance' WHERE email='" . $user['email'] . "'");
            core_message_set('money', language('messages', 'SUCCESSFULLY_REDEEMED_MONEY'));
            core_header('money', 2);
        }
    }
}

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
