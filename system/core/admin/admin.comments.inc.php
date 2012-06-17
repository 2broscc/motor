<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.comments.inc.php
Version=161
Updated=2012-feb-15
Type=Core.admin
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('comments', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=tools", $L['adm_manage']);
$adminpath[] = array ("admin.php?m=comments", $L['Comments']);
$adminhelp = $L['adm_help_comments'];
$adminmain = "<h2><img src=\"system/img/admin/comments.png\" alt=\"\" /> ".$L['Comments']."</h2>"; 
 
$adminmain .= "<ul><li><a href=\"admin.php?m=config&amp;n=edit&amp;o=core&amp;p=comments\">".$L['Configuration']."</a></li></ul>";

if ($a=='delete')
	{
	sed_check_xg();
	$sql = sed_sql_query("DELETE FROM $db_com WHERE com_id='$id'");
	}

$d = sed_import('d', 'G', 'INT');
if(empty($d)) $d = 0;
$totallines = sed_sql_result(sed_sql_query("SELECT COUNT(*) FROM $db_com"), 0, 0);
$totalpages = ceil($totallines / $cfg['maxrowsperpage']);
$currentpage= ceil ($d / $cfg['maxrowsperpage'])+1;
$pagination = '';

for($i = 1; $i <= $totalpages; $i++)
  {
	$pagination .= ($i == $currentpage) ? ' <span class="pagenav_current">' : ' ';
	$pagination .= '<a href="admin.php?m=comments&d='.(($i-1)*$cfg['maxrowsperpage']).'">'.$i.'</a>';
	$pagination .= ($i == $currentpage) ? '</span> ' : ' ';
	if($i != $totalpages) $pagination .= '|';
  }
 
$sql = sed_sql_query("SELECT * FROM $db_com WHERE 1 ORDER BY com_id DESC LIMIT $d,".$cfg['maxrowsperpage']);

$adminmain .= "<h4>".$L['viewdeleteentries']." :</h4><table class=\"cells\"><tr>";
$adminmain .= "<td style=\"width:40px;\" class=\"coltop\">".$L['Delete']."</td>";
$adminmain .= "<td style=\"width:40px;\" class=\"coltop\">#</td>";
$adminmain .= "<td style=\"width:40px;\" class=\"coltop\">".$L['Code']."</td>";
$adminmain .= "<td class=\"coltop\">".$L['Author']."</td>";
$adminmain .= "<td style=\"width:128px;\" class=\"coltop\">".$L['Date']."</td>";
$adminmain .= "<td class=\"coltop\">".$L['Comment']."</td>";
$adminmain .= "<td style=\"width:64px;\" class=\"coltop\">".$L['Open']."</td></tr>";

$ii = 0;

while ($row = sed_sql_fetchassoc($sql))
	{
	$row['com_text'] = sed_cc(sed_cutstring($row['com_text'], 40));
	$row['com_type'] = substr($row['com_code'], 0, 1);
	$row['com_value'] = substr($row['com_code'], 1);

	switch($row['com_type'])
		{
		case 'p':
			$row['com_url'] = "page.php?id=".$row['com_value']."&comments=1#c".$row['com_id'];
		break;
		
		case 'g':
			$row['com_url'] = 'gallery.php?id='.$row['com_value'].'&comments=1#c'.$row['com_id'];
		break;
		
		case 'u':
			$row['com_url'] = 'users.php?m=details&id='.$row['com_value'].'&comments=1#c'.$row['com_id'];
		break;
		
		case 'v':
			$row['com_url'] = 'polls.php?id='.$row['com_value'].'&comments=1#c'.$row['com_id'];
		break;
		
		default:
			$row['com_url'] = '';
		break;
		}

	$adminmain .= "<tr><td style=\"text-align:center;\">";
	$adminmain .= "<a href=\"admin.php?m=comments&amp;a=delete&amp;id=".$row['com_id']."&amp;".sed_xg()."\">".$out['img_delete']."</a></td>";
	$adminmain .= "<td style=\"text-align:center;\">".$row['com_id']."</td>";
	$adminmain .= "<td style=\"text-align:center;\">".$row['com_code']."</td>";
	$adminmain .= "<td>".$row['com_author']."</td>";
	$adminmain .= "<td style=\"text-align:center;\">".date($cfg['dateformat'], $row['com_date'])."</td>";
	$adminmain .= "<td>".$row['com_text']."</td>";
	$adminmain .= "<td style=\"text-align:center;\"><a href=\"".$row['com_url']."\"><img src=\"system/img/admin/jumpto.png\" alt=\"\" /></a></td></tr>";
	$ii++;
	}
$adminmain .= "<tr><td colspan=\"7\">".$L['Total']." : ".$ii."</td></tr></table>";

$adminmain .= '<div class="paging">'.$pagination.'</div>';

?>
