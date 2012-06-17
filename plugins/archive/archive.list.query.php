<?php

/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=archive
Part=list.query
File=archive.list.query
Hooks=list.query
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */

defined('SED_CODE') or die('Wrong URL');

sed_die(empty($sed_cat[$c]['title']) && !$usr['isadmin']);

$year = sed_import('year','G','INT',4);
$month = sed_import('month','G','INT',2);
$between = '';

if($year && $month && $month<=12)
{
	$start = mktime(0, 0, 0, $month, 1, $year);
	$end = mktime(0, 0, 0, $month+1, 1, $year)-1;
	$between = "AND page_begin BETWEEN $start AND $end";
}

if ($c=='all')
{
	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pages WHERE page_state=0");
	$totallines = sed_sql_result($sql, 0, 0);
	$sql = sed_sql_query("SELECT p.*, u.user_name ".$join_ratings_columns."
	FROM $db_pages as p ".$join_ratings_condition."
	LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
	WHERE page_state=0 $between
	ORDER BY page_$s $w LIMIT $d,".$cfg['maxrowsperpage']);
}
elseif ($c == 'unvalidated')
{
	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pages
		WHERE page_state = 1 AND page_ownerid = " . $usr['id']);
	$totallines = sed_sql_result($sql, 0, 0);
	$sql = sed_sql_query("SELECT p.*, u.user_name ".$join_ratings_columns."
		FROM $db_pages as p ".$join_ratings_condition."
			LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
		WHERE page_state = 1 AND page_ownerid = {$usr['id']} $between
		ORDER BY page_$s $w LIMIT $d,".$cfg['maxrowsperpage']);
	$sed_cat[$c]['title'] = $L['pag_validation'];
	$sed_cat[$c]['desc'] = $L['pag_validation_desc'];
 }
elseif (!empty($o) && !empty($p) && $p!='password')
{
	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pages
		WHERE page_cat='$c' AND (page_state='0' OR page_state='2') AND page_$o='$p'");
	$totallines = sed_sql_result($sql, 0, 0);
	$sql = sed_sql_query("SELECT p.*, u.user_name ".$join_ratings_columns."
	FROM $db_pages as p ".$join_ratings_condition."
	LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
	WHERE page_cat='$c' AND (page_state=0 OR page_state=2) AND page_$o='$p' $between
	ORDER BY page_$s $w LIMIT $d,".$cfg['maxrowsperpage']);
}
else
{
	sed_die(empty($sed_cat[$c]['title']) && !$usr['isadmin']);
	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pages
		WHERE page_cat='$c' AND (page_state='0' OR page_state='2')");
	$totallines = sed_sql_result($sql, 0, 0);
	$sql = sed_sql_query("SELECT p.*, u.user_name ".$join_ratings_columns."
	FROM $db_pages as p ".$join_ratings_condition."
	LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
	WHERE page_cat='$c' AND (page_state=0 OR page_state=2) $between
	ORDER BY page_$s $w LIMIT $d,".$cfg['maxrowsperpage']);
}

?>