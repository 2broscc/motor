<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.versions.inc.php
Version=161
Updated=2012-feb-15
Type=Core.admin
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if (!defined('SED_CODE') || !defined('SED_ADMIN')) { die('Wrong URL.'); }


$adminhelp = $L['adm_help_versions'];

$adminmain .= "<h4>".$L['adm_clocks']." :</h4>";
$adminmain .= "<table class=\"cells\">";
$adminmain .= "<tr><td>".$L['adm_time1']."</td><td> ".date("Y-m-d H:i")." </td></tr>";
$adminmain .= "<tr><td>".$L['adm_time2']."</td><td> ".gmdate("Y-m-d H:i")." GMT </td></tr>";
$adminmain .= "<tr><td>".$L['adm_time3']."</td>";
$adminmain .= "<td>".$usr['gmttime']." </td></tr>";
$adminmain .= "<tr><td>".$L['adm_time4']." : </td>";
$adminmain .= "<td>".date($cfg['dateformat'], $sys['now_offset'] + $usr['timezone'] * 3600)." ".$usr['timetext']." </td></tr>";
$adminmain .= "</table>";

?>
