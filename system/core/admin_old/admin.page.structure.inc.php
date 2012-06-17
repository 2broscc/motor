<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.structure.inc.php
Version=125
Updated=2009-jun-22
Type=Core.admin
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

$id = sed_import('id','G','INT');
$c = sed_import('c','G','TXT');

$adminpath[] = array ("admin.php?m=page", $L['Pages']);
$adminpath[] = array ("admin.php?m=page&amp;s=structure", $L['Structure']);
$adminhelp = $L['adm_help_structure'];

if ($n=='options')
	{
	if ($a=='update')
		{
		$rpath = sed_import('rpath','P','TXT');
		$rtitle = sed_import('rtitle','P','TXT');
		$rtplmode = sed_import('rtplmode','P','INT');
		$rdesc = sed_import('rdesc','P','TXT');
		$ricon = sed_import('ricon','P','TXT');
		$rgroup = sed_import('rgroup','P','BOL');
		$rgroup = ($rgroup) ? 1 : 0;

	if ($rtplmode==1)
		{ $rtpl = ''; }
	elseif ($rtplmode==3)
		{ $rtpl = 'same_as_parent'; }
	else
		{ $rtpl = sed_import('rtplforced','P','ALP'); }

		$sql = sed_sql_query("UPDATE $db_structure SET
			structure_path='".sed_sql_prep($rpath)."',
			structure_tpl='".sed_sql_prep($rtpl)."',
			structure_title='".sed_sql_prep($rtitle)."',
			structure_desc='".sed_sql_prep($rdesc)."',
			structure_icon='".sed_sql_prep($ricon)."',
			structure_group='".$rgroup."'
			WHERE structure_id='".$id."'");

		sed_cache_clear('sed_cat');
		header("Location: admin.php?m=page&s=structure");
		exit;
		}

	$sql = sed_sql_query("SELECT * FROM $db_structure WHERE structure_id='$id' LIMIT 1");
	sed_die(sed_sql_numrows($sql)==0);

	$handle=opendir("skins/".$cfg['defaultskin']."/");
	$allskinfiles = array();

	while ($f = readdir($handle))
		{
		if (($f != ".") && ($f != "..") && strtolower(substr($f, strrpos($f, '.')+1, 4))=='tpl')
			{
			$allskinfiles[] = $f;
			}
		}
	closedir($handle);

	$allskinfiles = implode (',', $allskinfiles);

	$row = sed_sql_fetcharray($sql);

	$structure_id = $row['structure_id'];
	$structure_code = $row['structure_code'];
	$structure_path = $row['structure_path'];
	$structure_title = $row['structure_title'];
	$structure_desc = $row['structure_desc'];
	$structure_icon = $row['structure_icon'];
	$structure_group = $row['structure_group'];

	if (empty($row['structure_tpl']))
		{

		$check1 = " checked=\"checked\"";
		}
	elseif ($row['structure_tpl']=='same_as_parent')
		{
		$structure_tpl_sym = "*";
		$check3 = " checked=\"checked\"";
		}
	else
		{
		$structure_tpl_sym = "+";
		$check2 = " checked=\"checked\"";
		}

	$adminpath[] = array ("admin.php?m=page&amp;s=structure&amp;n=options&amp;id=".$id, sed_cc($structure_title));

	$adminmain .= "<form id=\"savestructure\" action=\"admin.php?m=page&amp;s=structure&amp;n=options&amp;a=update&amp;id=".$structure_id."\" method=\"post\">";
	$adminmain .= "<table class=\"cells\">";
	$adminmain .= "<tr><td>".$L['Code']." :</td>";
	$adminmain .= "<td>".$structure_code."</td></tr>";
	$adminmain .= "<tr><td>".$L['Path']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"rpath\" value=\"".$structure_path."\" size=\"16\" maxlength=\"16\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Title']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"rtitle\" value=\"".$structure_title."\" size=\"64\" maxlength=\"32\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Description']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"rdesc\" value=\"".$structure_desc."\" size=\"64\" maxlength=\"255\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Icon']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"ricon\" value=\"".$structure_icon."\" size=\"64\" maxlength=\"128\" /></td></tr>";
	$checked = $structure_pages ? "checked=\"checked\"" : '';
	$checked = $structure_group ? "checked=\"checked\"" : '';
	$adminmain .= "<tr><td>".$L['Group']." :</td>";
	$adminmain .= "<td><input type=\"checkbox\" class=\"checkbox\" name=\"rgroup\" $checked /></td></tr>";
	$adminmain .= "<tr><td>".$L['adm_tpl_mode']." :</td><td>";
	$adminmain .= "<input type=\"radio\" class=\"radio\" name=\"rtplmode\" value=\"1\" $check1 /> ".$L['adm_tpl_empty']."<br/>";
	$adminmain .= "<input type=\"radio\" class=\"radio\" name=\"rtplmode\" value=\"2\" $check2 /> ".$L['adm_tpl_forced'];
	$adminmain .=  " <select name=\"rtplforced\" size=\"1\">";

	foreach($sed_cat as $i => $x)
		{
		if ($i!='all')
			{
			$selected = ($i==$row['structure_tpl']) ? "selected=\"selected\"" : '';
			$adminmain .= "<option value=\"".$i."\" $selected> ".$x['tpath']."</option>";
			}
		}
	$adminmain .= "</select><br/>";
	$adminmain .= "<input type=\"radio\" class=\"radio\" name=\"rtplmode\" value=\"3\" $check3 /> ".$L['adm_tpl_parent'];
	$adminmain .= "</td></tr>";
	$adminmain .= "<tr><td colspan=\"2\"><input type=\"submit\" class=\"submit\" value=\"".$L['Update']."\" /></td></tr>";
	$adminmain .= "</table></form>";
	}
else
	{
	if ($a=='update')
		{
		$s = sed_import('s', 'P', 'ARR');

		foreach($s as $i => $k)
			{
			$s[$i]['rgroup'] = (isset($s[$i]['rgroup'])) ? 1 : 0;

			$sql1 = sed_sql_query("UPDATE $db_structure SET
				structure_path='".sed_sql_prep($s[$i]['rpath'])."',
				structure_group='".$s[$i]['rgroup']."'
				WHERE structure_id='".$i."'");
			}
		sed_auth_clear('all');
		sed_cache_clear('sed_cat');
		header("Location: admin.php?m=page&s=structure");
		exit;
		}
	elseif ($a=='add')
		{
		$g = array ('ncode','npath', 'ntitle', 'ndesc', 'nicon', 'ngroup');
		foreach($g as $k => $x) $$x = $_POST[$x];
		$group = (isset($group)) ? 1 : 0;
		sed_structure_newcat($ncode, $npath, $ntitle, $ndesc, $nicon, $ngroup);
		header("Location: admin.php?m=page&s=structure");
		exit;
		}
	elseif ($a=='delete')
		{
		sed_check_xg();
		sed_structure_delcat($id, $c);
		header("Location: admin.php?m=page&s=structure");
		exit;
		}

	$sql = sed_sql_query("SELECT DISTINCT(page_cat), COUNT(*) FROM $db_pages WHERE 1 GROUP BY page_cat");

	while ($row = sed_sql_fetcharray($sql))
		{ $pagecount[$row['page_cat']] = $row['COUNT(*)']; }

	$sql = sed_sql_query("SELECT * FROM $db_structure ORDER by structure_path ASC, structure_code ASC");

	$adminmain .= "<h4>".$L['editdeleteentries']." :</h4>";
	$adminmain .= "<form id=\"savestructure\" action=\"admin.php?m=page&amp;s=structure&amp;a=update\" method=\"post\">";
	$adminmain .= "<table class=\"cells\">";
	$adminmain .= "<tr><td class=\"coltop\">".$L['Delete']."</td>";
	$adminmain .= "<td class=\"coltop\">".$L['Code']."</td>";
	$adminmain .= "<td class=\"coltop\">".$L['Title']." ".$L['adm_clicktoedit']."</td>";
	$adminmain .= "<td class=\"coltop\">".$L['Path']."</td>";
	$adminmain .= "<td class=\"coltop\">".$L['TPL']."</td>";
	$adminmain .= "<td class=\"coltop\">".$L['Group']."</td>";
	$adminmain .= "<td class=\"coltop\">".$L['Pages']."</td>";
	$adminmain .= "<td class=\"coltop\">".$L['Rights']."</td>";
	$adminmain .= "</tr>";

	while ($row = sed_sql_fetcharray($sql))
		{
		$jj++;
		$structure_id = $row['structure_id'];
		$structure_code = $row['structure_code'];
		$structure_path = $row['structure_path'];
		$structure_title = $row['structure_title'];
		$structure_desc = $row['structure_desc'];
		$structure_icon = $row['structure_icon'];
		$structure_group = $row['structure_group'];
		$pathfieldlen = (strpos($structure_path, ".")==0) ? 3 : 9;
		$pathfieldimg = (strpos($structure_path, ".")==0) ? '' : "<img src=\"system/img/admin/join2.gif\" alt=\"\" /> ";
		$pagecount[$structure_code] = (!$pagecount[$structure_code]) ? "0" : $pagecount[$structure_code];

		if (empty($row['structure_tpl']))
			{ $structure_tpl_sym = $L['adm_tpl_empty']; }
		elseif ($row['structure_tpl']=='same_as_parent')
			{ $structure_tpl_sym = $L['adm_tpl_parent']; }
		else
			{ $structure_tpl_sym = $L['adm_tpl_forced']." : ".$sed_cat[$row['structure_tpl']]['tpath']; }

		$adminmain .= "<tr><td style=\"text-align:center;\">";
		$adminmain .= ($pagecount[$structure_code]>0) ? '' : "[<a href=\"admin.php?m=page&amp;s=structure&amp;a=delete&amp;id=".$structure_id."&amp;c=".$row['structure_code']."&amp;".sed_xg()."\">x</a>]";
		$adminmain .= "</td>";
		$adminmain .= "<td>".$structure_code."</td>";
		$adminmain .= "<td><a href=\"admin.php?m=page&amp;s=structure&amp;n=options&amp;id=".$structure_id."&amp;".sed_xg()."\">".sed_cc($structure_title)."</a></td>";
		$adminmain .= "<td>$pathfieldimg<input type=\"text\" class=\"text\" name=\"s[$structure_id][rpath]\" value=\"".$structure_path."\" size=\"$pathfieldlen\" maxlength=\"24\" /></td>";
		$adminmain .= "<td>".$structure_tpl_sym."</td>";
		$checked = $structure_group ? "checked=\"checked\"" : '';
		$adminmain .= "<td style=\"text-align:center;\"><input type=\"checkbox\" class=\"checkbox\" name=\"s[$structure_id][rgroup]\" $checked /></td>";
		$adminmain .= "<td style=\"text-align:right;\">".$pagecount[$structure_code]." ";
		$adminmain .= "<a href=\"list.php?c=".$structure_code."\"><img src=\"system/img/admin/jumpto.gif\" alt=\"\" /></a></td>";
		$adminmain .= "<td style=\"text-align:center;\"><a href=\"admin.php?m=rightsbyitem&amp;ic=page&amp;io=".$structure_code."\"><img src=\"system/img/admin/rights2.gif\" alt=\"\" /></a></td>";
		$adminmain .= "</tr>";
		}

	$adminmain .= "<tr><td colspan=\"9\"><input type=\"submit\" class=\"submit\" value=\"".$L['Update']."\" /></td></tr>";
	$adminmain .= "</table></form>";
	$adminmain .= "<h4>".$L['addnewentry']." :</h4>";
	$adminmain .= "<form id=\"addstructure\" action=\"admin.php?m=page&amp;s=structure&amp;a=add\" method=\"post\">";
	$adminmain .= "<table class=\"cells\">";
	$adminmain .= "<tr><td style=\"width:160px;\">".$L['Code']." :</td><td><input type=\"text\" class=\"text\" name=\"ncode\" value=\"\" size=\"16\" maxlength=\"16\" /> ".$L['adm_required']."</td></tr>";
	$adminmain .= "<tr><td>".$L['Path']." :</td><td><input type=\"text\" class=\"text\" name=\"npath\" value=\"\" size=\"16\" maxlength=\"16\" /> ".$L['adm_required']."</td></tr>";
	$adminmain .= "<tr><td>".$L['Title']." :</td><td><input type=\"text\" class=\"text\" name=\"ntitle\" value=\"\" size=\"48\" maxlength=\"32\" /> ".$L['adm_required']."</td></tr>";
	$adminmain .= "<tr><td>".$L['Description']." :</td><td><input type=\"text\" class=\"text\" name=\"ndesc\" value=\"\" size=\"48\" maxlength=\"255\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Icon']." :</td><td><input type=\"text\" class=\"text\" name=\"nicon\" value=\"\" size=\"48\" maxlength=\"128\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Group']." :</td><td><input type=\"checkbox\" class=\"checkbox\" name=\"ngroup\" /></td></tr>";
	$adminmain .= "<tr><td colspan=\"2\"><input type=\"submit\" class=\"submit\" value=\"".$L['Add']."\" /></td></tr></table></form>";
	}

?>