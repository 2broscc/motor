<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.pm.inc.php
Version=161
Updated=2012-feb-15
Type=Core.admin
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('pm', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=tools", $L['adm_manage']);
$adminpath[] = array ("admin.php?m=pm", $L['Private_Messages']);
$adminhelp = $L['adm_help_pm'];
$adminmain = "<h2><img src=\"system/img/admin/pm.png\" alt=\"\" /> ".$L['Private_Messages']."</h2>";

$adminmain .= "<ul><li><a href=\"admin.php?m=config&amp;n=edit&amp;o=core&amp;p=pm\">".$L['Configuration']."</a></li></ul>";

$totalpmdb = sed_sql_rowcount($db_pm);
$totalpmsent = sed_stat_get('totalpms');

$adminmain .= "<table class=\"cells\">";
$adminmain .= "<tr><td colspan=\"2\" class=\"coltop\">".$L['Statistics']."</td></tr>";
$adminmain .= "<tr><td>".$L['adm_pm_totaldb']."</td><td style=\"text-align:center;\">".$totalpmdb."</td></tr>";
$adminmain .= "<tr><td>".$L['adm_pm_totalsent']."</td><td style=\"text-align:center;\">".$totalpmsent."</td></tr>";

$adminmain .= "</table>";



?>
