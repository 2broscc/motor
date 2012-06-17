<?PHP

/*

Filename: functions.bestdeal.inc.php
CMS Framework based on Seditio v121 www.neocrome.net
Re-programmed by 2bros cc
Date:03-07-2011
Programmer: Peter Magyar
Email:ridelineonline@gmail.com
http://2bros.atw.hu

This file has been added by 2bros cc

*/


if ( !defined('SED_CODE') ) { die("Wrong URL."); }

//username
function userinfo($id,$link='on')
	{
	global $usr,$db_users;
	
	$sql_getinfo = sed_sql_query("SELECT * FROM $db_users WHERE user_id='$id'");
	$userinfo = sed_sql_fetcharray($sql_getinfo);
	
	if($usr['id'] > 0 && $link == "on")
	{
	$link_start = "<a href=\"users.php?m=details&amp;id=&id\">";
	$link_end = "</a>";
	}
	
	return $link_start.$userinfo['user_name'].$link_end;
	}

//itemcount	
function itemcount($cat_id)
	{
	global $sys;
	
		$sql = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_cat_id='$cat_id' AND bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."'");
	
		$count = sed_sql_result($sql, 0, "COUNT(*)");
	
	return $count;
	}
		
//category information
function titelcat($mode,$cat)
	{
	global $L;
	
	$sql_getcat = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_id='$cat'");
	
	$catinfo = sed_sql_fetcharray($sql_getcat);
	
	$sql_getheadcat = sed_sql_query("SELECT bdcat_id,bdcat_headcat,bdcat_name from sed_bestdeal_cat WHERE bdcat_id='".$catinfo['bdcat_headcat']."'");
	$headcatinfo = sed_sql_fetcharray($sql_getheadcat);
	
	$sql_getupperheadcat = sed_sql_query("SELECT bdcat_id,bdcat_headcat,bdcat_name from sed_bestdeal_cat WHERE bdcat_id='".$headcatinfo['bdcat_headcat']."'");
	
	$upperheadcatinfo = sed_sql_fetcharray($sql_getupperheadcat);
	
	if($mode ==1)
	{
	$sql_getsubcats = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='". $catinfo['bdcat_id']."'");
		while ($subcatinfo = sed_sql_fetcharray($sql_getsubcats))
		{
			$subcats .= " <td><a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$subcatinfo['bdcat_id']."\">".$subcatinfo['bdcat_name']."(".itemcount($subcatinfo['bdcat_id']).")</a>";
			
				$sql_getsubcats2 = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='".$subcatinfo['bdcat_id']."'");
				while ($subcatinfo2 = sed_sql_fetcharray($sql_getsubcats2))
				{
				$subcats .= "<br />
			 &nbsp;&nbsp;&nbsp;&nbsp;<a style=\"font-size:0.9em\" href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$subcatinfo2['bdcat_id']."\">".$subcatinfo2['bdcat_name']."(".itemcount($subcatinfo2['bdcat_id']).")</a>&nbsp;&nbsp;";
				}
			$subcats .="</td>";
		}
	}
	$upperheadcat = !empty($upperheadcatinfo['bdcat_id']) ? " <a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$upperheadcatinfo['bdcat_id']."\">".$upperheadcatinfo['bdcat_name']."(".itemcount($upperheadcatinfo['bdcat_id']).")</a>  " : "";
	
if($headcatinfo['bdcat_id'] > 0) {

	$headcatnotempty = "<a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$headcatinfo['bdcat_id']."\">".$headcatinfo['bdcat_name']."(".itemcount($headcatinfo['bdcat_id']).") </a>";
	
}
	
	$headcat = $headcatnotempty."> <a href=\"plug.php?e=bestdeal&amp;page=viewcat&amp;cat=".$catinfo['bdcat_id']."\">".$catinfo['bdcat_name']."(".itemcount($catinfo['bdcat_id']).")</a>";
	$view_cat_info_subcats = !empty($subcats) ? "<table><tr><td><a href=\"plug.php?e=bestdeal\">".$L['bd_index']."</a></td><td>".$headcat." < </td>".$subcats."</tr></table>" : "<table><tr><td><a href=\"plug.php?e=bestdeal\">".$L['bd_index']."</a></td><td>".$upperheadcat."</td><td>".$headcat." < </td></tr></table>";
	
	return $view_cat_info_subcats;
}

