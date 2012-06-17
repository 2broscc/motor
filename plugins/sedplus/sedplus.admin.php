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
Description=Use thus with extra caution!
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=admin
File=sedplus.admin
Hooks=tools
Tags=
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");
$defavatar = $cfg['plugin']['sedplus']['defavatar'];
$defphoto = $cfg['plugin']['sedplus']['defphoto'];
$plugin_body = '';

if($a=='run')
{
	$mode = sed_import('mode','P','INT');
	switch($mode)
	{	
	case '1':
		if (!empty($defavatar))
		{
			$sql = sed_sql_query("ALTER TABLE $db_users CHANGE user_avatar 
							user_avatar varchar(255) NOT NULL default '".$defavatar."'");
			$plugin_body .= "(".sed_sql_affectedrows().") ".$L['done'];
		}
		else
		{
			$plugin_body .= $L['ava_error'];
		}
		
	break;

	case '2':
		if (!empty($defavatar))
		{
			$sql = sed_sql_query("UPDATE $db_users SET user_avatar='".$defavatar."' WHERE user_avatar=''");
			$plugin_body .= "(".sed_sql_affectedrows().") ".$L['done'];
		}
		else
		{
			$plugin_body .= $L['ava_error'];
		}
		
	break;

	case '3':
		if (!empty($defphoto))
		{
			$sql = sed_sql_query("ALTER TABLE $db_users CHANGE user_photo 
							user_photo varchar(255) NOT NULL default '".$defphoto."'");
			$plugin_body .= "(".sed_sql_affectedrows().") ".$L['done'];
		}
		else
		{
			$plugin_body .= $L['pho_error'];
		}
	break;

	case '4':
		if (!empty($defphoto)){
			$sql = sed_sql_query("UPDATE $db_users SET user_photo='".$defphoto."' WHERE user_photo=''");
			$plugin_body .= "(".sed_sql_affectedrows().") ".$L['done'];
		}
		else
		{
			$plugin_body .= $L['pho_error'];
		}	
	break;

	case '5':
		if (!empty($defphoto)){		
			$sql = sed_sql_query("UPDATE $db_users SET user_photo='' WHERE user_photo='".$defphoto."'");
			$sql = sed_sql_query("ALTER TABLE $db_users CHANGE user_photo user_photo varchar(255) NOT NULL default ''");
			$plugin_body .= "(".sed_sql_affectedrows().") ".$L['done'];
		}
		else
		{
			$plugin_body .= $L['remove_pho_error'];
		}
	break;

	case '6':
		if (!empty($defavatar)){
			$sql = sed_sql_query("UPDATE $db_users SET user_avatar='' WHERE user_avatar='".$defavatar."'");
			$sql = sed_sql_query("ALTER TABLE $db_users CHANGE user_avatar user_avatar varchar(255) NOT NULL default ''");
			$plugin_body .= "(".sed_sql_affectedrows().") ".$L['done'];
		}
		else
		{
			$plugin_body .= $L['remove_ava_error'];
		}
	break;	

	case '7':
		$sql = sed_sql_query("DELETE FROM sed_pm WHERE pm_date < UNIX_TIMESTAMP(NOW()) - 86400 * 365");
		$affected = sed_sql_affectedrows();
		$sql = sed_sql_query("DELETE FROM sed_pm WHERE pm_date < UNIX_TIMESTAMP(NOW()) - 86400 * 180 AND pm_state=1");
		$affected += sed_sql_affectedrows();
		$sql = sed_sql_query("DELETE FROM sed_pm WHERE pm_date < UNIX_TIMESTAMP(NOW()) - 86400 * 90 AND pm_state=0");
		$affected += sed_sql_affectedrows();
		$sql = sed_sql_query("OPTIMIZE TABLE sed_pm");
		$plugin_body .= "(".$affected.") ".$L['done'];
	break;

	default:
		sed_die();
	break;
	}
}

$mode_map = array();
$mode_map[] = array($L['set_dava'], 1);
$mode_map[] = array($L['sync_dava'], 2);
$mode_map[] = array($L['set_dpho'], 3);
$mode_map[] = array($L['sync_dpho'], 4);
$mode_map[] = array($L['remove_dava'], 5);
$mode_map[] = array($L['remove_dpho'], 6);
$mode_map[] = array($L['clean_pms'], 7);

$plugin_body .= "<form id=\"maintain\" name=\"maintain\" action=\"admin.php?m=tools&p=sedplus&amp;a=run\" method=\"post\">\n";
$plugin_body .= "<table class=\"cells\">\n";
$plugin_body .= "<tr>\n";
$plugin_body .= "<td class=\"coltop\">".$L['Options']."</td>\n";
$plugin_body .= "<td class=\"coltop\">".$L['Select']."</td>\n";
$plugin_body .= "</tr>\n";
foreach($mode_map as $mode)
{ 
	$plugin_body .= "<tr>\n";
	$plugin_body .= "<td><strong>".$mode[0]."</strong></td>\n";
	$plugin_body .= "<td align=\"center\"><input type=\"radio\" class=\"radio\" name=\"mode\" value=\"".$mode[1]."\" /></td>\n";
	$plugin_body .= "</tr>\n";
}
$plugin_body .= "<tr>\n";
$plugin_body .= "<td colspan=\"2\" align=\"center\"><input type=\"submit\" class=\"submit\" value=\"".$L['Submit']."\" /></td>\n";
$plugin_body .= "</tr>\n";
$plugin_body .= "</table>\n";
$plugin_body .= "</form><br /><br /><br />\n";	




		
?>