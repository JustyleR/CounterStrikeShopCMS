<?php

namespace Listener;

define('file_access', TRUE);

require('libs/PaypalIPN.php');
require('config/config.php');
require('libs/Core.php');
require('libs/Language.php');

use PaypalIPN;

$ipn = new PaypalIPN();


if (paypal_type == 'test') {
    $ipn->useSandbox();
}

$verified = $ipn->verifyIPN();

$conn = connect();

$payer_email = core_POSTP($conn, $_POST['payer_email']);

if($verified) {
	$payment_status		= $_POST['payment_status'];
	$payment_amount		= $_POST['mc_gross'];
	
	
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
		addLog($conn, $payer_email, language($conn, 'paypal', 'PAYPAL_FAILED_BUY'));
	}
	
}