// ================================== / Strip media /=========================
function remove_media($text)
{
//Text replacing with thanx to Rayblo
$pattern[0] = "@\[img\](.+?)\[\/img\]@i";
$pattern[1] = "@\[hide](.+?)\[\/hide\]@is";
$pattern[2] = "@\[youtube](.+?)\[\/youtube\]@is";
$pattern[3] = "@\[center](.+?)\[\/center\]@is";
$pattern[4] = "@^\s+@";
$pattern[5] = "@((^[\r\n]+|[\r\n]+)[\s\t]*[\r\n]+){2,}@";

$replace[0] = "";
$replace[1] = "";
$replace[2] = "";
$replace[3] = "\\1";
$replace[4] = "";
$replace[5] = "\r\n\r\n";

$strippedtext = preg_replace($pattern,$replace,$text);

return $strippedtext;

}
// ================================== / VIEWING AND ADDING BIDS /=========================
function bids($item)
	{
	global $usr,$cfg,$action,$valuta,$page,$L;
	
	$sql_getitem = sed_sql_query("SELECT bditem_mode,bditem_id,bditem_user FROM sed_bestdeal_item WHERE bditem_id='$item' ");
	$iteminfo = sed_sql_fetcharray($sql_getitem);
	
	if($iteminfo['bditem_mode'] == 1)
	{
	$bids .= "<table><td>";
	
		if($usr['auth_write']&& $page != 'edititem')
		{
		if($action=='higher')
		{
		$bids .= $L['bd_bidhigher'];
		}
		$bids .= "<form action=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=".$iteminfo['bditem_id']."&amp;a=bid\" method=\"post\" name=\"bid\">";
		$bids .= $bid_mailpm == 0 ? "<input type=\"radio\" class=\"radio\" name=\"bid_mailpm\" value=\"0\" checked=\"checked\" />".$L['bd_bidpm']."<input type=\"radio\" class=\"radio\" name=\"bid_mailpm\" value=\"1\" />".$L['bd_bidmail'] : "<input type=\"radio\" class=\"radio\" name=\"bid_mailpm\" value=\"0\" />".$L['bd_bidpm']."<input type=\"radio\" class=\"radio\" name=\"bid_mailpm\" value=\"1\" checked=\"checked\" />".$L['bd_bidmail'];
		$bids .= "<br/><input type=\"text\" class=\"text\" name=bid_amount size=\"10\" maxlength=\"10\" />";
		$bids .= "<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"".$L['bd_bidsubmit']."\">";
		$bids .= "</form>";
		}
		elseif($page == 'edititem')
		{
		
		}
		else
		{
		$bids .= $L['bd_bidlogin'];
		}
	
	$bids .="</td><td style=\"width:50%;\">";
	
	$sql_getbid = sed_sql_query("SELECT * FROM sed_bestdeal_bid WHERE bdbid_item_id='$item' ORDER BY (bdbid_bid+0) DESC");
	
	$bids .="<table>";
	$bids .="<tr><td><b>".$L['bd_bid']."</b></td><td><b>".$L['bd_bidbidder']."</b></td><td><b>".$L['bd_biddate']."</b></td><td></td></tr>";
	
	while($bidinfo = sed_sql_fetcharray($sql_getbid))
	{
	
	if($iteminfo['bditem_user'] == $usr['id'])
	{
	$contact = $bidinfo['bdbid_mailpm'] == 0 ? "<a href=\"pm.php?m=send&amp;to=".$bidinfo['bdbid_user']."\">".$L['bd_bidcontact']."</a>" : "<a href=\"plug.php?e=bestdeal&amp;page=sendmail&amp;id=".$bidinfo['bdbid_user']."&amp;pn=".$bidinfo['bdbid_item_id']."\">".$L['bd_bidcontact']."</a>";
	}
	
	if($iteminfo['bditem_mode'] == 1 && $page == 'edititem')
	{
	$contact = "";
	$delete = "<a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=".$iteminfo['bditem_id']."&amp;pn=".$bidinfo['bdbid_id']."&amp;a=deletebid\">Verwijderen</a>";
	}
	
	$bids .="<tr><td>".$valuta.$bidinfo['bdbid_bid']."</td><td>".userinfo($bidinfo['bdbid_user'])."</td><td>".date($cfg['dateformat'],$bidinfo['bdbid_date'] + $usr['timezone'] * 3600)."</td><td>".$contact.$delete."</td></tr>";
	}
	
	if(sed_sql_numrows($sql_getbid)==0)
	{
	$bids .="<tr><td colspan=\"4\">".$L['bd_bidnobid']."</td></tr>";
	}
	$bids .="</table>";
	
	$bids .= "</td></tr>"; 
	
	$bids .= "</table>";
	 
	return $bids;
	}
	
	}
