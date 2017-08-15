<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('deleteFlag', '{NUMBER}');
}

function main() {
    $page = core_page();

    if ($page[2] != NULL) {
        $page        = core_POSTP($page[2]);
        $checkFlag = query("SELECT flag_id FROM flags WHERE flag_id='$page'");
        if (num_rows($checkFlag) > 0) {
            query("DELETE FROM flags WHERE flag_id='$page'");
            core_header('!admin/allFlags/');
        } else {
            core_header('!admin/home');
        }
    } else {
        core_header('!admin/home');
    }
}