<?php

	
	$sql_getitem = sed_sql_query("SELECT * from sed_bestdeal_item WHERE bditem_id='$id' LIMIT 1");
	sed_die(sed_sql_numrows($sql_getitem)==0);
	
	$iteminfo = sed_sql_fetcharray($sql_getitem);


	// ============ 4 ============ / sql insert / =========== 4 ========= //	

	// ============ / bid actions / ================= //
	
	if($action=='bid' && $usr['auth_write'])
	{
	
	$bid_mailpm = sed_import('bid_mailpm','P','INT');
	$bid_amount = sed_import('bid_amount','P','INT');

	
	$sql_getbid = sed_sql_query("SELECT * FROM sed_bestdeal_bid WHERE bdbid_item_id='".$iteminfo['bditem_id']."' ORDER BY (bdbid_bid+0) DESC");
	$bidinfo = sed_sql_fetcharray($sql_getbid);
	
		if($bid_amount <= $bidinfo['bdbid_bid'])
		{
		header("Location: plug.php?e=bestdeal&id=".$iteminfo['bditem_id']."&a=higher");
		exit;
		}
		else
		{
		$sql = sed_sql_query("INSERT into sed_bestdeal_bid 
		(bdbid_user
		,bdbid_mailpm
		,bdbid_item_id
		,bdbid_date
		,bdbid_bid
		,bdbid_state)
		VALUES
		('".$usr['id']."'
		,'".$bid_mailpm."'
		,'".$iteminfo['bditem_id']."'
		,'".$sys['now_offset']."'
		,'".$bid_amount."'
		,'1')
		");
		
		
		$message_title = $L['bd_pretitle'].$iteminfo['bditem_name']." - " .$iteminfo['bditem_shortdesc'];
		
		$message_body = $L['bd_messagenewbid_1'].$iteminfo['bditem_name'].$L['bd_messagenewbid_2'].$valuta.$bid_amount.$L['bd_messagenewbid_3'].userinfo($usr['id'],"off");
		
		if($iteminfo['bditem_mailpm'] == 1)
		{
		send_mail($usr['id'],$iteminfo['bditem_user'], $message_title, $message_body);
		}
		else
		{
		send_pm($usr['id'],$iteminfo['bditem_user'], $message_title, $message_body);
		}
		
		
		header("Location: plug.php?e=bestdeal&id=".$iteminfo['bditem_id']."");
		exit;
		}
	
	}
	
if (!empty($action) && ($usr['id'] == $iteminfo['bditem_user'] || $usr['isadmin']))
{

// ============================ Delete a bit / ========================== //

	if($action=='deletebid')
	{
	
	$sql = sed_sql_query("DELETE FROM sed_bestdeal_bid WHERE bdbid_id='$p'");
	
	header("Location: plug.php?e=bestdeal&page=edititem&id=".$iteminfo['bditem_id']."");
	exit;
	}
	
// ============================ / Delete an item / ========================== //
	if ($action=='deleteitemphoto')
	{
	
		$photo = "bd_item-".$iteminfo['bditem_id'].".gif";
		$photopath = $photodir.$photo;
	
		if (file_exists($photopath))
			{ unlink($photopath); }
	
		$sql = sed_sql_query("DELETE FROM $db_pfs WHERE pfs_file='$photo'");
		$sql = sed_sql_query("UPDATE sed_bestdeal_item SET bditem_photo='' WHERE bditem_id='".$iteminfo['bditem_id']."'");
		header("Location: plug.php?e=bestdeal&page=edititem&id=".$iteminfo['bditem_id']."");
		exit;
	}

	if($action=='delete')
	{
	
	$sql_deleteitem = sed_sql_query("DELETE FROM sed_bestdeal_item WHERE bditem_id='$id'");
	$sql_deleteitem = sed_sql_query("DELETE FROM sed_bestdeal_bid WHERE bdbid_item_id='$id'");	
	
			$photo = "bd_item-".$id.".gif";
			$photopath = $photodir.$photo;
		
			if (file_exists($photopath))
				{ unlink($photopath); }
	
	$sql = sed_sql_query("DELETE FROM $db_pfs WHERE pfs_file='$photo'");
		
	sed_log("Deleted bestdeal item #".$id,'bestdeal');	
	
	header("Location: plug.php?e=bestdeal");
	exit;		
	}
	
	// ============ / Adminpanel actions / ================= //
	if($action=='validate' && $usr['isadmin'])
	{
	$sql = sed_sql_query("UPDATE sed_bestdeal_item SET 
		bditem_state ='1'
		WHERE bditem_id ='".$id."'");
	
	$message_title = $L['bd_pretitle'].$iteminfo['bditem_name']." - " .$iteminfo['bditem_shortdesc'];
		
		$message_body = $L['bd_messagevalidated_1'].$iteminfo['bditem_name'].$L['bd_messagevalidated_2'].date($cfg['dateformat'],$sys['now_offset'] + $usr['timezone'] * 3600).$L['bd_messagevalidated_3'];
		
		if($iteminfo['bditem_mailpm'] == 1)
		{
		send_mail($usr['id'],$iteminfo['bditem_user'], $message_title, $message_body);
		}
		else
		{
		send_pm($usr['id'],$iteminfo['bditem_user'], $message_title, $message_body);
		}
		
		header("Location: plug.php?e=bestdeal&page=userpanel&cat=10");
		exit;
	}
	
	if($action=='reactivate' && $usr['isadmin'])
	{
	
	$sql = sed_sql_query("UPDATE sed_bestdeal_item SET 
		bditem_state ='2'
		WHERE bditem_id ='".$id."'");
		
		$message_title = "Betreft: ".$iteminfo['bditem_name']." - " .$iteminfo['bditem_shortdesc'];
		
		$message_body = $L['bd_messageended_1'].$iteminfo['bditem_name'].$L['bd_messageended_2'].date($cfg['dateformat'],$iteminfo['bditem_state_enddate'] + $usr['timezone'] * 3600).$L['bd_messageended_3'];
		
		if($iteminfo['bditem_mailpm'] == 1)
		{
		send_mail($usr['id'],$iteminfo['bditem_user'], $message_title, $message_body);
		}
		else
		{
		send_pm($usr['id'],$iteminfo['bditem_user'], $message_title, $message_body);
		}
		
		header("Location: plug.php?e=bestdeal&page=userpanel&cat=12");
		exit;
		
	
	}
	if($action=='close' && $usr['isadmin'])
	{
	$sql = sed_sql_query("UPDATE sed_bestdeal_item SET 
		bditem_state ='3'
		WHERE bditem_id ='".$id."'");
	
	
	
	if($delphotoatclose == 1)
	{
	$photo = "bd_item-".$iteminfo['bditem_id'].".gif";
		$photopath = $photodir.$photo;
	
		if (file_exists($photopath))
			{ unlink($photopath); }
	
		$sql = sed_sql_query("DELETE FROM $db_pfs WHERE pfs_file='$photo'");
		$sql = sed_sql_query("UPDATE sed_bestdeal_item SET bditem_photo='' WHERE bditem_id='".$iteminfo['bditem_id']."'");
	}
		
		header("Location: plug.php?e=bestdeal&page=userpanel&cat=12");
		exit;
	}
	
	$bditem_ph_tmp_name = $_FILES['ibditemphoto']['tmp_name'];
	$bditem_ph_type = $_FILES['ibditemphoto']['type'];
	$bditem_ph_name = $_FILES['ibditemphoto']['name'];
	$bditem_ph_size = $_FILES['ibditemphoto']['size'];	

	$ibditem_cat_id = sed_import('ibditem_cat_id','P','INT');
	$ibditem_mode = sed_import('ibditem_mode','P','INT');
	$ibditem_name = sed_import('ibditem_name','P','TXT');
	$ibditem_shortdesc = sed_import('ibditem_shortdesc','P','TXT');
	$ibditem_details = sed_import('ibditem_details','P','HTM');
	$ibditem_editdate = $sys['now_offset'];
	$ibditem_price = sed_import('ibditem_price','P','TXT');
	$ibditem_mailpm = sed_import('ibditem_mailpm','P','INT');
	$ibditem_location = sed_import('ibditem_location','P','TXT');
	$ibditem_phone = sed_import('ibditem_phone','P','INT');
	$ibditem_reactivate = sed_import('ibditem_reactivate','P','INT');
	$ibditem_state = $iteminfo['bditem_state'];
	
		if($iteminfo['bditem_startdate'] > $sys['now_offset'])
		{
	// === $ibditem_startdate
	$ryear_startdate = sed_import('ryear_startdate','P','INT');
	$rmonth_startdate = sed_import('rmonth_startdate','P','INT');
	$rday_startdate = sed_import('rday_startdate','P','INT');
	$rhour_startdate = sed_import('rhour_startdate','P','INT');
	$rminute_startdate = sed_import('rminute_startdate','P','INT');
	
	$endstate_month = $rmonth_startdate + $state_active;
	$endstate_year = $ryear_startdate;
		}
		
	while($endstate_month > 12)
	{
	for($m = 1; $m<=12; $m++)
	{
	$endstate_month--;
	}
	$endstate_year++;
	}
	if($ibditem_reactivate == 1)
		{
		$ibditem_state = 1;
		$ibditem_startdate = $iteminfo['bditem_startdate'];
		$ibditem_state_enddate = $iteminfo['bditem_state_enddate'] + ($state_active*2674800);
		}
		elseif($iteminfo['bditem_startdate'] > $sys['now_offset'])
		{
		$ibditem_startdate = sed_mktime($rhour_startdate, $rminute_startdate, 0, $rmonth_startdate, $rday_startdate, $ryear_startdate) - $usr['timezone']*3600;
		
		$ibditem_state_enddate = sed_mktime($rhour_startdate, $rminute_startdate, 0,$endstate_month, $rday_startdate, $endstate_year) - $usr['timezone']*3600;
		}
		else
		{
		$ibditem_startdate = $iteminfo['bditem_startdate'];
		$ibditem_state_enddate = $iteminfo['bditem_state_enddate'];
		}
	
	if($usr['isadmin'])
	{
	$error_string .= $ibditem_cat_id == 0 ? $L['bd_choosecategorie']."<br />" : '';
	}
	$error_string .= (strlen($ibditem_name)< 5) ? $L['bd_nametoshort']."<br />" : '';
	//$error_string .= (strlen($ibditem_shortdesc)< 5) ? $L['bd_detailstoshort']."<br />" : '';
	
	if (empty($error_string))
		{
		
	if (!empty($bditem_ph_tmp_name))
		{ @clearstatcache(); }

if (!empty($bditem_ph_tmp_name) && $bditem_ph_size>0)
		{
		$dotpos = strrpos($bditem_ph_name,".")+1;
		$f_extension = strtolower(substr($bditem_ph_name, $dotpos, 5));

		if (is_uploaded_file($bditem_ph_tmp_name) && $bditem_ph_size>0 && $bditem_ph_size<=$max_size_item_photo && ($f_extension=='jpeg' || $f_extension=='jpg' || $f_extension=='gif' || $f_extension=='png'))
			{
			list($w, $h) = @getimagesize($bditem_ph_tmp_name);
			if ($w<=$max_x_item_photo && $h<=$max_y_item_photo)
				{
				$photo = "bd_item-".$iteminfo['bditem_id'].".gif";
				$photopath = $photodir.$photo;
				
				if (file_exists($photopath))
					{ unlink($photopath); }

				move_uploaded_file($bditem_ph_tmp_name, $photopath);
				$bditem_ph_size = filesize($photopath);
				$sql = sed_sql_query("UPDATE sed_bestdeal_item SET bditem_photo='$photopath' WHERE bditem_id='".$iteminfo['bditem_id']."'");
				$sql = sed_sql_query("DELETE FROM $db_pfs WHERE pfs_file='$photo'");
				$sql = sed_sql_query("INSERT INTO $db_pfs (pfs_userid, pfs_file, pfs_extension, pfs_folderid, pfs_desc, pfs_size, pfs_count) VALUES (".(int)$usr['id'].", '$photo', '$f_extension', -1, '', ".(int)$bditem_ph_size.", 0)");
				@chmod($photopath, 0666);
				}
			}
		}
		
		$sql = sed_sql_query("UPDATE sed_bestdeal_item SET 
		
		 bditem_name ='".sed_sql_prep($ibditem_name)."'
		,bditem_shortdesc ='".sed_sql_prep($ibditem_shortdesc)."'
		,bditem_editdate ='".$ibditem_editdate."'
		,bditem_price ='".$ibditem_price."'
		,bditem_state ='".$ibditem_state."'
		,bditem_details ='".sed_sql_prep($ibditem_details)."'
		,bditem_location ='".sed_sql_prep($ibditem_location)."'
		,bditem_phone ='".$ibditem_phone."'
		,bditem_mailpm ='".$ibditem_mailpm."'
		,bditem_startdate ='".$ibditem_startdate."'
		,bditem_state_enddate ='".$ibditem_state_enddate."'
		WHERE bditem_id ='".$id."'");
		
		if($usr['isadmin'])
		{
		$sql = sed_sql_query("UPDATE sed_bestdeal_item SET 
		bditem_cat_id ='".$ibditem_cat_id."'

		,bditem_mode ='".$ibditem_mode."' WHERE bditem_id='$id'");
		

		}
		

		//header("plug.php?e=bestdeal&page=edititem&id=$id");
		if($iteminfo['bditem_state'] == 0)
		{
		header("Location: plug.php?e=bestdeal&page=userpanel&cat=0");
		exit;
		}
		elseif($iteminfo['bditem_state'] == 2 || $iteminfo['bditem_startdate'] > $sys['now_offset'])
		{
		header("Location: plug.php?e=bestdeal&page=userpanel&cat=2");
		exit;
		}
		else{
		header("Location: plug.php?e=bestdeal&page=viewcat&cat=".$iteminfo['bditem_cat_id']."");
		exit;
		}
		}



}

if (($usr['id'] == $iteminfo['bditem_user'] || $usr['isadmin']) && $iteminfo['bditem_state']!='3')
{
	// ============== 1 ========== / Make a new template / ========== 1 ========== //

		$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.edititem.tpl";
		$path_skin_path	= "skins/$skin/extplugin.bestdeal.edititem.tpl";	
		
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

	// =========== 2 ============= / Textboxer / ========== 2 ========== //
		
		
		$edit_item_form_bbcodes = ($cfg['plugin']['bestdeal']['parsebbcode']) ? sed_build_bbcodes('edit_item', 'ibditem_details',$L['BBcodes']) : '';
$edit_item_form_smilies = ($cfg['plugin']['bestdeal']['parsesmilies']) ? sed_build_smilies('edit_item', 'ibditem_details',$L['Smilies']) : '';
$edit_item_form_pfs = sed_build_pfs($usr['id'], 'edit_item', 'ibditem_details', $L['Mypfs']);
$edit_item_form_pfs .= (sed_auth('pfs', 'a', 'A')) ? " &nbsp; ".sed_build_pfs(0, 'edit_item', 'ibditem_details', $L['SFS']) : '';
		
		
		
		$edit_item_form_details = sed_textboxer2('ibditem_details', 'edit_item', sed_cc($iteminfo['bditem_details']), $tb2TextareaRows, $tb2TextareaCols, 'XXXXXXXXXXXXXXXXXXXX', $tb2ParseBBcodes, $tb2ParseSmilies, $tb2ParseBR, $tb2Buttons, $tb2DropdownIcons, $tb2MaxSmilieDropdownHeight, $tb2InitialSmilieLimit).$pfs;
		
	// ============ 2 ============ / Define more functions / ========== 2 ========== //
		
		if($sys['now_offset'] > $iteminfo['bditem_state_enddate'])
		{
		$edit_item_form_startdate = $L['bd_activateended_1'].date($cfg['dateformat'],$iteminfo['bditem_state_enddate'] + $usr['timezone'] * 3600).$L['bd_activateended_2']." <input type=\"checkbox\" name=\"ibditem_reactivate\" value=\"1\">";
		}
		elseif($iteminfo['bditem_startdate'] < $sys['now_offset'])
		{
		$edit_item_form_startdate = $L['bd_alreadystarted_1'].date($cfg['dateformat'],$iteminfo['bditem_startdate'] + $usr['timezone'] * 3600).$L['bd_alreadystarted_2'].date($cfg['dateformat'],$iteminfo['bditem_state_enddate'] + $usr['timezone'] * 3600);
		}
		else{
		$edit_item_form_startdate = sed_selectbox_date($iteminfo['bditem_startdate']+$usr['timezone']*3600, 'long','_startdate');
		
		}
		
		
		if($iteminfo['bditem_mode'] == 0)
		{
		$edit_item_form_mode = "<input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"0\"  checked=\"checked\" /> ".$L['bd_forsale']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"1\"/> ".$L['bd_forsalebid']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"2\"/> ".$L['bd_asked']."";
		}
		elseif($iteminfo['bditem_mode'] == 1)
		{
		$edit_item_form_mode = "<input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"0\"/> ".$L['bd_forsale']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"1\"  checked=\"checked\" /> ".$L['bd_forsalebid']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"2\"/> ".$L['bd_asked']."";
		}
		else
		{
		$edit_item_form_mode = "<input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"0\"/> ".$L['bd_forsale']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"1\"/> ".$L['bd_forsalebid']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"2\" checked=\"checked\"/> ".$L['bd_asked']."";
		}
		
		$edit_item_form_mailpm = $iteminfo['bditem_mailpm'] == 0 ? "<input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"0\" checked=\"checked\" /> ".$L['bd_bidpm']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"1\" />".$L['bd_bidmail'] : "<input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"0\" />".$L['bd_bidpm']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"1\" checked=\"checked\" />".$L['bd_bidmail'];	
		
		//képek szerkesztése
		$edit_item_form_photo .= (empty($iteminfo['bditem_photo'])) ? "<img src=\"".$iteminfo['bditem_photo']."\" alt=\"\" /><br/> ".$L['Delete']." [<a href=\"plug.php?e=bestdeal&amp;page=edititem&amp;id=".$iteminfo['bditem_id']."&amp;a=deleteitemphoto\">x</a>]" : '';
		$edit_item_form_photo .= $L['pro_photoupload']." (".$L['bd_widthof'].$max_x_item_photo."x".$L['bd_heightof'].$max_y_item_photo." x ".$L['bd_sizeof'].$max_size_item_photo."bytes)<br />";
		$edit_item_form_photo .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".($max_size_item_photo*1024)."\" />";
		$edit_item_form_photo .= "<input name=\"ibditemphoto\" type=\"file\" class=\"file\" size=\"24\" /><br />";
		
	// ============ 3 ============ / Tagparsing / ========= 3 =========== //
	
	if (!empty($error_string))
	{
	$t->assign("EDIT_ITEM_ERROR_BODY",$error_string);
	$t->parse("MAIN.EDITITEM_ERROR");
	}
	

	
	$t->assign(array(
	"EDIT_ITEM_FORM_NAME" => "<input type=\"text\" class=\"text\" name=\"ibditem_name\" value=\"".sed_cc($iteminfo['bditem_name']
)."\" size=\"56\" maxlength=\"50\" />",
	"EDIT_ITEM_FORM_SHORTDESC" => "<input type=\"text\" class=\"text\" name=\"ibditem_shortdesc\" value=\"".sed_cc($iteminfo['bditem_shortdesc']
)."\" size=\"56\" maxlength=\"50\" />",
	"EDIT_ITEM_FORM_PRICE" => "<input type=\"text\" class=\"text\" name=\"ibditem_price\" value=\"".sed_cc($iteminfo['bditem_price']
)."\" size=\"10\" maxlength=\"10\" />",
	
	"EDIT_ITEM_FORM_PHOTO" => $edit_item_form_photo,
	"EDIT_ITEM_FORM_DETAILS" => $edit_item_form_details,
	"EDIT_ITEM_FORM_LOCATION" => "<input type=\"text\" class=\"text\" name=\"ibditem_location\" value=\"".sed_cc($iteminfo['bditem_location']
)."\" size=\"56\" maxlength=\"80\" />",
	"EDIT_ITEM_FORM_PHONE" => "<input type=\"text\" class=\"text\" name=\"ibditem_phone\" value=\"".sed_cc($iteminfo['bditem_phone']
)."\" size=\"56\" maxlength=\"15\" />",
	"EDIT_ITEM_FORM_MAILPM" => $edit_item_form_mailpm,
	"EDIT_ITEM_FORM_BIDS" => bids($iteminfo['bditem_id']),
	"EDIT_ITEM_FORM_BBCODES" => $edit_item_form_bbcodes,
	"EDIT_ITEM_FORM_SMILIES" => $edit_item_form_smilies,
	"EDIT_ITEM_FORM_MYPFS" => $edit_item_form_pfs,
	"EDIT_ITEM_FORM_STATELENGTH" => $state_active,
	"EDIT_ITEM_FORM_STARTDATE" => $edit_item_form_startdate,
	"EDIT_ITEM_FORM_SEND" => "plug.php?e=bestdeal&amp;page=edititem&amp;a=update&amp;id=$id"
		));
	$t->parse("MAIN.EDITITEM_USER");
	
	if ($usr['isadmin'])
	{

	$t->assign(array(
	"EDIT_ITEM_FORM_CAT_ID" => bestdeal_cat_o_niser('none','ibditem_cat_id',3,$iteminfo['bditem_cat_id']),
	"EDIT_ITEM_FORM_MODE" => $edit_item_form_mode,

		));
	$t->parse("MAIN.EDITITEM_ADMIN");
	}
}
else
{
			header("Location: plug.php?e=bestdeal");
			exit;
}
?>	