<?php
/*
	Template Library
	The core file for the template
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

function template($conn, $template) {
	$loader = new Twig_Loader_Filesystem('templates/' . template . '/structure/');
	$twig = new Twig_Environment($loader, array(
	'debug' => true
	));
	
	$lang = get_language($conn);
	
	$translate = new Twig_SimpleFunction('translate', function($cat, $string) {
		$lang = user_language;
		$ini = parse_ini_file('language/' . $lang . '/' . $lang . '.ini', TRUE);
		return $lang = $ini[$cat][$string];
	});
	$twig->addFunction($translate);

	$template = $twig->load($template . '.html');

	return $template;
}

function template_vars($conn) {
  $vars['SITE_TITLE'] = site_title;
  $vars['SITE_TEMPLATE'] = template;
  $vars['SITE_URL'] = url;
  $vars['SITE_PAGE'] = core_page();
  $vars['USER_BANNED'] = csbans_checkBan($conn);
  $vars['SITE_PAYPAL'] = paypal_enabled;
  $vars['SITE_SMS'] = sms_enabled;
  
  if(isset($_SESSION['user_logged'])) {
	$vars['user_info'] = user_info($conn, $_SESSION['user_logged']);
    $vars['user_logged'] = TRUE;
  }
  
  if(isset($_SESSION['admin_logged'])) {
    $vars['admin_logged'] = TRUE;
  }

  return $vars;
}

function template_error($conn, $message, $file = 'error', $die = 0) {
  // Load the template
  $template = template($conn, $file);
  // Load the default template variables
  $vars = template_vars($conn);

  $vars['error_message'] = $message;

  echo $template->render($vars);
}

function get_templates() {
	$path    	= 'templates/';
	$results 	= scandir($path);
	$list		= array();
	foreach ($results as $result) {
		
		if ($result === '.' or $result === '..')
			continue;
		
		if (is_dir($path . '/' . $result)) {
			
			$list[] = $result;
			
		}
	}
	
	return $list;
}
