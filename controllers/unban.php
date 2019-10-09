<?php

/*
	Home page
*/

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('unban');
}

// Main function
function main($conn) {
    if (!isset($_SESSION['user_logged'])) {
        core_header('');
    }

    if (csbans_userBanned($conn) == 0) {
        core_header('home');
    }

    // Load the template
    $template = template($conn, 'unban');
    // Load the default template variables
    $vars = template_vars($conn);

    $vars['message'] = unban($conn);

    echo $template->render($vars);
}

function unban($conn) {
    $message = core_message('unban');

    if (isset($_POST['unban'])) {
        $user = user_info($conn, $_SESSION['user_logged']);

        if ($user['balance'] >= unban_price) {
            csbans_removeBan($conn, $_SERVER['REMOTE_ADDR']);
            addLog($conn, $_SESSION['user_logged'], language($conn, 'amxbans', 'SUCCESSFULLY_REMOVE_BAN_LOG'));

            $message = language($conn, 'amxbans', 'SUCCESSFULLY_REMOVE_BAN');
            core_message_set('settings', $message);
        } else {
            $message = language($conn, 'amxbans', 'NO_ENOUGH_MONEY');
        }
    }

    return $message;
}
