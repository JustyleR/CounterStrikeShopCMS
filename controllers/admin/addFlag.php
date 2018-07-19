<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('addFlag', '{EVERYTHING}');
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
			$content = template($conn, 'admin/addFlag');
			$content = addFlag($conn, $content);
			
			echo $content;
			
        } else { core_header('!admin/addFlag/'); }
    } else {
        $content = template($conn, 'admin/chooseServer');
		$content = template_show_servers($conn, $content);
		
		if(isset($_POST['choose'])) {
			$page = core_page();
			
			core_header('!admin/addFlag/' . $_POST['server']);
		}
		
		echo $content;
    }
}

function addFlag($conn, $content) {
	$message = core_message('addFlag');
    if (isset($_POST['add'])) {
        $flag      = core_POSTP($conn, $_POST['flag']);
        $flagDesc  = core_POSTP($conn, $_POST['flagDesc']);
        $flagPrice = core_POSTP($conn, $_POST['flagPrice']);
        $server    = core_page()[2];

        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
			// Set the output message
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
            $checkData = query($conn, "SELECT flag_id FROM "._table('flags')." WHERE flag='". $flag ."'");
            if (num_rows($checkData) > 0) {
				// Set the output message
                $message = language($conn, 'messages', 'FLAG_ALREADY_EXISTS');
            } else {
                query($conn, "INSERT INTO "._table('flags')." (flag,flagDesc,price,server) VALUES ('". $flag ."','". $flagDesc ."','". $flagPrice ."','".  $server ."')");
				// Set the output message
                $message = language($conn, 'messages', 'SUCCESSFULLY_CREATED_FLAG');
            }
        }
    }
	return $content = str_replace('{SHOW_MESSAGE}', $message, $content);
}
