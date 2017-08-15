<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('flags', '{EVERYTHING}');
}

function main() {
    core_check_logged('user', 'logged');
    $page = core_page();

    if ($page[1] != NULL) {
        $page        = core_POSTP($page[1]);
        $checkServer = query("SELECT * FROM servers WHERE shortname='$page'");
        if (num_rows($checkServer) > 0) {
            template('flags');
        } else {
            template('chooseServer');
        }
    } else {
        template('chooseServer');
    }
}
