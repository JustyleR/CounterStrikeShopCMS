<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('editFlag', '{NUMBER}');
}

// Main function
function main($conn) {
    // Pages
    $page = core_page();
    // Check if we have the flag id set
    if ($page[2] != NULL) {
        $flagID        = core_POSTP($conn, $page[2]);
        $checkServer   = query($conn, "SELECT flag_id FROM " . _table('flags') . " WHERE flag_id='" . $flagID . "'");
        if (num_rows($checkServer) > 0) {
            // Load the template
            $template = template($conn, 'admin/editFlag');
            // Load the default template variables
            $vars = template_vars($conn);

            $getFlag = db_array($conn, "SELECT * FROM " . _table('flags') . " WHERE flag_id='" . $page[2] . "'");

            $vars['flag']     = $getFlag[0];
            $vars['message']  = editFlag_submit($conn);

            echo $template->render($vars);
        } else {
            core_header('!admin/allFlags');
        }
    } else {
        core_header('!admin/allFlags');
    }
}


// Call the function after the submit button
function editFlag_submit($conn) {
    $message = core_message('editFlag');
    if (isset($_POST['edit'])) {
        $flag      = core_POSTP($conn, $_POST['flag']);
        $flagDesc  = core_POSTP($conn, $_POST['flagDesc']);
        $flagPrice = core_POSTP($conn, $_POST['flagPrice']);
        $flagID    = core_page()[2];

        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
            query($conn, "UPDATE " . _table('flags') . " SET flag='" . $flag . "', flagDesc='" . $flagDesc . "', price='" . $flagPrice . "' WHERE flag_id='" . $flagID . "'");

            $message = language($conn, 'messages', 'SUCCESSFULLY_UPDATED_THE_FLAG');
        }
        core_message_set('editFlag', $message);
        core_header('!admin/editFlag/' . core_page()[2]);
    }

    return $message;
}
