<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.users.php
Version=1.05
Updated=2007-Feb-10
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=users
File=sedplus.users
Hooks=users.loop
Tags=users.tpl:{SEDPLUS_USERS_ROW_GENDER},{SEDPLUS_USERS_ROW_WEBSITE},{SEDPLUS_USERS_ROW_WEBSITE_IMG},{SEDPLUS_USERS_ROW_ONLINE_IMG},{SEDPLUS_USERS_ROW_ONLINE}
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");			

$online_txt = (sed_userisonline($urr['user_id'])) ? $L['online'] : $L['offline'];
$online_img = (sed_userisonline($urr['user_id'])) ? "<img src=\"skins/$skin/img/online1.gif\"  alt=\"".$L['online']."\" />" : "<img src=\"skins/$skin/img/online0.gif\"  alt=\"".$L['offline']."\" />";

$usersite_txt = '';
$usersite_img = '';
if ($urr['user_website'])
{
	$usersite_txt = "<a href=\"".sed_build_www($urr ['user_website'])."\">".$L['usersite']."</a>";
	$usersite_img = "<a href=\"".sed_build_www($urr ['user_website'])."\"><img src='skins/$skin/img/system/button-www.gif' alt='".$L['usersite']."'  /></a>";
}

$gender = '';
if ($urr['user_gender'] === $L["Gender_M"]) $gender = "Male"; 
if ($urr['user_gender'] === $L["Gender_F"]) $gender = "Female";
$gender = ($gender == '')? '' : "<img src='skins/$skin/img/system/Gender_".$gender.".gif' alt='Gender_".$urr['user_gender']."'  />";


$t-> assign(array(
	"SEDPLUS_USERS_ROW_GENDER" 			=> $gender,
	"SEDPLUS_USERS_ROW_WEBSITE" 		=> $usersite_url,
	"SEDPLUS_USERS_ROW_WEBSITE_IMG"	 	=> $usersite_img,
	"SEDPLUS_USERS_ROW_ONLINE_IMG" 		=> $online_img ,
	"SEDPLUS_USERS_ROW_ONLINE" 			=> $online_txt
	));	

?>