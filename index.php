<?php

/*
 * @project SMS CMS
 * @author  JustyleR
 * @version 0.0.3
 */

define('file_access', TRUE);

// Core files
require('config/config.php');
require('libs/Users.php');
require('libs/Bootstrap.php');
require('libs/Template.php');
require('libs/Core.php');
require('libs/Language.php');
require('libs/Pagination.php');
require('libs/CSBans.php');
require('libs/Custom.php');
require('libs/bbcodes.php');
require('libs/Rcon.php');
expire_flags();
checkUser();
Bootstrap();