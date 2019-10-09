<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('allFlags', '{EVERYTHING}');
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
            $template = template($conn, 'admin/allFlags');
            // Load the default template variables
            $vars = template_vars($conn);

            $getFlags = db_array($conn, "SELECT * FROM "._table('flags')." WHERE server='". $page[2] ."'", 15);

            $vars['flags'] = $getFlags;

            echo $template->render($vars);
        } else {
            core_header('!admin/allFlags/');
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
