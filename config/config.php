<?php
ob_start();
session_start();

date_default_timezone_set('Europe/Sofia');

// MySQL Connect
define('db_host', '');
define('db_user', '');
define('db_pass', '');
define('db_name', '');
define('prefix',  '');

// Settings
define('url', '');
define('template', 'default');
define('default_language', 'bg');

// Avatar settings
define('avatar_w', 150);
define('avatar_h', 150);

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