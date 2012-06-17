<?php

		
		
// ============== 1 ===========/ Get info from mysql /================ 1==============//

if(empty($cat))
		{
		$cat=0;
		}
		else
		{
			$sql_getcat = sed_sql_query("SELECT bdcat_id,bdcat_name,bdcat_fmode,bdcat_level FROM sed_bestdeal_cat WHERE bdcat_id='$cat'");
		$catinfo = sed_sql_fetcharray($sql_getcat);
		}
		
		$ibdcat_level = 1;
		$ibdcat_timebeforereact = $state_active; 
		if ($action=='add')
		{		
		
		$ibdcat_headcat = $cat;
		$ibdcat_name = sed_import('ibdcat_name','P','TXT');
		$ibdcat_shortdesc = sed_import('ibdcat_shortdesc','P','TXT');
		$ibdcat_level = sed_import('ibdcat_level','P','INT');
		$ibdcat_fmode = sed_import('ibdcat_fmode','P','INT');
		$ibdcat_timebeforereact = sed_import('ibdcat_timebeforereact','P','INT');
		
		// ============ 3 ============ / sql insert / =========== 3 ========= //
		
		$error_string .= (strlen($ibdcat_name)<5) ? $L['bd_nametoshort']."<br />" : '';
		$error_string .= (strlen($ibdcat_level)==0) ? $L['bd_nolevel']."<br />" : '';
		
			if (empty($error_string))
			{
			
			$sql = sed_sql_query("INSERT into sed_bestdeal_cat
			(bdcat_headcat
			,bdcat_name
			,bdcat_shortdesc
			,bdcat_level
			,bdcat_fmode
			,bdcat_timebeforereact
			)
			VALUES
			('".$ibdcat_headcat."'
			,'".sed_sql_prep($ibdcat_name)."'
			,'".sed_sql_prep($ibdcat_shortdesc)."'
			,'".$ibdcat_level."'
			,'".$ibdcat_fmode."'
			,'".$ibdcat_timebeforereact."'
			)");
			
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

		$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.addcat.tpl";
		$path_skin_path	= "skins/$skin/extplugin.bestdeal.addcat.tpl";	
		
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
		
		
		
		$add_cat_form_bbcodes = ($cfg['plugin']['bestdeal']['parsebbcode']) ? sed_build_bbcodes('add_cat', 'ibdcat_shortdesc',$L['BBcodes']) : '';
		$add_cat_form_smilies = ($cfg['plugin']['bestdeal']['parsesmilies']) ? sed_build_smilies('add_cat', 'ibdcat_shortdesc',$L['Smilies']) : '';
		$add_cat_form_pfs = sed_build_pfs($usr['id'], 'add_cat', 'ibdcat_shortdesc', $L['Mypfs']);
		$add_cat_form_pfs .= (sed_auth('pfs', 'a', 'A')) ? " &nbsp; ".sed_build_pfs(0, 'add_item', 'ibdcat_shortdesc', $L['SFS']) : '';
		
		
		
		$add_cat_form_shortdesc = sed_textboxer2('ibdcat_shortdesc', 'add_cat', sed_cc($ibdcat_shortdesc), $tb2TextareaRows, $tb2TextareaCols, 'XXXXXXXXXXXXXXXXXXXX', $tb2ParseBBcodes, $tb2ParseSmilies, $tb2ParseBR, $tb2Buttons, $tb2DropdownIcons, $tb2MaxSmilieDropdownHeight, $tb2InitialSmilieLimit).$pfs;
	
		// ================ 2============ / End  Make template ==================== 2=========
	
	$add_cat_form_fmode = "<input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"0\" checked=\"checked\" /> ".$L['bd_optionclosed']." <input DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"1\" /> ".$L['bd_optionwebshop']." <input  DISABLED type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"2\"/> ".$L['bd_optionanimocheck']." <input type=\"radio\" class=\"radio\" name=\"ibdcat_fmode\" value=\"3\" /> ".$L['bd_optionpublicmarket']." ";

	// ============TAGS===========/ Everyone/===========TAGS==============================
	
		if (!empty($error_string))
	{
	$t->assign("ADD_CAT_ERROR_BODY",$error_string);
	$t->parse("MAIN.ADDCAT_ERROR");
	}
	
	$t->assign(array(
	"ADD_CAT_FORM_TITLE" => ($cat==0 )? $L['bd_headcategorie'] : $catinfo['bdcat_name'],
	"ADD_CAT_FORM_HEADCAT" => ($cat==0 )? "0 (".$L['bd_headcategorie'].")" : $cat." ".$catinfo['bdcat_name'],
	"ADD_CAT_FORM_NAME" => "<input type=\"text\" class=\"text\" name=\"ibdcat_name\" value=\"".sed_cc($ibdcat_name)."\" size=\"56\" maxlength=\"50\" />",
	"ADD_CAT_FORM_SHORTDESC" => $add_cat_form_shortdesc,
	"ADD_CAT_FORM_LEVEL" => "<input type=\"text\" class=\"text\" name=\"ibdcat_level\" value=\"".sed_cc($ibdcat_level)."\" size=\"5\" maxlength=\"2\" />",
	"ADD_CAT_FORM_FMODE" => $add_cat_form_fmode,
	"ADD_CAT_FORM_TIMEBEFOREREACT" => "<input type=\"text\" class=\"text\" name=\"ibdcat_timebeforereact\" value=\"".sed_cc($ibdcat_timebeforereact)."\" size=\"5\" maxlength=\"3\" /> (".$L['bd_default']." ".$state_active.")",
	"ADD_CAT_FORM_BBCODES" => $add_cat_form_bbcodes,
	"ADD_CAT_FORM_SMILIES" => $add_cat_form_smilies,
	"ADD_CAT_FORM_MYPFS" => $add_cat_form_pfs,
	"ADD_CAT_FORM_SEND" => "plug.php?e=bestdeal&amp;page=addcat&amp;cat=$cat&amp;a=add",
	));
    
?>