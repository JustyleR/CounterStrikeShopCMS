<?php
/*
	Database Library
	The core file for the database
*/

if (!defined('file_access')) {
    header('Location: home');
}

// Function to connect to the database
function connect() {
    $conn = mysqli_connect(db_host, db_user, db_pass, db_name);
    if(mysqli_error($conn)) {
        template_error('Cant connect to MySQL!', 1);
    }
    mysqli_set_charset($conn, 'utf8');
    
    return $conn;
}

// Query function
function query($conn, $query) {
    return $conn = mysqli_query($conn, $query);
}

// Get the number of rows
function num_rows($query) {
    if(mysqli_num_rows($query) > 0) {
        $return = mysqli_num_rows($query);
    } else {
        $return = 0;
    }
    
    return $return;
}

// Fetch assoc
function fetch_assoc($query) {
    return mysqli_fetch_assoc($query);
}

// Fetch array
function fetch_array($query) {
    return mysqli_fetch_array($query);
}

// Get the site settings
function get_site_settings() {
	$conn = connect();
	$get = query($conn, "SELECT * FROM "._table('settings')."");
	if(num_rows($get) > 0) {
		
		$row = fetch_assoc($get);
		
		return array(
			"template" => $row['template'],
			"language" => $row['language'],
			"site_title" => $row['site_title'],
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
			"allow_sms" => $row['allow_sms'],
			"allow_paypal" => $row['allow_paypal'],
			"unban_price" => $row['unban_price'],
			"paypal_type" => $row['paypal_type'],
			"paypal_logs" => $row['paypal_logs'],
			"paypal_email" => $row['paypal_email'],
		);
		
	} else { die("The settings table is empty! Please reinstall the system!"); }
}

// set the tables with the current prefix
function _table($table) {
	return sysPrefix . $table;
}

function db_array($conn, $sql) {
  $query = query($conn, $sql);
  if($query !== FALSE) {
	if(num_rows($query) > 0) {
		$array = array();
		while($row = fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	} else { return ''; }
  } else { return ''; }
}