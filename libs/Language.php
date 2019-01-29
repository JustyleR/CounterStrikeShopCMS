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
            template_error($conn, 'Could not find the langauge file!', 'error', 1);
        }
    }
}

// Function for translating stuff in the template engine
function get_language($conn) {
	if(isset($_SESSION['user_logged'])) {
		$user = user_info($conn, $_SESSION['user_logged']);
        check_language($conn, $user['language']);
        $lang = $user['language'];
	} else {
		$lang = default_language;
	}
    
	return define('user_language', $lang);
}

// Function for translating stuff inside php functions
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

// Function to get all available languages into array
function get_languages() {
	$path    	= 'language/';
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