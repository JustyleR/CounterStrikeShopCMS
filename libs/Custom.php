<?php
/*
	Custom Library
	File for custom functions
*/

if (!defined('file_access')) {
    die();
}

// Return all servers into array
function get_all_servers($conn) {
	$get = mysqli_query($conn, "SELECT * FROM "._table('servers')."");
	if(num_rows($get) > 0) {

		$array = array();

		while($row = fetch_assoc($get)) {

			$csbans = csbans_serverInfo($conn, $row['csbans_id']);

			$replace	= ['{SERVER}', '{SERVER_NAME}'];
			$with		= [$row['shortname'], $csbans['hostname']];

			$arr = array();

			$arr['csbans_hostname'] = $csbans['hostname'];
			$arr['sms_hostname'] = $row['shortname'];

			$array[] = $arr;

		}

		return $array;

	} else {

		return '';

	}
}
