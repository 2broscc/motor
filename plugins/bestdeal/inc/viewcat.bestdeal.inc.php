<?php

/*

Filename: viewcat.bestdeal.inc.php
CMS Framework based on Seditio v121 www.neocrome.net
Re-programmed by 2bros cc
Date:03-07-2011
Programmer: Peter Magyar
Email:ridelineonline@gmail.com
http://2bros.atw.hu

This file has been added by 2bros cc

*/




if (empty($p)) { $p = '0';

	 }
	
	if(empty($action)) {
	
		$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_cat_id='$cat' AND bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."'");
	
		$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

		$sql_getcat = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_id='$cat'");
		$catinfo = sed_sql_fetcharray($sql_getcat);
	
		$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_cat_id='".$catinfo['bdcat_id']."' AND bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' LIMIT $p, ".$maxitemsperpage);
	
			if(sed_sql_numrows($sql_getcat)==0) {
					
					header("Location: plug.php?e=bestdeal");
					exit;
			}
	
	}
	elseif($action == 'search')
	{
	$search_query = sed_import('search_query','P','TXT');
	$search_cat_id = sed_import('search_cat_id','P','INT');
	
	if($search_cat_id > 0)
	{
	$cat_id = "bditem_cat_id='$search_cat_id' AND";
	}
	else
	{
	$cat_id = "";
	}
	
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE $cat_id (bditem_name LIKE '%$search_query%'OR bditem_shortdesc LIKE '%$search_query%' OR bditem_details LIKE '%$search_query%' ) AND bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");
	
	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE $cat_id (bditem_name LIKE '%$search_query%'OR bditem_shortdesc LIKE '%$search_query%' OR bditem_details LIKE '%$search_query%' ) AND bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' LIMIT $p, ".$maxitemsperpage);
	}
	
		
		
		
		
/*
Making the template stuff
*/

		$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.viewcat.tpl";
		$path_skin_path	= "skins/$skin/extplugin.bestdeal.viewcat.tpl";	
		
		if (file_exists($path_plugin_path))
		{
			$path_skin= $path_plugin_path;
		}
		elseif (file_exists($path_skin_path))
		{
			$path_skin = $path_skin_path;
		}
		else
		{
			header("Location: message.php?msg=907");
			exit;
		}	
		$t = new XTemplate($path_skin);
	
		// ================ 2============ / Make template ==================== 2=========

/*
Search field
*/
		
		$search .= "<form action=\"plug.php?e=bestdeal&amp;page=viewcat&amp;a=search\" method=\"post\" name=\"search\">";
		$search .= "<input type=\"text\" class=\"text\" name=\"search_query\" value=\"".$search_query."\" size=\"20\" maxlength=\"20\" />  ";
		$search .= bestdeal_cat_o_niser('none','search_cat_id',3,$search_cat_id);
		$search .= "<input type=\"submit\" value=\"".$L['bd_searchsubmit']."\">";
		$search .= "</form>";
		
