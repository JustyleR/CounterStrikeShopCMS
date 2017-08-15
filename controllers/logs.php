<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('logs');
}

function main() {
    core_check_logged('user', 'logged');
    template('logs');
}
