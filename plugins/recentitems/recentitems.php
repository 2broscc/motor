<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/recentitems/recentitems.php
Version=110
Updated=2010-june-15
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=recentitems
Part=main
File=recentitems
Hooks=index.tags
Tags=index.tpl:{PLUGIN_LATESTPAGES},{PLUGIN_LATESTTOPICS},{PLUGIN_LATESTPOLL}
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

/* ============ MASKS FOR THE HTML OUTPUTS =========== */
//top video

$cfg['plu_mask_topvideo'] = "      $s"."  %2\$s ";
// %1\$s = Link to the category
// %2\$s = Link to the page
// %3\$s = Date

//videos

$cfg['plu_mask_videos'] = "      $s"."  %2\$s  ";
// %1\$s = Link to the category
// %2\$s = Link to the page
// %3\$s = Date

/*top articles mask*/

$cfg['plu_mask_top'] = "    $s"."  %2\$s <br> %3\$s";
// %1\$s = Link to the category
// %2\$s = Link to the page
// %3\$s = Date

$cfg['plu_mask_pages'] = "    $s"."  %3\$s -"."%2\$s"." <br />";
// %1\$s = Link to the category
// %2\$s = Link to the page
// %3\$s = Date

$cfg['plu_mask_topics'] =  "%1\$s"." "."%2\$s"." "."%3\$s"." ".$cfg['separator']." "."%4\$s"." ("."%5\$s".")<br />";
// %1\$s = "Follow" image
// %2\$s = Date
// %3\$s = Section
// %4\$s = Topic title
// %5\$s = Number of replies

$cfg['plu_mask_polls'] =  "<p>%1\$s</p>";

$plu_empty = $L['None']."<br />";


/*
LATEST PAGES
*/

function sed_get_latestpages($limit_cikkek, $mask) 	{
	global $L, $db_pages, $usr, $cfg, $sed_cat, $plu_empty;
	$limit_cikkek = 23;
	$sql = sed_sql_query("SELECT page_id, page_alias, page_cat, page_title, page_date FROM $db_pages WHERE page_state=0 AND page_cat = 'articles' ORDER by page_date DESC LIMIT $limit_cikkek");

	while ($row = sed_sql_fetcharray($sql))
		{
		if (sed_auth('page', $row['page_cat'], 'R'))
			{
			$row['page_pageurl'] = (empty($row['page_alias'])) ? "page.php?id=".$row['page_id'] : "page.php?al=".$row['page_alias'];
		$res .= sprintf($mask,
			"<a href=\"list.php?c=".$row['page_cat']."\">".$sed_cat[$row['page_cat']]['title']."</a>",
			"<a href=\"".$row['page_pageurl']."\">".sed_cc(sed_cutstring(stripslashes($row['page_title']), 36))."</a>",
			date($cfg['formatyearmonthday'], $row['page_date'] + $usr['timezone'] * 3600)
				);
			}
		}

	$res = (empty($res)) ? $plu_empty : $res;

	return($res);
}




/*
LATEST MOBILE PAGES
*/

function sed_get_mobilepages($limit_cikkek, $mask) 	{
	global $L, $db_pages, $usr, $cfg, $sed_cat, $plu_empty;
	$limit_cikkek = 23;
	$sql = sed_sql_query("SELECT page_id, page_alias, page_cat, page_title, page_date FROM $db_pages WHERE page_state=0 AND page_cat = 'articles' ORDER by page_date DESC LIMIT $limit_cikkek");

	while ($row = sed_sql_fetcharray($sql))
		{
		if (sed_auth('page', $row['page_cat'], 'R'))
			{
			$row['page_pageurl'] = (empty($row['page_alias'])) ? "mobile.php?m=page&id=".$row['page_id'] : "page.php?al=".$row['page_alias'];
		
		$res .= sprintf($mask,
			"<a href=\"list.php?c=".$row['page_cat']."\">".$sed_cat[$row['page_cat']]['title']."</a>",
			"<a href=\"".$row['page_pageurl']."\">".sed_cc(sed_cutstring(stripslashes($row['page_title']), 36))."</a>",
			date($cfg['formatyearmonthday'], $row['page_date'] + $usr['timezone'] * 3600)
				);
			}
		}

	$res = (empty($res)) ? $plu_empty : $res;

	return($res);
}
	
	
	
