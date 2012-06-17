<?php

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=plugins/bestdeal/bestdeal.index.php
Version=0.8
Updated=2010-07-05
Type=Plugin
Author=Péter at 2bros creative consultant
Description= Index tags for recent items of bestdeal
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=bestdeal
Part=index
File=bestdeal.index
Hooks=index.tags
Tags=index.tpl:{BD_INDEX_LASTITEMS}
Order=11
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

// Extra tags for on the indexpage


$state_active = $cfg['plugin']['bestdeal']['state_active']; // Months a item will stay active (1)
$maxitemsperpage = $cfg['plugin']['bestdeal']['maxitemsperpage']; // Max pages per categorie (5)


$photodir = "datas/photos/"; // Directory for the photo's (Make sure to chmod the directory)

$sql_randomgoods  = sed_sql_query("SELECT * FROM sed_bestdeal_item where bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' ORDER BY RAND() DESC LIMIT 1");


while ($iteminfo = sed_sql_fetcharray($sql_randomgoods)) {
		
	$t-> assign(array(
		
			
		"INDEX_VIEW_ITEM_INFO_ID" => $iteminfo['bditem_id'],
		"INDEX_VIEW_ITEM_INFO_NAME" => substr($iteminfo['bditem_name'],0,34)."...",
		"INDEX_VIEW_ITEM_INFO_SHORTDESC" => $iteminfo['bditem_shortdesc'],
		"INDEX_VIEW_ITEM_INFO_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
		"INDEX_VIEW_ITEM_INFO_PHOTO" => "<img src=\"".$iteminfo['bditem_photo']."\" height=\"150px\"  alt=\"kep\" />",
		"INDEX_VIEW_ITEM_INFO_DETAILS" => $iteminfo['bditem_details'],
		"INDEX_VIEW_ITEM_INFO_LOCATION" => $iteminfo['bditem_location'],
		"INDEX_VIEW_ITEM_INFO_PRICE" => $iteminfo['bditem_price'],	
		));
		
		$t->parse("MAIN.INDEX_GOODS.ROW");
		}


?>

