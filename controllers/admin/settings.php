<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('settings');
}

// Main function
function main($conn) {
	
	$content = template($conn, 'admin/settings');
	$content = getSettings($conn, $content);
	$content = settings_submit($conn, $content);
	
	echo $content;
}

// Get the information about the settings from the database
function getSettings($conn, $content) {
    $query = query($conn, "SELECT * FROM settings");
    if(num_rows($query) > 0) {
		$row 		= fetch_assoc($query);
		$content	= str_replace('{INFO_SITE_TITLE}', $row['site_title'], $content);
		$comment	= comment('SHOW SITE LANGUAGE', $content);
		$path     	= 'language/';
		$results  	= scandir($path);
		$list		= "";
		
		foreach($results as $result) {
			if($result === '.' or $result === '..')
				continue;
			
			if(is_dir($path . '/' . $result)) {
				
				if($row['language'] == $result) { $selected = 'selected'; } else { $selected = ''; }
				
				$replace 	= ['{INFO_SITE_LANGUAGE}', '{SELECTED}'];
				$with		= [$result, $selected];
				$list .= str_replace($replace, $with, $comment);
				
			}
			
		}
		
		$content	= str_replace($comment, $list, $content);
		$comment	= comment('SHOW SITE TEMPLATE', $content);
		$path		= 'templates/';
		$results	= scandir($path);
		$list		= "";

		foreach($results as $result) {
			if($result === '.' or $result === '..')
				continue;

			if(is_dir($path . '/' . $result)) {
				
				if($row['template'] == $result) { $selected = 'selected'; } else { $selected = ''; }
				
				$replace 	= ['{INFO_SITE_TEMPLATE}', '{SELECTED}'];
				$with		= [$result, $selected];
				$list .= str_replace($replace, $with, $comment);
				
			}
		}
		
		$content	= str_replace($comment, $list, $content);
		$comment	= comment('SHOW SITE MD5', $content);
		$list		= "";
		$array		= array(1 => language($conn, 'others', 'YES_'), 0 => language($conn, 'others', 'NO_'));
		
		foreach($array as $id=>$option) {
			
			if($row['md5_enc'] == $id) { $selected = 'selected'; } else { $selected = ''; }
			
			$replace	= ['{INFO_MD5_VALUE}', '{INFO_MD5_OPTION}', '{SELECTED}'];
			$with		= [$id, $option, $selected];
			$list		.= str_replace($replace, $with, $comment);
			
		}
		
		$content	= str_replace($comment, $list, $content);
		$comment	= comment('SHOW SITE AMIND RELOAD', $content);
		$list		= "";
		$array		= array(1 => language($conn, 'others', 'YES_'), 0 => language($conn, 'others', 'NO_'));
		
		foreach($array as $id=>$option) {
			
			if($row['reloadadmins'] == $id) { $selected = 'selected'; } else { $selected = ''; }
			
			$replace	= ['{INFO_RELOAD_VALUE}', '{INFO_RELOAD_OPTION}', '{SELECTED}'];
			$with		= [$id, $option, $selected];
			$list		.= str_replace($replace, $with, $comment);
			
		}
		
		$content	= str_replace($comment, $list, $content);
		
		$replace 	= ['{INFO_MOBIO_ID120}', '{INFO_MOBIO_ID240}', '{INFO_MOBIO_ID480}', '{INFO_MOBIO_ID600}', 
		'{INFO_MOBIO_BALANCE120}', '{INFO_MOBIO_BALANCE240}', '{INFO_MOBIO_BALANCE480}', '{INFO_MOBIO_BALANCE600}'];
		$with		= [$row['servID1'], $row['servID2'], $row['servID3'], $row['servID4'], 
		$row['balance1'], $row['balance2'], $row['balance3'], $row['balance4']];
		$content 	= str_replace($replace, $with, $content);
		
	} else {
		
		template_error($conn, language('errors', 'EMPTY_SETTINGS_TABLE'), 1);
		
	}
	
	return $content;
}

// Call the function after the submit button
function settings_submit($conn, $content) {
	$message = core_message('settings');
    if (isset($_POST['edit'])) {
		$title		= core_POSTP($conn, $_POST['site_title']);
        $lang		= core_POSTP($conn, $_POST['lang']);
		$temp		= core_POSTP($conn, $_POST['template']);
		$md5		= core_POSTP($conn, $_POST['md5']);
		$radmins	= core_POSTP($conn, $_POST['reloadadmins']);
		$id1		= core_POSTP($conn, $_POST['id120']);
		$id2		= core_POSTP($conn, $_POST['id240']);
		$id3		= core_POSTP($conn, $_POST['id480']);
		$id4		= core_POSTP($conn, $_POST['id600']);
		$b1			= core_POSTP($conn, $_POST['b120']);
		$b2			= core_POSTP($conn, $_POST['b240']);
		$b3			= core_POSTP($conn, $_POST['b480']);
		$b4			= core_POSTP($conn, $_POST['b600']);
		

		query($conn, "UPDATE settings SET site_title='". $title ."', template='". $temp ."', language='". $lang ."', md5_enc='". $md5 ."', reloadadmins='". $radmins ."', servID1='". $id1 ."', 
		servID2='". $id2 ."', servID3='". $id3 ."', servID4='". $id4 ."', 
		balance1='". $b1 ."', balance2='". $b2 ."', balance3='". $b3 ."', balance4='". $b4 ."'");
		
		$message = language($conn, 'messages', 'CHANGES_SAVED');
		
		core_message_set('settings', $message);
		core_header('!admin/settings');
    }
	
	return $content = str_replace('{SHOW_MESSAGE}', $message, $content);
}
