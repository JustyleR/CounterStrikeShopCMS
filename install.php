<form action="" method="POST">
	
	<?php
	$msg = '';
	if(isset($_POST['install'])) {
		
		$hostname 		= $_POST['hostname'];
		$username		= $_POST['user'];
		$password		= $_POST['pass'];
		$dbname			= $_POST['db'];
		$admin_email	= $_POST['admin_email'];
		$admin_pass 	= $_POST['admin_pass'];
		$prefix			= $_POST['csbans_prefix'];
		$sysPrefix		= $_POST['system_prefix'];
		$url			= $_POST['site_url'];
		
		if(substr($url, -1) != '/') {
			
			$url.= '/';
			
		}
		
		if(empty($prefix)) { $prefix = 'csbans_'; }
		
		if(empty($sysPrefix)) { $sysPrefix = 'sms_'; }
		
		$conn = mysqli_connect($hostname, $username, $password, $dbname);
		
		if(mysqli_connect_errno($conn)) {
			
			$msg = 'I cannot connect to MySQL';
			
		} else {
			
			if($_POST['sql'] == 1) {
				
				$templine	= '';
				$lines		= file('SQL/sms.sql');
				
				foreach ($lines as $line)
				{
					
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
				
			}
			
			if(file_exists('config/config.php')) {
			
				$get	= file_get_contents('config/config.php');
				
				$get	= str_replace("define('db_host', '');", "define('db_host', '". $hostname ."');", $get);
				$get	= str_replace("define('db_user', '');", "define('db_user', '". $username ."');", $get);
				$get	= str_replace("define('db_pass', '');", "define('db_pass', '". $password ."');", $get);
				$get	= str_replace("define('db_name', '');", "define('db_name', '". $dbname ."');", $get);
				$get	= str_replace("define('prefix',  '');", "define('prefix',  '". $prefix ."');", $get);
				$get	= str_replace("define('sysPrefix',  '');", "define('sysPrefix',  '". $sysPrefix ."');", $get);
				$get	= str_replace("define('url', '');", "define('url', '". $url ."');", $get);
				
				file_put_contents('config/config.php', $get);
				
				$pass	= password_hash($admin_pass, PASSWORD_DEFAULT);
				$conn2	= mysqli_connect($hostname, $username, $password, $dbname);
				$rand	= rand(999,9999);
				mysqli_query($conn2, "INSERT INTO ". $sysPrefix ."users (email,password,type, nickname, nicknamePass) VALUES ('$admin_email','$pass','2', 'Admin', '$rand')");
				
				$msg	= 'You have installed the system successfully!';
				
			} else {
				
				$msg = 'The file config.php is missing..';
				
			}
			
		}
		
	}
	?>
	
	<input type="text" name="hostname" placeholder="Hostname" />
	<input type="text" name="user" placeholder="Username" />
	<input type="text" name="pass" placeholder="Password" />
	<input type="text" name="db" placeholder="Database" />
	<select name="sql">
		<option value="1">Import SQL</option>
		<option value="0">Dont import SQL</option>
	</select>
	<br /><br />
	<input type="text" name="admin_email" placeholder="Admin email" />
	<input type="text" name="admin_pass" placeholder="Admin password" />
	<br /><br />
	<input type="text" name="csbans_prefix" size="35" placeholder="CSBans tables prefix (default: csbans_)" />
	<input type="text" name="system_prefix" size="35" placeholder="Site prefix (default: sms)" />
	<input type="text" name="site_url" size="40" placeholder="Site url (example: http://www.sitename.com/)" />
	<br /><br />
	<input type="submit" name="install" value="Install" />
	
	<?php echo $msg; ?>
</form>
