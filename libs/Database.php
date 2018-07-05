<?php

if (!defined('file_access')) {
    header('Location: home');
}

function connect() {
    $conn = mysqli_connect(db_host, db_user, db_pass, db_name);
    if(mysqli_error($conn)) {
        template_error('Cant connect to MySQL!', 1);
    }
    mysqli_set_charset($conn, 'utf8');
    
    return $conn;
}

function lastid() {
	$conn = connect();
	return mysqli_insert_id($conn);
}

function query($query) {
    $conn = connect();
    return $conn = mysqli_query($conn, $query);
}

function num_rows($query) {
    if(mysqli_num_rows($query) > 0) {
        $return = mysqli_num_rows($query);
    } else {
        $return = 0;
    }
    
    return $return;
}

function fetch_assoc($query) {
    return mysqli_fetch_assoc($query);
}

function fetch_array($query) {
    return mysqli_fetch_array($query);
}