<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('allFlags', '{EVERYTHING}');
}

function main() {
    $page = core_page();

    if ($page[2] != NULL) {
        $page        = core_POSTP($page[2]);
        $checkServer = query("SELECT * FROM servers WHERE shortname='$page'");
        if (num_rows($checkServer) > 0) {
            template('admin/allFlags');
        } else {
            template('admin/chooseServer');
        }
    } else {
        template('admin/chooseServer');
    }
}

function allFlags() {
    $page = core_page()[2];
    
    $getFlags = query("SELECT * FROM flags WHERE server='$page'");
    if(num_rows($getFlags) > 0) {
        $array = array();
        while($row = fetch_assoc($getFlags)) {
            $array[] = $row;
        }
        return $array;
    } else {
        return language('messages', 'NOTHING_ADDED');
    }
}