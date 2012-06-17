<?php
/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=similar
Part=page
File=similar.page
Hooks=page.tags
Tags=similar.tpl:{SIMILAR_ROW_NUMBER},{SIMILAR_ROW_URL},{SIMILAR_ROW_TITLE},{SIMILAR_ROW_AUTHOR},{SIMILAR_ROW_CATEGORY},{SIMILAR_ROW_DATE}
Order=1
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$relev = $cfg['plugin']['similar']['relev'];
$limit = $cfg['plugin']['similar']['max_sim'];

$title = preg_replace('#[^\p{L}0-9\-_ ]#u', ' ', $pag['page_title']);

require_once sed_langfile('similar');

$t1 = new XTemplate(sed_skinfile('similar', true));

$l3 = $limit * 3;
$sql_sim = sed_sql_query("SELECT p.page_id, p.page_alias, p.page_title, p.page_ownerid, p.page_cat, p.page_date,
		p.page_desc, u.user_name
	FROM $db_pages AS p LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid
	WHERE (p.page_state='0' OR p.page_state='2') AND p.page_id != {$pag['page_id']}
		AND MATCH (page_title) AGAINST ('$title')>$relev LIMIT $l3");
if (sed_sql_numrows($sql_sim) > 0)
{
	$samesubcat = array();
	$samecat = array();
	$samesite = array();
	while($row = sed_sql_fetcharray($sql_sim))
	{
		if($row['page_cat'] == $pag['page_cat'])
			$samesubcat[] = $row;
		elseif(strstr($sed_cat[$pag['page_cat']]['path'], $row['page_cat']))
			$samecat[] = $row;
		else
			$samesite[] = $row;
	}
	$i=1;
	$j = 0;
	$k = 1;
	while ($i <= $limit)
	{
		if($k == 1 && $j >= count($samesubcat)) { $k = 2; $j = 0; }
		if($k == 2 && $j >= count($samecat)) { $k = 3; $j = 0; }
		if($k == 3 && $j >= count($samesite)) break;
		if($k == 1) $row = $samesubcat[$j]; elseif($k == 2) $row = $samecat[$j]; else $row = $samesite[$j];
		$row['page_pageurl'] = (empty($row['page_alias'])) ? sed_url('page', 'id=' . $row['page_id'])
			: sed_url('page', 'al=' . $row['page_alias']);
		$t1->assign(array(
			'SIMILAR_ROW_NUMBER' => $i,
			'SIMILAR_ROW_URL' => $row['page_pageurl'],
			'SIMILAR_ROW_TITLE' => sed_cutstring($row['page_title'], $cfg['plugin']['similar']['cutstr']),
			'SIMILAR_ROW_AUTHOR' => sed_build_user($row['page_ownerid'], sed_cc($row['user_name'])),
			'SIMILAR_ROW_CATEGORY' => '<a href="'.sed_url('list', 'c='.$row['page_cat']).'">'.sed_cutstring($sed_cat[$row['page_cat']]['title'], $cfg['plugin']['similar']['cutstr']).'</a>',
			'SIMILAR_ROW_DATE' => date($cfg['formatyearmonthday'], $row['page_date'] + $usr['timezone'] * 3600),
			'SIMILAR_ROW_DESC' => htmlspecialchars($row['page_desc'])
		));
		$i++;
		$j++;
		$t1->parse('MAIN.SIMILAR_ROW');
	}
	$t1->parse('MAIN');
	$plugin_out = $t1->text('MAIN');
}
else
{
	$t1->parse('NOTFOUND');
	$plugin_out = $t1->text('NOTFOUND');
}

$t->assign('SIMILAR_PAGES', $plugin_out);

?>