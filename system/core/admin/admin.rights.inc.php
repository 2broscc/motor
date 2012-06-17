<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.rights.inc.php
Version=161
Updated=2012-feb-15
Type=Core.admin
Author=Neocrome
Description=Rights
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }


$g = sed_import('g','G','INT');
$advanced = sed_import('advanced','G','BOL');
$adminpath[] = array ("admin.php?m=rights&amp;g=".$g, $L['Rights']." : ".$sed_groups[$g]['title']);
$adminmain = "<h2><img src=\"system/img/admin/rights1.png\" alt=\"\" /> ".$L['Rights']." : ".$sed_groups[$g]['title']."</h2>";

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('users', 'a');
sed_block($usr['isadmin']);

$L['adm_code']['admin'] = $L['Administration'];
$L['adm_code']['comments'] = $L['Comments'];
$L['adm_code']['forums'] = $L['Forums'];
$L['adm_code']['index'] = $L['Home'];
$L['adm_code']['message'] = $L['Messages'];
$L['adm_code']['page'] = $L['Pages'];
$L['adm_code']['pfs'] = $L['PFS'];
$L['adm_code']['gallery'] = $L['Gallery'];
$L['adm_code']['plug'] = $L['Plugins'];
$L['adm_code']['pm'] = $L['Private_Messages'];
$L['adm_code']['polls'] = $L['Polls'];
$L['adm_code']['ratings'] = $L['Ratings'];
$L['adm_code']['users'] = $L['Users'];

if ($a=='update')
	{
	$ncopyrightsconf =  sed_import('ncopyrightsconf','P','BOL');
	$ncopyrightsfrom =  sed_import('ncopyrightsfrom','P','INT');

	if ($ncopyrightsconf && !empty($sed_groups[$ncopyrightsfrom]['title']) && $g>5)
		{
		$sql = sed_sql_query("SELECT * FROM $db_auth WHERE auth_groupid='".$ncopyrightsfrom."' order by auth_code ASC, auth_option ASC");
		if (sed_sql_numrows($sql)>0)
			{
			$sql1 = sed_sql_query("DELETE FROM $db_auth WHERE auth_groupid='".$g."'");

			while ($row = sed_sql_fetchassoc($sql))
				{
				$sql1 = sed_sql_query("INSERT into $db_auth (auth_groupid, auth_code, auth_option, auth_rights, auth_rights_lock, auth_setbyuserid) VALUES (".(int)$g.", '".$row['auth_code']."', '".$row['auth_option']."', ".(int)$row['auth_rights'].", 0, ".(int)$usr['id'].")");
				}
			}
		sed_auth_reorder();
		sed_auth_clear('all');
		header("Location: admin.php?m=rights&g=".$g);
		exit;
		}
	elseif (is_array($_POST['auth']))
		{
		$mask = array();
		$auth = sed_import('auth', 'P', 'ARR');

		$sql = sed_sql_query("UPDATE $db_auth SET auth_rights=0 WHERE auth_groupid='$g'");

		foreach($auth as $k => $v)
			{
			foreach($v as $i => $j)
				{
				if (is_array($j))
					{
					$mask =0;
					foreach($j as $l => $m)
						{ $mask +=  sed_auth_getvalue($l); }
					$sql = sed_sql_query("UPDATE $db_auth SET auth_rights='$mask' WHERE auth_groupid='$g' AND auth_code='$k' AND auth_option='$i'");
					}
				}
			}
		sed_auth_reorder();
		sed_auth_clear('all');
		header("Location: admin.php?m=rights&g=".$g);
		exit;
		}
	}

$jj=1;

