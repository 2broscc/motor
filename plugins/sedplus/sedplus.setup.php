<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.setup.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Name=Seditio Plus
Description=Additional features for your seditio site.
Version=1.06
Author=Tefra
Date=2007-Jun-24
Copyright=http://www.T3-Desing.com
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=12345
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
defavatar=03:string::datas/avatars/default.gif:Default avatar address
defphoto=04:string::datas/photos/default.gif:Default photo address
linksperside=05:select:1,2,3,4,5,6,7,8,9,10,15,20,25,30,50,100:3:Total links per side in the pagination.
[END_SED_EXTPLUGIN_CONFIG]
==================== */

if ( !defined('SED_CODE') ) { die("Wrong URL."); }

?>