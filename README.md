## SMS CMS

Counter-Strike 1.6 SMS CMS build to work with [CSBans](https://github.com/craft-soft/CS-Bans).

Right now is in very early stage of developement, which means there are alot of bugs that need to be fixed.
I'm releasing the system now so people can be able to check the code and test it to find bugs so i can fix them.

The system is **FREE**, everyone can use it just don't change the author of the system.

## Installation

1. Install [CSBans](https://github.com/craft-soft/CS-Bans).
2. Install the server side plugins so your save can be saved in the Database.
3. Import the .sql files in the same database where you have installed CSBans.
4. When you have everything working, go to config/config.php file and edit these lines:

define('db_host', 'hostname');

define('db_user', 'user');

define('db_pass', 'pass');

define('db_name', 'database');

define('prefix',  'csbans tabel prefix (default amx)');

define('url', 'http://127.0.0.1/');
Your site url (At the end you need to add / or you will have problems)

define('template', 'default'); Template folder name

define('default_language', 'bg'); Language folder name

**The rest is not that important.**