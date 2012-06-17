<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/sedplus.list.pagenav.php
Version=1.06
Updated=2007-Jun-24
Type=Plugin
Author=Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=sedplus
Part=list.pagenav
File=sedplus.list.pagenav
Hooks=list.main
Tags=
Order=100
[END_SED_EXTPLUGIN]
============ */

if (!defined('SED_CODE')) { die('Wrong URL.'); }
		
require_once("plugins/sedplus/inc/sedplus.functions.php");

if (empty($d)) { $d = '0'; }
if (!$totallines==0){		
	$perpage 	= $cfg['maxrowsperpage'];
	$totalitems = $totallines;
	if(!empty($alpha))
	{
		$address = "list.php?c=$c&amp;alpha=$alpha&amp;s=$s&amp;w=$w&amp;o=$o&amp;p=$p&amp;d=";
	}
	else
	{
		$address = "list.php?c=$c&amp;s=$s&amp;w=$w&amp;o=$o&amp;p=$p&amp;d=";
	}
	$pagenumber = $d;
	$pagnav 	= t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber);
}

?>