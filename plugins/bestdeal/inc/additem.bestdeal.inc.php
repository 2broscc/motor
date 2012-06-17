<?php

/*
originally made by bestdeal
updated:2011.01.05 by 2bros 

*/

$sql_getcat = sed_sql_query("SELECT bdcat_id,bdcat_name,bdcat_fmode,bdcat_level FROM sed_bestdeal_cat WHERE bdcat_id='$cat'");
sed_die(sed_sql_numrows($sql_getcat)==0);
$catinfo = sed_sql_fetcharray($sql_getcat);
			

	
//Adding new product	
if ($action=='add')
{

	$bditem_ph_tmp_name = $_FILES['ibditemphoto']['tmp_name'];
	$bditem_ph_type = $_FILES['ibditemphoto']['type'];
	$bditem_ph_name = $_FILES['ibditemphoto']['name'];
	$bditem_ph_size = $_FILES['ibditemphoto']['size'];	
	
	$ibditem_cat_id = sed_import('ibditem_cat_id','P','INT');
	$ibditem_mode = sed_import('ibditem_mode','P','INT');
	$ibditem_name = sed_import('ibditem_name','P','TXT');
	$ibditem_shortdesc = sed_import('ibditem_shortdesc','P','TXT');
	$ibditem_details = sed_import('ibditem_details','P','HTM');
	$ibditem_adddate = $sys['now_offset'];
	$ibditem_editdate = $sys['now_offset'];
	$ibditem_photo = sed_import('ibditem_photo','P','TXT');
	$ibditem_price = sed_import('ibditem_price','P','INT');
	$ibditem_mailpm = sed_import('ibditem_mailpm','P','INT');
	$ibditem_location = sed_import('ibditem_location','P','TXT');
	$ibditem_phone = sed_import('ibditem_phone','P','INT');

	
	// === $ibditem_startdate
	$ryear_startdate = sed_import('ryear_startdate','P','INT');
	$rmonth_startdate = sed_import('rmonth_startdate','P','INT');
	$rday_startdate = sed_import('rday_startdate','P','INT');
	$rhour_startdate = sed_import('rhour_startdate','P','INT');
	$rminute_startdate = sed_import('rminute_startdate','P','INT');
	
	if($catinfo['bdcat_timebeforereact'] < $state_active)
	{
	$state_time = $state_active;
	}
	else
	{
	$state_time = $catinfo['bdcat_timebeforereact'];
	}
	
	$endstate_month = $rmonth_startdate + $state_time;
	$endstate_year = $ryear_startdate;
	
	while($endstate_month > 12)
	{
	for($m = 1; $m<=12; $m++)
	{
	$endstate_month--;
	}
	$endstate_year++;
	}
	
	$ibditem_state = ($autovalidation == 1) ? 1 : 0;
	
	$error_string = $ibditem_cat_id == 0 ? $L['bd_choosecategorie']."<br />" : '';
	$error_string .= (strlen($ibditem_name)< 5) ? $L['bd_nametoshort']."<br />" : '';
	//$error_string .= (strlen($ibditem_shortdesc)< 5) ? $L['bd_detailstoshort']."<br />" : '';
	
	if (empty($error_string))
		{
		
		$ibditem_startdate = sed_mktime($rhour_startdate, $rminute_startdate, 0, $rmonth_startdate, $rday_startdate, $ryear_startdate) - $usr['timezone']*3600;
		
		$ibditem_state_enddate = sed_mktime($rhour_startdate, $rminute_startdate, 0,$endstate_month, $rday_startdate, $endstate_year) - $usr['timezone']*3600;
		
		$sql = sed_sql_query("INSERT into sed_bestdeal_item 
		(bditem_cat_id
		,bditem_user
		,bditem_name
		,bditem_shortdesc
		,bditem_state
		,bditem_editdate
		,bditem_adddate
		,bditem_state_enddate
		,bditem_startdate
		,bditem_price
		,bditem_mode
		,bditem_photo
		,bditem_details
		,bditem_hits
		,bditem_location
		,bditem_phone
		,bditem_mailpm
		) 
		VALUES 
		('".sed_sql_prep($ibditem_cat_id)."'
		,'".$usr['id']."'
		,'".sed_sql_prep($ibditem_name)."'
		,'".sed_sql_prep($ibditem_shortdesc)."'
		,'".$ibditem_state."'
		,'".$ibditem_editdate."'
		,'".$ibditem_adddate."'
		,'".$ibditem_state_enddate."'
		,'".$ibditem_startdate."'
		,'".sed_sql_prep($ibditem_price)."'
		,'".$ibditem_mode."'
		,'".$ibditem_photo."'
		,'".sed_sql_prep($ibditem_details)."'
		,'0'
		,'".sed_sql_prep($ibditem_location)."'
		,'".$ibditem_phone."'
		,'".sed_sql_prep($ibditem_mailpm)."'
		)");
		

	if (!empty($bditem_ph_tmp_name))
		{ @clearstatcache(); }
				
if (!empty($bditem_ph_tmp_name) && $bditem_ph_size>0)
		{
	
	$ibditem_name_stripped = sed_sql_prep($ibditem_name);
	
	$sql_getitem = sed_sql_query("SELECT * from sed_bestdeal_item WHERE bditem_name='$ibditem_name_stripped' AND bditem_user='".$usr['id']."' LIMIT 1");
	sed_die(sed_sql_numrows($sql_getitem)==0);
	
	$iteminfo = sed_sql_fetcharray($sql_getitem);
		
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

				header("Location: plug.php?e=bestdeal&page=viewcat&cat=$cat");
				exit;
				
}
}		

	// ============== 1 ========== / Make a new template / ========== 1 ========== //

		$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.additem.tpl";
		$path_skin_path	= "skins/$skin/extplugin.bestdeal.additem.tpl";	
		
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


//TextBoxer Prase implementation
		
$add_item_form_bbcodes = ($cfg['plugin']['bestdeal']['parsebbcode']) ? sed_build_bbcodes('add_item', 'ibditem_details',$L['BBcodes']) : '';
$add_item_form_smilies = ($cfg['plugin']['bestdeal']['parsesmilies']) ? sed_build_smilies('add_item', 'ibditem_details',$L['Smilies']) : '';
$add_item_form_pfs = sed_build_pfs($usr['id'], 'add_item', 'ibditem_details', $L['Mypfs']);
$add_item_form_pfs .= (sed_auth('pfs', 'a', 'A')) ? " &nbsp; ".sed_build_pfs(0, 'add_item', 'ibditem_details', $L['SFS']) : '';
		
		
		
		$add_item_form_details = sed_textboxer2('ibditem_details', 'add_item', sed_cc($ibditem_details), $tb2TextareaRows, $tb2TextareaCols, 'XXXXXXXXXXXXXXXXXXXX', $tb2ParseBBcodes, $tb2ParseSmilies, $tb2ParseBR, $tb2Buttons, $tb2DropdownIcons, $tb2MaxSmilieDropdownHeight, $tb2InitialSmilieLimit).$pfs;
		
//Define functions
		
		$add_item_form_startdate = sed_selectbox_date($sys['now_offset']+$usr['timezone']*3600, 'long','_startdate');


		$add_item_form_photo .= $L['pro_photoupload']." (".$L['bd_widthof'].$max_x_item_photo."x".$L['bd_heightof'].$max_y_item_photo." x ".$L['bd_sizeof'].$max_size_item_photo."bytes)<br />";
		$add_item_form_photo .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".($max_size_item_photo*1024)."\" />";
		$add_item_form_photo .= "<input name=\"ibditemphoto\" type=\"file\" class=\"file\" size=\"24\" /><br />";
		
		$add_item_form_mode = "<input checked=\"checked\" type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"0\" /> ".$L['bd_forsale']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"1\" /> ".$L['bd_forsalebid']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mode\" value=\"0\" /> ".$L['bd_asked']."";
		$add_item_form_mailpm = $ibditem_mailpm == 0 ? "<input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"0\" checked=\"checked\" />".$L['bd_bidpm']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"1\"  />".$L['bd_bidmail'] : "<input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"0\" checked=\"checked\"/>".$L['bd_bidpm']." <input type=\"radio\" class=\"radio\" name=\"ibditem_mailpm\" value=\"1\" checked=\"checked\" />".$L['bd_bidmail']."";
	

//Tags
	
	if (!empty($error_string)) {
		$t->assign("ADD_ITEM_ERROR_BODY",$error_string);
		$t->parse("MAIN.ADDITEM_ERROR");
	}
	
	
	$t->assign(array(
	"ADD_ITEM_FORM_CAT_TITLE"=> $catinfo['bdcat_name'],
	"ADD_ITEM_FORM_CAT_ID" => "<input name=\"ibditem_cat_id\" type=\"hidden\" value=\"".$catinfo['bdcat_id']."\"/>".$catinfo['bdcat_name'],
	"ADD_ITEM_FORM_NAME" => "<input type=\"text\" class=\"text\" name=\"ibditem_name\" value=\"".sed_cc($ibditem_name)."\" size=\"56\" maxlength=\"50\" />",
	"ADD_ITEM_FORM_SHORTDESC" => "<input type=\"text\" class=\"text\" name=\"ibditem_shortdesc\" value=\"".sed_cc($ibditem_shortdesc)."\" size=\"56\" maxlength=\"50\" />",
	"ADD_ITEM_FORM_PRICE" => "<input type=\"text\" class=\"text\" name=\"ibditem_price\" value=\"".sed_cc($ibditem_price)."\" size=\"10\" maxlength=\"10\" />",
	"ADD_ITEM_FORM_MODE" => $add_item_form_mode,
	"ADD_ITEM_FORM_DETAILS" => $add_item_form_details,
	"ADD_ITEM_FORM_PHOTO" => $add_item_form_photo,
	"ADD_ITEM_FORM_STATELENGTH" => $catinfo['bdcat_timebeforereact'] < $state_active ? $state_active : $catinfo['bdcat_timebeforereact'] ,
	"ADD_ITEM_FORM_STARTDATE" => $add_item_form_startdate,
	"ADD_ITEM_FORM_LOCATION" => "<input type=\"text\" class=\"text\" name=\"ibditem_location\" value=\"".sed_cc($ibditem_location)."\" size=\"56\" maxlength=\"80\" />",
	"ADD_ITEM_FORM_PHONE" => "<input type=\"text\" class=\"text\" name=\"ibditem_phone\" value=\"".sed_cc($ibditem_phone)."\" size=\"15\" maxlength=\"15\" />",
	"ADD_ITEM_FORM_MAILPM" => $add_item_form_mailpm,
	"ADD_ITEM_FORM_BBCODES" => $add_item_form_bbcodes,
	"ADD_ITEM_FORM_SMILIES" => $add_item_form_smilies,
	"ADD_ITEM_FORM_MYPFS" => $add_item_form_pfs,
	"ADD_ITEM_FORM_SEND" => "plug.php?e=bestdeal&amp;page=additem&amp;a=add&cat=$cat",
		));


?>