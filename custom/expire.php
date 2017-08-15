<?php

if (!defined('file_access')) {
    header('Location: home');
}

$get = query("SELECT * FROM flag_history");
if(num_rows($get) > 0) {
    $date = strtotime(core_date());
    while($row = fetch_assoc($get)) {
        $expireDate = strtotime($row['dateExpire']);
        if($date >= $expireDate) {
            $getFlags = query("SELECT flags FROM admins WHERE nickname='". $row['nickname'] ."' AND server='". $row['server'] ."'");
            if(num_rows($getFlags) > 0) {
                $row2 = fetch_assoc($getFlags);
                $flags = str_replace($row['flag'], '', $row2['flags']);
                query("UPDATE admins SET flags='$flags' WHERE nickname='". $row['nickname'] ."' AND server='". $row['server'] ."'");
                query("DELETE FROM flag_history WHERE flag_id='". $row['flag_id'] ."'");
            }
        }
    }
}