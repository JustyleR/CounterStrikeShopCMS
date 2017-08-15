<?php

/*
 * @project SMS CMS
 * @author  JustyleR
 * @version 0.01
 */

define('file_access', TRUE);

// Core files
require('config/config.php');
require('libs/Database.php');
require('libs/Users.php');
require('libs/Bootstrap.php');
require('libs/Template.php');
require('libs/Core.php');
require('libs/Language.php');
require('libs/Pagination.php');
require('libs/CSBans.php');

// Custom files
require('custom/expire.php');

checkUser();
Bootstrap();