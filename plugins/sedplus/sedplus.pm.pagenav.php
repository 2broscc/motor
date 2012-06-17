<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.pm.pagenav.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=pm.pagenav
File=sedplus.pm.pagenav
Hooks=pm.main
Tags=
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");
		
if (empty($d)) { $d = '0'; }		
$perpage 	= $cfg['maxrowsperpage'];
$totalitems = $totallines;
$address 	= "pm.php?f=$f&amp;d=";
$pagenumber = $d;
$pagnav 	= (t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber));

?>