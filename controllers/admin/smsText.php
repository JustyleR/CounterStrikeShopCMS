<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('smsText');
}

// Main function
function main($conn) {
  // Load the template
  $template = template($conn, 'admin/smsText');
  // Load the default template variables
  $vars = template_vars($conn);

  $vars['sms_text'] = smsGetText($conn);
  $vars['message']  = smsText($conn);

  echo $template->render($vars);
}

function smsGetText($conn) {
    $query = query($conn, "SELECT text FROM " . _table('text') . "");
    if (num_rows($query) > 0) {
        $text = bbcode_brFix(fetch_assoc($query)['text']);
    } else {
        $text = '';
    }

    return $text;
}

function smsText($conn) {
	$message = core_message('smsText');
    if(isset($_POST['edit'])) {

		$text = bbcode_save(core_POSTP($conn, $_POST['smsText']));

		$get = query($conn, "SELECT text FROM "._table('text')."");
		if(num_rows($get) > 0) {

			query($conn, "UPDATE "._table('text')." SET text='". $text ."'");

		} else {

			query($conn, "INSERT INTO "._table('text')." (text) VALUES ('". $text ."')");

		}

		core_message_set('smsText', language($conn, 'messages', 'CHANGES_SAVED'));
		core_header('!admin/smsText');

	}

	return $message;
}
