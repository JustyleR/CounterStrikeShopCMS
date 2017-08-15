<?php

define('file_access', TRUE);

require('../config/config.php');
require('../libs/Database.php');

query("TRUNCATE TABLE admins");
query("TRUNCATE TABLE flags");
query("TRUNCATE TABLE flag_history");
query("TRUNCATE TABLE logs");
query("TRUNCATE TABLE servers");
query("TRUNCATE TABLE users");