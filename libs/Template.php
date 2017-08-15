<?php

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

function template($file) {
    core_file_exists(0, language('errors', 'FILE_DOESNT_EXISTS') . ' templates/' . template . '/structure/' . $file . '.php', 'templates/' . template . '/structure/' . $file . '.php');
}

function template_error($msg, $die = 0) {
    if (file_exists('templates/' . template . '/structure/error.php')) {
        if ($die == 1) {
            die($msg);
        } else {
            require('templates/' . template . '/structure/error.php');
        }
    } else {
        die(language('errors', 'FILE_DOESNT_EXISTS') . 'templates/' . template . '/structure/error.php');
    }
}
