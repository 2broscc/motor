<?php


$L['RidelineMTB'] = "Rideline";

$adminmenu = "<table><tr>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\"><a href=\"admin.php\">";
$adminmenu .= "<img src=\"system/img/admin/admin.gif\" alt=\"\" /><br />".$L['Home']."</a></td>";
$adminmenu .= "<td style=\"width:12%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=config", "<img src=\"system/img/admin/config.gif\" alt=\"\" /><br />".$L['Configuration'], sed_auth('admin', 'a', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=page", "<img src=\"system/img/admin/page.gif\" alt=\"\" /><br />".$L['Pages'], sed_auth('page', 'any', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=forums", "<img src=\"system/img/admin/forums.gif\" alt=\"\" /><br />".$L['Forums'], sed_auth('admin', 'a', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=users", "<img src=\"system/img/admin/users.gif\" alt=\"\" /><br />".$L['Users'], sed_auth('users', 'a', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=plug", "<img src=\"system/img/admin/plugins.gif\" alt=\"\" /><br />".$L['Plugins'], sed_auth('admin', 'a', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=tools", "<img src=\"system/img/admin/tools.gif\" alt=\"\" /><br />".$L['Tools'], sed_auth('admin', 'a', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=trashcan", "<img src=\"system/img/admin/delete.gif\" alt=\"\" /><br />".$L['Trashcan'], sed_auth('admin', 'a', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\">";
$adminmenu .= sed_linkif("admin.php?m=rideline", "<img src=\"system/img/admin/delete.gif\" alt=\"\" /><br />".$L['RidelineMTB'],sed_auth('admin', 'a', 'A'));
$adminmenu .= "</td>";
$adminmenu .= "<td style=\"width:11%; text-align:center;\"><a href=\"admin.php?m=other\">";
$adminmenu .= "<img src=\"system/img/admin/folder.gif\" alt=\"\" /><br />".$L['Other']."</a></td>";
$adminmenu .= "</tr></table>";


?>