<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('editFlag', '{NUMBER}');
}

function main() {
    $page = core_page();

    if ($page[2] != NULL) {
        $page        = core_POSTP($page[2]);
        $checkServer = query("SELECT flag_id FROM flags WHERE flag_id='$page'");
        if (num_rows($checkServer) > 0) {
            template('admin/editFlag');
        } else {
            template('admin/home');
        }
    } else {
        template('admin/home');
    }
}

function editFlag() {
    $page  = core_page()[2];
    $query = query("SELECT * FROM flags WHERE flag_id='$page'");
    return $row   = fetch_assoc($query);
}

function editFlag_submit() {
    if (isset($_POST['edit'])) {
        $flag      = core_POSTP($_POST['flag']);
        $flagDesc  = core_POSTP($_POST['flagDesc']);
        $flagPrice = core_POSTP($_POST['flagPrice']);
        $flagID    = core_page()[2];

        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
            core_message_set('editFlag', language('messages', 'FILL_THE_FIELDS'));
        } else {
            query("UPDATE flags SET flag='$flag', flagDesc='$flagDesc', price='$flagPrice' WHERE flag_id='$flagID'");
            core_message_set('editFlag', language('messages', 'SUCCESSFULLY_UPDATED_THE_FLAG'));
            core_header('', 1);
        }
    }
}
