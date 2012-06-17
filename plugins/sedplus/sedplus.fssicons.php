<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.fssicons.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=fssicons
File=sedplus.fssicons
Hooks=forums.sections.loop
Tags=forums.sections.tpl:{SEDPLUS_FORUMS_SECTIONS_ROW_STATUS_ICON}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");

if ($usr['id']>0 && $fsn['fs_newposts'] > 0 && $fsn['fs_lt_posterid']!=$usr['id'])
{
	$fssicons = "<img src=\"skins/$skin/img/system/forum_new.gif\" title=\"".$L['newposts']."\" alt=\"".$L['newposts']."\" />";
}
else 
{
	$fssicons = "<img src=\"skins/$skin/img/system/forum_old.gif\" title=\"".$L['nonewposts']."\" alt=\"".$L['nonewposts']."\" />";
}
if ($fsn['fs_state'] > 0)
{
	$fssicons = "<img src=\"skins/$skin/img/system/forum_lock.gif\" title=\"".$L['closed']."\" alt=\"".$L['closed']."\" />";
}

$t->assign("SEDPLUS_FORUMS_SECTIONS_ROW_STATUS_ICON", $fssicons);

?>