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
			
			$content = template($conn, 'flags');
			$content = show_flags($conn, $content);
			
			echo $content;
			
        } else { core_header('flags/'); }
    } else {
		
		$content = template($conn, 'chooseServer');
		$content = template_show_servers($conn, $content);
		
		if(isset($_POST['choose'])) {
			$page = core_page();
			
			core_header($page[0] . '/' . $_POST['server']);
		}
		
		echo $content;
		
    }
}

function show_flags($conn, $content) {
	
	$cFlags		= comment('SHOW FLAGS INFO', $content);
	$cText		= comment('SHOW NO FLAGS TEXT', $content);
	$server		= core_page()[1];
	$adminID	= csbans_getadminID($conn, $server);
	$content	= str_replace('{YOUR_FLAGS_TITLE}', language($conn, 'titles', 'CURRENT_FLAGS'), $content);
	
	$getFlags = query($conn, "SELECT * FROM ". prefix ."amxadmins WHERE id='$adminID'");
	if(num_rows($getFlags) > 0) {
		
		$row		= fetch_assoc($getFlags);
		$replace	= ['{FLAG}', '{INFORMATION}', '{EXPIRE_DATE}'];
		$with		= [language($conn, 'others', 'FLAG'), language($conn, 'others', 'INFORMATION'), language($conn, 'others', 'DATE_EXPIRE')];
		$content	= str_replace($replace, $with, $content);
		$comment	= comment('SHOW FLAGS', $content);
		$list		= "";
		$flags		= $row['access'];
		$strlen		= strlen($flags);
		
		for ($i = 0; $i <= $strlen; $i++) {
			
			$char	= substr($flags, $i, 1);
			
			$getFlagInfo = query($conn, "SELECT flagDesc FROM "._table('flags')." WHERE flag='". $char ."' AND server='". $server ."'");
			if (num_rows($getFlagInfo) > 0) {
				
				$row = fetch_assoc($getFlagInfo);
				$getFlagExpire = query($conn, "SELECT dateExpire FROM "._table('flag_history')." WHERE flag='". $char ."' AND server='". $server ."'");
				if (num_rows($getFlagExpire) > 0) {
					
					$row2 = fetch_assoc($getFlagExpire);
					$replace	= ['{FLAGS_FLAG}', '{FLAGS_DESCRIPTION}' ,'{FLAGS_EXPIRE_DATE}'];
					$with		= [$char, $row['flagDesc'], $row2['dateExpire']];
					$list		.= str_replace($replace, $with, $comment);
					
				}
				
			}
			
		}
		
		$content = str_replace($comment, $list, $content);
		$content = str_replace($cText, '', $content);
		
	} else {
		
		$content = str_replace($cFlags, '', $content);
		$content = str_replace('{NO_FLAGS_TEXT}', language($conn, 'messages', 'NO_BOUGHT_FLAGS'), $content);
		
	}
	
	return $content;
}