<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('logout');
}

function main() {
    core_check_logged('user', 'logged');
    
    unset($_SESSION['user_logged']);
    unset($_SESSION['admin_logged']);
    core_header('login');
}