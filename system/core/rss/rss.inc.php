<?PHP
/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=rss.php
Version=101
Updated=2010-07-08
Type=Core
Author=Neocrome
Description=RSS
[END_SED]
==================== */

define('SED_CODE', TRUE);


/* ================ Settings ================ */

//RSS Titles 
$cfg['rss_titlenews'] = $cfg_titlenews;
$cfg_titleforums	= "Forums";
$cfg_titlearticles	= "Articles";
$cfg_titlevideosarok = "Videosarok";
//Page categories by sections
$cfg_newscat	= "news";
$cfg_articlecat	= "articles";
$cfg_videosarokcat	= "videosarok";
//Main site url
$cfg_url	= "http://www.site.ru";
//RSS Charset
$cfg_charset	= "windows-1250";
//News displayed in RSS
$cfg_maxlines	= 25;
$cfg_ttl	= 1;

/* ================ Getting Type ============ */

$m = sed_import('m','G','ALP');

/* ================ Grabbing Data =========== */

switch ($m)
	{

	// News Export

	default :

		$cfg_title=$cfg_titlenews;

		$mtch = $sed_cat[$cfg_newscat]['path'].".";
		$mtchlen = strlen($mtch);
		$catsub = array();
		$catsub[] = $cfg_newscat;

		foreach($sed_cat as $i => $x)
			{
			if (substr($x['path'], 0, $mtchlen)==$mtch)
				{ $catsub[] = $i; }
			}


		$sql = sed_sql_query("SELECT page_id, page_title, page_text, page_cat, page_date FROM $db_pages WHERE page_state=0 AND page_cat NOT LIKE 'system' AND page_cat IN ('".implode("','", $catsub)."') ORDER by page_date DESC LIMIT ".$cfg_maxlines);

		while ($row = mysql_fetch_array($sql))
			{
			$readmore = strpos($row['page_text'], "[more]");
			if ($readmore>0)
				{
				$row['page_text'] = substr($row['page_text'], 0, $readmore)."<br />";
				$row['page_text'] .= "<a href=\"".$row['page_pageurl']."\">".$L['ReadMore']."</a>";
				}

			$items .= "<item>\n";
			$items .= " <title>".htmlspecialchars(stripslashes($row['page_title']))."</title>\n";
			$items .= " <description>".htmlspecialchars(sed_parse($row['page_text'], $cfg['parsebbcodepages'], $cfg['parsesmiliespages'], 1))."</description>\n";
			$items .= " <category>".$sed_cat[$row['page_cat']]['title']."</category>\n";
			$items .= " <link>".$cfg_url."/page.php?id=".$row['page_id']."</link>\n";
			$items .= " <pubDate>".date("r",$row['page_date'])."</pubDate>\n";
			$items .= "</item>\n";
			}

	break;
	
	// Articles Export

	case 'articles' :

		$cfg_title=$cfg_titlearticles;

		$mtch = $sed_cat[$cfg_articlecat]['path'].".";
		$mtchlen = strlen($mtch);
		$catsub = array();
		$catsub[] = $cfg_articlecat;

		foreach($sed_cat as $i => $x)
			{
			if (substr($x['path'], 0, $mtchlen)==$mtch)
				{ $catsub[] = $i; }
			}


		$sql = sed_sql_query("SELECT page_id, page_title, page_text, page_cat, page_date FROM $db_pages WHERE page_state=0 AND page_cat NOT LIKE 'system' AND page_cat IN ('".implode("','", $catsub)."') ORDER by page_date DESC LIMIT ".$cfg_maxlines);

		while ($row = mysql_fetch_array($sql))
			{
			$readmore = strpos($row['page_text'], "[more]");
			if ($readmore>0)
				{
				$row['page_text'] = substr($row['page_text'], 0, $readmore)."<br />";
				$row['page_text'] .= "<a href=\"".$row['page_pageurl']."\">".$L['ReadMore']."</a>";
				}

			$items .= "<item>\n";
			$items .= " <title>".htmlspecialchars(stripslashes($row['page_title']))."</title>\n";
			$items .= " <description>".htmlspecialchars(sed_parse($row['page_text'], $cfg['parsebbcodepages'], $cfg['parsesmiliespages'], 1))."</description>\n";
			$items .= " <category>".$sed_cat[$row['page_cat']]['title']."</category>\n";
			$items .= " <link>".$cfg_url."/page.php?id=".$row['page_id']."</link>\n";
			$items .= " <pubDate>".date("r",$row['page_date'])."</pubDate>\n";
			$items .= "</item>\n";
			}

	break;
	
// Videosarok Export

	case 'video' :

		$cfg_title=$cfg_titlevideosarok;

		$mtch = $sed_cat[$cfg_videosarokcat]['path'].".";
		$mtchlen = strlen($mtch);
		$catsub = array();
		$catsub[] = $cfg_videosarokcat;

		foreach($sed_cat as $i => $x)
			{
			if (substr($x['path'], 0, $mtchlen)==$mtch)
				{ $catsub[] = $i; }
			}


		$sql = sed_sql_query("SELECT page_id, page_title, page_text, page_cat, page_date FROM $db_pages WHERE page_state=0 AND page_cat NOT LIKE 'system' AND page_cat IN ('".implode("','", $catsub)."') ORDER by page_date DESC LIMIT ".$cfg_maxlines);

		while ($row = mysql_fetch_array($sql))
			{
			$readmore = strpos($row['page_text'], "[more]");
			if ($readmore>0)
				{
				$row['page_text'] = substr($row['page_text'], 0, $readmore)."<br />";
				$row['page_text'] .= "<a href=\"".$row['page_pageurl']."\">".$L['ReadMore']."</a>";
				}

			$items .= "<item>\n";
			$items .= " <title>".htmlspecialchars(stripslashes($row['page_title']))."</title>\n";
			$items .= " <description>".htmlspecialchars(sed_parse($row['page_text'], $cfg['parsebbcodepages'], $cfg['parsesmiliespages'], 1))."</description>\n";
			$items .= " <category>".$sed_cat[$row['page_cat']]['title']."</category>\n";
			$items .= " <link>".$cfg_url."/page.php?id=".$row['page_id']."</link>\n";
			$items .= " <pubDate>".date("r",$row['page_date'])."</pubDate>\n";
			$items .= "</item>\n";
			}

	break;

	// Forums export

	case 'forums':

		$cfg_title=$cfg_titleforums;

		$sql = sed_sql_query("SELECT t.ft_id, t.ft_title, t.ft_updated, s.fs_title, s.fs_id 
		FROM $db_forum_topics t,$db_forum_sections s
		WHERE t.ft_sectionid=s.fs_id AND t.ft_movedto=0
		ORDER by t.ft_updated DESC LIMIT 100");
		$fc=1;

		while ($row = mysql_fetch_array($sql))
			{

			list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', $row['fs_id']);

			if (($usr['auth_read']) && ($fc<=$cfg_maxlines)) {
				$fc++;
				$items .= "<item>\n";
				$items .= " <title>".htmlspecialchars(stripslashes($row['fs_title'])." : ".stripslashes($row['ft_title']))."</title>\n";
				$items .= " <description> </description>\n";
				$items .= " <link>".$cfg['mainurl']."/forums.php?m=posts&amp;q=".$row['ft_id']."&amp;n=last#bottom</link>\n";
				$items .= " <pubDate>".date("r",$row['ft_updated'])."</pubDate>\n";
				$items .= "</item>\n\n";
				}
			}

	break;
	
	case 'comments' :
	
	if ($c == "comments")
{
	// == Comments rss ==
	$page_id = $id;

	$rss_title = "Comments for ".$cfg['maintitle'];

	$sql = sed_sql_query("SELECT * FROM $db_pages WHERE page_id='$page_id' LIMIT 1");
	if (sed_sql_affectedrows()>0)
	{
		$row = mysql_fetch_assoc($sql);
		if(sed_auth('page', $row['page_cat'], 'R'))
		{
			$rss_title = $row['page_title'];
			$rss_description = $L['rss_comments_item_desc'];

			$sql = sed_sql_query("SELECT * FROM $db_com WHERE com_code='p$page_id' ORDER BY com_date DESC LIMIT $cfg_maxitems");
			$i = 0;
			while($row = mysql_fetch_assoc($sql))
			{
				$sql2 = sed_sql_query("SELECT * FROM $db_users WHERE user_id='".$row['com_authorid']."' LIMIT 1");
				$row2 = mysql_fetch_assoc($sql2);
				$items[$i]['title'] = $L['rss_comment']." ".$row2['user_name'];
				$text = sed_parse(htmlspecialchars($row['com_text']), $cfg['parsebbcodecom'], $cfg['parsesmiliescom'], 1);
				$text = sed_post_parse($text, 'pages');
				$items[$i]['description'] = $text;
				$items[$i]['link'] = SED_ABSOLUTE_URL.sed_url('page', "id=$page_id", '#c'.$row['com_id'], true);
				$items[$i]['pubDate'] = date('r', $row['com_date']);
				$i++;
			}
			// Attach original page text as last item
			$sql = sed_sql_query("SELECT * FROM $db_pages WHERE page_id='$page_id' LIMIT 1");
			$row = mysql_fetch_assoc($sql);
			$items[$i]['title'] = $L['rss_original'];
			//$items[$i]['description'] = sed_parse_page_text($row['page_text']);
			$items[$i]['description'] = $row['page_html']; // TODO page_text parse
			$items[$i]['link'] = SED_ABSOLUTE_URL.sed_url('page', "id=$page_id", '', true);
			$items[$i]['pubDate'] = date('r', $row['page_date']);
		}
	}
}

	}

/* ================ Display result ========== */


header('Content-type: text/xml');

$output = "<?xml version=\"1.0\" encoding=\"".$cfg_charset."\"?>\n";
$output .= "<rss version=\"2.0\">\n";
$output .= "<channel>\n";
$output .= "<title>".$cfg_title."</title>\n";
$output .= "<link>".$cfg_url."</link>\n";
$output .= "<description></description>\n";
$output .= "<ttl>".$cfg_ttl."</ttl>\n";
$output .= $items;
$output .= "</channel>\n";
$output .= "</rss>";

@ob_start("ob_gzhandler");
echo($output);
@ob_end_flush();

?>
