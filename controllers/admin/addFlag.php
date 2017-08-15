<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('addFlag', '{EVERYTHING}');
}

function main() {
    $page = core_page();

    if ($page[2] != NULL) {
        $page        = core_POSTP($page[2]);
        $checkServer = query("SELECT * FROM servers WHERE shortname='$page'");
        if (num_rows($checkServer) > 0) {
            template('admin/addFlag');
        } else {
            template('admin/chooseServer');
        }
    } else {
        template('admin/chooseServer');
    }
}

function addFlag() {
    if (isset($_POST['add'])) {
        $flag      = core_POSTP($_POST['flag']);
        $flagDesc  = core_POSTP($_POST['flagDesc']);
        $flagPrice = core_POSTP($_POST['flagPrice']);
        $server    =  core_page()[2];
        
        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
            core_message_set('addFlag', language('messages', 'FILL_THE_FIELDS'));
        } else {
            $checkData = query("SELECT flag_id FROM flags WHERE flag='$flag'");
            if (num_rows($checkData) > 0) {
                core_message_set('addFlag', language('messages', 'FLAG_ALREADY_EXISTS'));
            } else {
                query("INSERT INTO flags (flag,flagDesc,price,server) VALUES ('$flag','$flagDesc','$flagPrice','$server')");
                core_message_set('addFlag', language('messages', 'SUCCESSFULLY_CREATED_FLAG'));
            }
        }
    }
}
