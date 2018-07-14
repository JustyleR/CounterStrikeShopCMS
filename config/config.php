<?php
ob_start();
session_start();

date_default_timezone_set('Europe/Sofia');

// Database connect settings
define('db_host', 'localhost'); // Hostname
define('db_user', 'root'); // User
define('db_pass', ''); // Password
define('db_name', 'sms'); // Database
define('prefix',  'csbans_'); // Prefix for AMXBans tables

// Include the Database library and get the site settings from the table
require('libs/Database.php');
$settings = get_site_settings();

// Settings
define('url', ''); // Don't forget to add the / at the end of the link (sitename.com/sms/)

// Define the settings from the table
define('template', $settings['template']);
define('default_language', $settings['language']);
define('site_title', $settings['site_title']);
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