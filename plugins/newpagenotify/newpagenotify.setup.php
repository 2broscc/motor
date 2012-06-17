<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=plugins/newpagenotify/newpagenotify.setup.php
Version=100
Updated=2006-apr-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=newpagenotify
Name=Email notification for new pages
Description=Send an email to the administrator when there's a new page in the validation queue.
Version=100
Date=2006-apr-24
Author=Neocrome
Copyright=
Notes=
SQL=
Auth_guests=
Lock_guests=RW12345A
Auth_members=R
Lock_members=W12345A
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
email_address=01:string:::The email address of the administrator
email_title=02:string::New page waiting for validation:Title of the private message
email_body=03:text::Hello,\n\nThere is a new page waiting in the validation queue, click the link below to check it.:Body of the private message
[END_SED_EXTPLUGIN_CONFIG]

==================== */

?>
