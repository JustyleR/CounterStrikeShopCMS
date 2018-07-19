<?php
/*
	Core Library
	The core functions for the system
*/

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

// Check if file exists and if it does it will include it
function core_file_exists($die = 0, $msg, $filedir) {
    if (file_exists($filedir)) {
        require($filedir);
    } else {
        if ($die == 0) {
            template_error($msg);
        } else {
            die($msg);
        }
    }
}

// Function to get the url into array
function core_page() {
    if(isset($_GET['p'])) {
        $page = $_GET['p'];
        $page = explode('/', $page);
        return $page;
    }
}

// Function to redirect to a page
function core_header($location, $time = 0) {
    if($time == 0) {
        header('Location: ' . url . $location);
    } else {
		header('refresh:'. $time .'; url=' . url . $location);
    }
}

// Set a message in session so it will be able to be printed in another page
function core_message_set($session, $msg) {
    $_SESSION['msg_' . $session] = $msg . '<>' . core_date('hour', '1 second');
}

// Print the message and call a function to delete the session which has the message
function core_message($msg) {
    if (isset($_SESSION['msg_' . $msg])) {
        $session = explode('<>', $_SESSION['msg_' . $msg]);
		core_check_message($msg);
        return $session[0];
    }
}

// Check if message session is set and if it is then it will unset it
function core_check_message($session) {
    if (isset($_SESSION['msg_' . $session])) {
        $nsession = explode('<>', $_SESSION['msg_' . $session]);

        if($nsession[1] <= core_date('hour')) {
            unset($_SESSION['msg_' . $session]);
        }
    }
}

// Get the date
// (all = day, month, year, hour, seconds) , (day = day, month, year) , (hour = hour, seconds)
function core_date($get = 'all', $plus = 0) {
    if ($plus == 0) {
        if ($get === 'date') {
            $date = date('d-m-Y');
        } else if ($get == 'hour') {
            $date = date('H:i');
        } else if ($get == 'all') {
            $date = date('d-m-Y H:i');
        }
    } else {
        if ($get === 'date') {
            $date = date('d-m-Y', strtotime($plus));
        } else if ($get == 'hour') {
            $date = date('H:i', strtotime($plus));
        } else if ($get == 'all') {
            $date = date('d-m-Y H:i', strtotime($plus));
        }
    }

    return $date;
}

// Check if session isset and redirect
// logged = check if user is logged and if he is not, then it will redirect him to the home page
// else it will check if user is logged and if he is then it will redirect him
function core_check_logged($type, $status = 0) {
    if($status === 'logged') {
        if(!isset($_SESSION[$type . '_logged'])) {
            core_header('home');
        }
    } else {
       if(isset($_SESSION[$type . '_logged'])) {
            core_header('home');
        }
    }
}

// A function that will get the POST data and prevent any exploits
function core_POSTP($conn, $string) {
    $string = mysqli_real_escape_string($conn, $string);
    
    return $string;
}

function random($lenght, $upper = 0) {
	
	$array = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m',1,2,3,4,5,6,7,8,9,0);
	
	$string = '';
	
	for($i = 0; $i < $lenght; $i++) {
		
		$string = $string . $array[rand(0, count($array) - 1)];
		
	}
	
	if($upper == 1) {
		return strtoupper($string);
	} else {
		return $string;
	}
}

// Function to add logs
function addLog($conn, $user, $log) {
	query($conn, "INSERT INTO "._table('logs')." (user,date,log) VALUES ('". $user ."','". core_date() ."','". $log ."')");
}