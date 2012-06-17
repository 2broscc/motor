<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/printversion/page.php
Version=110
Updated=2006-jun-27
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=printversion
Part=main
File=page
Hooks=page.main
Tags=
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$printver = sed_import('print','G','ALP',24);

require('plugins/printversion/lang/printversion.'.$usr['lang'].'.lang.php');

if ($printver=='page' && (!empty($id) || !empty($al)))
	{

	$tpl_file = "plugins/printversion/tpl/page.tpl";
	$t=new XTemplate ($tpl_file);

	$t->assign(array(
		"PAGE_ID" => $pag['page_id'],
		"PAGE_STATE" => $pag['page_state'],
		"PAGE_EXECUTE" => $pag['page_execute'],
		"PAGE_TITLE" => $pag['page_fulltitle'],
		"PAGE_TITLEURL" => $cfg['mainurl']."/page.php?id=".$id,
		"PAGE_SHORTTITLE" => $pag['page_title'],
		"PAGE_CAT" => $pag['page_cat'],
		"PAGE_CATTITLE" => $sed_cat[$pag['page_cat']]['title'],
		"PAGE_CATPATH" => $catpath,
		"PAGE_CATDESC" => $sed_cat[$pag['page_cat']]['desc'],
		"PAGE_CATICON" => $sed_cat[$pag['page_cat']]['icon'],
		"PAGE_KEY" => $pag['page_key'],
		"PAGE_EXTRA1" => $pag['page_extra1'],
		"PAGE_EXTRA2" => $pag['page_extra2'],
		"PAGE_EXTRA3" => $pag['page_extra3'],
		"PAGE_EXTRA4" => $pag['page_extra4'],
		"PAGE_EXTRA5" => $pag['page_extra5'],
		"PAGE_DESC" => $pag['page_desc'],
		"PAGE_AUTHOR" => $pag['page_author'],
		"PAGE_OWNER" => sed_build_user($pag['page_ownerid'], sed_cc($pag['user_name'])),
		"PAGE_AVATAR" => sed_build_userimage($pag['user_avatar']),
		"PAGE_DATE" => $pag['page_date'],
		"PAGE_BEGIN" => $pag['page_begin'],
		"PAGE_EXPIRE" => $pag['page_expire'],
		"PAGE_COMMENTS" => $comments_link,
		"PAGE_COMMENTS_DISPLAY" => $comments_display,
		"PAGE_RATINGS" => $ratings_link,
		"PAGE_RATINGS_DISPLAY" => $ratings_display
			));

	if($pag['page_totaltabs']>1)
		{
		$t->assign(array(
			"PAGE_MULTI_TABNAV" => $pag['page_tabnav'],
			"PAGE_MULTI_TABTITLES" => $pag['page_tabtitles'],
			"PAGE_MULTI_CURTAB" => $pag['page_tab'],
			"PAGE_MULTI_MAXTAB" => $pag['page_totaltabs']
				));
		$t->parse("MAIN.PAGE_MULTI");
		}

	if ($usr['isadmin'])
		{
		$t-> assign(array(
			"PAGE_ADMIN_COUNT" => $pag['page_count'],
			"PAGE_ADMIN_UNVALIDATE" => "<a href=\"admin.php?m=page&amp;s=queue&amp;a=unvalidate&amp;id=".$pag['page_id']."&amp;".sed_xg()."\">".$L['Putinvalidationqueue']."</a>",
			"PAGE_ADMIN_EDIT" => "<a href=\"page.php?m=edit&amp;id=".$pag['page_id']."&amp;r=list\">".$L['Edit']."</a>"
			));

		$t->parse("MAIN.PAGE_ADMIN");
		}

	
	if (file_exists('plugins/posthide/inc/posthide.functions.php') && strpos($pag['page_text'],'[/hide]')>0)
		{
		require('plugins/posthide/inc/posthide.functions.php');
		$pag['page_text'] = sed_posthide($pag['page_text'], 'ForumQuote', 0, 0, 0, 0, $usr['lang'], '000000');
		}

	switch($pag['page_type'])
		{
		case '1':
		$t->assign("PAGE_TEXT", $pag['page_text']);
		break;

		case '2':

		if ($cfg['allowphp_pages'] && $cfg['allowphp_override'])
			{
			ob_start();
			eval($pag['page_text']);
			$t->assign("PAGE_TEXT", ob_get_clean());
			}
	       else
			{
			$t->assign("PAGE_TEXT", "The PHP mode is disabled for pages.<br />Please see the administration panel, then \"Configuration\", then \"Parsers\".");
			}
		break;

		default:
		$t->assign("PAGE_TEXT",sed_parse(sed_cc($pag['page_text']), $cfg['parsebbcodepages'], $cfg['parsesmiliespages'], 1));
		break;
		}

	if($pag['page_file'])
		{
		if (!empty($pag['page_url']))
			{
			$dotpos = strrpos($pag['page_url'],".")+1;
			$pag['page_fileicon'] = "system/img/pfs/".strtolower(substr($pag['page_url'], $dotpos, 5)).".gif";
			if (!file_exists($pag['page_fileicon']))
				{ $pag['page_fileicon'] = "system/img/admin/page.gif"; }
			$pag['page_fileicon'] = "<img src=\"".$pag['page_fileicon']."\" alt=\"\">";
			}
		else
			{ $pag['page_fileicon'] = ''; }
				
		$t->assign(array(
			"PAGE_FILE_URL" => "page.php?id=".$pag['page_id']."&amp;a=dl",
			"PAGE_FILE_SIZE" => $pag['page_size'],
			"PAGE_FILE_COUNT" => $pag['page_filecount'],
			"PAGE_FILE_ICON" => $pag['page_fileicon']			
				));
		$t->parse("MAIN.PAGE_FILE");
		}

	$t->assign(array (
		"HEADER_TITLE" => $cfg['maintitle']." ".$cfg['separator']." ".$pag['page_title']." :: ".$L['plu_title'],
		));

	$t->parse("MAIN");
	$t->out("MAIN");

	
	/* === Hook === */
	$extp = sed_getextplugins('footer.tags');
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	//sed_sql_close($id);


	exit;
	}

if (empty($id) && !empty($al)) { $id = $pag['page_id']; }




?>