//priceinfo
function priceinfo($price,$mode,$item=0)
	{
	global $valuta,$L;
	
	if($mode == 0)
	{
	
		if($price=="f" || $price=="F") 	{
			$priceinfo = $L['bd_pricefree'];
	
		}
			elseif($price=="n" || $price=="N") {
			
				$priceinfo = $L['bd_pricetotalkabout'];
			}
	
				elseif($price>='0') {
				
					$priceinfo = $valuta.$price; 
				}
	
	}
	
	if($mode == 1)
	{
	if(empty($price))
	{
	$priceinfo = $L['bd_pricebid'];
	}
	else{
	$priceinfo = $L['bd_pricebidfrom'].$valuta.$price ;
	}
	
		if($item > 0)
	{
	
	$sql_getbid = sed_sql_query("SELECT * FROM sed_bestdeal_bid WHERE bdbid_item_id='$item' ORDER BY (bdbid_bid+0) DESC LIMIT 1");
	$bidinfo = sed_sql_fetcharray($sql_getbid);
	
	if(sed_sql_numrows($sql_getbid)> 0)
	$priceinfo .= "<br/>".$L['bd_lastbidded'].$valuta.$bidinfo['bdbid_bid'];
	}
	
	}

	if($mode == 2)
	{
		if($price=="f" || $price=="F")
	{
	$priceinfo = "<b>".$L['bd_priceaskes']."</b>".$L['bd_pricefree'];
	}
	elseif(($price=="n" || $price=="N") || empty($price))
	{
	$priceinfo = "<b>".$L['bd_priceasked']."</b>".$L['bd_pricetotalkabout'];
	}
	elseif($price>='0')
	{
	$priceinfo = "<b>".$L['bd_priceaskedfor']."</b>".$valuta.$price; 
	}
		
	}
	
	return $priceinfo;
	}
// ================================== / USER AND ADMINPANEL  /=========================
function userpanel($userid)
	{
	global $usr, $sys,$L;
	
	if($usr['isadmin'])
	{
		
		$validation_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='0'");
		$validation_total = sed_sql_result($validation_count, 0, "COUNT(*)");
		
		if($validation_total > 0)
		{
		$adminpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=10\"> ".$L['bd_unvalidated']."( ".$validation_total." )</a>";
		}
		
		$active_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='1' AND bditem_state_enddate < '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."'");
		$active_total = sed_sql_result($active_count, 0, "COUNT(*)");
		
		if($active_total > 0)
		{
		$adminpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=11\"> ".$L['bd_foractivation']."( ".$active_total." )</a>";
		}
		
		$inactive_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='2'");
		$inactive_total = sed_sql_result($inactive_count, 0, "COUNT(*)");
		
		if($inactive_total > 0)
		{
		$adminpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=12\"> ".$L['bd_inactive']."( ".$inactive_total." )</a>";
		}
		
		$closed_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='3'");
		$closed_total = sed_sql_result($closed_count, 0, "COUNT(*)");
		
		if($closed_total > 0)
		{
		$adminpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=13\">  ".$L['bd_closeditem']."( ".$closed_total." )</a>";
		}

		$adminpanel = (!empty($adminpanel)) ? $L['bd_adminpanel'].$adminpanel."<br/>" : '' ;
	}
	
	if($usr['auth_write'])
	{

		$validation_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='0' AND bditem_user='$userid'");
		$validation_total = sed_sql_result($validation_count, 0, "COUNT(*)");
		
		if($validation_total > 0)
		{
		$userpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=0\"> ".$L['bd_unvalidated']."( ".$validation_total." )</a>";
		}
		
		$active_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='1' AND bditem_state_enddate > '".$sys['now_offset']."' AND bditem_startdate < '".$sys['now_offset']."' AND bditem_user='$userid'");
		$active_total = sed_sql_result($active_count, 0, "COUNT(*)");
		
		if($active_total > 0)
		{
		$userpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=1\"> ".$L['bd_active']."( ".$active_total." )</a>";
		}
		
		$inactive_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE (bditem_state='2' OR bditem_startdate > '".$sys['now_offset']."') AND bditem_user='$userid'");
		$inactive_total = sed_sql_result($inactive_count, 0, "COUNT(*)");
		
		if($inactive_total > 0)
		{
		$userpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=2\">  ".$L['bd_inactive']."( ".$inactive_total." )</a>";
		}
		
		$closed_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state='3' AND bditem_user='$userid'");
		$closed_total = sed_sql_result($closed_count, 0, "COUNT(*)");
		
		if($closed_total > 0)
		{
		$userpanel .= "<a href=\"plug.php?e=bestdeal&amp;page=userpanel&amp;cat=3\">  ".$L['bd_closeditem']."( ".$closed_total." )</a>";
		}
	}
	
	$userpanel = (!empty($userpanel)) ? $adminpanel.$L['bd_userpanel'].$userpanel : $adminpanel ;
	
	return $userpanel;
	}
	
