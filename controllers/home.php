<?php

if (!defined('file_access')) {
    header('Location: home');
}

function main_info() {
    return array('home');
}

function main() {
    if(isset($_SESSION['user_logged'])) {
        template('home');
    } else {
        core_header('login');
		template('login');
    }
    
}