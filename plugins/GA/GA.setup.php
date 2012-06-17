<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/GA/GA.setup.php
Version=100
Updated=2009-oct-03
Type=Plugin
Author=Leo 2basix.nl
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=GA
Name=Google Analytics
Description=Add Google Analytics to the website
Version=100
Date=2009-oct-03
Author=Leo 2basix.nl
Copyright=
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
GA_Enable=01:select:Yes,No:Yes:Enable Plugin
GA_Code=02:string::system:Google Analytics code
[END_SED_EXTPLUGIN_CONFIG]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

?>
