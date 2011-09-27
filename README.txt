****** What is KeyPass? *******

KeyPass is a password-storage solution. I tried to apply the principles of a proof-hosting application.

This is the server part of KeyPass. It's pretty straighforward, a basic request handler.


****** Is there any components I should know about? ******

I've used Code Igniter framework.


****** Installation ******

You have to set up a MySQL database. Then dump in 'database.sql'
You have to edit its information in /application/config/database.php

Finaly, you have to edit /.htaccess, to set the correct RewriteBase (the name of the folder where the app is).


****** License ******

Feel free to use, re-use it. I make no warranties about my code.
I would be happy to hear from users (or forks), don't hesitate to send me a message.

Also see CodeIgniter_license.txt