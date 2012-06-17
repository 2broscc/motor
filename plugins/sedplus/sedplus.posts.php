<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.posts.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=posts
File=sedplus.posts
Hooks=forums.posts.loop
Tags=forums.posts.tpl:{SEDPLUS_FORUMS_POSTS_ROW_SENDPM},{SEDPLUS_FORUMS_POSTS_ROW_SENDPM_IMG},{SEDPLUS_FORUMS_POSTS_ROW_ADMINBUTTONS},{SEDPLUS_FORUMS_POSTS_ROW_GENDER},{SEDPLUS_FORUMS_POSTS_ROW_WEBSITE},{SEDPLUS_FORUMS_POSTS_ROW_WEBSITE_IMG}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");

$buttons = ($usr['id']>0) ? "&nbsp;<a href=\"forums.php?m=posts&amp;q=".$q."&amp;n=last#bottom\"><img src=\"skins/$skin/img/system/button-reply.gif\" style=\"border: 0px; vertical-align: middle;\" alt=\"".$L['reply']."\"  /></a>" : "&nbsp;";
$buttons .= ($usr['id']>0) ? "&nbsp;<a href=\"forums.php?m=posts&amp;s=".$s."&amp;q=".$q."&amp;quote=".$row['fp_id']."&amp;n=last#np\"><img src=\"skins/$skin/img/system/button-quote.gif\" style=\"border: 0px; vertical-align: middle;\" alt=\"".$L['quote']."\"  /></a>" : "&nbsp;";
$buttons .= (($usr['isadmin'] || $row['fp_posterid']==$usr['id']) && $usr['id']>0) ? "&nbsp;<a href=\"forums.php?m=editpost&amp;s=".$s."&amp;q=".$q."&amp;p=".$row['fp_id']."&amp;".sed_xg()."\"><img src=\"skins/$skin/img/system/button-edit.gif\" style=\"border: 0px; vertical-align: middle;\" alt=\"".$L['edit']."\"  /></a>" : '';
$buttons .= ($usr['id']>0 && ($usr['isadmin'] || $row['fp_posterid']==$usr['id']) && !($post12[0]==$row['fp_id'] && $post12[1]>0)) ? "&nbsp;<a href=\"forums.php?m=posts&amp;a=delete&amp;".sed_xg()."&amp;s=".$s."&amp;q=".$q."&amp;p=".$row['fp_id']."\"><img src=\"skins/$skin/img/system/button-delete.gif\" style=\"border: 0px; vertical-align: middle;\" alt=\"".$L['delete']."\"  /></a>" : '';
$buttons .= ($fp_num==$totalposts) ? "<a name=\"bottom\" id=\"bottom\"></a>" : '';

$gender = '';
if ($row['user_gender'] === $L["Gender_M"]) $gender = "Male"; 
if ($row['user_gender'] === $L["Gender_F"]) $gender = "Female";
$gender = ($gender == '')? '' : "<img src='skins/$skin/img/system/Gender_".$gender.".gif' alt='Gender_".$row['user_gender']."'  />";

$usersite_txt = '';
$usersite_img = '';
$sendpm_txt = '';
$sendpm_img = '';
if ($row['user_website'])
{
	$usersite_txt = "<a href=\"".sed_build_www($row ['user_website'])."\">".$L['usersite']."</a>";
	$usersite_img = "<a href=\"".sed_build_www($row ['user_website'])."\"><img src='skins/$skin/img/system/button-www.gif' alt='".$L['usersite']."'  /></a>"; 
}

if ($usr['id']>0)
{
	$sendpm_txt = "<a href=\"pm.php?m=send&amp;to=".$row['fp_posterid']."\">".$L['contact']."</a>";
	$sendpm_img = "<a href=\"pm.php?m=send&amp;to=".$row['fp_posterid']."\"><img src='skins/$skin/img/system/icon-pm.gif' alt='".$L['contact']."' /></a>";
}

$t-> assign(array(
	"SEDPLUS_FORUMS_POSTS_ROW_SENDPM" 		=> $sendpm_txt,
	"SEDPLUS_FORUMS_POSTS_ROW_SENDPM_IMG" 	=> $sendpm_img,
	"SEDPLUS_FORUMS_POSTS_ROW_ADMINBUTTONS" => $buttons,
	"SEDPLUS_FORUMS_POSTS_ROW_GENDER" 		=> $gender,
	"SEDPLUS_FORUMS_POSTS_ROW_WEBSITE" 		=> $usersite_txt,
	"SEDPLUS_FORUMS_POSTS_ROW_WEBSITE_IMG" 	=> $usersite_img
	));

?>