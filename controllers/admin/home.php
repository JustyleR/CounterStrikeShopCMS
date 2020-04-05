<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('home');
}

// Main function
function main($conn) {
    $users		= query($conn, "SELECT user_id FROM " . _table('users') . "");
    $users		= num_rows($users);

    $servers	= query($conn, "SELECT server_id FROM " . _table('servers') . "");
    $servers	= num_rows($servers);

    $flags		= query($conn, "SELECT flag_id FROM " . _table('flags') . "");
    $flags		= num_rows($flags);

    $codes		= query($conn, "SELECT sms_code_id FROM " . _table('codes') . "");
    $codes		= num_rows($codes);

    // Load the template
    $template = template($conn, 'admin/home');
    // Load the default template variables
    $vars = template_vars($conn);

    $vars['count_users']    = $users;
    $vars['count_servers']  = $servers;
    $vars['count_flags']    = $flags;
    $vars['count_codes']    = $codes;

    echo $template->render($vars);
}
