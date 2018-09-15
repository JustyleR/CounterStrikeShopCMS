<?php
define('file_access', TRUE);

require('config/config.php');
require('libs/Core.php');
require('libs/Language.php');

$conn = connect();

$type = isset($_GET['type']) ? trim($_GET['type']) : "";
$email = isset($_GET['email']) ? core_POSTP($conn, trim($_GET['email'])) : "";

switch($type)
{
		case 'user': {			
				$query = query($conn, "SELECT user_id,email,nickname,lang,balance,type,registerDate FROM "._table('users')." WHERE email='$email'");
				if(num_rows($query) > 0) {
					print json_encode(fetch_assoc($query));
				}
				break;
		}
		
		case 'users': {
			if(isset($_GET['num']) && ctype_digit($_GET['num'])) {
				$num = $_GET['num'];
				
				if($num == 0) {
					// Вадене на всички потребители
				} else {
					$query = query($conn, "SELECT user_id,email,nickname,lang,balance,type,registerDate FROM "._table('users')." WHERE `email` LIKE '%$email%' LIMIT ". $num ."");
					if($query && num_rows($query) > 0) {
						$array = array();
						
						while($row = fetch_assoc($query)) {
							$array[] = $row;
						}
						
						print json_encode($array);						
					} else { echo 'test'; }
				}
			}
			break;
		}
		
		case 'paypal-verify': {
			
			$raw_post_data	= file_get_contents('php://input');
			
			if($raw_post_data != NULL) {
				
				$raw_post_array	= explode('&', $raw_post_data);
				$myPost			= array();
				
				foreach ($raw_post_array as $keyval) {
					
				  $keyval = explode ('=', $keyval);
				  
				  if (count($keyval) == 2) { $myPost[$keyval[0]] = urldecode($keyval[1]); }
				}
				
				$req = 'cmd=_notify-validate';
				
				foreach ($myPost as $key => $value) {
					
					$value = urlencode($value);
					$req .= "&$key=$value";
				}
				
				
				if(paypal_type == 'test') {$ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr'); }
				else { $ch = curl_init('https://www.paypal.com/cgi-bin/webscr'); }
				
				curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
				curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/libs/cert/cacert.pem");
				
				if(!($res = curl_exec($ch))) {
					
				  curl_close($ch);
				  exit;
				}
				
				if (strcmp ($res, "VERIFIED") == 1) {
					
					$payment_status		= $_POST['payment_status'];
					$payment_amount		= $_POST['mc_gross'];
					$payer_email		= core_POSTP($conn, $_POST['payer_email']);
					
					if($payment_status == 'Completed') {
						
						$get = query($conn, "SELECT balance FROM "._table('users')." WHERE email='". $payer_email ."'");
						if(num_rows($get) > 0) {
							
							$balance = fetch_assoc($get)['balance'] + $payment_amount;
							
							query($conn, "UPDATE "._table('users')." SET balance='". $balance ."' WHERE email='". $payer_email ."'");
							
						}
						
						if(paypal_logs == 1) {
							$message = language($conn, 'paypal', 'PAYPAL_SUCCESSFULLY_BOUGHT');
							$message = str_replace('{MONEY}', $payment_amount, $message);
							addLog($conn, $payer_email, $message);
						}
					}
					
				} else {
					
					if(paypal_logs == 1) {
						addLog($conn, 'unknown', language($conn, 'paypal', 'PAYPAL_FAILED_BUY'));
					}
					
				}


				curl_close($ch);
				
			}
			
			break;
		}
}