<?php
define('file_access', TRUE);

require('config/config.php');
require('libs/Core.php');

$conn = connect();

$type = isset($_GET['type']) ? trim($_GET['type']) : "";
$email = isset($_GET['email']) ? core_POSTP($conn, trim($_GET['email'])) : "";

switch($type)
{
		case 'user': {				
				$query = query($conn, "SELECT user_id,email,nickname,lang,balance,type,registerDate FROM users WHERE email='$email'");
				if(num_rows($query) > 0) {
					print json_encode(fetch_assoc($query));
				}
		}
		
		case 'users': {
			if(isset($_GET['num']) && ctype_digit($_GET['num'])) {
				$num = $_GET['num'];
				
				if($num == 0) {
					// Вадене на всички потребители
				} else {
					$query = query($conn, "SELECT user_id,email,nickname,lang,balance,type,registerDate FROM users WHERE `email` LIKE '%$email%'");
					if($query && num_rows($query) > 0) {
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