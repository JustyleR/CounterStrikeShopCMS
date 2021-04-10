<?php

/*
 * @project SMS CMS
 * @author  JustyleR
 * @version 1.1
 */

define('file_access', TRUE);

// Core files
require('config/config.php');
require('libs/Bootstrap.php');
require('libs/Users.php');
require('libs/Core.php');
require('libs/Language.php');
require('libs/BBCodes.php');
require('libs/Custom.php');
require('libs/CSBans.php');
require('libs/Pagination.php');
require('libs/Rcon.php');
require('libs/composer/vendor/autoload.php');
require('libs/Template.php');
Bootstrap();
