<?php
/*
	Language Library
	The core file for the language
*/

if (!defined('file_access')) {
    header('Location: home');
}

// Check if the language file exists
function check_language($conn, $lang) {
    if (!file_exists('language/' . $lang . '/' . $lang . '.ini')) {
        if (file_exists('language/' . default_language . '/' . default_language . '.ini')) {
            $lang = default_language;
            query($conn, "UPDATE "._table('users')." SET lang='$lang' WHERE email='" . $_SESSION['user_logged'] . "'");
            core_header('home');
        } else {
            template_error('Could not find the langauge file!', 1);
        }
    }
}

// Use the language
function language($conn, $name, $string) {
	if(isset($_SESSION['user_logged'])) {
		$user = user_info($conn, $_SESSION['user_logged']);
        check_language($conn, $user['language']);
        $lang = $user['language'];
	} else {
		$lang = default_language;
	}
    $ini = parse_ini_file('language/' . $lang . '/' . $lang . '.ini', TRUE);
    return $ini[$name][$string];
}

// Use custom language (in the template folder)
function clanguage($name, $string) {
	if(isset($_SESSION['user_logged'])) {
		
		$user = user_info($_SESSION['user_logged']);
		$lang = $user['language'];
		
	} else { $lang = default_language; }
	
    if (file_exists('templates/' . template . '/language/' . lang . '/' . lang . '.ini')) {
        $ini = parse_ini_file('templates/' . template . '/language/' . lang . '/' . lang . '.ini', TRUE);
        return $ini[$name][$string];
    }
}

function mlanguage($mod, $name, $string) {
	if(isset($_SESSION['user_logged'])) {
		
		$user = user_info($_SESSION['user_logged']);
		$lang = $user['language'];
		
	} else { $lang = default_language; }
	
	if (file_exists('mods/' . $mod . '/language/' . $lang . '/' . $lang . '.ini')) {
        $ini = parse_ini_file('mods/' . $mod . '/language/' . $lang . '/' . $lang . '.ini', TRUE);
        return $ini[$name][$string];
    }
}