/*

ARTICLES

*/
	
function sed_get_latestarticle($limit_articles, $mask)
	{
	global $L, $db_pages, $usr, $cfg, $sed_cat, $plu_empty;
	$limit_articles	= 1;
	$cat = "articles";
	$sql = sed_sql_query("SELECT page_id, page_alias, page_text, page_cat, page_desc, page_title, page_date FROM $db_pages WHERE page_state=0 AND page_cat = '$cat' ORDER by page_date DESC LIMIT $limit_articles");
	
	$szoveg = substr($row['page_text'],0,10);
	
	while ($row = sed_sql_fetcharray($sql))
		{
		if (sed_auth('page', $row['page_cat'], 'R'))
			{
			$row['page_pageurl'] = (empty($row['page_alias'])) ? "page.php?id=".$row['page_id'] : "page.php?al=".$row['page_alias'];
	
	$res .= "
		<div><h3><a href=\"".$row['page_pageurl']."\">".sed_cc(sed_cutstring(stripslashes($row['page_title']), 36))."</a></h3></div>
		<div>".substr($row['page_text'],0,80)."...</div>

		";
	
			}
		}

	$res = (empty($res)) ? $plu_empty : $res;

	return($res);
	}
	

function sed_get_latestvideosarok($limit_videosarok, $mask)
	{
	global $L, $db_pages, $usr, $cfg, $sed_cat, $plu_empty;
	$limit_videosarok = 8;
	$sql = sed_sql_query("SELECT * FROM $db_pages WHERE page_state=0 AND page_cat = 'videosarok' ORDER by page_date DESC LIMIT $limit_videosarok");

	while ($row = sed_sql_fetcharray($sql))
		{
		if (sed_auth('page', $row['page_cat'], 'R'))
			{
			$row['page_pageurl'] = (empty($row['page_alias'])) ? "video.php?id=".$row['page_id'] : "video.php?al=".$row['page_alias'];
		$oldal_id = $row['page_id'];
		
	
//todo
		
	if (empty($row['page_extra7'])) {
		
			$page_extra7_mask = "ÜRES";
		
		
		}
		
		else {
		
			$page_extra7_mask = "".sed_cc(sed_cutstring(stripslashes($row['page_extra7']), 28))."";
		
		}
		
		
		
		$res .= "
		<table width=\"100%\">
		<tr>
		<td>
		<img src=\"".$row['page_desc']."\" width=\"50\" height=\"50\" alt=\"vidkep\" /><br>
		</td>
		<td>
		<div style=\"padding-left:4px;\">
		
		<a href=\"".$row['page_pageurl']."\"><h5>".sed_cc(sed_cutstring(stripslashes($row['page_title']), 28))."</h5></a> <br>
		$page_extra7_mask <br>
		".date($cfg['formatyearmonthday'], $row['page_date'] + $usr['timezone'] * 3600)."
		
		</div>
		</td>
		</tr>
		</table>";
		
		}
			
	}

	$res = (empty($res)) ? $plu_empty : $res;

	return($res);
	}
	
	


/*
function name: poll
*/