/*
Pagination
*/
		
		$nbpages = ceil($totalitems  / $maxitemsperpage);
		$curpage = $p / $maxitemsperpage;
		
		for ($i = 0; $i < $nbpages; $i++)
			{
			$j = $i * $maxitemsperpage;
			if ($i==$curpage)
				{ $pages .= "&gt; <a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=$cat&amp;pn=".$j."\">".($i+1)."</a> &lt; "; }
			elseif (is_int(($i+1)/5) || $i<10 || $i+1==$nbpages)
				{ $pages .= "[<a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=$cat&amp;pn=".$j."\">".($i+1)."</a>] "; 		 }
			}
	
	
	if(empty($action))
	{
	// ============TAGS============/ Admin + user with level to add items /=====TAGS======
	if(($usr['isadmin'] || $sed_groups[$usr['maingrp']]['level'] >= $catinfo['bdcat_level']) && $catinfo['bdcat_fmode'] > 0)
	{
	$t->assign(array(
	"VIEW_CAT_INFO_ADDITEM" => $L['bd_actions']."<a href=\"plug.php?e=bestdeal&page=additem&cat=".$catinfo['bdcat_id']."\">".$L['bd_preadditem']."</a>",
	));
	}
	
		if($usr['isadmin'])
		{
			$t->assign(array(
			"VIEW_CAT_INFO_EDITCAT" => "<a href=\"plug.php?e=bestdeal&page=editcat&amp;cat=".$catinfo['bdcat_id']."\">".$L['bd_preeditcat']."</a>",
			));
			
			$sql_getheadcat = sed_sql_query("SELECT bdcat_id,bdcat_headcat,bdcat_name from sed_bestdeal_cat WHERE bdcat_id='".$catinfo['bdcat_headcat']."'");
			$headcatinfo = sed_sql_fetcharray($sql_getheadcat);
		
			if(($headcatinfo['bdcat_headcat'] == 0))
			{
			$t->assign(array(
			"VIEW_CAT_INFO_ADDSUBCAT" => "<a href=\"plug.php?e=bestdeal&page=addcat&amp;cat=".$catinfo['bdcat_id']."\">".$L['bd_preaddcat']."</a>",
			));
			}
		}
	}
	// ============TAGS===========/ Everyone/===========TAGS==============================
	
		if(empty($action))
		{
		$t->assign(array(
		
		"VIEW_CAT_INFO_TITLE" => $catinfo['bdcat_name'],
		"VIEW_CAT_INFO_SUBCATS" => titelcat(1,$cat),
		"VIEW_CAT_INFO_CATONISER" => bestdeal_cat_o_niser('url','jumpbox',$catinfo['bdcat_fmode'],$catinfo['bdcat_id']),
		"VIEW_CAT_INFO_SHORTDESC" => $catinfo['bdcat_shortdesc'],
		));
		}
		else
		{
		$t->assign(array(
		"VIEW_CAT_INFO_TITLE" => $L['bd_presearchtitle'].$search_query,
		"VIEW_CAT_INFO_CATONISER" => bestdeal_cat_o_niser('url','jumpbox',3,0),
		));
		}
		
		$t->assign(array(
		"VIEW_CAT_INFO_USERPANEL" => userpanel($usr['id']),
		"VIEW_CAT_INFO_SEARCH" => $search,
		"VIEW_CAT_INFO_PAGES" => $pages,
		));
	
	
	// ============TAGS===========/ ereryone (ROW) /===========TAGS=======================
	
	$ii=0;
	
