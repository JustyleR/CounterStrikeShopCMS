<?php

if (!defined('file_access')) {
    header('Location: home');
}

// Check if the language file exists
function check_language($lang) {
    if (!file_exists('language/' . $lang . '/' . $lang . '.ini')) {
        if (file_exists('language/' . default_language . '/' . default_language . '.ini')) {
            $lang = default_language;
            query("UPDATE users SET lang='$lang' WHERE email='" . $_SESSION['user_logged'] . "'");
            core_header('home');
        } else {
            template_error('Could not find the langauge file!', 1);
        }
    }
}

// Use the language
function language($name, $string) {
	if(isset($_SESSION['user_logged'])) {
		$user = user_info($_SESSION['user_logged']);
        check_language($user['language']);
        $lang = $user['language'];
	} else {
		$lang = default_language;
	}
    $ini = parse_ini_file('language/' . $lang . '/' . $lang . '.ini', TRUE);
    return $ini[$name][$string];
}

// Use custom language (in the template folder)
function clanguage($name, $string) {
    if (file_exists('templates/' . template . '/language/' . template_lang . '/' . template_lang . '.ini')) {
        $ini = parse_ini_file('templates/' . template . '/language/' . template_lang . '/' . template_lang . '.ini', TRUE);
        return $ini[$name][$string];
    }
}