// ================================== / ACTIONS IN USERPANEL /=========================
function actions($item)
	{
	global $sys,$cfg, $cat, $usr,$L,$page;
	
			$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_id='$item'");
		$iteminfo = sed_sql_fetcharray($sql_getitem);
	
		if($usr['isadmin'] && $cat>=10)
		{

			if($iteminfo['bditem_state'] == 0)
			{
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=validate\">".$L['bd_validate']."</a>";
			
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item\">".$L['bd_edit']."</a>";
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=delete\">".$L['bd_delete']."</a>";
			}
			
			if($iteminfo['bditem_state'] == 1 && $sys['now_offset'] > $iteminfo['bditem_state_enddate'])
			{
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=reactivate\">".$L['bd_acceptreactivation']."</a>";			
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item\">".$L['bd_edit']."</a>";
			}
			if($iteminfo['bditem_state'] == 2)
			{
			$actions .=$L['bd_acceptedon'].date($cfg['dateformat'],$iteminfo['bditem_editdate'] + $usr['timezone'] * 3600)."<br/>";			
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item\">".$L['bd_heractivate_edit']."</a>";
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=close\">".$L['bd_close']."</a>";
			}
			if($iteminfo['bditem_state'] == 3)
			{
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=delete\">".$L['bd_delete']."</a>";
			}
			
		}
		
		
		if($usr['auth_write'] && $iteminfo['bditem_user'] == $usr['id'] && $cat < 10)
		{
			
			if($iteminfo['bditem_state'] == 0)
			{
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item\">".$L['bd_edit']."</a>";
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=close\">".$L['bd_close']."</a>";
			}
			if($iteminfo['bditem_state'] == 1 && $iteminfo['bditem_startdate'] > $sys['now_offset'])
			{
			$actions .= $L['bd_notyetstarted'];
			}
			if($iteminfo['bditem_state'] == 1)
			{
			if(!empty($page))
			{
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;id=$item\">".$L['bd_view']."</a>";
			}
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item\">".$L['bd_edit']."</a>";
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=close\">".$L['bd_close']."</a>";
			}
			if($iteminfo['bditem_state'] == 2)
			{
			$actions .="(Heractivatie) <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item\">".$L['bd_check_edit_reactivate']."</a>";
			}
			if($iteminfo['bditem_state'] == 3)
			{
			$actions .=" <a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=$item&amp;a=delete\">".$L['bd_delete']."</a>";
			}
		}
		
		
	return $actions;
	}
	
// ================================== / CATONIZER /=========================	
function bestdeal_cat_o_niser($function,$fieldname,$fmode,$selecteditem)
	{
	global $usr, $sed_groups,$L;
	
	
	if($function == 'url')
	{
	$defaultfunction = 'value=""';
	$selectfunction = 'onchange="redirect(this)"';
	$optionfunction = 'plug.php?e=bestdeal&page=viewcat&cat=';
	}
	else
	{
	$defaultfunction = 'value=\"0\"';
	$selectfunction = '';
	$optionfunction = '';
	}
	
	
	
	$headcat_sql = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE  bdcat_headcat='0'");
	
	$selector= "<select name=\"".$fieldname."\" ".$selectfunction.">";
	$selector.= "<option ".$defaultfunction." >".$L['bd_choosecat']."</option>";
	while ($row_headcat = sed_sql_fetcharray($headcat_sql))
	{
	
	if ($selecteditem == $row_headcat['bdcat_id'])
	{
	$selected="SELECTED";
	}
	else
	{
	$selected="";
	}
	
	$selector.= "<option style=\"font-weight:bold;\" value=\"".$optionfunction.$row_headcat['bdcat_id']."\" ".$selected.">".$row_headcat['bdcat_name']."</option>";
	
		$subcat_sql = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='".$row_headcat['bdcat_id']."' ");
	
		while ($row_subcat = sed_sql_fetcharray($subcat_sql))
		{
		
			if ($row_subcat['bdcat_id'] == $selecteditem)
			{
			
			$selected="SELECTED";
			
			}
			else
			{
			$selected="";
			}
		
		$selector.= "<option value=\"".$optionfunction.$row_subcat['bdcat_id']."\" ".$selected."> &nbsp; ".$row_subcat['bdcat_name']."</option>";
		
			$sub2cat_sql = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_headcat='".$row_subcat['bdcat_id']."' ");
		
			while ($row_sub2cat = sed_sql_fetcharray($sub2cat_sql))
			{
			
				if ($selecteditem == $row_sub2cat['bdcat_id'])
				{
				$selected="SELECTED";
				}
				else
				{
				$selected="";
				}
			
			$selector.= "<option value=\"".$optionfunction.$row_sub2cat['bdcat_id']."\" ".$selected.">&nbsp;&nbsp;&nbsp;&nbsp; ".$row_sub2cat['bdcat_name']."</option>";
			}
		}
	
	}
	
	$selector.= "</select>";
	
		
	return $selector;
	}
	
