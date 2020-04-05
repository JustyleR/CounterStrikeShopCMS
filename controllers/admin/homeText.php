<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('homeText');
}

// Main function
function main($conn) {
    // Load the template
    $template = template($conn, 'admin/homeText');
    // Load the default template variables
    $vars = template_vars($conn);

    $vars['sms_text'] = homeGetText($conn);
    $vars['message']  = homeText($conn);

    echo $template->render($vars);
}

function homeGetText($conn) {
    $query = query($conn, "SELECT home FROM " . _table('text') . "");
    if (num_rows($query) > 0) {
        $text = bbcode_brFix(fetch_assoc($query)['home']);
    } else {
        $text = '';
    }

    return $text;
}

function homeText($conn) {
    $message = core_message('text');
    if (isset($_POST['edit'])) {
        $text = bbcode_save(core_POSTP($conn, $_POST['homeText']));

        $get = query($conn, "SELECT home FROM " . _table('text') . "");
        if (num_rows($get) > 0) {
            query($conn, "UPDATE " . _table('text') . " SET home='" . $text . "'");
        } else {
            query($conn, "INSERT INTO " . _table('text') . " (home) VALUES ('" . $text . "')");
        }

        core_message_set('text', language($conn, 'messages', 'CHANGES_SAVED'));
        core_header('!admin/homeText');
    }

    return $message;
}
