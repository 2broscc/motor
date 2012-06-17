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
Part=userdetails
File=sedplus.userdetails
Hooks=users.details.tags
Tags=users.details.tpl:{SEDPLUS_USERSDETAILS_GENDER},{SEDPLUS_USERSDETAILS_ONLINE_IMG},{SEDPLUS_USERSDETAILS_ONLINE}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");

$gender = '';
if ($urr['user_gender'] === $L["Gender_M"]) $gender = "Male"; 
if ($urr['user_gender'] === $L["Gender_F"]) $gender = "Female";
$gender = ($gender == '')? '' : "<img src='skins/$skin/img/system/Gender_".$gender.".gif' alt='Gender_".$urr['user_gender']."'  />";

$online_txt = (sed_userisonline($urr['user_id'])) ? $L['online'] : $L['offline'];
$online_img = (sed_userisonline($urr['user_id'])) ? "<img src=\"skins/$skin/img/online1.gif\"  alt=\"".$L['online']."\" />" : "<img src=\"skins/$skin/img/online0.gif\"  alt=\"".$L['offline']."\" />";

$t-> assign(array(
	"SEDPLUS_USERSDETAILS_GENDER" 		=> $gender,
	"SEDPLUS_USERSDETAILS_ONLINE_IMG" 	=> $online_img ,
	"SEDPLUS_USERSDETAILS_ONLINE" 		=> $online_txt
	));
		
?>