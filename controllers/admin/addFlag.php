<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('addFlag', '{EVERYTHING}');
}

// Main function
function main($conn) {
    // Pages
    $page = core_page();

    // Check if we have the servername set
    if ($page[2] != NULL) {
        $serverName		= core_POSTP($conn, $page[2]);
        $checkServer	= query($conn, "SELECT * FROM " . _table('servers') . " WHERE shortname='" . $serverName . "'");
        if (num_rows($checkServer) > 0) {
            // Load the template
            $template = template($conn, 'admin/addFlag');
            // Load the default template variables
            $vars = template_vars($conn);

            $vars['message'] = addFlag($conn);

            echo $template->render($vars);
        } else {
            core_header('!admin/addFlag/');
        }
    } else {
        // Load the template
        $template = template($conn, 'admin/chooseServer');
        // Load the default template variables
        $vars = template_vars($conn);

        $vars['servers'] = get_all_servers($conn);

        echo $template->render($vars);

        if (isset($_POST['choose'])) {
            core_header($page[0] . '/' . $page[1] . '/' . $_POST['server']);
        }
    }
}

function addFlag($conn) {
    $message = core_message('addFlag');
    if (isset($_POST['add'])) {
        $flag      = core_POSTP($conn, $_POST['flag']);
        $flagDesc  = core_POSTP($conn, $_POST['flagDesc']);
        $flagPrice = core_POSTP($conn, $_POST['flagPrice']);
        $server    = core_page()[2];

        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
            // Set the output message
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
            $checkData = query($conn, "SELECT flag_id FROM " . _table('flags') . " WHERE flag='" . $flag . "' AND server='" . $server . "'");
            if (num_rows($checkData) > 0) {
                // Set the output message
                $message = language($conn, 'messages', 'FLAG_ALREADY_EXISTS');
            } else {
                query($conn, "INSERT INTO " . _table('flags') . " (flag,flagDesc,price,server) VALUES ('" . $flag . "','" . $flagDesc . "','" . $flagPrice . "','" . $server . "')");
                // Set the output message
                $message = language($conn, 'messages', 'SUCCESSFULLY_CREATED_FLAG');
            }
        }
    }

    return $message;
}
