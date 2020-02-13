<?php

if (!defined('file_access')) { header('Location: home'); }

// Pages function
function main_info() {
    return array('terms');
}

// Main function
function main($conn) {
  // Load the template
  $template = template($conn, 'admin/terms');
  // Load the default template variables
  $vars = template_vars($conn);

  $vars['terms'] = getTerms($conn);
  $vars['message']  = terms($conn);

  echo $template->render($vars);
}

function getTerms($conn) {
    $query = query($conn, "SELECT terms FROM " . _table('sms_text') . "");
    if (num_rows($query) > 0) {
        $text = bbcode_brFix(fetch_assoc($query)['terms']);
    } else {
        $text = '';
    }

    return $text;
}

function terms($conn) {
	$message = core_message('terms');
    if(isset($_POST['edit'])) {

		$text = bbcode_save(core_POSTP($conn, $_POST['terms']));

		$get = query($conn, "SELECT terms FROM "._table('sms_text')."");
		if(num_rows($get) > 0) {

			query($conn, "UPDATE "._table('sms_text')." SET terms='". $text ."'");

		} else {

			query($conn, "INSERT INTO "._table('sms_text')." (terms) VALUES ('". $text ."')");

		}

		core_message_set('terms', language($conn, 'messages', 'CHANGES_SAVED'));
		core_header('!admin/terms');

	}

	return $message;
}
