<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.posts.pagenav.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=posts.pagenav
File=sedplus.posts.pagenav
Hooks=forums.posts.main
Tags=
Order=10
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");

$perpage 	= $cfg['maxtopicsperpage'];
$totalitems = $totalposts;
$address 	= "forums.php?m=posts&amp;q=$q&amp;d=";
$pagenumber = $d;
$pagnav 	= t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber);

?>