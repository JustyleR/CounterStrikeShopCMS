<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('allUsers', '{EVERYTHING}', '{NUMBER}');
}

// Main function
function main($conn) {
    // Load the template
    $template = template($conn, 'admin/allUsers');
    // Load the default template variables
    $vars = template_vars($conn);

    $allUsers = pagination($conn, "SELECT * FROM " . _table('users') . "", 10);

    $vars['users'] = $allUsers;

    echo $template->render($vars);
}
