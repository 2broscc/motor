<?php

// ============== 1 ===========/ Get info from mysql /================ 1==============//

		{
		$sql_getcat = sed_sql_query("SELECT * FROM sed_bestdeal_cat WHERE bdcat_id='$cat'");
		$catinfo = sed_sql_fetcharray($sql_getcat);
		}
		
		
		
		if ($action=='edit')
		{		
		
		$ibdcat_headcat = sed_import('ibdcat_headcat','P','TXT');
		$ibdcat_name = sed_import('ibdcat_name','P','TXT');
		$ibdcat_shortdesc = sed_import('ibdcat_shortdesc','P','TXT');
		$ibdcat_level = sed_import('ibdcat_level','P','INT');
		$ibdcat_fmode = sed_import('ibdcat_fmode','P','INT');
		$ibdcat_timebeforereact = sed_import('ibdcat_timebeforereact','P','INT');
		$ibdcat_delete = sed_import('ibdcat_delete','P','INT');
		
		if ($ibdcat_delete=='1')
		{
		$items_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_item WHERE bditem_state!='3' AND bditem_cat_id='$cat'");
		$items_total = sed_sql_result($items_count, 0, "COUNT(*)");
		
		$subcats_count = sed_sql_query("SELECT COUNT(*) FROM sed_bestdeal_cat WHERE bdcat_headcat='$cat'");
		$subcats_total = sed_sql_result($subcats_count, 0, "COUNT(*)");
		
		$error_string .= ($subcats_total > 0) ? $L['bd_stillcatsincat']."<br />" : '';
		
		$error_string .= ($items_total > 0) ? $L['bd_stillitemsincat']."<br />" : '';
			if (empty($error_string))
			{
			$sql = sed_sql_query("DELETE FROM sed_bestdeal_cat WHERE bdcat_id='$cat'");
			}
			
		}
		
		// ============ 3 ============ / sql insert / =========== 3 ========= //
		
		$error_string .= (strlen($ibdcat_name)< 5) ? $L['bd_nametoshort']."<br />" : '';
		$error_string .= (strlen($ibdcat_level)==0) ? $L['bd_nolevel']."<br />" : '';
		
			if (empty($error_string))
			{
			
			$sql = sed_sql_query("UPDATE sed_bestdeal_cat SET
			bdcat_name='".sed_sql_prep($ibdcat_name)."'
			,bdcat_shortdesc='".sed_sql_prep($ibdcat_shortdesc)."'
			,bdcat_level='".$ibdcat_level."'
			,bdcat_fmode='".$ibdcat_fmode."'
			,bdcat_timebeforereact='".$ibdcat_timebeforereact."'
			WHERE bdcat_id='".$catinfo['bdcat_id']."'");
			
				if($cat==0)
				{
				header("Location: plug.php?e=bestdeal");
				exit;
				}
				else
				{
				header("Location: plug.php?e=bestdeal&page=viewcat&cat=$cat");
				exit;
				}
			}
			
			
		}
		// ============== 2 ========== / Make a new template / ========== 2 ========== //

		$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.editcat.tpl";
		$path_skin_path	= "skins/$skin/extplugin.bestdeal.editcat.tpl";	
		
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
		
		$edit_cat_form_bbcodes = ($cfg['plugin']['bestdeal']['parsebbcode']) ? sed_build_bbcodes('edit_cat', 'ibdcat_shortdesc',$L['BBcodes']) : '';
$edit_cat_form_smilies = ($cfg['plugin']['bestdeal']['parsesmilies']) ? sed_build_smilies('edit_cat', 'ibdcat_shortdesc',$L['Smilies']) : '';
$edit_cat_form_pfs = sed_build_pfs($usr['id'], 'edit_cat', 'ibdcat_shortdesc', $L['Mypfs']);
$edit_cat_form_pfs .= (sed_auth('pfs', 'a', 'A')) ? " &nbsp; ".sed_build_pfs(0, 'edit_cat', 'ibdcat_shortdesc', $L['SFS']) : '';
		
		
		
		$edit_cat_form_shortdesc = sed_textboxer2('ibdcat_shortdesc', 'edit_cat', sed_cc($catinfo['bdcat_shortdesc']), $tb2TextareaRows, $tb2TextareaCols, 'XXXXXXXXXXXXXXXXXXXX', $tb2ParseBBcodes, $tb2ParseSmilies, $tb2ParseBR, $tb2Buttons, $tb2DropdownIcons, $tb2MaxSmilieDropdownHeight, $tb2InitialSmilieLimit).$pfs;
	
		// ================ 2============ / End  Make template ==================== 2=========
	
	if($catinfo['bdcat_fmode'] == 0)
	{
	$edit_cat_form_fmode = "<input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"0\" checked=\"checked\" /> ".$L['bd_optionclosed']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"1\" /> ".$L['bd_optionwebshop']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"2\"/> ".$L['bd_optionanimocheck']." <input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"3\" /> ".$L['bd_optionpublicmarket']." ";
	}
	elseif($catinfo['bdcat_fmode'] == 1)
	{
	$edit_cat_form_fmode = "<input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"0\" /> ".$L['bd_optionclosed']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"1\"  checked=\"checked\" /> ".$L['bd_optionwebshop']." <input  DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"2\"/> ".$L['bd_optionanimocheck']."  <input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"3\" /> ".$L['bd_optionpublicmarket']."";
	}
	elseif($catinfo['bdcat_fmode'] == 2)
	{
	$edit_cat_form_fmode = "<input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"0\" /> ".$L['bd_optionclosed']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"1\" /> ".$L['bd_optionwebshop']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"2\" checked=\"checked\"/> A".$L['bd_optionanimocheck']." <input  type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"3\" /> ".$L['bd_optionpublicmarket']." ";
	}
	elseif($catinfo['bdcat_fmode'] == 3)
	{
	$edit_cat_form_fmode = "<input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"0\" /> ".$L['bd_optionclosed']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_mode\" value=\"1\" /> ".$L['bd_optionwebshop']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"2\"/> ".$L['bd_optionanimocheck']." <input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"3\" checked=\"checked\" /> ".$L['bd_optionpublicmarket']."";
	}
	
	$edit_cat_form_delete = "<input type=\"radio\" class=\"radio\" name=\"ibdcat_delete\" value=\"1\" /> ".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"ibdcat_delete\" value=\"0\" checked=\"checked\" /> ".$L['No']."";

	// ============TAGS===========/ Everyone/===========TAGS==============================
	
		if (!empty($error_string))
	{
	$t->assign("EDIT_CAT_ERROR_BODY",$error_string);
	$t->parse("MAIN.EDITCAT_ERROR");
	}
	
	$t->assign(array(
	"EDIT_CAT_FORM_TITLE" => $catinfo['bdcat_name'],
	"EDIT_CAT_FORM_NAME" => "<input type=\"text\" class=\"text\" name=\"ibdcat_name\" value=\"".sed_cc($catinfo['bdcat_name']
)."\" size=\"56\" maxlength=\"50\" />",
	"EDIT_CAT_FORM_SHORTDESC" => $edit_cat_form_shortdesc,
	"EDIT_CAT_FORM_LEVEL" => "<input type=\"text\" class=\"text\" name=\"ibdcat_level\" value=\"".sed_cc($catinfo['bdcat_level']
)."\" size=\"5\" maxlength=\"2\" />",
	"EDIT_CAT_FORM_FMODE" => $edit_cat_form_fmode,
	"EDIT_CAT_FORM_TIMEBEFOREREACT" => "<input type=\"text\" class=\"text\" name=\"ibdcat_timebeforereact\" value=\"".sed_cc($catinfo['bdcat_timebeforereact']
)."\" size=\"5\" maxlength=\"3\" /> (".$L['bd_default']." ".$state_active.")",
	"EDIT_CAT_FORM_BBCODES" => $edit_cat_form_bbcodes,
	"EDIT_CAT_FORM_SMILIES" => $edit_cat_form_smilies,
	"EDIT_CAT_FORM_MYPFS" => $edit_cat_form_pfs,
	"EDIT_CAT_FORM_SEND" => "plug.php?e=bestdeal&amp;page=editcat&amp;cat=$cat&amp;a=edit",
	"EDIT_CAT_FORM_DELETE" => $edit_cat_form_delete,
	));
?>