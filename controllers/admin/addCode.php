<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('addCode');
}

// Main function
function main($conn) {
    // Load the template
    $template = template($conn, 'admin/addCode');
    // Load the default template variables
    $vars = template_vars($conn);

    $code = addCode($conn);

    $vars['message'] = $code[0];
    $vars['code']    = $code[1];

    echo $template->render($vars);
}

function addCode($conn) {
    $message = core_message('addCode');

    if (isset($_SESSION['code'])) {
        $code = $_SESSION['code'];

        unset($_SESSION['code']);
    } else {
        $code = '';
    }

    if (isset($_POST['add'])) {
        $balance	= core_POSTP($conn, $_POST['code']);
        $code		  = random(6, 1);


        if (empty($balance)) {
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
            query($conn, "INSERT INTO " . _table('codes') . " (code, balance) VALUES ('$code','$balance')");

            $_SESSION['code'] = $code;


            $message = language($conn, 'messages', 'SUCCESSFULLY_CREATED_CODE');
        }

        core_message_set('addCode', $message);
        core_header('!admin/addCode');
    }
    return array($message, $code);
}