function sed_get_latestpolls($limit, $mask)
	{
	global $L, $db_polls, $db_polls_voters, $db_polls_options, $usr, $plu_empty;
	
	$sql_p = sed_sql_query("SELECT poll_id, poll_text FROM $db_polls WHERE 1 AND poll_state=0  AND poll_type=0 ORDER by poll_creationdate DESC LIMIT $limit");

	while ($row_p = sed_sql_fetcharray($sql_p))
		{
		unset($res);
		$poll_id = $row_p['poll_id'];

		if ($usr['id']>0)
	 		{ $sql2 = sed_sql_query("SELECT pv_id FROM $db_polls_voters WHERE pv_pollid='$poll_id' AND (pv_userid='".$usr['id']."' OR pv_userip='".$usr['ip']."') LIMIT 1"); }
	       else
	 		{ $sql2 = sed_sql_query("SELECT pv_id FROM $db_polls_voters WHERE pv_pollid='$poll_id' AND pv_userip='".$usr['ip']."' LIMIT 1"); }

		if (sed_sql_numrows($sql2)>0)
			{
			$alreadyvoted =1;
			$sql2 = sed_sql_query("SELECT SUM(po_count) FROM $db_polls_options WHERE po_pollid='$poll_id'");
			$totalvotes = sed_sql_result($sql2,0,"SUM(po_count)");
			}
		else
			{ $alreadyvoted =0; }

		$res .= "<h5>".sed_parse(sed_cc($row_p['poll_text']), 1, 1, 1)."</h5>";

		$sql = sed_sql_query("SELECT po_id, po_text, po_count FROM $db_polls_options WHERE po_pollid='$poll_id' ORDER by po_id ASC");

		while ($row = sed_sql_fetcharray($sql))
			{
			if ($alreadyvoted)
				{
				$percentbar = floor(($row['po_count'] / $totalvotes) * 100);
				//need to finish this thing
				$res .= sed_parse(sed_cc($row['po_text']), 1, 1, 1)." : $percentbar%
						<div style=\"width:95%;\">
							<div class=\"bar_back\">
								
									<div class=\"bar_front\" style=\"width:".$percentbar."%;\"></div>
								
								</div>
							</div>";
				}
			else
				{
				$res .= "<a href=\"javascript:pollvote('".$poll_id."','".$row['po_id']."')\">";
				$res .= sed_parse(sed_cc($row['po_text']), 1, 1, 1)."</a><br />";
				}
			}
			
			
		$res .= "<p style=\"text-align:center;\"><a href=\"javascript:polls('".$poll_id."')\" >".$L['polls_viewresults']."</a> &nbsp; ";
		$res .= "<a href=\"javascript:polls('viewall')\" >".$L['polls_viewarchives']."</a></p>";
		$res_all .= sprintf($mask, $res);
		}

//		{ $res = $plu_empty; }

	return($res_all);
	}
	
/*
function name: latest topics
*/

