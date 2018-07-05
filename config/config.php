<?php
ob_start();
session_start();

date_default_timezone_set('Europe/Sofia');

// MySQL Connect
define('db_host', 'localhost');
define('db_user', 'root');
define('db_pass', '');
define('db_name', 'sms');
define('prefix',  'csbans_');

// Settings
define('url', '');
define('template', 'bootstrap');
define('default_language', 'bg');
define('md5_enc', 0); // (1 = on / 0 = off ) md5 hash за паролите в сървъра
define('amx_reloadadmins', 1); // (1 = on / 0 = off ) при закупуване на флаг да изпраща reloadadmins команда

// Mobio Codes
define('servID120', 25);
define('servID240', 26);
define('servID480', 7);
define('servID600', 29);

// Mobio Money Receive
define('money120', 0.50); // serverID120
define('money240', 1.50); // servID240
define('money480', 3.50); // servID480
define('money600', 8.50); // servID600