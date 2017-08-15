<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('test');
}

function main() {
    csbans_createAdmin('classic');
}