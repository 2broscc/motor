<?php

/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=archive
Part=main
File=archive
Hooks=standalone
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */

defined('SED_CODE') or die('Wrong URL');

$c = sed_import('c','G','TXT');
$t = new XTemplate(sed_skinfile('archive', true));

if($c && isset($sed_cat[$c]))
{
	$t->assign('CATEGORY', $sed_cat[$c]['title']);

	$sql = sed_sql_query("
		SELECT page_begin FROM $db_pages
		WHERE page_cat = '".sed_sql_prep($c)."'
		ORDER BY page_begin DESC
	");

	$years = array();
	while($row = sed_sql_fetchassoc($sql))
	{
		$years[date('Y', $row['page_begin'])][date('n', $row['page_begin'])] = $row['page_begin'];
	}

	foreach($years as $year => $months)
	{
		$t->assign('YEAR', $year);
		foreach($months as $month => $ts)
		{
			$t->assign(array(
				'MONTH' => $L[date('F', $ts)],
				'LIST_URL' => sed_url('list', 'c='.$c.'&year='.$year.'&month='.$month)
			));
			$t->parse('MAIN.ARCHIVE.YEARS.MONTHS');
		}
		$t->parse('MAIN.ARCHIVE.YEARS');
	}
	$t->parse('MAIN.ARCHIVE');
}
else
{
	$sql = sed_sql_query("
		SELECT * FROM $db_structure
		WHERE structure_group = 0 AND structure_code != 'system' AND structure_path NOT LIKE CONCAT((
			SELECT structure_path FROM $db_structure WHERE structure_code = 'system'
		), '.%')
	");
	while($row = sed_sql_fetchassoc($sql))
	{
		$t->assign(array(
			'CAT_CODE' => $row['structure_code'],
			'CAT_TITLE' => $row['structure_title'],
			'ARCHIVE_URL' => sed_url('plug', 'e=archive&c='.$row['structure_code'])
		));
		$t->parse('MAIN.ARCHIVES.CATEGORIES');
	}
	$t->parse('MAIN.ARCHIVES');
}

?>