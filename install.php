<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>SMS CMS &bull; Installation</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	</head>

	<body>
		<main role="main">
			<?php

			session_start();

			if(isset($_GET['p'])) {
				$page = $_GET['p'];

				if($page == 'step2') {

					$_SESSION['step1'] = TRUE;
					header('Location: install.php');

				} else if($page == 'goBack') {

					unset($_SESSION['db']);
					unset($_SESSION['config']);
					unset($_SESSION['sql']);
					unset($_SESSION['step1']);
					unset($_SESSION['step2']);
					unset($_SESSION['step3']);
					unset($_SESSION['step4']);

				}
			}

			if(isset($_SESSION['step1'])) {
				echo '
				<div class="container">
					<p><a href="install.php?p=goBack" role="button">&raquo; Start Again &raquo;</a></p>
				</div>
				';
			}

			if(!isset($_SESSION['step1'])) {

				echo '
			<div class="jumbotron">
				<div class="container">
					<h1 class="display-3">Hello, world!</h1>
					<p>
					Counter-Strike SMS CMS by <strong>JustyleR</strong>.<br />
					Add flags so people can be able to buy them for specific price.<br />
					Everything is automatic so you do not need to worry about anything.
					</p>
					<p><a class="btn btn-primary btn-lg" href="https://github.com/JustyleR/smsCMS" role="button">Learn more &raquo;</a></p>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<h2>BALANCE</h2>
						<p>
						People can add funds to their account either with <a href="https://mobio.bg/site/">Mobio</a> or with <a href="http://paypal.com">Paypal</a>.<br />
						Also the site owner can make custom balance codes from the admin panel.
						</p>
					</div>
					<div class="col-md-4">
						<h2>FLAGS</h2>
						<p>
						Add flags from the Admin panel so people can buy them for specific price.<br />
						When the flag is bought then it will be available for the user for only 30 days and it will expire after that time.
						</p>
					</div>
					<div class="col-md-4">
						<h2>AUTOMATIC</h2>
						<p>
						Everything is automatic. You do not need to worry about contacting people about their nickname/password in game to add flags etc.
						People will add funds and buy the flags they want, easy as that.
						</p>
					</div>
				</div>

				<hr />

				<p><a class="btn btn-success btn-lg" href="install.php?p=step2" role="button">Install &raquo;</a></p>
			</div>
				';

			} else if(!isset($_SESSION['step2'])) {
				$message = '';

				if(isset($_POST['next'])) {

					$hostname	= $_POST['hostname'];
					$database	= $_POST['db'];
					$user		= $_POST['user'];
					$password	= $_POST['pass'];

					if(empty($hostname) || (empty($database)) || (empty($user))) {

						$message = 'Please, fill the fields!';

					} else {

						$conn = mysqli_connect($hostname, $user, $password, $database);

						if (mysqli_connect_errno()) {
							$message = 'MySQL Connecton ERROR!';
						} else {

							$_SESSION['db'] = array($hostname, $user, $password, $database);
							$_SESSION['step2'] = TRUE;

							header('Location: install.php');

						}

					}

				}

				echo '
			<div class="jumbotron">
				<div class="container">
					<h1 class="display-3">MySQL Connection</h1>
					<p>
					Plese insert your MySQL information so we can create the connection.
					</p>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<form action="" method="POST">
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="text" name="hostname" class="form-control" placeholder="Hostname">
								</div>
								<div class="col">
									<input type="text" name="db" class="form-control" placeholder="Database">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="text" name="user" class="form-control" placeholder="User">
								</div>
								<div class="col">
									<input type="text" name="pass" class="form-control" placeholder="Password">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="submit" name="next" class="btn btn-primary" value="Next">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									'. $message .'
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
				';
			} else if(!isset($_SESSION['step3'])) {

				$message = '';

				if(isset($_POST['next'])) {

					$email			= $_POST['email'];
					$pass			= $_POST['password'];
					$csprefix		= $_POST['csbansprefix'];
					$smsprefix		= $_POST['smsprefix'];
					$paypal_email	= $_POST['paypal_email'];
					$paypal_enable	= $_POST['paypal_enable'];
					$paypal_logs	= $_POST['paypal_logs'];
					$url			= $_POST['url'];

					if(empty($email) || (empty($pass)) || (empty($url))) {

						$message = 'Please fill E-Mail,Password and Site URL!';

					} else {

						if(substr($url, -1) != '/') { $url.= '/'; }

						if(empty($csprefix)) { $csprefix = 'csbans_'; }
						if(empty($smsprefix)) { $smsprefix = 'sms_'; }

						if(file_exists('config/config.php')) {

						$get	= file_get_contents('config/config.php');

						$get	= str_replace("define('db_host', '');", "define('db_host', '". $_SESSION['db'][0] ."');", $get);
						$get	= str_replace("define('db_user', '');", "define('db_user', '". $_SESSION['db'][1] ."');", $get);
						$get	= str_replace("define('db_pass', '');", "define('db_pass', '". $_SESSION['db'][2] ."');", $get);
						$get	= str_replace("define('db_name', '');", "define('db_name', '". $_SESSION['db'][3] ."');", $get);
						$get	= str_replace("define('prefix', '');", "define('prefix', '". $csprefix ."');", $get);
						$get	= str_replace("define('sysPrefix', '');", "define('sysPrefix', '". $smsprefix ."');", $get);
						$get	= str_replace("define('url', '');", "define('url', '". $url ."');", $get);
						$get	= str_replace("define('paypal_email', '');", "define('paypal_email', '". $paypal_email ."');", $get);
						$get	= str_replace("define('paypal_logs', );", "define('paypal_logs', ". $paypal_logs .");", $get);
						$get	= str_replace("define('paypal_enabled', );", "define('paypal_enabled', ". $paypal_enable .");", $get);

						file_put_contents('config/config.php', $get);

						$_SESSION['step3'] = TRUE;
						$_SESSION['config'] = array($email, $pass, $paypal_email, $paypal_enable, $paypal_logs, $url, $csprefix, $smsprefix);

						header('Location: install.php');

						} else { $msg = 'The file config.php is missing..'; }
					}
				}

				echo '
			<div class="jumbotron">
				<div class="container">
					<h1 class="display-3">Configuration</h1>
					<p>
					Insert your E-Mail, Password, the prefix for the AMXBans tables also the SMS CMS tables prefix etc.
					</p>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<form action="" method="POST">
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="text" name="email" class="form-control" placeholder="Admin E-Mail">
								</div>
								<div class="col">
									<input type="text" name="password" class="form-control" placeholder="Admin Password">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="text" name="csbansprefix" class="form-control" placeholder="AMXBans Prefix">
								</div>
								<div class="col">
									<input type="text" name="smsprefix" class="form-control" placeholder="SMS CMS Prefix">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="text" name="paypal_email" class="form-control" placeholder="PayPal E-Mail">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">Use PayPal?</div>
								<div class="col">
									<select name="paypal_enable" class="custom-select mr-sm-2">
									<option value="1">Yes</option>
									<option value="0">No</option>
								  </select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">Use PayPal Logs?</div>
								<div class="col">
									<select name="paypal_logs" class="custom-select mr-sm-2">
									<option value="1">Yes</option>
									<option value="0">No</option>
								  </select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="text" name="url" class="form-control" placeholder="Site URL">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="submit" name="next" class="btn btn-primary" value="Next">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									'. $message .'
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
				';

			} else if(!isset($_SESSION['step4'])) {


				if(isset($_POST['no'])) {

					$_SESSION['step4'] = TRUE;
					$_SESSION['sql'] = 'no';

					header('Location: install.php');
				} else if(isset($_POST['import'])) {

					$conn = mysqli_connect($_SESSION['db'][0],$_SESSION['db'][1],$_SESSION['db'][2],$_SESSION['db'][3]);

					$templine	= '';
					$lines		= file('SQL/sms.sql');
					$sysPrefix	= $_SESSION['config'][7];

					foreach ($lines as $line) {

						// Skip it if it's a comment
						if (substr($line, 0, 2) == '--' || $line == '') { continue; }

						// Replace the tables with the prefix
						$count = substr_count($line, 'CREATE TABLE `');

						for($i = 0; $i < $count; $i++) {
							$start	= 'CREATE TABLE `';
							$end	= '` (';
							$string	= ' ' . $line;
							$ini	= strpos($string, $start);

							if ($ini == 0) return '';

							$ini	+= strlen($start);
							$len	= strpos($string, $end, $ini) - $ini;
							$table	= substr($string, $ini, $len);

							$line = str_replace('CREATE TABLE `'. $table .'` (', 'CREATE TABLE '. $sysPrefix . $table .' (', $line);
						}

						// Replace the tables with the prefix
						$count = substr_count($line, 'INSERT INTO `');

						for($i = 0; $i < $count; $i++) {
							$start	= 'INSERT INTO `';
							$end	= '` (';
							$string	= ' ' . $line;
							$ini	= strpos($string, $start);

							if ($ini == 0) return '';

							$ini	+= strlen($start);
							$len	= strpos($string, $end, $ini) - $ini;
							$table	= substr($string, $ini, $len);

							$line = str_replace('INSERT INTO `'. $table .'` (', 'INSERT INTO '. $sysPrefix . $table .' (', $line);
						}

						// Replace the tables with the prefix
						$count = substr_count($line, 'ALTER TABLE `');

						for($i = 0; $i < $count; $i++) {
							$start	= 'ALTER TABLE `';
							$end	= '`';
							$string	= ' ' . $line;
							$ini	= strpos($string, $start);

							if ($ini == 0) return '';

							$ini	+= strlen($start);
							$len	= strpos($string, $end, $ini) - $ini;
							$table	= substr($string, $ini, $len);

							$line = str_replace('ALTER TABLE `'. $table .'`', 'ALTER TABLE '. $sysPrefix . $table .' ', $line);
						}

						// Add this line to the current segment
						$templine .= $line;
						// If it has a semicolon at the end, it's the end of the query
						if (substr(trim($line), -1, 1) == ';')
						{
							// Perform the query
							mysqli_query($conn, $templine);
							// Reset temp variable to empty
							$templine = '';
						}

					}
					$conn = mysqli_connect($_SESSION['db'][0],$_SESSION['db'][1],$_SESSION['db'][2],$_SESSION['db'][3]);
					$hash	= password_hash($_SESSION['config'][1], PASSWORD_DEFAULT);
					$rand	= rand(999,9999).rand(999,9999);

					mysqli_query($conn, "INSERT INTO ". $sysPrefix ."users (email,password,type, nickname, nicknamePass,balance,ipAdress,registerDate) VALUES
					('". $_SESSION['config'][0] ."','$hash','2', 'Admin', '$rand','0','". $_SERVER['REMOTE_ADDR'] ."','". date('d-m-Y H:i') ."')");
					
					$_SESSION['step4'] = TRUE;
					$_SESSION['sql'] = 'yes';

					header('Location: install.php');
				}

				echo '
			<div class="jumbotron">
				<div class="container">
					<h1 class="display-3">SQL</h1>
					<p>
					Do you want to import the SQL? The tables and everything.<br />
					This is good if you have not installed the system yet or you want to do a fresh install.
					</p>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<form action="" method="POST">
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="submit" name="import" class="btn btn-success" value="Import">
								</div>
								<div class="col">
									<input type="submit" name="no" class="btn btn-danger" value="Do not">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
				';


			} else if(!isset($_SESSION['finish'])) {

				$config = $_SESSION['config'];

				echo '
			<div class="jumbotron">
				<div class="container">
					<h1 class="display-3">Information</h1>
					<p>
					<table class="table">
						<tbody>
							<tr>
								<td>Admin E-Mail</td>
								<td>'. $config[0] .'</td>
							</tr>
							<tr>
								<td>Admin Password</td>
								<td>'. $config[1] .'</td>
							</tr>
							<tr>
								<td>PayPal E-Mail</td>
								<td>'. $config[2] .'</td>
							</tr>
							<tr>
								<td>PayPal Enable</td>
								<td>';
								if($config[3] == 0) { echo 'No'; } else { echo 'Yes'; }
								echo '</td>
							</tr>
							<tr>
								<td>PayPal Logs</td>
								<td>';
								if($config[4] == 0) { echo 'No'; } else { echo 'Yes'; }
								echo '</td>
							</tr>
							<tr>
								<td>Site URL</td>
								<td>'. $config[5] .'</td>
							</tr>
							<tr>
								<td>AMXBans Prefix</td>
								<td>'. $config[6] .'</td>
							</tr>
							<tr>
								<td>SMS CMS Prefix</td>
								<td>'. $config[7] .'</td>
							</tr>
							<tr>
								<td>Import SQL</td>
								<td>';
								if($_SESSION['sql'] == 'no') { echo 'No'; } else { echo 'Yes'; }
								echo '</td>
							</tr>
						</tbody>
					</table>
					</p>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<form action="" method="POST">
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="submit" name="finish" class="btn btn-success" value="Finish">
								</div>
								<div class="col">
									<input type="submit" name="back" class="btn btn-danger" value="Go Back">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
				';

				if(isset($_POST['finish'])) {

					$_SESSION['finish'] = TRUE;
					header('Location: install.php');

				} else if(isset($_POST['back'])) {

					unset($_SESSION['db']);
					unset($_SESSION['config']);
					unset($_SESSION['sql']);
					unset($_SESSION['step1']);
					unset($_SESSION['step2']);
					unset($_SESSION['step3']);
					unset($_SESSION['step4']);

					header('install.php');

				}

			} else if(isset($_SESSION['finish'])) {

				echo '
			<div class="jumbotron">
				<div class="container">
					<h1 class="display-3">Final</h1>
					<p>
					You have installed the system!<br />
					Please delete the <strong>install.php</strong> file and also the SQL folder.<br /><br />
					Have fun using the system.<br />
					- <strong>JustyleR</strong>
					</p>
					<p><a href="'. $_SESSION['config'][5] .'">To the site</a></p>
				</div>
			</div>
				';

				unset($_SESSION['db']);
				unset($_SESSION['config']);
				unset($_SESSION['sql']);
				unset($_SESSION['step1']);
				unset($_SESSION['step2']);
				unset($_SESSION['step3']);
				unset($_SESSION['step4']);

			}

			?>

		</main>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	</body>
</html>
