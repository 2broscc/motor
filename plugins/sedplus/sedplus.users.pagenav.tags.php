<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.users.pagenav.tags.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=users.pagenav.tags
File=sedplus.users.pagenav.tags
Hooks=users.tags
Tags=users.tpl:{SEDPLUS_USERS_TOP_PAGENAV}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
	
$t->assign("SEDPLUS_USERS_TOP_PAGENAV", $pagnav);

?>