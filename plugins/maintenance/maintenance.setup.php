<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/maintenance/maintenance.setup.php
Version=1.0
Updated=2006-apr-19
Type=Plugin
Author=riptide
Description=Plugin based on riptide's ldu forcepage
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=maintenance
Name=Maintenance
Description=Plugin replacing the old ldu maintenance mod
Version=1.0
Date=2005/04/19
Author=riptide
Copyright=
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=12345A
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
reason=01:string::We are updating our website at the moment. Only administrators can log in below.:Reason site is down
status=02:select:No,Yes:No:Turn Maintenance Mode On?
standalone=03:select:No,Yes:No:Change script to redirect to a different page?
page=04:string:::Page to redirect to if redirecting to a seperate page. It can not be a full URL address. Make sure the page exist on your server and is in the SED root!
userauth=05:select:No,Yes:No:Redirect to the user auth page. This is the default choice...
[END_SED_EXTPLUGIN_CONFIG]

==================== */

if ( !defined('SED_CODE') ) { die("Wrong URL."); }

?>