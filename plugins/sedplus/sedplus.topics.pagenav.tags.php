<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.topics.pagenav.tags.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=topics.pagenav.tags
File=sedplus.topics.pagenav.tags
Hooks=forums.topics.tags
Tags=forums.topics.tpl:{SEDPLUS_FORUMS_TOPICS_PAGENAV}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
$t->assign("SEDPLUS_FORUMS_TOPICS_PAGENAV", $pagnav);

?>