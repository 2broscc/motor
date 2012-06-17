<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.list.pagenav.tags.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=list.pagenav.tags
File=sedplus.list.pagenav.tags
Hooks=list.tags
Tags=list.tpl:{SEDPLUS_LIST_PAGENAV}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
$t->assign("SEDPLUS_LIST_PAGENAV", $pagnav);

?>