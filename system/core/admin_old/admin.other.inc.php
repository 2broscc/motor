<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.modules.inc.php
Version=121
Updated=2007-mar-20
Type=Core
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if (!defined('SED_CODE') || !defined('SED_ADMIN')) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['auth_read']);

$adminpath[] = array ("admin.php?m=other", $L['Other']);

$sql = sed_sql_query("SELECT DISTINCT(config_cat), COUNT(*) FROM $db_config WHERE config_owner!='plug' GROUP BY config_cat");
while ($row = sed_sql_fetcharray($sql))
	{ $cfgentries[$row['config_cat']] = $row['COUNT(*)']; }

$sql = sed_sql_query("SELECT DISTINCT(auth_code), COUNT(*) FROM $db_auth WHERE 1 GROUP BY auth_code");
while ($row = sed_sql_fetcharray($sql))
	{ $authentries[$row['auth_code']] = $row['COUNT(*)']; }

$sql = sed_sql_query("SELECT * FROM $db_core WHERE ct_code NOT IN ('admin', 'message', 'index', 'forums', 'users', 'plug', 'page', 'trash') ORDER BY ct_title ASC");
$lines = array();

$adminmain = "<table class=\"cells\">";
$adminmain .= "<tr>";
$adminmain .= "<td class=\"coltop\">".$L['Modules']." ".$L['adm_clicktoedit']."</td>";
$adminmain .= "<td class=\"coltop\" style=\"width:80px;\">".$L['Rights']."</td>";
$adminmain .= "<td class=\"coltop\" style=\"width:128px;\">".$L['Configuration']."</td>";

$adminmain .= "</tr>";

while ($row = sed_sql_fetcharray($sql))
	{
	$adminmain .= "<tr>";
	$adminmain .= "<td>";
	
	$row['ct_title_loc'] = (empty($L["core_".$row['ct_code']])) ? $row['ct_title'] : $L["core_".$row['ct_code']];
	$adminmain .= sed_linkif("admin.php?m=".$row['ct_code'], "<img src=\"system/img/admin/".$row['ct_code'].".gif\" alt=\"\" /> ".$row['ct_title_loc'], sed_auth($row['ct_code'], 'a', 'A') && $row['ct_code']!='admin' && $row['ct_code']!='index' && $row['ct_code']!='message');
	$adminmain .= "</td>";

	$adminmain .= "<td style=\"text-align:center;\">";
	$adminmain .= ($authentries[$row['ct_code']]>0) ? "<a href=\"admin.php?m=rightsbyitem&amp;ic=".$row['ct_code']."&amp;io=a\"><img src=\"system/img/admin/rights2.gif\" alt=\"\" /></a>" : '&nbsp;';
	$adminmain .= 	"</td>";

	$cfgcode = "disable_".$row['ct_code'];
	$adminmain .= "<td style=\"text-align:center;\">";
	$adminmain .= ($cfgentries[$row['ct_code']]>0) ? "<a href=\"admin.php?m=config&amp;n=edit&amp;o=core&amp;p=".$row['ct_code']."\"><img src=\"system/img/admin/config.gif\" alt=\"\" /></a>" : '&nbsp;';
	$adminmain .= "</td></tr>";
	}

$adminmain .= "<tr>";
$adminmain .= "<td colspan=\"3\">".sed_linkif("admin.php?m=cache", "<img src=\"system/img/admin/config.gif\" alt=\"\" /> ".$L['adm_internalcache'], sed_auth('admin', 'a', 'A'))."</td>";
$adminmain .= "</tr>";

$adminmain .= "<tr>";
$adminmain .= "<td colspan=\"3\">".sed_linkif("admin.php?m=smilies", "<img src=\"system/img/admin/smilies.gif\" alt=\"\" /> ".$L['Smilies'], sed_auth('admin', 'a', 'A'))."</td>";
$adminmain .= "</tr>";

$adminmain .= "<tr>";
$adminmain .= "<td colspan=\"3\">".sed_linkif("admin.php?m=banlist", "<img src=\"system/img/admin/users.gif\" alt=\"\" /> ".$L['Banlist'], sed_auth('users', 'a', 'A'))."</td>";
$adminmain .= "</tr>";

$adminmain .= "<tr>";
$adminmain .= "<td colspan=\"3\"><a href=\"admin.php?m=hits\"><img src=\"system/img/admin/statistics.gif\" alt=\"\" /> ".$L['Hits']."</a></td>";
$adminmain .= "</tr>";

$adminmain .= "<tr>";
$adminmain .= "<td colspan=\"3\">".sed_linkif("admin.php?m=referers", "<img src=\"system/img/admin/info.gif\" alt=\"\" /> ".$L['Referers'], sed_auth('admin', 'a', 'A'))."</td>";
$adminmain .= "</tr>";

$adminmain .= "<tr>";
$adminmain .= "<td colspan=\"3\">".sed_linkif("admin.php?m=log", "<img src=\"system/img/admin/page.gif\" alt=\"\" /> ".$L['adm_log'], sed_auth('admin', 'a', 'A'))."</td>";
$adminmain .= "</tr>";

$adminmain .= "<tr>";
$adminmain .= "<td colspan=\"3\">".sed_linkif("admin.php?m=infos", "<img src=\"system/img/admin/info.gif\" alt=\"\" /> ".$L['adm_infos'], sed_auth('admin', 'a', 'A'))."</td>";
$adminmain .= "</tr>";

$adminmain .= "</table>";

?>
