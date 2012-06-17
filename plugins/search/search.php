<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=plugins/search/search.php
Version=121
Updated=2007-apr-02
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=search
Part=main
File=search
Hooks=standalone
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE') || !defined('SED_PLUG')) { die('Wrong URL.'); }

$cfg_maxwords = 3;
$cfg_maxitems = 100;

$sq = sed_import('sq','P','TXT');
$pre = sed_import('pre','G','TXT');
$a = sed_import('a','G','TXT');

$frm = sed_import('frm','G','BOL');
$pag = sed_import('pag','G','BOL');

$searchin_frm = sed_import('searchin_frm','P','BOL');
$searchin_pag = sed_import('searchin_pag','P','BOL');

If ($frm+$pag+$searchin_frm+$searchin_pag==0)
	{
	$pag = 1;
	$frm = 1;
	}

$prechecked_pag = ($pag || $searchin_pag) ? "checked=\"checked\"": '';
$prechecked_frm = ($frm || $searchin_frm) ? "checked=\"checked\"": '';

$sq = (!empty($pre)) ? $pre : $sq;

$plugin_title = $L['plu_title'];

if ($a=='search')
	{
	if (strlen($sq)<3)
		{
		$plugin_body .= "<p>".$L['plu_querytooshort']."</p>";
		unset ($searchin_frm, $searchin_use, $searchin_pag, $a);
		}

	$sq = sed_sql_prep($sq);

	$words = explode(" ", $sq);
	$words_count = count($words);

	if ($words_count > $cfg_maxwords)
		{
		$plugin_body .= "<p>".$L['plu_toomanywords']." ".$cfg_maxwords."</p>";
		$a = '';
		}

	$sqlsearch = implode("%", $words);
	$sqlsearch = "%".$sqlsearch."%";

	if ($searchin_pag && !$cfg['disable_page'])
		{
		$pag_sub = sed_import('pag_sub','P','ARR');

		if ($pag_sub[0]=='all')
			{ $sqlsections = ''; }
	       else
	       	{
	       	$sub = array();
			foreach($pag_sub as $i => $k)
   				{ $sub[] = "page_cat='".$k."'"; }
			$sqlsections = "AND (".implode(' OR ', $sub).")";
			}

       	 $sql  = sed_sql_query("SELECT page_id, page_title, page_cat from $db_pages p, $db_structure s
   	 		WHERE (p.page_text LIKE '$sqlsearch' OR p.page_title LIKE '$sqlsearch'
       	 	OR p.page_desc LIKE '".sed_sql_prep($sqlsearch)."')
       	 	AND p.page_state='0'
       	 	AND p.page_cat=s.structure_code
       	 	AND p.page_cat NOT LIKE 'system'
       	 	$sqlsections ORDER by page_cat ASC, page_title ASC
       	 	LIMIT $cfg_maxitems");

		$items = mysql_num_rows($sql);
		$plugin_body .= "<h4>".$L['Pages']." : ".$L['plu_found']." ".$items." ".$L['plu_match']."</h4>";

		while ($row = mysql_fetch_array($sql))
			{
			if (sed_auth('page', $row['page_cat'], 'R'))
				{
				$plugin_body .= "<a href=\"list.php?c=".$row['page_cat']."\">".$sed_cat[$row['page_cat']]['tpath']."</a>";
				$plugin_body .= " ".$cfg['separator']." "."<a href=\"page.php?id=".$row['page_id']."\">";
				$plugin_body .= sed_cc($row['page_title'])."</a><br />";
				}
			}
		$sections++;
		}

	if ($searchin_frm && !$cfg['disable_forums'])
		{
		$frm_sub = sed_import('frm_sub','P','ARR');

		if ($frm_sub[0]==9999)
			{ $sqlsections = ''; }
	       else
	       	{
			foreach($frm_sub as $i => $k)
   				{ $sections1[] = "s.fs_id='".$k."'"; }
			$sqlsections = "AND (".implode(' OR ', $sections1).")";
			}

		$sql = sed_sql_query("SELECT p.fp_id, t.ft_title, t.ft_id, s.fs_id, s.fs_title, s.fs_category
		 	FROM $db_forum_posts p, $db_forum_topics t, $db_forum_sections s
			WHERE 1 AND (p.fp_text LIKE '".sed_sql_prep($sqlsearch)."' OR t.ft_title LIKE '".sed_sql_prep($sqlsearch)."')
			AND p.fp_topicid=t.ft_id
			AND p.fp_sectionid=s.fs_id $sqlsections
			GROUP BY t.ft_id ORDER BY fp_id DESC
			LIMIT $cfg_maxitems");

		$items = mysql_num_rows($sql);
		$plugin_body .= "<h4>".$L['Forums']." : ".$L['plu_found']." ".$items." ".$L['plu_match']."</h4>";

		while ($row = mysql_fetch_array($sql))
			{
			if (sed_auth('forums', $row['fs_id'], 'R'))
				{
				$plugin_body .= sed_build_forums($row['fs_id'], $row['fs_title'], $row['fs_category'], TRUE)." ".$cfg['separator']." <a href=\"forums.php?m=posts&amp;p=".$row['fp_id']."#".$row['fp_id']."\">".sed_cc($row['ft_title'])."</a><br />";
				}
			}
		$sections++;
		}
	}

$plugin_body .= "<form id=\"search\" action=\"plug.php?e=search&amp;a=search\" method=\"post\"><p>".$L['plu_searchin1'];
$plugin_body .= "<input type=\"text\" class=\"skinned\"  name=\"sq\" value=\"".sed_cc($sq)."\" size=\"90\" maxlength=\"89\" />";
$plugin_body .= "<input type=\"submit\" class=\"submit\" value=\"".$L['Search']."\" />".$L['plu_searchin2']."</p>";
$plugin_body .= "<table class=\"cells\">";

if (!$cfg['disable_forums'])
	{
	$plugin_body .= "<tr><td>".$L['plu_sections']."</td>";
	$plugin_body .= "<td>".$L['plu_options']."</td></tr>";

	$sql1 = sed_sql_query("SELECT s.fs_id, s.fs_title, s.fs_category FROM $db_forum_sections AS s
		LEFT JOIN $db_forum_structure AS n ON n.fn_code=s.fs_category
    	ORDER by fn_path ASC, fs_order ASC");

	$plugin_body .= "<tr><td><input type=\"checkbox\" class=\"checkbox\" name=\"searchin_frm\" $prechecked_frm value=\"1\" /> ";
	$plugin_body .= $L['Forums']."</td><td><select multiple name=\"frm_sub[]\" class=\"skinned\"  size=\"8\">";
	$plugin_body .= "<option value=\"9999\" selected=\"selected\">".$L['plu_allsections']."</option>";

	while ($row1 = mysql_fetch_array($sql1))
		{
		if (sed_auth('forums', $row1['fs_id'], 'R'))
			{
			$plugin_body .= "<option value=\"".$row1['fs_id']."\">".sed_build_forums($row1['fs_id'], $row1['fs_title'], $row1['fs_category'], FALSE)."</option>";
			}
		}

	$plugin_body .= "</select></td></tr>";
	}

if (!$cfg['disable_page'])
	{
	$plugin_body .= "<tr><td><input type=\"checkbox\" class=\"checkbox\" name=\"searchin_pag\" $prechecked_pag value=\"1\" /> ";
	$plugin_body .= $L['Pages']."</td><td><select multiple name=\"pag_sub[]\" class=\"skinned\" size=\"5\">";
	$plugin_body .= "<option value=\"all\"  selected=\"selected\">".$L['plu_allcategories']."</option>";

	foreach ($sed_cat as $i =>$x)
		{
		if ($i!='all' && $i!='system' && sed_auth('page', $i, 'R'))
			{
			$selected = ($i == $check) ? "selected=\"selected\"" : '';
			$plugin_body .= "<option value=\"".$i."\" $selected> ".$x['tpath']."</option>";
			}
		}

	$plugin_body .= "</select></td></tr>";
	}

$plugin_body .= "</table></form>";

?>