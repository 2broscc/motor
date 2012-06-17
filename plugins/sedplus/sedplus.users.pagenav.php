<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.users.pagenav.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=users.pagenav
File=sedplus.users.pagenav
Hooks=users.main
Tags=
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");	
		
$perpage 	= $cfg['maxusersperpage'];
$totalitems = $totalusers;
$address 	= "users.php?f=$f&amp;s=$s&amp;w=$w&amp;d=";
$pagenumber = $d;
$pagnav 	= t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber);

?>