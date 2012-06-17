<?php

	// ============== 1 ===========/ Get info from mysql /================ 1==============//

if (empty($p))
	{ $p = '0'; }
	
if($cat == 10 && $usr['isadmin'])
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='0'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_state='0' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_admintitleunvalidated'];
	
}
elseif($cat == 11 && $usr['isadmin'])
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' AND bditem_user='".$usr['id']."'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_state='1' AND bditem_state_enddate < '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_admintitletoreactivate'];
}
elseif($cat == 12 && $usr['isadmin'])
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='2' AND bditem_user='".$usr['id']."'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_state='2' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_admintitleinactive'];
}
elseif($cat == 13 && $usr['isadmin'])
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='3'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_state='3' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_admintitleclosed'];
}
elseif($cat == 0)
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='0'AND bditem_user='".$usr['id']."'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_state='0'AND bditem_user='".$usr['id']."' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_myitemtitleunvalidated'];
}
elseif($cat == 1)
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' AND bditem_user='".$usr['id']."'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' AND bditem_user='".$usr['id']."' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_myitemtitleactive'];
}
elseif($cat == 2)
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE (bditem_state='2' OR bditem_startdate > '".$sys['now_offset']."') AND bditem_user='".$usr['id']."'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE (bditem_state='2' OR bditem_startdate > '".$sys['now_offset']."') AND bditem_user='".$usr['id']."' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_myitemtitleinactive'];
}
elseif($cat == 3)
{
	$sql_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='3' AND bditem_user='".$usr['id']."'");
	$totalitems = sed_sql_result($sql_count, 0, "COUNT(*)");

	$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_state='3' AND bditem_user='".$usr['id']."' LIMIT $p, ".$maxitemsperpage);
	$title = $L['bd_myitemstitleclosed'];
}

else
{
header("Location: plug.php?e=bestdeal");
exit;
}


		
		// ============== 2 ========== / Make a new template / ========== 2 ========== //

		$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.userpanel.tpl";
		$path_skin_path	= "skins/$skin/extplugin.bestdeal.userpanel.tpl";	
		
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

		// ========================= Pagination ===============/
		
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
	
	// ============TAGS============/ Admin + user with level to add items /=====TAGS======

	// ============TAGS===========/ Everyone/===========TAGS==============================
	$t->assign(array(
	"USERPANEL_INFO_USERPANEL" => userpanel($usr['id']),
	"USERPANEL_INFO_TITLE" => $title,
	"USERPANEL_INFO_PAGES" => $pages,
	));
	
	
	// ============TAGS===========/ ereryone (ROW) /===========TAGS=======================
	$ii=0;
while ($iteminfo = sed_sql_fetcharray($sql_getitem))
	{
	$ii++;
	
	$t-> assign(array(
	"USERPANEL_ITEMROW_ID" => $iteminfo['bditem_id'],
	"USERPANEL_ITEMROW_USER" => userinfo($iteminfo['bditem_user']),
	"USERPANEL_ITEMROW_NAME" => $iteminfo['bditem_name'],
	"USERPANEL_ITEMROW_SHORTDESC" => $iteminfo['bditem_shortdesc'],
	"USERPANEL_ITEMROW_STATE" => $iteminfo['bditem_state'],
	"USERPANEL_ITEMROW_EDITDATE" => date($cfg['dateformat'],$iteminfo['bditem_editdate'] + $usr['timezone'] * 3600),
	"USERPANEL_ITEMROW_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
	"USERPANEL_ITEMROW_STATE_ENDDATE" => date($cfg['dateformat'],$iteminfo['bditem_state_enddate'] + $usr['timezone'] * 3600),
	"USERPANEL_ITEMROW_STARTDATE" => date($cfg['dateformat'],$iteminfo['bditem_startdate'] + $usr['timezone'] * 3600),
	"USERPANEL_ITEMROW_ENDDATE" => date($cfg['dateformat'],$iteminfo['bditem_enddate'] + $usr['timezone'] * 3600),
	"USERPANEL_ITEMROW_PRICE" =>priceinfo($iteminfo['bditem_price'],$iteminfo['bditem_mode'],$iteminfo['bditem_id']),
	"USERPANEL_ITEMROW_MODE" => $iteminfo['bditem_mode'],
	"USERPANEL_ITEMROW_PHOTO" => empty($iteminfo['bditem_photo']) ?  "alt=\"".$L['bd_nophoto']."\" src=\"plugins/bestdeal/tpl_files/noimage_small.gif\"" : "src=\"".$iteminfo['bditem_photo']."\"",
	"USERPANEL_ITEMROW_DETAILS" => sed_cutstring(remove_media($iteminfo['bditem_details']),125),
	"USERPANEL_ITEMROW_HITS" => $iteminfo['bditem_hits'],
	"USERPANEL_ITEMROW_LOCATION" => $iteminfo['bditem_location'],
	"USERPANEL_ITEMROW_PHONE" => $iteminfo['bditem_phone'],
	"USERPANEL_ITEMROW_MAILMP" => $iteminfo['bditem_mailpm'],
	"USERPANEL_ITEMROW_ODDEVEN" => sed_build_oddeven($ii),
	"USERPANEL_ITEMROW_ACTIONS" => actions($iteminfo['bditem_id']),
	));
		
	$t->parse("MAIN.USERPANEL_ROW");
	}
	
	if(sed_sql_numrows($sql_getitem)==0)
	{
	$t->parse("MAIN.USERPANEL_ROW_EMPTY");
	}
	
?>
