<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/news/news.php
Version=1.5
Updated=19-Sep-2006
Type=Plugin
Author=Neocrome advanced by Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=news
Part=homepage
File=news
Hooks=index.tags
Tags=index.tpl:{INDEX_NEWS}
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$d = sed_import('d','G','INT');
$c = sed_import('c','G','TXT');
$id = sed_import('id','G','INT');
$al = sed_import('al','G','ALP');

if (empty($d))	{ $d = '0'; }
if (empty($c))	
	{ 
		$c = $cfg['plugin']['news']['category']; 
	}
else
	{		
		$checkin = strpos($sed_cat[$c]['path'], $sed_cat[$cfg['plugin']['news']['category']]['path']);
		$c = ($checkin === false) ? $cfg['plugin']['news']['category'] :  $c ;
	}

$jj = 0;
$mtch = $sed_cat[$c]['path'].".";
$mtchlen = strlen($mtch);
$catsub = array();
$catsub[] = $c;

foreach($sed_cat as $i => $x)
	{
	if (substr($x['path'], 0, $mtchlen)==$mtch && sed_auth('page', $i, 'R'))
		{ $catsub[] = $i; }
	}

switch($m)
{
case 'single':
	if (!empty($al))
		{ $sql = sed_sql_query("SELECT p.*, u.user_name, user_avatar FROM $db_pages AS p
			LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid WHERE page_alias='$al'  
			AND page_cat IN ('".implode("','", $catsub)."')");}
	else
		{ $sql = sed_sql_query("SELECT p.*, u.user_name, user_avatar FROM $db_pages AS p
			LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid WHERE page_id='$id' 
			AND page_cat IN ('".implode("','", $catsub)."')");}

	sed_die(sed_sql_numrows($sql)==0);
	$out['viewmode'] = "<a href=\"index.php\">".$L['Expand']."</a> / <a href=\"index.php?m=headlines\">".$L['Headlines']."</a>";
break;

case 'headlines':
	if ($cfg['plugin']['news']['maxheadlines']>0)
		{
			$sql = sed_sql_query("SELECT page_id, page_cat, page_title , page_date FROM $db_pages AS p
			WHERE page_state=0 AND page_cat NOT LIKE 'system' AND page_cat IN ('".implode("','", $catsub)."') 
			ORDER BY page_".$sed_cat[$c]['order']." ".$sed_cat[$c]['way']." LIMIT $d,".$cfg['plugin']['news']['maxheadlines']);

			$sql2 = sed_sql_query("SELECT COUNT(*) FROM $db_pages WHERE page_state=0 AND page_cat 
			NOT LIKE 'system' AND page_cat IN ('".implode("','", $catsub)."')");
			$totalnews = sed_sql_result($sql2,0,"COUNT(*)");

			$perpage = $cfg['plugin']['news']['maxheadlines'];
			$totalitems = $totalnews;
			$address = "index.php?m=headlines&amp;d=";
			$pagenumber = $d;
	
			if($cfg['plugin']['news']['pagenav']=='Sedplus' && is_array($cfg['plugin']['sedplus'])){
				require_once("plugins/sedplus/inc/sedplus.functions.php");
				$pagnav = t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber);
			}
			else
			{
				require_once("plugins/news/inc/functions.php");
				$pagnav = sed_default_pagination($totalitems, $perpage, $address, $pagenumber);
			}
			$out['viewmode'] = "<a href=\"index.php\">".$L['Expand']."</a>";
		}
break;

default:

	if ($cfg['plugin']['news']['maxpages']>0 && !empty($c))
		{
			$sql = sed_sql_query("SELECT p.*, u.user_name, user_avatar FROM $db_pages AS p
			LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
			WHERE page_state=0 AND page_cat NOT LIKE 'system'
			AND page_cat IN ('".implode("','", $catsub)."') ORDER BY 
			page_".$sed_cat[$c]['order']." ".$sed_cat[$c]['way']." LIMIT $d,".$cfg['plugin']['news']['maxpages']);

			$sql2 = sed_sql_query("SELECT COUNT(*) FROM $db_pages WHERE page_state=0 AND page_cat 
			NOT LIKE 'system' AND page_cat IN ('".implode("','", $catsub)."')");
			$totalnews = sed_sql_result($sql2,0,"COUNT(*)");

			$perpage = $cfg['plugin']['news']['maxpages'];
			$totalitems = $totalnews;
			$address = "index.php?c=$c&amp;d=";
			$pagenumber = $d;
	
			if($cfg['plugin']['news']['pagenav']=='Sedplus' && is_array($cfg['plugin']['sedplus'])){
				require_once("plugins/sedplus/inc/sedplus.functions.php");
				$pagnav = t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber);
			}
			else
			{
				require_once("plugins/news/inc/functions.php");
				$pagnav = sed_default_pagination($totalitems, $perpage, $address, $pagenumber);
			}
		$out['viewmode'] = "<a href=\"index.php?m=headlines\">".$L['Headlines']."</a>";
		}
break;
}

$news = new XTemplate(sed_skinfile('news'));
if($cfg['plugin']['news']['maxpages']>0 && $cfg['plugin']['news']['maxheadlines']>0 && !empty($c)){
	while ($pag = sed_sql_fetcharray($sql))
		{
		$jj++;
		$catpath = sed_build_catpath($pag['page_cat'], "<a href=\"list.php?c=%1\$s\">%2\$s</a>");
		$catpath_idx = sed_build_catpath($pag['page_cat'], "<a href=\"index.php?c=%1\$s\">%2\$s</a>");
		$pag['page_desc'] = sed_cc($pag['page_desc']);
		$pag['page_pageurl'] = (empty($pag['page_alias'])) ? "page.php?id=".$pag['page_id'] : "page.php?al=".$pag['page_alias'];
		$pag['page_pageurl_idx'] = (empty($pag['page_alias'])) ? "page.php?id=".$pag['page_id'] : "index.php?m=single&amp;al=".$pag['page_alias'];
		
		$pag['page_fulltitle'] = $catpath." ".$cfg['separator']." <a href=\"".$pag['page_pageurl']."\">".$pag['page_title']."</a>";
		if(sed_auth('page', $pag['page_cat'], 'A')){
			$pag['admin'] = "<a href=\"admin.php?m=page&amp;s=queue&amp;a=unvalidate&amp;id=".$pag['page_id']."&amp;";
			$pag['admin'] .= sed_xg()."\">".$L['Putinvalidationqueue']."</a>";
			$pag['admin'] .= "&nbsp;<a href=\"page.php?m=edit&amp;id=".$pag['page_id']."&amp;r=index\">".$L['Edit']."</a> ";	
		}
	
		$item_code = 'p'.$pag['page_id'];
		if($cfg['plugin']['news']['newscomments'] && $m!=='headlines')
		{
			list($pag['page_comments'], $pag['page_comments_display'])=sed_build_comments($item_code, $pag['page_pageurl'], FALSE);	
		}
		if($cfg['plugin']['news']['newsratings'] && $m!=='headlines')
		{
			list($pag['page_ratings'], $pag['page_ratings_display'])=sed_build_ratings($item_code, $pag['page_pageurl'], FALSE);	
		}
		$news-> assign(array(
			"PAGE_ROW_URL" => $pag['page_pageurl'],
			"PAGE_ROW_URL_IDX" => $pag['page_pageurl_idx'],
			"PAGE_ROW_ID" => $pag['page_id'],
			"PAGE_ROW_TITLE" => $pag['page_fulltitle'],
			"PAGE_ROW_SHORTTITLE" => $pag['page_title'],
			"PAGE_ROW_CAT" => $pag['page_cat'],
			"PAGE_ROW_CATTITLE" => $sed_cat[$pag['page_cat']]['title'],
			"PAGE_ROW_CATPATH" => $catpath,
			"PAGE_ROW_CATPATH_IDX" => $catpath_idx,
			"PAGE_ROW_DATE" => @date($cfg['formatyearmonthday'], $pag['page_date'] + $usr['timezone'] * 3600),
			"PAGE_ROW_ODDEVEN" => sed_build_oddeven($jj)
			));
			
		if($m!=='headlines'){
			$news-> assign(array(
				"PAGE_ROW_CATDESC" => $sed_cat[$pag['page_cat']]['desc'],
				"PAGE_ROW_CATICON" => $sed_cat[$pag['page_cat']]['icon'],
				"PAGE_ROW_KEY" => sed_cc($pag['page_key']),
				"PAGE_ROW_EXTRA1" => sed_cc($pag['page_extra1']),
				"PAGE_ROW_EXTRA2" => sed_cc($pag['page_extra2']),
				"PAGE_ROW_EXTRA3" => sed_cc($pag['page_extra3']),
				"PAGE_ROW_EXTRA4" => sed_cc($pag['page_extra4']),
				"PAGE_ROW_EXTRA5" => sed_cc($pag['page_extra5']),
				"PAGE_ROW_DESC" => $pag['page_desc'],
				"PAGE_ROW_AUTHOR" => sed_cc($pag['page_author']),
				"PAGE_ROW_OWNER" => sed_build_user($pag['page_ownerid'], sed_cc($pag['user_name'])),
				"PAGE_ROW_AVATAR" => sed_build_userimage($pag['user_avatar']),			
				"PAGE_ROW_FILEURL" => $pag['page_url'],
				"PAGE_ROW_SIZE" => $pag['page_size'],
				"PAGE_ROW_COUNT" => $pag['page_count'],
				"PAGE_ROW_FILECOUNT" => $pag['page_filecount'],
				"PAGE_ROW_COMMENTS" => $pag['page_comments'],
				"PAGE_ROW_RATINGS" => $pag['page_ratings'],
				"PAGE_ROW_ADMIN" => $pag['admin']
					));	
				
			switch($pag['page_type'])
				{
				case '1':
				$news->assign("PAGE_ROW_TEXT", $pag['page_text']);
				break;

				case '2':
		
				if ($cfg['allowphp_pages'])
				{
					ob_start();
					eval($pag['page_text']);
					$news->assign("PAGE_ROW_TEXT", ob_get_clean());
				}
	    	 	else
				{
					$news->assign("PAGE_ROW_TEXT", "The PHP mode is disabled for pages.<br />Please see the administration panel, then \"Configuration\", then \"Parsers\".");
				}
				break;

				default:
				$readmore = strpos($pag['page_text'], "[more]");
				if ($readmore>0 && $m!=='single')
					{
					$pag['page_text'] = substr($pag['page_text'], 0, $readmore)."<br />";
					$pag['page_text'] .= "<a href=\"".$pag['page_pageurl_idx']."\">".$L['ReadMore']."</a>";
					}		
				$news->assign("PAGE_ROW_TEXT", sed_parse($pag['page_text'], $cfg['parsebbcodepages'], $cfg['parsesmiliespages'], 1));
				break;
				}
			}
		$m=='headlines' ?  $news->parse("NEWS.HEADLINES_ROW") :  $news->parse("NEWS.PAGE_ROW");	
	}
	$m=='single' ?  '' :  $news->assign("NEWS_INDEX_PAGENAV", $pagnav);
	
	
	
	$submitnewpage = (sed_auth('page', $c, 'W')) ? "<a href=\"page.php?m=add&amp;c=$c\">".$L['lis_submitnew']."</a>" : '';	
	$news-> assign(array(
		"NEWS_SUBMITNEWPOST" => $submitnewpage,
		"NEWS_HEADLINESTOGGLE" => $out['viewmode'],
		));	
	$news->parse("NEWS");	
	$t->assign("INDEX_NEWS", $news->text("NEWS"));
	
}
?>
