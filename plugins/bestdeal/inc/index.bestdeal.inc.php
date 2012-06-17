<?php

include("kiemelt.php");
	
$sql_randomitem  = sed_sql_query("SELECT * FROM sed_bestdeal_item where bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' ORDER BY RAND() DESC LIMIT 1");
$sql_lastitemsfmode3 = sed_sql_query("SELECT * FROM sed_bestdeal_item where bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' ORDER BY bditem_adddate DESC LIMIT 5");
$sql_headcats = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='0'");
$sql_lastbids = sed_sql_query("SELECT * FROM sed_bestdeal_bid ORDER BY bdbid_date DESC LIMIT 5");
	
//Making the template file

$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.index.tpl";
$path_skin_path	= "skins/$skin/extplugin.bestdeal.index.tpl";	
		
	if (file_exists($path_plugin_path)) { $path_skin= $path_plugin_path; 
	
		}
		elseif (file_exists($path_skin_path)) {
			
			$path_skin = $path_skin_path;
		}
			else {
				header("Location: message.php?msg=907");
				exit;
			}	

$t = new XTemplate($path_skin);
	
//Listing the categories
		
$sql_getheadcat = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='0'");
	
	while ($headcatinfo = sed_sql_fetcharray($sql_getheadcat)) {
		
		$index_info_cats .= ($headcatinfo['bdcat_fmode']>0) ? "<a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$headcatinfo['bdcat_id']."\" >".$headcatinfo['bdcat_name']."(".itemcount($headcatinfo['bdcat_id']).")</a>" : "<a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$headcatinfo['bdcat_id']."\" >".$headcatinfo['bdcat_name']."</a>";
		$sql_getsubcat = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='".$headcatinfo['bdcat_id']."'");
		
		while ($subcatinfo = sed_sql_fetcharray($sql_getsubcat)) {
			
			$index_info_cats .= "<br/>&nbsp;&nbsp;&nbsp;<a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$subcatinfo['bdcat_id']."\" >".$subcatinfo['bdcat_name']."(".itemcount($subcatinfo['bdcat_id']).")</a>";
			$sql_getsubcat2 = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='".$subcatinfo['bdcat_id']."'");
			
			while ($subcatinfo2 = sed_sql_fetcharray($sql_getsubcat2)) {
				
				$index_info_cats .= "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$subcatinfo2['bdcat_id']."\" >".$subcatinfo2['bdcat_name']."(".itemcount($subcatinfo2['bdcat_id']).")</a>";
				
				}
				
		}
			
		$index_info_cats .="<br/><br/>";
	}
		
	// ============TAGS===========/ ereryone /===========TAGS=======================
	
	while ($iteminfo = sed_sql_fetcharray($sql_lastitemsfmode3))
		{
		$t-> assign(array(
		"VIEW_ITEM_INFO_ID" => $iteminfo['bditem_id'],
		"VIEW_ITEM_INFO_NAME" => $iteminfo['bditem_name'],
		"VIEW_ITEM_INFO_SHORTDESC" => $iteminfo['bditem_shortdesc'],
		"VIEW_ITEM_INFO_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
		"VIEW_ITEM_INFO_PHOTO" => empty($iteminfo['bditem_photo']) ? "alt=\"".$L['bd_nophoto']."\" src=\"plugins/bestdeal/tpl_files/noimage.gif\"" : "src=\"".$iteminfo['bditem_photo']."\"",
		"VIEW_ITEM_INFO_DETAILS" => sed_cutstring(remove_media($iteminfo['bditem_details']),125),
		"VIEW_ITEM_INFO_LOCATION" => $iteminfo['bditem_location'],
		"VIEW_ITEM_INFO_PRICE" => priceinfo($iteminfo['bditem_price'],$iteminfo['bditem_mode']),	
		));
		
		$t->parse("MAIN.INDEX_INFO_LASTITEMS.ROW");
		}
	
	if(sed_sql_numrows($sql_lastitemsfmode3) > 0)
	{
	$t->parse("MAIN.INDEX_INFO_LASTITEMS");
	}
	
		while ($bidinfo = sed_sql_fetcharray($sql_lastbids))
		{
		
		
		$sql_iteminfo = sed_sql_query("SELECT * FROM sed_bestdeal_item where bditem_id='".$bidinfo['bdbid_item_id']."'");
		
		$iteminfo = sed_sql_fetcharray($sql_iteminfo);
		
		$t-> assign(array(
		"VIEW_ITEM_INFO_BID_USER" => userinfo($bidinfo['bdbid_user']),
		"VIEW_ITEM_INFO_BID_BID" => $valuta.$bidinfo['bdbid_bid'],
		"VIEW_ITEM_INFO_BID_DATE" => date($cfg['dateformat'],$bidinfo['bdbid_date'] + $usr['timezone'] * 3600),
		"VIEW_ITEM_INFO_ID" => $iteminfo['bditem_id'],
		"VIEW_ITEM_INFO_NAME" => $iteminfo['bditem_name'],
		"VIEW_ITEM_INFO_USER" => userinfo($iteminfo['bditem_user']),
		"VIEW_ITEM_INFO_SHORTDESC" => $iteminfo['bditem_shortdesc'],
		"VIEW_ITEM_INFO_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
		"VIEW_ITEM_INFO_PHOTO" => empty($iteminfo['bditem_photo']) ? "alt=\"".$L['bd_nophoto']."\" src=\"plugins/bestdeal/tpl_files/noimage.gif\"" : "src=\"".$iteminfo['bditem_photo']."\"",
		"VIEW_ITEM_INFO_DETAILS" => sed_cutstring(remove_media($iteminfo['bditem_details']),125),
		"VIEW_ITEM_INFO_LOCATION" => $iteminfo['bditem_location'],
		"VIEW_ITEM_INFO_PRICE" => priceinfo($iteminfo['bditem_price'],$iteminfo['bditem_mode']),	
		));
		
		$t->parse("MAIN.INDEX_INFO_LASTBIDS.ROW");
		}
		
		
	
	if(sed_sql_numrows($sql_lastbids) > 0)
	{
	$t->parse("MAIN.INDEX_INFO_LASTBIDS");
	}
	
	$iteminfo = sed_sql_fetcharray($sql_randomitem);
		
		$t-> assign(array(
		"VIEW_ITEM_INFO_ID" => $iteminfo['bditem_id'],
		"VIEW_ITEM_INFO_NAME" => $iteminfo['bditem_name'],
		"VIEW_ITEM_INFO_SHORTDESC" => $iteminfo['bditem_shortdesc'],
		"VIEW_ITEM_INFO_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
		"VIEW_ITEM_INFO_PHOTO" => empty($iteminfo['bditem_photo']) ? "<img style=\" max-width:100px; max-height:100px;\" src=\"plugins/bestdeal/tpl_files/noimage.gif\" />" : "<img style=\"width:100px; max-width:100px; max-height:100px;\" src=\"".$iteminfo['bditem_photo']."\" />",
		"VIEW_ITEM_INFO_DETAILS" => sed_cutstring(remove_media($iteminfo['bditem_details']),125),
		"VIEW_ITEM_INFO_LOCATION" => $iteminfo['bditem_location'],
		"VIEW_ITEM_INFO_PRICE" => priceinfo($iteminfo['bditem_price'],$iteminfo['bditem_mode']),	
		));
	
		if(sed_sql_numrows($sql_randomitem) > 0)
		{
		$t->parse("MAIN.INDEX_INFO_RANDOM");
		}
	
		while ($catinfo = sed_sql_fetcharray($sql_headcats))
		{
		
			$sql_lastitem = sed_sql_query("SELECT * FROM sed_bestdeal_item where bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' AND (bditem_cat_id='".$catinfo['bdcat_id']."' OR bditem_cat_id IN (SELECT s.bdcat_id FROM sed_bestdeal_cat AS s WHERE s.bdcat_headcat=".$catinfo['bdcat_id']." OR s.bdcat_id in (SELECT bdcat_id FROM sed_bestdeal_cat WHERE bdcat_headcat IN (SELECT s.bdcat_id FROM sed_bestdeal_cat AS s WHERE s.bdcat_headcat=".$catinfo['bdcat_id'].")))) ORDER BY bditem_adddate DESC LIMIT 5");
			
			 
			
			$t-> assign(array(
			"VIEW_CAT_INFO_ID" => $catinfo['bdcat_id'],
			"VIEW_CAT_INFO_NAME" => $catinfo['bdcat_name'],
			));
	
			while ($iteminfo = sed_sql_fetcharray($sql_lastitem))
			{
			$t-> assign(array(
			"VIEW_ITEM_INFO_ID" => $iteminfo['bditem_id'],
			"VIEW_ITEM_INFO_NAME" => $iteminfo['bditem_name'],
			"VIEW_ITEM_INFO_SHORTDESC" => $iteminfo['bditem_shortdesc'],
			"VIEW_ITEM_INFO_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
			"VIEW_ITEM_INFO_PHOTO" => empty($iteminfo['bditem_photo']) ? "alt=\"".$L['bd_nophoto']."\" src=\"plugins/bestdeal/tpl_files/noimage.gif\"" : "src=\"".$iteminfo['bditem_photo']."\"",
			"VIEW_ITEM_INFO_DETAILS" => sed_cutstring(remove_media($iteminfo['bditem_details']),125),
			"VIEW_ITEM_INFO_LOCATION" => $iteminfo['bditem_location'],
			"VIEW_ITEM_INFO_PRICE" => priceinfo($iteminfo['bditem_price'],$iteminfo['bditem_mode']),	
			));
			
			$t->parse("MAIN.INDEX_INFO_LASTINHEADCATS.ROW");
			}
	
			if(sed_sql_numrows($sql_lastitem) > 0)
			{
			$t->parse("MAIN.INDEX_INFO_LASTINHEADCATS");
			}
		}

	
	if($usr['isadmin'])
	{
	$t->assign(array(
	"INDEX_INFO_ADDCAT" => $L['bd_actions']."<a href=\"plug.php?e=bestdeal&page=addcat\">".$L['bd_addheadcat']."</a>",
	));
	}
	
	$search .= "<form action=\"plug.php?e=bestdeal&amp;page=viewcat&amp;a=search\" method=\"post\" name=\"search\">";
	$search .= "<input type=\"text\" class=\"skinned\"  name=\"search_query\" value=\"".$search_query."\" size=\"90\" maxlength=\"80\" />  ";
	$search .= bestdeal_cat_o_niser('none','search_cat_id',3,$search_cat_id);
	$search .= "<input type=\"submit\" value=\"".$L['bd_searchsubmit']."\">";
	$search .= "</form>";
	
/*Akciok query on index page of bestdeal*/	
$result = mysql_query("SELECT * FROM $db_akciok ORDER BY akciokID DESC LIMIT ".$cfg['bestdeal_akciok_limit']." ");
	
	while ( $row = mysql_fetch_array($result)) {
	
		//echo $row['title'];

	$akciok_mask .= "
		<div>
			<div><h4>".$row['title']."</h4></div>
			<div>".$row['content']."</div>
			<div><a href=\"".$row['url']."\" target=\"_blank\"\">".$row['url']."</a></div>
			<br>
		</div>
	";
	
	}	
	
	
	
	$t->assign(array(
	
	"INDEX_AKCIOK" => $akciok_mask,
	"INDEX_AD7" => $index_ad_7,
	"INDEX_AD6" => $index_ad_6,
	//"INDEX_AKCIOK" =>$bestdeal_akciok,
	
	"INDEX_ADVERT" => $rg_index_advert,
	
	"INDEX_INFO_CATS" => $index_info_cats,
	"INDEX_INFO_USERPANEL" => userpanel($usr['id']),
	"INDEX_INFO_SEARCH" => $search,
	"INDEX_INFO_CATONISER" => bestdeal_cat_o_niser('url','jumpbox',0,0),
	));
	

	
?>
