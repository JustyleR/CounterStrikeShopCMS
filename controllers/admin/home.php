<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('home');
}

function main() {
    template('admin/home');
}