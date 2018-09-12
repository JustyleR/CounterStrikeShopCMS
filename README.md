# smsCMS

Automatic Counter-Strike CMS which works with AMXBans where people can buy flags that will expire after 30 days.  
Add flag for a specific server with custom price and after that people can buy that flag for that server for that price.  
There are a few ways to add balance.  
- PayPal - People can used their paypal to add balance to their account.
- [MOBIO](https://mobio.bg/site/) - People can send SMS with specific text and number  and after that they will receieve a SMS with code and with that code they can add balance (ID and Price can be changed from the admin panel)
- Balance Code - From the admin panel can be created a random code with specific balance and when that code is redeemed they will gain the balance.
- Directly while editing an user's profile from the admin panel

# Functions
- Login/Register/Lost password functions
- User settings - Nickname, password in game, language
- Adding balance - PayPal, Mobio, Custom Codes
- Adding servers - Adding specific servers from AMXBans which can be used to create flags for them
- Creating flags - Create flags with custom price for specific server
- Buying flags - Buying flags with balance
- Checking for already bought flags
- Checking the logs
- View profile
- Change user's group - Banned/Member/Admin
- Edit the text in the home and in the add balance pages from the admin panel
- Page where you can change the site settings in the admin panel
- And much more!

## Installation
- **WARNING:** Go to config/config.php and change the file permissions to 777 until you install the system, after that you can change the permission back
- Open hostname/sms/install.php in your browser and follow the instructions
- Delete install.php file and install AMXBans
- After that you should have at least 1 server in the AMXBans table and you can add that server in the SMS CMS from the admin panel and create flags for that server.

If you have any problems or questions then ask them directly to me, JustyleR.
