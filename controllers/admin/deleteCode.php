<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('deleteCode', '{NUMBER}', '{NUMBER}');
}

// Main function
function main($conn) {
	// Pages
	$page = core_page();
	
    if ($page[2]	!= NULL) {
        $codeID		= (int)$page[2];
        $checkCode	= query($conn, "SELECT sms_code_id FROM "._table('codes')." WHERE sms_code_id='". $codeID ."'");
        if (num_rows($checkCode) > 0) {
            query($conn, "DELETE FROM "._table('codes')." WHERE sms_code_id='". $codeID ."'");
			
            core_header('!admin/allCodes/cPage/' . $page[3]);
        } else { core_header('!admin/allCodes/cPage/' . $page[3]); }
    } else { core_header('!admin/allCodes/cPage/' . $page[3]); }
}
