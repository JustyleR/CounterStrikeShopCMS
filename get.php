<?php

define('file_access', TRUE);

require('config/config.php');
require('libs/Database.php');
require('libs/Core.php');

if(isset($_GET['type'])) {
	$type = $_GET['type'];
	

	if($type === 'user') {
		if(isset($_GET['email'])) {
			$email = core_POSTP($_GET['email']);
			$query = query("SELECT user_id,email,nickname,lang,balance,type,registerDate FROM users WHERE email='$email'");
			if(num_rows($query) > 0) {
				print json_encode(fetch_assoc($query));
			}
		}
	} else if($type === 'users') {
		if($_GET['num'] === 0) {
			// Get all users
		} else {
			if(isset($_GET['email'])) {
				$email = core_POSTP($_GET['email']);
				$query = query("SELECT user_id,email,nickname,lang,balance,type,registerDate FROM users WHERE email LIKE '%$email%'");
				if(num_rows($query) > 0) {
					$array = array();
					while($row = fetch_assoc($query)) {
						$array[] = $row;
					}
					print json_encode($array);
				}
			}
		}
	}
}

