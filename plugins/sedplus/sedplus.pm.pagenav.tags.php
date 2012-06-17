<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.pm.pagenav.tags.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=pm.pagenav.tags
File=sedplus.pm.pagenav.tags
Hooks=pm.loop
Tags=pm.tpl:{SEDPLUS_PM_TOP_PAGENAV}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

if($totallines >= $cfg['maxrowsperpage']){
	if($jj<=$cfg['maxrowsperpage'])	$t->assign("SEDPLUS_PM_TOP_PAGENAV", $pagnav);
}
else
{
	if($jj==$totallines)	$t->assign("SEDPLUS_PM_TOP_PAGENAV", $pagnav);
}

?>