<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('editFlag', '{NUMBER}');
}

// Main function
function main($conn) {
	// Pages
	$page = core_page();
	// Check if we have the flag id set
    if ($page[2] != NULL) {
        $flagID        = core_POSTP($conn, $page[2]);
        $checkServer = query($conn, "SELECT flag_id FROM flags WHERE flag_id='". $flagID ."'");
        if (num_rows($checkServer) > 0) {
			$content = template($conn, 'admin/editFlag');
			$content = editFlag($conn, $content);
			$content = editFlag_submit($conn, $content);
			
			echo $content;
        } else { core_header('!admin/allFlags'); }
    } else { core_header('!admin/allFlags'); }
}

// Get the information about a flag from the database
function editFlag($conn, $content) {
    $page		= core_page()[2];
    $query	= query($conn, "SELECT * FROM flags WHERE flag_id='". $page ."'");
    $row	= fetch_assoc($query);
	
	$content = str_replace('{FLAG}', $row['flag'], $content);
	$content = str_replace('{FLAG_DESCRIPTION}', $row['flagDesc'], $content);
	$content = str_replace('{FLAG_PRICE}', $row['price'], $content);
	
	return $content;
}

// Call the function after the submit button
function editFlag_submit($conn, $content) {
	$message = core_message('editFlag');
    if (isset($_POST['edit'])) {
        $flag      = core_POSTP($conn, $_POST['flag']);
        $flagDesc  = core_POSTP($conn, $_POST['flagDesc']);
        $flagPrice = core_POSTP($conn, $_POST['flagPrice']);
        $flagID    = core_page()[2];

        if (empty($flag) || (empty($flagDesc)) || (empty($flagPrice))) {
            $message = language($conn, 'messages', 'FILL_THE_FIELDS');
        } else {
            query($conn, "UPDATE flags SET flag='". $flag ."', flagDesc='". $flagDesc ."', price='". $flagPrice ."' WHERE flag_id='". $flagID ."'");
			
            $message = language($conn, 'messages', 'SUCCESSFULLY_UPDATED_THE_FLAG');
        }
		core_message_set('editFlag', $message);
		core_header('!admin/editFlag/' . core_page()[2]);
    }
	
	return $content = str_replace('{SHOW_MESSAGE}', $message, $content);
}
