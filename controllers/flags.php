<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('flags', '{EVERYTHING}');
}

// Main function
function main($conn) {
	// Check if we are logged in
    core_check_logged('user', 'logged');

	// Pages
    $page = core_page();

	// Check if we have the servername set
    if ($page[1] != NULL) {
      $serverName  = core_POSTP($conn, $page[1]);
      $checkServer = query($conn, "SELECT * FROM "._table('servers')." WHERE shortname='". $serverName ."'");
      if (num_rows($checkServer) > 0) {
        // Load the template
        $template = template($conn, 'flags');
        // Load the default template variables
        $vars = template_vars($conn);

      	$vars['flags'] = show_flags($conn);

      	echo $template->render($vars);
      } else { core_header('flags/'); }
    } else {
      // Load the template
      $template = template($conn, 'chooseServer');
      // Load the default template variables
      $vars = template_vars($conn);

    	$vars['servers'] = get_all_servers($conn);

    	echo $template->render($vars);

      if(isset($_POST['choose'])) { core_header($page[0] . '/' . $_POST['server']); }
    }
}

function show_flags($conn) {
	$server		= core_page()[1];
	$adminID	= csbans_getadminID($conn, $server);

	$getFlags = query($conn, "SELECT * FROM ". prefix ."amxadmins WHERE id='$adminID'");
	if(num_rows($getFlags) > 0) {
    $row      = fetch_assoc($getFlags);
		$flags		= $row['access'];
    $user     = user_info($conn, $_SESSION['user_logged']);

		$getFlagsHistory = query($conn, "SELECT * FROM ". sysPrefix ."flag_history WHERE nickname='". $user['nickname'] ."' AND server='". $server ."'");
    if(num_rows($getFlagsHistory) > 0) {
      $tArray = array();
      while($gRow = fetch_assoc($getFlagsHistory)) {
        if (\strpos($flags, $gRow['flag']) !== false) {
            $tArray[] = $gRow['flag'];
            $flags = str_replace($gRow['flag'], '', $flags);
        }
      }

      $array    = array();
      foreach($tArray as $char) {
        $getFlagInfo = query($conn, "SELECT flagDesc FROM "._table('flags')." WHERE flag='". $char ."' AND server='". $server ."'");
  			if (num_rows($getFlagInfo) > 0) {
  				$row = fetch_assoc($getFlagInfo);
  				$getFlagExpire = query($conn, "SELECT dateExpire FROM "._table('flag_history')." WHERE flag='". $char ."' AND server='". $server ."'");
  				if (num_rows($getFlagExpire) > 0) {
  					$row2 = fetch_assoc($getFlagExpire);

            $arr = array();
            $arr['flag'] = $char;
            $arr['desc'] = $row['flagDesc'];
            $arr['expire_date'] = $row2['dateExpire'];
            $array[] = $arr;
  				}
  			}
      }
    } else {
      return '';
    }

    return $array;
	} else {

		return '';

	}
}
