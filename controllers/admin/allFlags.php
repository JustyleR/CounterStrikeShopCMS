<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('allFlags', '{EVERYTHING}');
}

// Main function
function main($conn) {
	// Pages
    $page = core_page();
	
	// Check if we have the servername set
    if ($page[2] != NULL) {
        $serverName		= core_POSTP($conn, $page[2]);
        $checkServer	= query($conn, "SELECT * FROM "._table('servers')." WHERE shortname='". $serverName ."'");
        if (num_rows($checkServer) > 0) {
			$content = template($conn, 'admin/allFlags');
			$content = allFlags($conn, $content);
			
			echo $content;
        } else { core_header('!admin/allFlags/'); }
    } else {
        $content = template($conn, 'admin/chooseServer');
		$content = template_show_servers($conn, $content);
		
		if(isset($_POST['choose'])) {
			$page = core_page();
			
			core_header('!admin/allFlags/' . $_POST['server']);
		}
		
		echo $content;
    }
}

function allFlags($conn, $content) {
	
    $page	= core_page();
	$cAllFlags = comment('SHOW ALL FLAGS', $content);
	$cText	= comment('SHOW NOTHING ADDED', $content);
	
    $getFlags = query($conn, "SELECT * FROM "._table('flags')." WHERE server='". $page[2] ."'");
    if (num_rows($getFlags) > 0) {
		
		$cFlags		= comment('SHOW FLAGS', $content);
		$list		= "";
		
        while ($row	= fetch_assoc($getFlags)) {
            
			$replace	= ['{FLAG}', '{FLAG_PRICE}', '{FLAG_ID}'];
			$with		= [$row['flag'], $row['price'], $row['flag_id']];
			$list 		.= str_replace($replace, $with, $cFlags);
			
        }
		
		$content = str_replace($cFlags, $list, $content);
		$content = str_replace('{SERVER_NAME}', $page[2], $content);
		$content = str_replace($cText, '', $content);
    } else {
		$content = str_replace($cAllFlags, '', $content);
        $content = str_replace('{NOTHING_ADDED}', language($conn, 'messages', 'NOTHING_ADDED'), $content);
    }
	
	return $content;
}