/* === Hook for the plugins === */
$extp = sed_getextplugins('admin.rights.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$sql1 = sed_sql_query("SELECT a.*, u.user_name FROM $db_auth as a
	LEFT JOIN $db_users AS u ON u.user_id=a.auth_setbyuserid
	WHERE auth_groupid='$g' AND auth_code IN ('admin', 'comments', 'index', 'message', 'pfs', 'gallery', 'polls', 'pm', 'ratings', 'users')
	ORDER BY auth_code ASC");
	
sed_die(sed_sql_numrows($sql1)==0);

$sql2 = sed_sql_query("SELECT a.*, u.user_name, f.fs_id, f.fs_title, f.fs_category FROM $db_auth as a
	LEFT JOIN $db_users AS u ON u.user_id=a.auth_setbyuserid
	LEFT JOIN $db_forum_sections AS f ON f.fs_id=a.auth_option
	LEFT JOIN $db_forum_structure AS n ON n.fn_code=f.fs_category
	WHERE auth_groupid='$g' AND auth_code='forums'
	ORDER BY fn_path ASC, fs_order ASC, fs_title ASC");
$sql3 = sed_sql_query("SELECT a.*, u.user_name, s.structure_path FROM $db_auth as a
	LEFT JOIN $db_users AS u ON u.user_id=a.auth_setbyuserid
	LEFT JOIN $db_structure AS s ON s.structure_code=a.auth_option
	WHERE auth_groupid='$g' AND auth_code='page'
	ORDER BY structure_path ASC");
$sql4 = sed_sql_query("SELECT a.*, u.user_name FROM $db_auth as a
	LEFT JOIN $db_users AS u ON u.user_id=a.auth_setbyuserid
	WHERE auth_groupid='$g' AND auth_code='plug'
	ORDER BY auth_option ASC");



$adv_columns = ($advanced) ? 5 : 0;

$legend = "<img src=\"system/img/admin/auth_r.gif\" alt=\"\" /> : ".$L['Read']."<br />";
$legend .= "<img src=\"system/img/admin/auth_w.gif\" alt=\"\" /> : ".$L['Write']."<br />";
$legend .= ($advanced) ? "<img src=\"system/img/admin/auth_1.gif\" alt=\"\" /> : ".$L['Custom']." #1<br />" : '';
$legend .= ($advanced) ? "<img src=\"system/img/admin/auth_2.gif\" alt=\"\" /> : ".$L['Custom']." #2<br />" : '';
$legend .= ($advanced) ? "<img src=\"system/img/admin/auth_3.gif\" alt=\"\" /> : ".$L['Custom']." #3<br />" : '';
$legend .= ($advanced) ? "<img src=\"system/img/admin/auth_4.gif\" alt=\"\" /> : ".$L['Custom']." #4<br />" : '';
$legend .= ($advanced) ? "<img src=\"system/img/admin/auth_5.gif\" alt=\"\" /> : ".$L['Custom']." #5<br />" : '';
$legend .= "<img src=\"system/img/admin/auth_a.gif\" alt=\"\" /> : ".$L['Administration'];

$headcol .= "<td class=\"coltop\" rowspan=\"2\">".$L['Section']."</td>";
$headcol .= "<td class=\"coltop\" style=\"width:128px;\" rowspan=\"2\">".$L['adm_rightspergroup']."</td>";
$headcol .= "<td class=\"coltop\" style=\"width:80px;\" colspan=\"".(3+$adv_columns)."\">".$L['Rights']."</td>";
$headcol .= "<td class=\"coltop\" style=\"width:80px;\" rowspan=\"2\">".$L['adm_setby']."</td>";
$headcol .= "</tr>";

$headcol .= "<tr>\n";
$headcol .= "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_r.gif\" alt=\"\" /></td>\n";
$headcol .= "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_w.gif\" alt=\"\" /></td>\n";
$headcol .= ($advanced) ? "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_1.gif\" alt=\"\" /></td>\n" : '';
$headcol .= ($advanced) ? "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_2.gif\" alt=\"\" /></td>\n" : '';
$headcol .= ($advanced) ? "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_3.gif\" alt=\"\" /></td>\n" : '';
$headcol .= ($advanced) ? "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_4.gif\" alt=\"\" /></td>\n" : '';
$headcol .= ($advanced) ? "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_5.gif\" alt=\"\" /></td>\n" : '';
$headcol .= "<td style=\"width:24px;\" class=\"coltop\"><img src=\"system/img/admin/auth_a.gif\" alt=\"\" /></td>\n";
$headcol .= "</tr>\n";

$adminmain .= "<form id=\"saverights\" action=\"admin.php?m=rights&amp;a=update&amp;g=$g\" method=\"post\">";
$adminmain .= "<table class=\"cells\">";

if ($g>5)
	{
	$adminmain .= "<tr><td class=\"coltop\" colspan=\"".(6+$adv_columns)."\" style=\"text-align:right;\">";
	$adminmain .= "<input type=\"checkbox\" class=\"checkbox\" name=\"ncopyrightsconf\" /> ";
	$adminmain .= $L['adm_copyrightsfrom']." : ".sed_selectbox_groups(4, 'ncopyrightsfrom', array('5', $g));
	$adminmain .= " &nbsp; <input type=\"submit\" class=\"submit\" value=\"".$L['Update']."\" /></td></tr>";
	$adminmain .= "<tr>";
	}

function sed_rights_parseline($row, $title, $link)
	{
	global $L, $allow_img, $advanced;

	$mn['R'] = 1;
	$mn['W'] = 2;

	if ($advanced)
		{
		$mn['1'] = 4;
		$mn['2'] = 8;
		$mn['3'] = 16;
		$mn['4'] = 32;
		$mn['5'] = 64;
		}
	$mn['A'] = 128;

	foreach ($mn as $code => $value)
		{
		$state[$code] = (($row['auth_rights'] & $value) == $value) ? TRUE : FALSE;
		$locked[$code] = (($row['auth_rights_lock'] & $value) == $value) ? TRUE : FALSE;
		$checked[$code] = ($state[$code]) ? "checked=\"checked\"" : '';
		$disabled[$code] = ($locked[$code]) ? "disabled=\"disabled\"" : '';

		if ($locked[$code])
			{
			$box[$code] = ($checked[$code]) ? "<input type=\"hidden\" name=\"auth[".$row['auth_code']."][".$row['auth_option']."][".$code."]\" value=\"1\" />" : '';
			$box[$code] .= ($checked[$code]) ? "<img src=\"system/img/admin/discheck1.gif\" alt=\"\" />" : "<img src=\"system/img/admin/discheck0.gif\" alt=\"\" />";
			}
		else
			{
			$box[$code] = "<input type=\"checkbox\" class=\"checkbox\" name=\"auth[".$row['auth_code']."][".$row['auth_option']."][".$code."]\" ".$disabled[$code]." ".$checked[$code]." />";
			}
		}

	$res .= "<tr>\n";
	$res .= "<td style=\"padding:1px;\">\n";
	$res .= "<img src=\"system/img/admin/".$row['auth_code'].".png\" alt=\"\" /> ";
	$res .= "<a href=\"$link\">".$title."</a></td>\n";
	$res .= "<td style=\"text-align:center; padding:2px;\"><a href=\"admin.php?m=rightsbyitem&amp;ic=".$row['auth_code']."&amp;io=".$row['auth_option']."\"><img src=\"system/img/admin/rights2.png\" alt=\"\" /></a></td>";
	$res .= "<td style=\"text-align:center; padding:2px;\">".implode("</td><td style=\"text-align:center; padding:2px;\">", $box)."</td>\n";
	$res .= "<td style=\"text-align:center; padding:2px;\">".sed_build_user($row['auth_setbyuserid'], sed_cc($row['user_name']))."</td>\n";
	$res .= "</tr>\n";

	return($res);
	}

$adminmain .= "<h3><img src=\"system/img/admin/admin.png\" alt=\"\" /> ".$L['Core']." :</h3>\n";
$adminmain .= "<table class=\"cells\">";
$adminmain .= $headcol;

while ($row = sed_sql_fetchassoc($sql1))
	{
	$link = "admin.php?m=".$row['auth_code'];
	$title = $L['adm_code'][$row['auth_code']];
	$adminmain .= sed_rights_parseline($row, $title, $link);
	}

$adminmain .= "</table>";
$adminmain .= "<h3><img src=\"system/img/admin/forums.png\" alt=\"\" /> ".$L['Forums']." :</h3>";
$adminmain .= "<table class=\"cells\">";
$adminmain .= $headcol;

while ($row = sed_sql_fetchassoc($sql2))
	{
	$link = "admin.php?m=forums&amp;n=edit&amp;id=".$row['auth_option'];
	$title = sed_cc(sed_build_forums($row['fs_id'], sed_cutstring($row['fs_title'],24), sed_cutstring($row['fs_category'],32), FALSE));
	$adminmain .= sed_rights_parseline($row, $title, $link);
	}

$adminmain .= "</table>";
$adminmain .= "<h3><img src=\"system/img/admin/page.png\" alt=\"\" /> ".$L['Pages']." :</h3>";
$adminmain .= "<table class=\"cells\">";
$adminmain .= $headcol;

while ($row = sed_sql_fetcharray($sql3))
	{
	$link = "admin.php?m=page";
	$title = $sed_cat[$row['auth_option']]['tpath'];
	$adminmain .= sed_rights_parseline($row, $title, $link);
	}

$adminmain .= "</table>";
$adminmain .= "<h3><img src=\"system/img/admin/plugins.png\" alt=\"\" /> ".$L['Plugins']." :</h3>";
$adminmain .= "<table class=\"cells\">";
$adminmain .= $headcol;

while ($row = sed_sql_fetcharray($sql4))
	{
	$link = "admin.php?m=plug&amp;a=details&amp;pl=".$row['auth_option'];
	$title = $L['Plugin']." : ".$row['auth_option'];
	$adminmain .= sed_rights_parseline($row, $title, $link);
	}

/* === Hook for the plugins === */
$extp = sed_getextplugins('admin.rights.end');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$adminmain .= "<tr><td colspan=\"".(6+$adv_columns)."\" style=\"text-align:center;\"><input type=\"submit\" class=\"submit\" value=\"".$L['Update']."\" /></td></tr>";
$adminmain .= "</table></form>";

$adminhelp = $legend;

?>