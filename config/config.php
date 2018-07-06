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

require('libs/Database.php');

$settings = get_site_settings();

// Settings
define('url', ''); // Don't forget to add the / at the end of the link (sitename.com/sms/)

define('template', $settings['template']);
define('default_language', $settings['language']);
define('md5_enc', $settings['md5_enc']); // (1 = on / 0 = off ) md5 hash за паролите в сървъра
define('amx_reloadadmins', $settings['reloadadmins']); // (1 = on / 0 = off ) при закупуване на флаг да изпраща reloadadmins команда
define('servID120', $settings['servID1']);
define('servID240', $settings['servID2']);
define('servID480', $settings['servID3']);
define('servID600', $settings['servID4']);
define('money120', $settings['balance1']);
define('money240', $settings['balance2']);
define('money480', $settings['balance3']);
define('money600', $settings['balance4']);
