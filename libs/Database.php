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

function get_site_settings() {
	$get = query("SELECT * FROM settings");
	if(num_rows($get) > 0) {
		
		$arary = array();
		$row = fetch_assoc($get);
		
		return array(
			"template" => $row['template'],
			"language" => $row['language'],
			"md5_enc" => $row['md5_enc'],
			"reloadadmins" => $row['reloadadmins'],
			"servID1" => $row['servID1'],
			"servID2" => $row['servID2'],
			"servID3" => $row['servID3'],
			"servID4" => $row['servID4'],
			"balance1" => $row['balance1'],
			"balance2" => $row['balance2'],
			"balance3" => $row['balance3'],
			"balance4" => $row['balance4'],
		);
		
	} else { die("The settings table is empty! Please reinstall the system!"); }
}