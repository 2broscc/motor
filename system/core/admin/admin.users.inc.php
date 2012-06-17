<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.users.inc.php
Version=161
Updated=2012-feb-15
Type=Core.admin
Author=Neocrome
Description=Users
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

$g = sed_import('g','G','INT');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('users', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=users", $L['Users']);
$adminmain = "<h2><img src=\"system/img/admin/users.png\" alt=\"\" />".$L['Users']."</h2>";

$adminmain .= "<ul>";
$adminmain .= "<li>".sed_linkif("admin.php?m=config&amp;n=edit&amp;o=core&amp;p=users", $L['Configuration'], sed_auth('admin', 'a', 'A'))."</li>";
$adminmain .= "<li>".sed_linkif("admin.php?m=banlist", $L['Banlist'], sed_auth('users', 'a', 'A'))."</li>";
$adminmain .= "</ul>";

switch($n)
	{
	case 'add':

	$ntitle = sed_import('ntitle','P','TXT');
	$ndesc = sed_import('ndesc','P','TXT');
	$nicon = sed_import('nicon','P','TXT');
	$nalias = sed_import('nalias','P','TXT');
	$nlevel = sed_import('nlevel','P','LVL');
	$nmaxsingle = sed_import('nmaxsingle','P','INT');
	$nmaxtotal = sed_import('nmaxtotal','P','INT');
	$ncopyrightsfrom = sed_import('ncopyrightsfrom','P','INT');
	$ndisabled = sed_import('ndisabled','P','BOL');
	$nhidden = sed_import('nhidden','P','BOL');
	$ntitle = (empty($ntitle)) ? '???' : $ntitle;

	$sql = sed_sql_query("INSERT INTO $db_groups (grp_alias, grp_level, grp_disabled, grp_hidden, grp_title, grp_desc, grp_icon, grp_pfs_maxfile, grp_pfs_maxtotal, grp_ownerid) VALUES ('".sed_sql_prep($nalias)."', ".(int)$nlevel.", ".(int)$ndisabled.", ".(int)$nhidden.", '".sed_sql_prep($ntitle)."', '".sed_sql_prep($ndesc)."', '".sed_sql_prep($nicon)."', ".(int)$nmaxsingle.", ".(int)$nmaxtotal.", ".(int)$usr['id'].")");

	$grp_id = sed_sql_insertid();

	$sql = sed_sql_query("SELECT * FROM $db_auth WHERE auth_groupid='".$ncopyrightsfrom."' order by auth_code ASC, auth_option ASC");

	while ($row = sed_sql_fetchassoc($sql))
		{
		$sql1 = sed_sql_query("INSERT into $db_auth (auth_groupid, auth_code, auth_option, auth_rights, auth_rights_lock, auth_setbyuserid) VALUES (".(int)$grp_id.", '".$row['auth_code']."', '".$row['auth_option']."', ".(int)$row['auth_rights'].", 0, ".(int)$usr['id'].")");
		}

	sed_auth_reorder();
	sed_cache_clear('sed_groups');
	header("Location: admin.php?m=users");
	exit;
	break;

	case 'edit':

	if ($a=='update')
		{
		$rtitle = sed_import('rtitle','P','TXT');
		$rdesc = sed_import('rdesc','P','TXT');
		$ricon = sed_import('ricon','P','TXT');
		$ralias = sed_import('ralias','P','TXT');
		$rlevel = sed_import('rlevel','P','LVL');
		$rmaxfile = sed_import('rmaxfile','P','INT');
		$rmaxtotal = sed_import('rmaxtotal','P','INT');
		$rdisabled = ($g<6) ? 0 : sed_import('rdisabled','P','BOL');
		$rhidden = ($g==4) ? 0 : sed_import('rhidden','P','BOL');
		$rtitle = sed_sql_prep($rtitle);
	   	$rdesc = sed_sql_prep($rdesc);
	   	$ricon = sed_sql_prep($ricon);
	   	$ralias = sed_sql_prep($ralias);

		$sql = sed_sql_query("UPDATE $db_groups SET grp_title='$rtitle', grp_desc='$rdesc', grp_icon='$ricon', grp_alias='$ralias', grp_level='$rlevel', grp_pfs_maxfile='$rmaxfile', grp_pfs_maxtotal='$rmaxtotal', grp_disabled='$rdisabled', grp_hidden='$rhidden' WHERE grp_id='$g'");

		sed_cache_clear('sed_groups');
		header("Location: admin.php?m=users");
		exit;
		}
	elseif ($a=='delete' && $g>5)
		{
		$sql = sed_sql_query("DELETE FROM $db_groups WHERE grp_id='$g'");
		$sql = sed_sql_query("DELETE FROM $db_auth WHERE auth_groupid='$g'");
		$sql = sed_sql_query("DELETE FROM $db_groups_users WHERE gru_groupid='$g'");
		sed_auth_clear('all');
		sed_cache_clear('sed_groups');
		header("Location: admin.php?m=users");
		exit;
		}

  $sql = sed_sql_query("SELECT * FROM $db_groups WHERE grp_id='$g'");
	sed_die(sed_sql_numrows($sql)==0);
	$row = sed_sql_fetchassoc($sql);

	$sql1 = sed_sql_query("SELECT COUNT(*) FROM $db_groups_users WHERE gru_groupid='$g'");
	$row['grp_memberscount'] = sed_sql_result($sql1, 0, "COUNT(*)");

	$row['grp_title'] = sed_cc($row['grp_title']);
	$row['grp_desc'] = sed_cc($row['grp_desc']);
	$row['grp_icon'] = sed_cc($row['grp_icon']);
	$row['grp_alias'] = sed_cc($row['grp_alias']);

	$adminpath[] = array ("admin.php?m=users&amp;n=edit&amp;g=$g", $row['grp_title']);

	$adminmain .= "<form id=\"editlevel\" action=\"admin.php?m=users&amp;n=edit&amp;a=update&amp;g=$g\" method=\"post\">";
	$adminmain .= "<table class=\"cells\">";
	$adminmain .= "<tr><td>".$L['Group']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"rtitle\" value=\"".$row['grp_title']."\" size=\"40\" maxlength=\"64\" /> ".$L['adm_required']."</td></tr>";
	$adminmain .= "<tr><td>".$L['Description']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"rdesc\" value=\"".$row['grp_desc']."\" size=\"40\" maxlength=\"64\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Icon']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"ricon\" value=\"".$row['grp_icon']."\" size=\"40\" maxlength=\"128\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Alias']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"ralias\" value=\"".$row['grp_alias']."\" size=\"16\" maxlength=\"24\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['adm_maxsizesingle']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"rmaxfile\" value=\"".$row['grp_pfs_maxfile']."\" size=\"16\" maxlength=\"16\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['adm_maxsizeallpfs']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"rmaxtotal\" value=\"".$row['grp_pfs_maxtotal']."\" size=\"16\" maxlength=\"16\" /></td></tr>";


	$adminmain .= "<tr><td>".$L['Enabled']." :</td><td>";

	if ($g>5)
		{
		$adminmain .= (!$row['grp_disabled']) ? "<input type=\"radio\" class=\"radio\" name=\"rdisabled\" value=\"0\" checked=\"checked\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"rdisabled\" value=\"1\" />".$L['No'] : "<input type=\"radio\" class=\"radio\" name=\"rdisabled\" value=\"0\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"rdisabled\" value=\"1\" checked=\"checked\" />".$L['No'];
		}
	else
		{ $adminmain .= $L['Yes']; }
	$adminmain .= "</td></tr>";

	$adminmain .= "<tr><td>".$L['Hidden']." :</td><td>";

	if ($g!=4)
		{
		$adminmain .= ($row['grp_hidden']) ? "<input type=\"radio\" class=\"radio\" name=\"rhidden\" value=\"1\" checked=\"checked\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"rhidden\" value=\"0\" />".$L['No'] : "<input type=\"radio\" class=\"radio\" name=\"rhidden\" value=\"1\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"rhidden\" value=\"0\" checked=\"checked\" />".$L['No'];
		}
	else
		{ $adminmain .= $L['No']; }

	$adminmain .= "</td></tr>";

	$adminmain .= "<tr><td>".$L['Level']." :</td>";
	$adminmain .= "<td><select name=\"rlevel\" size=\"1\">";
		for ($i = 1; $i < 100; $i++)
			{
			$selected = ($i == $row['grp_level']) ? "selected=\"selected\"" : '';
			$adminmain .= "<option value=\"$i\" $selected>".$i."</option>";
			}
		$adminmain .= "</select></td></tr>";

	$adminmain .= "<tr><td>".$L['Rights']." :</td>";
	$adminmain .= "<td><a href=\"admin.php?m=rights&amp;g=$g\"><img src=\"system/img/admin/rights1.png\" alt=\"\" /></a></tr>";

	$adminmain .= ($g>5 && $row['grp_memberscount']==0) ? "<tr><td>".$L['Delete']." :</td><td><a href=\"admin.php?m=users&amp;n=edit&amp;a=delete&amp;g=".$g."&amp;".sed_xg()."\">".$out['img_delete']."</a></td></tr>" : '';
	$adminmain .= "<tr><td colspan=\"2\"><input type=\"submit\" class=\"submit\" value=\"".$L['Update']."\" /></td></tr></table></form>";

	break;

	default:

	$sql = sed_sql_query("SELECT DISTINCT(gru_groupid), COUNT(*) FROM $db_groups_users WHERE 1 GROUP BY gru_groupid");
	while ($row = sed_sql_fetchassoc($sql))
		{ $members[$row['gru_groupid']] = $row['COUNT(*)']; }

	$sql = sed_sql_query("SELECT DISTINCT(user_maingrp), COUNT(*) FROM $db_users WHERE 1 GROUP BY user_maingrp");
	while ($row = sed_sql_fetchassoc($sql))
		{ $members_main[$row['user_maingrp']] = $row['COUNT(*)']; }

	$sql = sed_sql_query("SELECT grp_id, grp_title, grp_disabled, grp_hidden FROM $db_groups WHERE 1 order by grp_level DESC, grp_id DESC");

	$adminmain .= "<table class=\"cells\">";
	$adminmain .= "<tr>";
	$adminmain .= "<td  class=\"coltop\">".$L['Groups']." ".$L['adm_clicktoedit']."</td>";
	$adminmain .= "<td class=\"coltop\" style=\"width:15%;\">".$L['Members']."</td>";
	$adminmain .= "<td class=\"coltop\" style=\"width:15%;\">".$L['Main']."</td>";  
	$adminmain .= "<td class=\"coltop\" style=\"width:12%;\">".$L['Enabled']."</td>";
	$adminmain .= "<td class=\"coltop\" style=\"width:12%;\">".$L['Hidden']."</td>";
	$adminmain .= "<td class=\"coltop\" style=\"width:12%;\">".$L['Rights']."</td>";
	$adminmain .= "</tr>";

	if (sed_sql_numrows($sql)>0)
		{
		while ($row = sed_sql_fetchassoc($sql))
			{
			$row['grp_hidden'] = ($row['grp_hidden']) ? '1' : '0';
			$members[$row['grp_id']] = (empty($members[$row['grp_id']])) ? '0' : $members[$row['grp_id']];
			$adminmain .= "<tr>";
			$adminmain .= "<td><img src=\"system/img/admin/groups.png\" alt=\"\" /> ";
			$adminmain .= "<a href=\"admin.php?m=users&amp;n=edit&amp;g=".$row['grp_id']."\">".sed_cc($row['grp_title'])."</a></td>";
			$adminmain .= "<td style=\"text-align:center;\"><a href=\"users.php?gm=".$row['grp_id']."\">".$members[$row['grp_id']]."</a></td>";
			$adminmain .= "<td style=\"text-align:center;\"><a href=\"users.php?g=".$row['grp_id']."\">".$members_main[$row['grp_id']]."</a></td>";
			$adminmain .= "<td style=\"text-align:center;\">".$sed_yesno[!$row['grp_disabled']]."</td>";
			$adminmain .= "<td style=\"text-align:center;\">".$sed_yesno[$row['grp_hidden']]."</td>";
			$adminmain .= "<td style=\"text-align:center;\"><a href=\"admin.php?m=rights&amp;g=".$row['grp_id']."\"><img src=\"system/img/admin/rights1.png\" alt=\"\" /></a></td>";
			$adminmain .= "</tr>";
			}
		}
	$adminmain .= "</table>";

	$adminmain .= "<h4>".$L['addnewentry']." :</h4>";
	$adminmain .= "<form id=\"addlevel\" action=\"admin.php?m=users&amp;n=add\" method=\"post\">";
	$adminmain .= "<table class=\"cells\">";
	$adminmain .= "<tr><td>".$L['Group']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"ntitle\" value=\"\" size=\"40\" maxlength=\"64\" /> ".$L['adm_required']."</td></tr>";
	$adminmain .= "<tr><td>".$L['Description']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"ndesc\" value=\"\" size=\"40\" maxlength=\"64\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Icon']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"nicon\" value=\"\" size=\"40\" maxlength=\"128\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['Alias']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"nalias\" value=\"\" size=\"16\" maxlength=\"24\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['adm_maxsizesingle']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"nmaxsingle\" value=\"0\" size=\"16\" maxlength=\"16\" /></td></tr>";
	$adminmain .= "<tr><td>".$L['adm_maxsizeallpfs']." :</td>";
	$adminmain .= "<td><input type=\"text\" class=\"text\" name=\"nmaxtotal\" value=\"0\" size=\"16\" maxlength=\"16\" /></td></tr>";

	$adminmain .= "<tr><td>".$L['adm_copyrightsfrom']." :</td>";
	$adminmain .= "<td>".sed_selectbox_groups(4, 'ncopyrightsfrom', array('5'))." ".$L['adm_required']."</td></tr>";

	$adminmain .= "<tr><td>".$L['Level']." :</td>";
	$adminmain .= "<td><select name=\"nlevel\" size=\"1\">";
		for ($i = 1; $i < 100; $i++)
			{ $adminmain .= "<option value=\"$i\" $selected>".$i."</option>"; }
		$adminmain .= "</select></td></tr>";

	$adminmain .= "<tr><td>".$L['Enabled']." :</td><td>";
	$adminmain .= "<input type=\"radio\" class=\"radio\" name=\"ndisabled\" value=\"0\" checked=\"checked\" /> ".$L['Yes'];
	$adminmain .= "<input type=\"radio\" class=\"radio\" name=\"ndisabled\" value=\"1\" /> ".$L['No'];
	$adminmain .= "</td></tr>";

	$adminmain .= "<tr><td>".$L['Hidden']." :</td><td>";
	$adminmain .= "<input type=\"radio\" class=\"radio\" name=\"nhidden\" value=\"1\" /> ".$L['Yes'];
	$adminmain .= "<input type=\"radio\" class=\"radio\" name=\"nhidden\" value=\"0\" checked=\"checked\" /> ".$L['No'];
	$adminmain .= "</td></tr>";

	$adminmain .= "<tr><td colspan=\"2\"><input type=\"submit\" class=\"submit\" value=\"".$L['Add']."\" /></td></tr></table></form>";
	break;
	}

?>