****** What is KeyPass? *******

KeyPass is a password-storage solution. I tried to apply the principles of a proof-hosting application.

This is the server part of KeyPass. It's pretty straighforward, a basic request handler.


****** Is there any components I should know about? ******

I've used Code Igniter framework.


****** Installation ******

You have to set up a MySQL database. Then dump in 'database.sql'
You have to edit its information in /application/config/database.php

Then you have to set the server url in /application/config/config.php (you may want to take a deeper look at this file).

Finaly, you have to edit /.htaccess, to set the correct RewriteBase (the name of the folder where the app is).

You can't access the root of the application, it's all right. You can try to go to /request/change_data, you should see a message like "missing parameter"


****** Multi-users ******

You can set several accounts. Each one will have access to his owns data (but no way to access others', because you need the password to decrypt).
To add another user, add an entry in key_user, usr_id because auto-incremented, with a different usr_user, and a password:
the easiest way is to set password to the same value than the first user, and then change it from the application.


****** Backup ******

Keypass now include a database backup feature. A valid user will be able to download a database backup from the client.
It's the whole database, so he'lle be aware of other users, but data stays encrypted so no way he can see them.
Database backups may be stored in /backup directory on the server, so you may want to empty the folder from time to time


****** License ******

Feel free to use, re-use it. I make no warranties about my code.
I would be happy to hear from users (or forks), don't hesitate to send me a message.

Also see CodeIgniter_license.txt