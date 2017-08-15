<?php

if (!defined('file_access')) {
    header('Location: ' . url . ' home');
}

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

function core_page() {
    if(isset($_GET['p'])) {
        $page = $_GET['p'];
        $page = explode('/', $page);
        return $page;
    }
}

function core_header($location, $time = 0) {
    if($time == 0) {
        header('Location: ' . url . $location);
    } else {
        header('refresh:'. $time .';url=' . $location);
    }
}

function core_message($msg) {
    if (isset($_SESSION['msg_' . $msg])) {
        $session = explode('<>', $_SESSION['msg_' . $msg]);
        echo $session[0];
        core_check_message($msg);
    }
}

function core_message_set($session, $msg) {
    $_SESSION['msg_' . $session] = $msg . '<>' . core_date('hour', '1 second');
}

function core_check_message($session) {
    if (isset($_SESSION['msg_' . $session])) {
        $nsession = explode('<>', $_SESSION['msg_' . $session]);

        if($nsession[1] <= core_date('hour')) {
            unset($_SESSION['msg_' . $session]);
        }
    }
}

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

function core_POSTP($string) {
    $string = mysqli_real_escape_string(connect(), $string);
    
    return $string;
}

function core_if_file_exists($path, $filename){
    if ($pos = strrpos($filename, '.')) {
           $name = substr($filename, 0, $pos);
           $ext = substr($filename, $pos);
    } else {
           $name = $filename;
           $ext = '';
    }

    $newpath = $path.'/'.$filename;
    $newname = $filename;
    $counter = 0;
    while (file_exists($newpath)) {
           $newname = $name .'_'. $counter . $ext;
           $newpath = $path.'/'.$newname;
           $counter++;
     }

    return $newname;
}