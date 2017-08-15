<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('credits');
}

function main() {
    core_check_logged('user', 'logged');
    template('credits');
}