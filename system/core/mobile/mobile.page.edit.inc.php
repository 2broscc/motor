<?PHP

/**
mobile.page.edit.inc.php
*/

defined('SED_CODE') or die('Wrong URL.'); 

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('page', 'any');
sed_block($usr['auth_read']);

$id = sed_import('id','G','INT');
$c = sed_import('c','G','TXT');

if ($a=='update') 	{
	
	sed_check_xg();
	
	$sql1 = sed_sql_query("SELECT page_cat, page_ownerid FROM $db_pages WHERE page_id='$id' LIMIT 1");
	sed_die(sed_sql_numrows($sql1)==0);
	$row1 = sed_sql_fetcharray($sql1);

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('page', $row1['page_cat']);
	sed_block($usr['isadmin']);

	/* === Hook === */
	$extp = sed_getextplugins('page.edit.update.first');
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	$rpagekey = sed_import('rpagekey','P','TXT');
	$rpagealias = sed_import('rpagealias','P','ALP');
	$rpageextra1 = sed_import('rpageextra1','P','TXT');
	$rpageextra2 = sed_import('rpageextra2','P','TXT');
	$rpageextra3 = sed_import('rpageextra3','P','TXT');
	$rpageextra4 = sed_import('rpageextra4','P','TXT');
	$rpageextra6 = sed_import('rpageextra6','P','TXT');
	$rpageextra7 = sed_import('rpageextra7','P','TXT');
	$rpageextra5 = sed_import('rpageextra5','P','HTM');
	$rpagetype = sed_import('rpagetype','P','INT');
	$rpagetitle = sed_import('rpagetitle','P','TXT');
	$rpagedesc = sed_import('rpagedesc','P','TXT');
	$rpagetext = sed_import('rpagetext','P','HTM');
	$rpagetext2 = sed_import('rpagetext2','P','HTM');
	$rpageauthor = sed_import('rpageauthor','P','TXT');
	$rpageownerid = sed_import('rpageownerid','P','INT');
	$rpagefile = sed_import('rpagefile','P','TXT');
	$rpageurl = sed_import('rpageurl','P','TXT');
	$rpagesize = sed_import('rpagesize','P','TXT');
	$rpagecount = sed_import('rpagecount','P','INT');
	$rpagefilecount = sed_import('rpagefilecount','P','INT');
	$rpagecat = sed_import('rpagecat','P','TXT');
	$rpagedatenow = sed_import('rpagedatenow','P','BOL');

	$ryear = sed_import('ryear','P','INT');
	$rmonth = sed_import('rmonth','P','INT');
	$rday = sed_import('rday','P','INT');
	$rhour = sed_import('rhour','P','INT');
	$rminute = sed_import('rminute','P','INT');

	$ryear_beg = sed_import('ryear_beg','P','INT');
	$rmonth_beg = sed_import('rmonth_beg','P','INT');
	$rday_beg = sed_import('rday_beg','P','INT');
	$rhour_beg = sed_import('rhour_beg','P','INT');
	$rminute_beg = sed_import('rminute_beg','P','INT');

	$ryear_exp = sed_import('ryear_exp','P','INT');
	$rmonth_exp = sed_import('rmonth_exp','P','INT');
	$rday_exp = sed_import('rday_exp','P','INT');
	$rhour_exp = sed_import('rhour_exp','P','INT');
	$rminute_exp = sed_import('rminute_exp','P','INT');

	$rpagedelete = sed_import('rpagedelete','P','BOL');

	$error_string .= (empty($rpagecat)) ? $L['pag_catmissing']."<br />" : '';
	$error_string .= (mb_strlen($rpagetitle)<2) ? $L['pag_titletooshort']."<br />" : '';

	if (empty($error_string) || $rpagedelete) {
		
		if ($rpagedelete) 	{
			$sql = sed_sql_query("SELECT * FROM $db_pages WHERE page_id='$id' LIMIT 1");

			if ($row = sed_sql_fetchassoc($sql))
				{
				if ($cfg['trash_page'])
					{ sed_trash_put('page', $L['Page']." #".$id." ".$row['page_title'], $id, $row); }

				$id2 = "p".$id;
				$sql = sed_sql_query("DELETE FROM $db_pages WHERE page_id='$id'");
				$sql = sed_sql_query("DELETE FROM $db_ratings WHERE rating_code='$id2'");
				$sql = sed_sql_query("DELETE FROM $db_rated WHERE rated_code='$id2'");
				$sql = sed_sql_query("DELETE FROM $db_com WHERE com_code='$id2'");
				sed_log("Deleted page #".$id,'adm');
				header("Location: list.php?c=".$row1['page_cat']);
				exit;
				}
			}
		else {
			$rpagedate = ($rpagedatenow) ? $sys['now_offset'] : sed_mktime($rhour, $rminute, 0, $rmonth, $rday, $ryear) - $usr['timezone'] * 3600;
			$rpagebegin = sed_mktime($rhour_beg, $rminute_beg, 0, $rmonth_beg, $rday_beg, $ryear_beg) - $usr['timezone'] * 3600;
			$rpageexpire = sed_mktime($rhour_exp, $rminute_exp, 0, $rmonth_exp, $rday_exp, $ryear_exp) - $usr['timezone'] * 3600;
			$rpageexpire = ($rpageexpire<=$rpagebegin) ? $rpagebegin+31536000 : $rpageexpire;

			$rpagetype = ($usr['maingrp']!=5 && $rpagetype==2) ? 0 : $rpagetype;

			if (!empty($rpagealias)) 	{
				$sql = sed_sql_query("SELECT page_id FROM $db_pages WHERE page_alias='".sed_sql_prep($rpagealias)."' AND page_id!='".$id."'");
				$rpagealias = (sed_sql_numrows($sql)>0) ? "alias".rand(1000,9999) : $rpagealias;
				}

			$sql = sed_sql_query("UPDATE $db_pages SET
				page_cat = '".sed_sql_prep($rpagecat)."',
				page_type = '".sed_sql_prep($rpagetype)."',
				page_key = '".sed_sql_prep($rpagekey)."',
				page_extra1 = '".sed_sql_prep($rpageextra1)."',
				page_extra2 = '".sed_sql_prep($rpageextra2)."',
				page_extra3 = '".sed_sql_prep($rpageextra3)."',
				page_extra4 = '".sed_sql_prep($rpageextra4)."',
				page_extra5 = '".sed_sql_prep($rpageextra5)."',
				page_extra6 = '".sed_sql_prep($rpageextra6)."',
				page_extra7 = '".sed_sql_prep($rpageextra7)."',
				page_title = '".sed_sql_prep($rpagetitle)."',
				page_desc = '".sed_sql_prep($rpagedesc)."',
				page_text='".sed_sql_prep($rpagetext)."',
				page_text2='".sed_sql_prep($rpagetext2)."',
				page_author = '".sed_sql_prep($rpageauthor)."',
				page_ownerid = '$rpageownerid',
				page_date = '$rpagedate',
				page_begin = '$rpagebegin',
				page_expire = '$rpageexpire',
				page_file = '".sed_sql_prep($rpagefile)."',
				page_url = '".sed_sql_prep($rpageurl)."',
				page_size = '".sed_sql_prep($rpagesize)."',
				page_count = '$rpagecount',
				page_filecount = '$rpagefilecount',
				page_alias = '".sed_sql_prep($rpagealias)."'
				WHERE page_id='$id'");

			/* === Hook === */
			$extp = sed_getextplugins('page.edit.update.done');
			if (is_array($extp))
				{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
			/* ===== */

			sed_log("Edited page #".$id,'adm');
			header("Location: page.php?id=".$id);
			exit;
			}
		}
	}

$sql = sed_sql_query("SELECT * FROM $db_pages WHERE page_id='$id' LIMIT 1");
sed_die(sed_sql_numrows($sql)==0);
$pag = sed_sql_fetcharray($sql);

$pag['page_date'] = sed_selectbox_date($pag['page_date'] + $usr['timezone'] * 3600,'long');
$pag['page_begin'] = sed_selectbox_date($pag['page_begin'] + $usr['timezone'] * 3600, 'long', '_beg');
$pag['page_expire'] = sed_selectbox_date($pag['page_expire'] + $usr['timezone'] * 3600, 'long', '_exp');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('page', $pag['page_cat']);
sed_block($usr['isadmin']);

/* === Hook === */
$extp = sed_getextplugins('page.edit.first');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$page_form_delete = "<input type=\"radio\" class=\"radio\" name=\"rpagedelete\" value=\"1\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"rpagedelete\" value=\"0\" checked=\"checked\" />".$L['No'];
$page_form_categories = sed_selectbox_categories($pag['page_cat'], 'rpagecat');

$page_form_type = "<select name=\"rpagetype\" size=\"1\">";
$selected0 = ($pag['page_type']==0) ? "selected=\"selected\"" : '';
$selected1 = ($pag['page_type']==1) ? "selected=\"selected\"" : '';
$selected2 = ($pag['page_type']==2 && $usr['maingrp']==5) ? "selected=\"selected\"" : '';
$page_form_type .= "<option value=\"0\" $selected0>".$L['Default']."</option>";
$page_form_type .= "<option value=\"1\" $selected1>HTML</option>";
$page_form_type .= ($usr['maingrp']==5 && $cfg['allowphp_pages'] && $cfg['allowphp_override']) ? "<option value=\"2\" $selected2>PHP</option>" : '';
$page_form_type .= "</select>";

if ($pag['page_file'])
	{ $page_form_file = "<input type=\"radio\" class=\"radio\" name=\"rpagefile\" value=\"1\" checked=\"checked\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"rpagefile\" value=\"0\" />".$L['No']; }
	else
	{ $page_form_file = "<input type=\"radio\" class=\"radio\" name=\"rpagefile\" value=\"1\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"rpagefile\" value=\"0\" checked=\"checked\" />".$L['No']; }

$bbcodes = ($cfg['parsebbcodepages']) ? sed_build_bbcodes('update', 'rpagetext', $L['BBcodes']) : '';
$smilies = ($cfg['parsesmiliespages']) ? sed_build_smilies('update', 'rpagetext', $L['Smilies']) : '';
$pfs = sed_build_pfs($usr['id'], 'update', 'rpagetext', $L['Mypfs']);
//page_desc
$pfs_desc = sed_build_pfs($usr['id'], 'update', 'rpagedesc', $L['Mypfs']);

$pfs .= (sed_auth('pfs', 'a', 'A')) ? " &nbsp; ".sed_build_pfs(0, 'update', 'rpagetext', $L['SFS']) : '';
$pfs_form_url_myfiles = (!$cfg['disable_pfs']) ? sed_build_pfs($usr['id'], "update", "rpageurl", $L['Mypfs']) : '';
$pfs_form_url_myfiles .= (sed_auth('pfs', 'a', 'A')) ? ' '.sed_build_pfs(0, 'update', 'rpageurl', $L['SFS']) : '';

$sys['sublocation'] = $sed_cat[$c]['title'];

/* === Hook === */
$extp = sed_getextplugins('page.edit.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

//require("system/header.php");


$mskin = "$user_skin_dir/".$skin."/mobile/page.edit.tpl"; 

$t = new XTemplate($mskin);

if (!empty($error_string))
	{
	$t->assign("PAGEEDIT_ERROR_BODY",$error_string);
	$t->parse("MAIN.PAGEEDIT_ERROR");
	}

$t->assign(array(
	"PAGEEDIT_PAGETITLE" => $L['paged_title'],
	"PAGEEDIT_SUBTITLE" => $L['paged_subtitle'],
	"PAGEEDIT_FORM_SEND" => "page.php?m=edit&amp;a=update&amp;id=".$pag['page_id']."&amp;r=".$r."&amp;".sed_xg(),
	"PAGEEDIT_FORM_ID" => $pag['page_id'],
	"PAGEEDIT_FORM_STATE" => $pag['page_state'],
	"PAGEEDIT_FORM_TYPE" => $page_form_type,
	"PAGEEDIT_FORM_CAT" => $page_form_categories,
	"PAGEEDIT_FORM_KEY" => "<input class=\"skinned\" type=\"text\"  name=\"rpagekey\" value=\"".sed_cc($pag['page_key'])."\" size=\"16\" maxlength=\"16\" />",
	"PAGEEDIT_FORM_ALIAS" => "<input class=\"skinned\" type=\"text\"  name=\"rpagealias\" value=\"".sed_cc($pag['page_alias'])."\" size=\"16\" maxlength=\"24\" />",
	"PAGEEDIT_FORM_EXTRA1" => "<input class=\"skinned\" type=\"text\"  name=\"rpageextra1\" value=\"".sed_cc($pag['page_extra1'])."\" size=\"56\" maxlength=\"255\" />",
	"PAGEEDIT_FORM_EXTRA2" => "<input class=\"skinned\" type=\"text\"  name=\"rpageextra2\" value=\"".sed_cc($pag['page_extra2'])."\" size=\"56\" maxlength=\"255\" />",
	"PAGEEDIT_FORM_EXTRA3" => "<input  class=\"skinned\"type=\"text\"  name=\"rpageextra3\" value=\"".sed_cc($pag['page_extra3'])."\" size=\"56\" maxlength=\"255\" />",
	"PAGEEDIT_FORM_EXTRA4" => "<input class=\"skinned\" type=\"text\"  name=\"rpageextra4\" value=\"".sed_cc($pag['page_extra4'])."\" size=\"56\" maxlength=\"255\" />",
	"PAGEEDIT_FORM_EXTRA5" => "<input class=\"skinned\" type=\"text\"  name=\"rpageextra5\" value=\"".sed_cc($pag['page_extra5'])."\" size=\"56\" maxlength=\"255\" />",
	
	//for img_s
	"PAGEEDIT_FORM_EXTRA6" => "<input class=\"skinned\" type=\"text\"  name=\"rpageextra6\" value=\"".sed_cc($pag['page_extra6'])."\" size=\"56\" maxlength=\"255\" />",
	
	"PAGEEDIT_FORM_EXTRA7" => "<input class=\"skinned\" type=\"text\"  name=\"rpageextra7\" value=\"".sed_cc($pag['page_extra7'])."\" size=\"56\" maxlength=\"255\" />",
	
	
	"PAGEEDIT_FORM_TITLE" => "<input class=\"skinned\" type=\"text\"  name=\"rpagetitle\" value=\"".sed_cc($pag['page_title'])."\" size=\"56\" maxlength=\"255\" />",
	"PAGEEDIT_FORM_DESC" => "<input class=\"skinned\" type=\"text\"  name=\"rpagedesc\" value=\"".sed_cc($pag['page_desc'])."\" size=\"56\" maxlength=\"255\" />",
	"PAGEEDIT_FORM_AUTHOR" => "<input class=\"skinned\" type=\"text\"  name=\"rpageauthor\" value=\"".sed_cc($pag['page_author'])."\" size=\"32\" maxlength=\"24\" />",
	"PAGEEDIT_FORM_OWNERID" => "<input class=\"skinned\" type=\"text\"  name=\"rpageownerid\" value=\"".sed_cc($pag['page_ownerid'])."\" size=\"32\" maxlength=\"24\" />",
	"PAGEEDIT_FORM_DATE" => $pag['page_date']." ".$usr['timetext'],
	"PAGEEDIT_FORM_DATENOW" => "<input class=\"skinned\" type=\"checkbox\" class=\"checkbox\" name=\"rpagedatenow\" value=\"1\" />",
	"PAGEEDIT_FORM_BEGIN" => $pag['page_begin']." ".$usr['timetext'],
	"PAGEEDIT_FORM_EXPIRE" => $pag['page_expire']." ".$usr['timetext'],
	"PAGEEDIT_FORM_FILE" => $page_form_file,
	"PAGEEDIT_FORM_URL" => "<input class=\"skinned\" type=\"text\"  name=\"rpageurl\" value=\"".sed_cc($pag['page_url'])."\" size=\"56\" maxlength=\"255\" /> ".$pfs_form_url_myfiles,
	"PAGEEDIT_FORM_SIZE" => "<input class=\"skinned\" type=\"text\"  name=\"rpagesize\" value=\"".sed_cc($pag['page_size'])."\" size=\"56\" maxlength=\"255\" />",
	"PAGEEDIT_FORM_PAGECOUNT" => "<input class=\"skinned\" type=\"text\"  name=\"rpagecount\" value=\"".$pag['page_count']."\" size=\"8\" maxlength=\"8\" />",
	"PAGEEDIT_FORM_FILECOUNT" => "<input class=\"skinned\" type=\"text\"  name=\"rpagefilecount\" value=\"".$pag['page_filecount']."\" size=\"8\" maxlength=\"8\" />",
	"PAGEEDIT_FORM_TEXT" => "<textarea  name=\"rpagetext\" rows=\"24\" cols=\"56\">".sed_cc($pag['page_text'])."</textarea><br />".$bbcodes." ".$smilies." ".$pfs,
	"PAGEEDIT_FORM_TEXT2" => "<textarea  name=\"rpagetext2\" rows=\"12\" cols=\"56\">".sed_cc($pag['page_text2'])."</textarea>",
	"PAGEEDIT_FORM_TEXTBOXER" => "<textarea  name=\"rpagetext\" rows=\"24\" cols=\"56\">".sed_cc($pag['page_text'])."</textarea><br />".$bbcodes." ".$smilies." ".$pfs,
	"PAGEEDIT_FORM_BBCODES" => $bbcodes,
	"PAGEEDIT_FORM_SMILIES" => $smilies,
	"PAGEEDIT_FORM_MYPFS" => $pfs,
	"PAGEEDIT_FORM_DELETE" => $page_form_delete,
	"PAGEEDIT_FORM_MYPFS_DESC" => $pfs_desc
		));

/* === Hook === */
$extp = sed_getextplugins('page.edit.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$t->parse("MAIN");
$t->out("MAIN");

//require("system/footer.php");

?>