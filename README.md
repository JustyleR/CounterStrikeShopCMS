# Automatic SMS System that works with AMXBans.

##### How it works?
You can crate flag from the admin panel and the players can buy it for a price. 
Every flag when bought will expire after 30 days.

What features does the system offer?
The system is both elementary and complex.
It uses Twig for Template Engine, meaning you don't need much knowledge to edit or create a new template (everything is in pure HTML format).
There is an added feature to change the language (there are only Bulgarian and English), so if you want you can add different languages.

##### What it offers:
- Login / Registration / Forgotten password. [[Demo](https://imgur.com/Qsr7cxB)]
- User settings. [[Demo](https://imgur.com/X1yXj3C)]
- Viewing profile. [[Demo](https://imgur.com/TutlHTD)]
- Modify Home Page Text [[Demo1](https://imgur.com/yY2Kf1c),[Demo2](https://imgur.com/HdAdUU6)]
- Ability to add balance via Mobio, as well as change the text of the page [[Demo1](https://imgur.com/MoZUtqv),[Demo2](https://imgur.com/8rOLW5Q)]
- Code added by admin panel with balance [[Demo](https://imgur.com/0ISgJT3)]
- PayPal Balance Added Option [[Demo](https://imgur.com/oHf0Ghs)]
- Ability to stop balancing functions via SMS or PayPal.
- Added / Edit / Delete flags from the Admin panel. [[Demo1](https://imgur.com/Y3VVIfG),[Demo2](https://imgur.com/pKGiSHB)]
- Buying a flag from the site. [[Demo](https://imgur.com/WVE5lTh)]
- View purchased flags. [[Demo](https://imgur.com/bTad16z)]
- View logs. (Activity History) [[Demo](https://imgur.com/uCrlC9b)]
- When the IP from which the account is registered is banished to a server, it will indicate that it has a ban and give it access to a page related to the ban removal.

##### Briefly about the features in the admin panel:
- Statistics homepage.
- Flag management pages.
- Pages for viewing all users, searching, editing or deleting a user.
- Pages for adding / deleting balance codes.
- Edit page for the homepage of the site and for the page related to load balance.
- Server Management Page with AMXBans.
- Page related to all logs on the site.
- Site settings page.

##### You want to do a template, a translation or something?
###### How to make a template?
You open the templates folder and copy the current template, change its name and start editing it. Go to the site settings page in the admin panel and change the template.

###### How to translate?
You open the language folder and copy a translation, change its name, and start translating. After that, translation will automatically come out as an option on the site.

Want to help with the system? The easiest way is to add me on discord and discuss it there.

##### Installation:
1. Download the system from here.
2. Find the config / config.php file and set it to 777.
3. Open the install.php file through your browser (Example: www.site.com/sms/install.php)
4. Follow the installation steps and then delete the install.php file
5. Reopen the config folder and change the file permissions.
6. The system is already installed and ready for use, however, remember that you need to install AMXBans for it to work.
7. Once you've installed the system, it's time to set up cron jobs. Without it, we can't check for expired flags.
The file for the cronjobs is: cron/deleteFlags.php. Set the time like everyday at 12pm. Because the date used for the flags doesn't have hours, only days. So it's pointless to check every minutes if the flag is expired.

Frequently Asked Questions:

[Q] Is the system going to run on a free host? [A] If AMXBans is working, then the system will too.

[Q] I have a problem with AMXBans, is there any alternative? [A] Yes, you can use CSBans.

[Q] I found a problem with the system, what should I do? [A] Contact me here, Discord or Steam.

[Q] I installed the system and now when I go to the home page it shows nothing.. [A] Check if you have mod_rewrite enabled and if the .htaccess file is in the core directory of the system.

The system is currently on a stable 1.0 version. There may be a change for a little bugs but I'll try to fix them ASAP
