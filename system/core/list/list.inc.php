<?PHP

/*

Filename: list.inc.php
CMS Framework based on Seditio v121 www.neocrome.net
Re-programmed by 2bros cc
Date:02-02-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com

This file has been added by 2bros cc

*/


if (!defined('SED_CODE')) { die('Wrong URL.'); }

$id = sed_import('id','G','INT');
$s = sed_import('s','G','ALP');
$w = sed_import('w','G','ALP');
$d = sed_import('d','G','INT');
$c = sed_import('c','G','TXT');
$o = sed_import('o','G','ALP');
$p = sed_import('p','G','ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('page', $c);
sed_block($usr['auth_read']);

/* === Hook === */
$extp = sed_getextplugins('list.first');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

if (empty($s))
	{
	$s = $sed_cat[$c]['order'];
	$w = $sed_cat[$c]['way'];
	}

if (empty($s)) { $s = 'title'; }
if (empty($w)) { $w = 'asc'; }
if (empty($d)) { $d = '0'; }

$item_code = 'list_'.$c;
$join_ratings_columns = ($cfg['disable_ratings']) ? '' : ", r.rating_average";
$join_ratings_condition = ($cfg['disable_ratings']) ? '' : "LEFT JOIN $db_ratings as r ON r.rating_code=CONCAT('p',p.page_id)";

if ($c=='system' && !$usr['isadmin'])
	{
	sed_log("System pages for administrators only", 'sec');
	header("Location: message.php?msg=904");
	exit;
	}
elseif ($c=='all' && $usr['isadmin'])
	{
	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pages WHERE page_state='0'");
	$totallines = sed_sql_result($sql, 0, "COUNT(*)");
	$sql = sed_sql_query("SELECT p.*, u.user_name ".$join_ratings_columns."
		FROM $db_pages as p ".$join_ratings_condition."
		LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
		WHERE page_state='0'
		ORDER BY page_$s $w LIMIT $d,".$cfg['maxrowsperpage']);
	}
elseif (!empty($o) && !empty($p) && $p!='password')
	{
	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pages WHERE page_cat='$c' AND (page_state='0' OR page_state='2') AND page_$o='$p'");
	$totallines = sed_sql_result($sql, 0, "COUNT(*)");
	$sql = sed_sql_query("SELECT p.*, u.user_name ".$join_ratings_columns."
		FROM $db_pages as p ".$join_ratings_condition."
		LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
		WHERE page_cat='$c' AND (page_state='0' OR page_state='2') AND page_$o='$p'
		ORDER BY page_$s $w LIMIT $d,".$cfg['maxrowsperpage']);
	}
else
	{
	sed_die(empty($sed_cat[$c]['title']) && !$usr['isadmin']);
	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pages WHERE page_cat='$c' AND (page_state='0' OR page_state='2') ");
	$totallines = sed_sql_result($sql, 0, "COUNT(*)");
	$sql = sed_sql_query("SELECT p.*, u.user_name ".$join_ratings_columns."
		FROM $db_pages as p ".$join_ratings_condition."
		LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
		WHERE page_cat='$c' AND (page_state='0' OR page_state='2')
		ORDER BY page_$s $w LIMIT $d,".$cfg['maxrowsperpage']);
	}

$totalpages = ceil($totallines / $cfg['maxrowsperpage']);
$currentpage= ceil ($d / $cfg['maxrowsperpage'])+1;
$submitnewpage = ($usr['auth_write'] && $c!='all') ? "<a href=\"page.php?m=add&amp;c=".$c."\" >".$L['lis_submitnew']."</a>" : '';
$incl="datas/content/list.$c.txt";

if (@file_exists($incl))
	{
	$fd = @fopen ($incl, "r");
	$extratext = fread ($fd, filesize ($incl));
	fclose ($fd);
	}

if ($c=='all' || $c=='system')
	{ $catpath = $sed_cat[$c]['title']; }
else
	{ $catpath = sed_build_catpath($c, "<a href=\"list.php?c=%1\$s\">%2\$s</a>"); }

unset($pageprev, $pagenext);

if ($d>0)
	{
	$prevpage = $d - $cfg['maxrowsperpage'];
	if ($prevpage < 0)
		{ $prevpage=0; }
	$pageprev = "<a href=\"list.php?c=$c&amp;s=$s&amp;w=$w&amp;o=$o&amp;p=$p&amp;d=$prevpage\">".$L['Previous']." $sed_img_left</a>";
	}

if (($d + $cfg['maxrowsperpage']) < $totallines)
	{
	$nextpage = $d + $cfg['maxrowsperpage'];
	$pagenext = "<a href=\"list.php?c=$c&amp;s=$s&amp;w=$w&amp;o=$o&amp;p=$p&amp;d=$nextpage\">$sed_img_right ".$L['Next']."</a>";
	}

list($list_comments, $list_comments_display) = sed_build_comments($item_code, 'list.php?c=$c', $comments);
list($list_ratings, $list_ratings_display) = sed_build_ratings($item_code, 'list.php?c=$c', $ratings);

$sys['sublocation'] = $sed_cat[$c]['title'];
$out['subtitle'] = $sed_cat[$c]['title'];

/* === Hook === */
$extp = sed_getextplugins('list.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

require("system/header.php");


$mskin = "$user_skin_dir/".$skin."/list.tpl";

/*if ($sed_cat[$c]['group'])
	{ $mskin = sed_skinfile(array('list', 'group', $sed_cat[$c]['tpl'])); }
else
	{ $mskin = sed_skinfile(array('list', $sed_cat[$c]['tpl'])); } */

$t = new XTemplate($mskin);

$t->assign(array(
	"LIST_PAGETITLE" => $catpath,
	"LIST_CATEGORY" => "<a href=\"list.php?c=$c\">".$sed_cat[$c]['title']."</a>",
	"LIST_CAT" => $c,
	"LIST_CATTITLE" => $sed_cat[$c]['title'],
	"LIST_CATPATH" => $catpath,
	"LIST_CATDESC" => $sed_cat[$c]['desc'],
	"LIST_CATICON" => $sed_cat[$c]['icon'],
	"LIST_COMMENTS" => $list_comments,
	"LIST_COMMENTS_DISPLAY" => $list_comments_display,
	"LIST_RATINGS" => $list_ratings,
	"LIST_RATINGS_DISPLAY" => $list_ratings_display,
	"LIST_EXTRATEXT" => $extratext,
	"LIST_SUBMITNEWPAGE" => $submitnewpage,
	"LIST_TOP_PAGEPREV" => $pageprev,
	"LIST_TOP_PAGENEXT" => $pagenext
	));

if (!$sed_cat[$c]['group'])
	{
	$t->assign(array(
	"LIST_TOP_CURRENTPAGE" => $currentpage,
	"LIST_TOP_TOTALLINES" => $totallines,
	"LIST_TOP_MAXPERPAGE" => $cfg['maxrowsperpage'],
	"LIST_TOP_TOTALPAGES" => $totalpages,
	"LIST_TOP_TITLE" => "<a href=\"list.php?c=$c&amp;s=title&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=title&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a> ".$L['Title'],
	"LIST_TOP_KEY" => "<a href=\"list.php?c=$c&amp;s=key&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=key&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a> ".$L['Key'],
	"LIST_TOP_EXTRA1" => "<a href=\"list.php?c=$c&amp;s=extra1&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=extra1&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a>",
	"LIST_TOP_EXTRA2" => "<a href=\"list.php?c=$c&amp;s=extra2&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=extra2&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a>",
	"LIST_TOP_EXTRA3" => "<a href=\"list.php?c=$c&amp;s=extra3&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=extra3&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a>",
	"LIST_TOP_EXTRA4" => "<a href=\"list.php?c=$c&amp;s=extra4&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=extra4&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a>",
	"LIST_TOP_EXTRA5" => "<a href=\"list.php?c=$c&amp;s=extra5&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=extra5&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a>",
	"LIST_TOP_DATE" => "<a href=\"list.php?c=$c&amp;s=date&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=date&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a> ".$L['Date'],
	"LIST_TOP_AUTHOR" => "<a href=\"list.php?c=$c&amp;s=author&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=author&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a> ".$L['Author'],
	"LIST_TOP_OWNER" => "<a href=\"list.php?c=$c&amp;s=ownerid&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=ownerid&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a> ".$L['Owner'],
	"LIST_TOP_COUNT" => "<a href=\"list.php?c=$c&amp;s=count&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=count&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a> ".$L['Hits'],
	"LIST_TOP_FILECOUNT" => "<a href=\"list.php?c=$c&amp;s=filecount&amp;w=asc&amp;o=$o&amp;p=$p\">$sed_img_down</a>
	<a href=\"list.php?c=$c&amp;s=filecount&amp;w=desc&amp;o=$o&amp;p=$p\">$sed_img_up</a> ".$L['Hits']
		));
	}

$ii=0;
$jj=1;
$mtch = $sed_cat[$c]['path'].".";
$mtchlen = strlen($mtch);
$mtchlvl = substr_count($mtch,".");

while (list($i,$x) = each($sed_cat) )
		{
		if (substr($x['path'],0,$mtchlen)==$mtch && substr_count($x['path'],".")==$mtchlvl)
			{
			$sql4 = sed_sql_query("SELECT COUNT(*) FROM $db_pages p, $db_structure s
				WHERE p.page_cat=s.structure_code
				AND s.structure_path LIKE '".$sed_cat[$i]['rpath']."%'
				AND page_state=0 ");
			$sub_count = sed_sql_result($sql4,0,"COUNT(*)");

			$t-> assign(array(
				"LIST_ROWCAT_URL" => "list.php?c=".$i,
				"LIST_ROWCAT_TITLE" => $x['title'],
				"LIST_ROWCAT_DESC" => $x['desc'],
				"LIST_ROWCAT_ICON" => $x['icon'],
				"LIST_ROWCAT_COUNT" => $sub_count,
				"LIST_ROWCAT_ODDEVEN" => sed_build_oddeven($ii)
					));
			$t->parse("MAIN.LIST_ROWCAT");
			$ii++;
			}
		}

/* === Hook - Part1 : Set === */
$extp = sed_getextplugins('list.loop');
/* ===== */

while ($pag = sed_sql_fetcharray($sql) and ($jj<=$cfg['maxrowsperpage']))
	{
	$jj++;
	$pag['page_desc'] = sed_cc($pag['page_desc']);
	$pag['page_pageurl'] = (empty($pag['page_alias'])) ? "page.php?id=".$pag['page_id'] : "page.php?al=".$pag['page_alias'];

	if (!empty($pag['page_url']) && $pag['page_file'])
		{
		$dotpos = strrpos($pag['page_url'],".")+1;
		$pag['page_fileicon'] = (strlen($pag['page_url'])-$dotpos>4) ? "system/img/admin/page.gif" : "system/img/pfs/".strtolower(substr($pag['page_url'], $dotpos, 5)).".gif";
		$pag['page_fileicon'] = "<img src=\"".$pag['page_fileicon']."\" alt=\"\">";
		}
	else
		{ $pag['page_fileicon'] = ''; }

	$item_code = 'p'.$pag['page_id'];
	list($pag['page_comments'], $pag['page_comments_display']) = sed_build_comments($item_code, $pag['page_pageurl'], FALSE);
	list($pag['page_ratings'], $pag['page_ratings_display']) = sed_build_ratings($item_code, $pag['page_pageurl'], FALSE);
	$pag['admin'] = $usr['isadmin'] ? "<a href=\"admin.php?m=page&amp;s=queue&amp;a=unvalidate&amp;id=".$pag['page_id']."&amp;".sed_xg()."\">".$L['Putinvalidationqueue']."</a> &nbsp;<a href=\"page.php?m=edit&amp;id=".$pag['page_id']."&r=list\">".$L['Edit']."</a> " : '';
	
	$kep = $kep = $pag['page_desc'] ;

	


	
	$t-> assign(array(
	
	 /*---------------------------------------------------------------*/
		"LIST_ROW_URL" => $pag['page_pageurl'],
		"LIST_ROW_ID" => $pag['page_id'],
		"LIST_ROW_CAT" => $pag['page_cat'],
		"LIST_ROW_KEY" => sed_cc($pag['page_key']),
		"LIST_ROW_EXTRA1" => sed_cc($pag['page_extra1']),
		"LIST_ROW_EXTRA2" => sed_cc($pag['page_extra2']),
		"LIST_ROW_EXTRA3" => sed_cc($pag['page_extra3']),
		"LIST_ROW_EXTRA4" => sed_cc($pag['page_extra4']),
		"LIST_ROW_EXTRA5" => sed_cc($pag['page_extra5']),
		"LIST_ROW_TITLE" => sed_cc($pag['page_title']),
	
		
		//"LIST_ROW_DESC" => "<img src=\"$kep\"  alt=\"Nincs kép megadva!\" heigth=\"150px\" width=\"200px\" />",
		
		"LIST_ROW_DESC" => "<img src=\"$kep\"  alt=\"Nincs kép megadva!\"  />",
		
		"LIST_ROW_AUTHOR" => sed_cc($pag['page_author']),
		"LIST_ROW_OWNER" => sed_build_user($pag['page_ownerid'], sed_cc($pag['user_name'])),
		"LIST_ROW_DATE" => @date($cfg['formatyearmonthday'], $pag['page_date'] + $usr['timezone'] * 3600),
		"LIST_ROW_FILEURL" => $pag['page_url'],
		"LIST_ROW_SIZE" => $pag['page_size'],
		"LIST_ROW_COUNT" => $pag['page_count'],
		"LIST_ROW_FILEICON" => $pag['page_fileicon'],
		"LIST_ROW_FILECOUNT" => $pag['page_filecount'],
		"LIST_ROW_JUMP" => $pag['page_pageurl']."&amp;a=dl",
		"LIST_ROW_COMMENTS" => $pag['page_comments'],
		"LIST_ROW_RATINGS" => "<a href=\"".$pag['page_pageurl']."&amp;ratings=1\"><img src=\"$user_skin_dir/".$usr['skin']."/img/system/vote".round($pag['rating_average'],0).".gif\" alt=\"\" /></a>",
		"LIST_ROW_ADMIN" => $pag['admin'],
		"LIST_ROW_ODDEVEN" => sed_build_oddeven($jj),
		
		/*-----------------------------user defined arrays-------------------*/
		
		"LIST_UDEF_LIST_ROW_TEXT" =>"".substr($pag['page_text'],0,150)."...", //for short description
		
		"LIST_UDEF_LIST" => "
		
		
		
		<li>
			<div class=\"content_block\">
			<a href=\"".$pag['page_pageurl']."\"><img width=\"215\" height=\"120\"  src=\"$kep\" alt=\"\"></a>
			<h2><a href=\"#\">".$pag['page_title']."</a></h2>
			

			</div>
		</li>
		
		
		
		
		",
			));

	/* === Hook - Part2 : Include === */
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	$t->parse("MAIN.LIST_ROW");
	}


/* === Hook === */
$extp = sed_getextplugins('list.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>
