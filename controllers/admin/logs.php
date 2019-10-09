<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Pages function
function main_info() {
    return array('logs', '{STRING}', '{NUMBER}');
}

// Main function
function main($conn) {
  // Load the template
  $template = template($conn, 'admin/logs');
  // Load the default template variables
  $vars = template_vars($conn);

  $getLogs = pagination($conn, "SELECT * FROM " . _table('logs') . " ORDER BY log_id DESC", 14);
  $vars['logs'] = $getLogs;

  echo $template->render($vars);
}
