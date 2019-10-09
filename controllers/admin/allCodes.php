<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('allCodes', '{STRING}', '{NUMBER}');
}

// Main function
function main($conn) {
    // Load the template
    $template = template($conn, 'admin/allCodes');
    // Load the default template variables
    $vars = template_vars($conn);

    $getCodes = pagination($conn, "SELECT * FROM " . _table('sms_codes') . "", 10);

    $vars['codes'] = $getCodes;

    echo $template->render($vars);
}