while ($iteminfo = sed_sql_fetcharray($sql_getitem))
	{
	$ii++;
	
	$t-> assign(array(
	"VIEW_CAT_ITEMROW_ID" => $iteminfo['bditem_id'],
	"VIEW_CAT_ITEMROW_USER" => userinfo($iteminfo['bditem_user']),
	"VIEW_CAT_ITEMROW_NAME" => $iteminfo['bditem_name'],
	"VIEW_CAT_ITEMROW_SHORTDESC" => $iteminfo['bditem_shortdesc'],
	"VIEW_CAT_ITEMROW_STATE" => $iteminfo['bditem_state'],
	"VIEW_CAT_ITEMROW_EDITDATE" => date($cfg['dateformat'],$iteminfo['bditem_editdate'] + $usr['timezone'] * 3600),
	"VIEW_CAT_ITEMROW_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
	"VIEW_CAT_ITEMROW_STATE_ENDDATE" => date($cfg['dateformat'],$iteminfo['bditem_state_enddate'] + $usr['timezone'] * 3600),
	"VIEW_CAT_ITEMROW_STARTDATE" => date($cfg['dateformat'],$iteminfo['bditem_startdate'] + $usr['timezone'] * 3600),
	"VIEW_CAT_ITEMROW_ENDDATE" => date($cfg['dateformat'],$iteminfo['bditem_enddate'] + $usr['timezone'] * 3600),
	"VIEW_CAT_ITEMROW_PRICE" => priceinfo($iteminfo['bditem_price'],$iteminfo['bditem_mode'],$iteminfo['bditem_id']),
	"VIEW_CAT_ITEMROW_MODE" => $iteminfo['bditem_mode'],
	"VIEW_CAT_ITEMROW_PHOTO" => empty($iteminfo['bditem_photo']) ? "alt=\"".$L['bd_nophoto']."\" src=\"plugins/bestdeal/tpl_files/noimage_small.gif\"" : "src=\"".$iteminfo['bditem_photo']."\" height=\"32px\" width=\"32px\"  ",
	"VIEW_CAT_ITEMROW_DETAILS" => sed_cutstring(remove_media($iteminfo['bditem_details']),125),
	"VIEW_CAT_ITEMROW_HITS" => $iteminfo['bditem_hits'],
	"VIEW_CAT_ITEMROW_LOCATION" => $iteminfo['bditem_location'],
	"VIEW_CAT_ITEMROW_PHONE" => $iteminfo['bditem_phone'],
	"VIEW_CAT_ITEMROW_MAILMP" => $iteminfo['bditem_mailpm'],
	"VIEW_CAT_ITEMROW_ODDEVEN" => sed_build_oddeven($ii),
	));
		
	$t->parse("MAIN.VIEWCAT.VIEW_CAT_ROW");
	
	
	}
	
	
	if(sed_sql_numrows($sql_getitem)> 0 && ($catinfo['bdcat_fmode'] > 0 || $action=='search'))
	{
	
	$t->parse("MAIN.VIEWCAT");
	
	}
	elseif(sed_sql_numrows($sql_getitem)== 0 && ($catinfo['bdcat_fmode'] > 0|| $action=='search'))
	{
	
	$t->parse("MAIN.VIEWCAT.VIEW_CAT_ROW_EMPTY");
	
	$t->parse("MAIN.VIEWCAT");
	
	}
	
	if($catinfo['bdcat_fmode'] == 0 && $action=="")
	{
	
	$sql_headcats = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='$cat'");
		$ii=0;
		
		while ($catinfo = sed_sql_fetcharray($sql_headcats))
		{
		$ii++;
		
			$sql_lastitem = sed_sql_query("SELECT * FROM sed_bestdeal_item where bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' AND (bditem_cat_id='".$catinfo['bdcat_id']."' OR bditem_cat_id IN (SELECT s.bdcat_id FROM sed_bestdeal_cat AS s WHERE s.bdcat_headcat=".$catinfo['bdcat_id']." OR s.bdcat_id in (SELECT bdcat_id FROM sed_bestdeal_cat WHERE bdcat_headcat IN (SELECT s.bdcat_id FROM sed_bestdeal_cat AS s WHERE s.bdcat_headcat=".$catinfo['bdcat_id'].")))) ORDER BY bditem_adddate DESC LIMIT 5");
			
			 
			$t-> assign(array(
			"VIEW_CAT_INFO_ROWSTART" => (sed_build_oddeven($ii)=='odd')? "<tr><td style=\"width:50%;\">" : "<td style=\"width:50%;\">",
			"VIEW_CAT_INFO_ROWEND" => (sed_build_oddeven($ii)=='odd')? "</td>" : "</td></tr>",
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
			
			
			if(sed_sql_numrows($sql_lastitem) > 0)
			{
			$t->parse("MAIN.VIEWCATLIST.VIEWCAT_INFO_LASTINHEADCATS.ROW");
			}

			
			}
			
			if(sed_sql_numrows($sql_lastitem) == 0)
			{
			$t->parse("MAIN.VIEWCATLIST.VIEWCAT_INFO_LASTINHEADCATS.ROW_EMPTY");
			}
$t->parse("WCATLIST.VIEWCAT_INFO_LASTINHEADCATS");
		}
		
	$t->parse("MAIN.VIEWCATLIST");
	}
	
	//==============================/ If category is closed /=====================


?>