<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.topics.pagenav.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=topics.pagenav
File=sedplus.topics.pagenav
Hooks=forums.topics.main
Tags=
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");
	
$perpage 	= $cfg['maxtopicsperpage'];
$totalitems = $totaltopics;
$address 	= "forums.php?m=topics&amp;s=$s&amp;o=$o&amp;w=$w&amp;d=";
$pagenumber = $d;
$pagnav 	= t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber);

?>