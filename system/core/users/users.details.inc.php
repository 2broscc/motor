<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=users.php
Version=120
Updated=2007-feb-20
Type=Core
Author=Neocrome
Description=Users
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$y = sed_import('y','P','TXT');
$id = sed_import('id','G','INT');
$s = sed_import('s','G','ALP',13);
$w = sed_import('w','G','ALP',4);
$d = sed_import('d','G','INT');
$f = sed_import('f','G','TXT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('users', 'a');
sed_block($usr['auth_read']);

/* === Hook === */
$extp = sed_getextplugins('users.details.first');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

if (empty($id) && $usr['id']>0)
   { $id = $usr['id']; }

$sql = sed_sql_query("SELECT * FROM $db_users WHERE user_id='$id' LIMIT 1");
sed_die(sed_sql_numrows($sql)==0);
$urr = sed_sql_fetcharray($sql);

$urr['user_text'] = sed_build_usertext(sed_cc($urr['user_text']));
$urr['user_website'] = sed_build_url($urr['user_website']);
$urr['user_age'] = ($urr['user_birthdate']!=0) ? sed_build_age($urr['user_birthdate']) : '';
$urr['user_birthdate'] = ($urr['user_birthdate']!=0) ? @date($cfg['formatyearmonthday'], $urr['user_birthdate']) : '';
$urr['user_gender'] = ($urr['user_gender']=='' || $urr['user_gender']=='U') ?  '' : $L["Gender_".$urr['user_gender']];
$urr['user_journal'] = ($urr['user_jrnpagescount']>0 && $urr['user_jrnupdated']>0) ? "<a href=\"journal.php?id=".$urr['user_id']."\"><img src=\"skins/$skin/img/system/icon-journal.gif\" alt=\"\" /></a> ".date($cfg['formatyearmonthday'], $urr['user_jrnupdated'] + $usr['timezone'] * 3600) : '';

$out['subtitle'] = $L['User']." : ".sed_cc($urr['user_name']);

/* === Hook === */
$extp = sed_getextplugins('users.details.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

require("system/header.php");
$mskin = "$user_skin_dir/".$skin."/users.details.tpl";
$t = new XTemplate($mskin);

$t->assign(array(
	"USERS_DETAILS_TITLE" => "<a href=\"users.php\">".$L['Users']."</a> ".$cfg['separator']." ".sed_build_user($urr['user_id'], sed_cc($urr['user_name'])),
	"USERS_DETAILS_SUBTITLE" => $L['use_subtitle'],
	"USERS_DETAILS_ID" => $urr['user_id'],
	"USERS_DETAILS_PM" => sed_build_pm($urr['user_id']),
	"USERS_DETAILS_NAME" => sed_cc($urr['user_name']),
	"USERS_DETAILS_PASSWORD" => $urr['user_password'],
	"USERS_DETAILS_MAINGRP" => sed_build_group($urr['user_maingrp']),
	"USERS_DETAILS_MAINGRPID" => $urr['user_maingrp'],
	"USERS_DETAILS_MAINGRPSTARS" => sed_build_stars($sed_groups[$urr['user_maingrp']]['level']),
	"USERS_DETAILS_MAINGRPICON" => sed_build_userimage($sed_groups[$urr['user_maingrp']]['icon']),
	"USERS_DETAILS_GROUPS" => sed_build_groupsms($urr['user_id'], FALSE, $urr['user_maingrp']),
	"USERS_DETAILS_COUNTRY" => sed_build_country($urr['user_country']),
	"USERS_DETAILS_COUNTRYFLAG" => sed_build_flag($urr['user_country']),
	"USERS_DETAILS_TEXT" => $urr['user_text'],
	"USERS_DETAILS_AVATAR" => sed_build_userimage($urr['user_avatar']),
	"USERS_DETAILS_PHOTO" => sed_build_userimage($urr['user_photo']),
	"USERS_DETAILS_SIGNATURE" => sed_build_userimage($urr['user_signature']),
	"USERS_DETAILS_EXTRA1" => sed_cc($urr['user_extra1']),
	"USERS_DETAILS_EXTRA2" => sed_cc($urr['user_extra2']),
	"USERS_DETAILS_EXTRA3" => sed_cc($urr['user_extra3']),
	"USERS_DETAILS_EXTRA4" => sed_cc($urr['user_extra4']),
	"USERS_DETAILS_EXTRA5" => sed_cc($urr['user_extra5']),
	"USERS_DETAILS_EXTRA6" => sed_cc($urr['user_extra6']),
	"USERS_DETAILS_EXTRA7" => sed_cc($urr['user_extra7']),
	"USERS_DETAILS_EXTRA8" => sed_cc($urr['user_extra8']),
	"USERS_DETAILS_EXTRA9" => sed_cc($urr['user_extra9']),
	"USERS_DETAILS_EXTRA1_TITLE" => $cfg['extra1title'],
	"USERS_DETAILS_EXTRA2_TITLE" => $cfg['extra2title'],
	"USERS_DETAILS_EXTRA3_TITLE" => $cfg['extra3title'],
	"USERS_DETAILS_EXTRA4_TITLE" => $cfg['extra4title'],
	"USERS_DETAILS_EXTRA5_TITLE" => $cfg['extra5title'],
	"USERS_DETAILS_EXTRA6_TITLE" => $cfg['extra6title'],
	"USERS_DETAILS_EXTRA7_TITLE" => $cfg['extra7title'],
	"USERS_DETAILS_EXTRA8_TITLE" => $cfg['extra8title'],
	"USERS_DETAILS_EXTRA9_TITLE" => $cfg['extra9title'],
	"USERS_DETAILS_EMAIL" => sed_build_email($urr['user_email'], $urr['user_hideemail']),
	"USERS_DETAILS_PMNOTIFY" =>  $sed_yesno[$urr['user_pmnotify']],
	"USERS_DETAILS_SKIN" => $urr['user_skin'],
	"USERS_DETAILS_WEBSITE" => $urr['user_website'],
	"USERS_DETAILS_JOURNAL" => $urr['user_journal'],
	"USERS_DETAILS_ICQ" => sed_build_icq($urr['user_icq']),
	"USERS_DETAILS_MSN" => sed_build_msn($urr['user_msn']),
	"USERS_DETAILS_IRC" => sed_cc($urr['user_irc']),
	"USERS_DETAILS_GENDER" => $urr['user_gender'],
	"USERS_DETAILS_BIRTHDATE" => $urr['user_birthdate'],
	"USERS_DETAILS_AGE" => $urr['user_age'],
	"USERS_DETAILS_TIMEZONE" => sed_build_timezone($urr['user_timezone']),
	"USERS_DETAILS_LOCATION" => sed_cc($urr['user_location']),
	"USERS_DETAILS_OCCUPATION" => sed_cc($urr['user_occupation']),
	"USERS_DETAILS_REGDATE" => @date($cfg['dateformat'], $urr['user_regdate'] + $usr['timezone'] * 3600)." ".$usr['timetext'],
	"USERS_DETAILS_LASTLOG" => @date($cfg['dateformat'], $urr['user_lastlog'] + $usr['timezone'] * 3600)." ".$usr['timetext'],
	"USERS_DETAILS_LOGCOUNT" => $urr['user_logcount'],
	"USERS_DETAILS_POSTCOUNT" => $urr['user_postcount'],
	"USERS_DETAILS_LASTIP" => $urr['user_lastip']
		));

/* === Hook === */
$extp = sed_getextplugins('users.details.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

if ($usr['isadmin'])
		{
		$t-> assign(array(
			"USERS_DETAILS_ADMIN_EDIT" => "<a href=\"users.php?m=edit&amp;id=".$urr['user_id']."\">".$L['Edit']."</a>"
			));

		$t->parse("MAIN.USERS_DETAILS_ADMIN");
		}

$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>