function sed_get_latesttopics($limit, $mask)
	{
	global $L, $db_forum_topics, $db_forum_sections, $usr, $cfg, $skin, $plu_empty;

	$sql = sed_sql_query("SELECT t.ft_id, t.ft_sectionid, t.ft_title, t.ft_updated, t.ft_postcount, s.fs_id, s.fs_title, s.fs_category
		FROM $db_forum_topics t,$db_forum_sections s
		WHERE t.ft_sectionid=s.fs_id
		AND t.ft_movedto=0 AND t.ft_mode=0
		ORDER by t.ft_updated DESC LIMIT $limit");

	while ($row = sed_sql_fetcharray($sql))
		{
		if (sed_auth('forums', $row['fs_id'], 'R'))
			{
			$img = ($usr['id']>0 && $row['ft_updated']>$usr['lastvisit']) ? "<a href=\"forums.php?m=posts&amp;q=".$row['ft_id']."&amp;n=unread#unread\"><img src=\"skins/$skin/img/system/arrow-unread.gif\" alt=\"\" /></a>" : "<a href=\"forums.php?m=posts&amp;q=".$row['ft_id']."&amp;n=last#bottom\"><img src=\"skins/$skin/img/system/arrow-follow.gif\" alt=\"\" /></a> ";

			$res .= sprintf($mask,
				$img,
				date($cfg['formatmonthdayhourmin'], $row['ft_updated'] + $usr['timezone'] * 3600),
				sed_build_forums($row['fs_id'], sed_cutstring($row['fs_title'],24), sed_cutstring($row['fs_category'],16)),
				"<a href=\"forums.php?m=posts&amp;q=".$row['ft_id']."&amp;n=last#bottom\">".sed_cc(sed_cutstring(stripslashes($row['ft_title']),25))."</a>",
			//	<a href=\"forums.php?m=posts&amp;q=".$row['ft_id']."&amp;n=last#bottom\" title=\"".$row['ft_title']."\">".sed_cc(sed_cutstring(stripslashes($row['ft_title']),25))."</a>
				$row['ft_postcount']-1
					);
			}
		}

	$res = (empty($res)) ? $plu_empty : $res;

	return($res);
	}
	
/*
function name: news
*/

function sed_get_latestnews($limit_news, $mask)
	{
	global $L, $db_pages, $usr, $cfg, $sed_cat, $plu_empty;
	$limit_news	= 5;
	$cat = "news";
	$sql = sed_sql_query("SELECT page_id, page_alias, page_text, page_cat, page_desc, page_title, page_date FROM $db_pages WHERE page_state=0 AND page_cat = '$cat' ORDER by page_date DESC LIMIT $limit_news");
	
		
	while ($row = sed_sql_fetcharray($sql))
		{
		if (sed_auth('page', $row['page_cat'], 'R'))
			{
			$row['page_pageurl'] = (empty($row['page_alias'])) ? "page.php?id=".$row['page_id'] : "page.php?al=".$row['page_alias'];
		$res .= sprintf($mask,
		
			"<a href=\"list.php?c=".$row['page_cat']."\">".$sed_cat[$row['page_cat']]['title']."</a>",
			"<div align=\"left\"><h5><a href=\"".$row['page_pageurl']."\">".sed_cc(sed_cutstring(stripslashes($row['page_title']), 36))."</a></h5> ".substr($row['page_text'],0,100)."...</div><br>",
			date($cfg['formatyearmonthday'], $row['page_date'] + $usr['timezone'] * 3600)
				);
			}
		}

	$res = (empty($res)) ? $plu_empty : $res;
	return($res);
	}

/*
Masks
*/

if ($cfg['plugin']['recentitems']['maxpages']>0 && !$cfg['disable_page'])
	{ $latestpages = sed_get_latestpages($cfg['plugin']['recentitems']['maxpages'], $cfg['plu_mask_pages']); }

	
	
if ($cfg['plugin']['recentitems']['maxpages']>0 && !$cfg['disable_page'])
	{ $pages = sed_get_mobilepages($cfg['plugin']['recentitems']['maxpages'], $cfg['plu_mask_pages']); }
	


if ($cfg['plugin']['recentitems']['maxtopics']>0 && !$cfg['disable_forums'])
	{ $latesttopics = sed_get_latesttopics($cfg['plugin']['recentitems']['maxtopics'], $cfg['plu_mask_topics']); }


//videosarok	
if ($cfg['plugin']['recentitems']['maxpages']>0 && !$cfg['disable_page'])
	{ $latestvideosarok = sed_get_latestvideosarok($cfg['plugin']['recentitems']['maxpages'], $cfg['plu_mask_videos']); }

if ($cfg['plugin']['recentitems']['maxpages']>0 && !$cfg['disable_page'])
	{ $latestarticles= sed_get_latestarticle($cfg['plugin']['recentitems']['maxpages'], $cfg['plu_mask_top']); }
	
if ($cfg['plugin']['recentitems']['maxpolls']>0 && !$cfg['disable_polls'])
	{ $latestpoll = sed_get_latestpolls($cfg['plugin']['recentitems']['maxpolls'], $cfg['plu_mask_polls']); }
	
	
$t-> assign(array(

	"PLUGIN_LATEST_ARTICLE" => $latestarticles,
	"PLUGIN_LATESTPOLL" => $latestpoll,
	"PLUGIN_LATESTPAGES" => $latestpages,
	
	"PLUGIN_PAGES" => $pages,
	
	"PLUGIN_LATESTTOPICS" => $latesttopics,
		));

?>