// ================================== / SEND MAIL /=========================	
function send_mail($sender,$recipient, $title, $body)
	{
	global $db_users, $cfg ,$admin_mail;
		
		$sql_getsender = sed_sql_query("SELECT user_email,user_name FROM $db_users WHERE user_id='$sender'");
		
		$sql_getrecipient = sed_sql_query("SELECT user_email FROM $db_users WHERE user_id='$recipient'")	;
		
		$senderinfo = sed_sql_fetcharray($sql_getsender);
		$recipientinfo = sed_sql_fetcharray($sql_getrecipient);
		
		if(empty($admin_mail))
		{
		$admin_name = $senderinfo['user_name'];
		$admin_mail = $senderinfo['user_email'];
		}
		else{
		$admin_name = $cfg['maintitle'];
		}
		
	if(empty($recipientinfo['user_email']))
		{
			return(FALSE);
		}
	else
		{
		$headers = "From: \"".$admin_name."\" <".$senderinfo['user_email'].">\n"
		."Reply-To: <".$senderinfo['user_email'].">\n"
		."Content-Type: text/plain; charset=".$cfg['charset']."\n";
		
		$body .= "\n\n".$cfg['maintitle']." - ".$cfg['mainurl']."\n".$cfg['subtitle'];
		
			mail($recipientinfo['user_email'], $title, $body, $headers);
		
			sed_stat_inc('totalmailsent');
		
			return(TRUE);
		}
	}
	
// ================================== / SEND PM /=========================
function send_pm($sender,$recipient, $title, $body)
	{
	global $db_users, $cfg ,$db_pm,$sys,$L;
		
		$sql_getsender = sed_sql_query("SELECT user_id,user_name FROM $db_users WHERE user_id='$sender'");
		
		$sql_getrecipient = sed_sql_query("SELECT user_id,user_email,user_pmnotify FROM $db_users WHERE user_id='$recipient'")	;
		
		$senderinfo = sed_sql_fetcharray($sql_getsender);
		$recipientinfo = sed_sql_fetcharray($sql_getrecipient);
		
		$sql = sed_sql_query("INSERT into $db_pm
				(pm_state,
				pm_date,
				pm_fromuserid,
				pm_fromuser,
				pm_touserid,
				pm_title,
				pm_text)
				VALUES
				(0,
				".(int)$sys['now_offset'].",
				".(int)$senderinfo['user_id'].",
				'".$senderinfo['user_name']."',
				".(int)$recipientinfo['user_id'].",
				'".$title."',
				'".$body."')");
		
		if($cfg['version'] > '110')
		{
		$sql = sed_sql_query("UPDATE $db_users SET user_newpm=1 WHERE user_id='".$recipientinfo['user_id']."'");
		}
		
		if ($cfg['pm_allownotifications'] && $recipientinfo['user_pmnotify']==1)
				{
				
					$rusername = sed_cc($recipientinfo['user_name']);
					$remail = $recipientinfo['user_email'];
					$rsubject = $cfg['maintitle']." - ".$L['pm_notifytitle'];
					$rbody = sprintf($L['pm_notify'], $rusername, sed_cc($senderinfo['user_name']), $cfg['mainurl']."/pm.php");
					sed_mail($remail, $rsubject, $rbody);
					sed_stat_inc('totalmailpmnot');
				}
		
		return(TRUE);
				
	}

?>