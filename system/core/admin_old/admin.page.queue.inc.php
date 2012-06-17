<?PHP



defined('SED_CODE') || defined('SED_ADMIN') or die ('wrong url');



list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('page', 'any');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=page", $L['Page']);
$adminpath[] = array ("admin.php?m=page&amp;s=queue", $L['adm_valqueue']);
$adminhelp = $L['adm_queues_page'];

$id = sed_import('id','G','INT');

if ($a=='validate') {
	
	sed_check_xg();

	$sql = sed_sql_query("SELECT page_cat FROM $db_pages WHERE page_id='$id'");
	
	if ($row = sed_sql_fetcharray($sql)) {

	$usr['isadmin_local'] = sed_auth('page', $row['page_cat'], 'A');
		
		sed_block($usr['isadmin_local']);
		$sql = sed_sql_query("UPDATE $db_pages SET page_state=0 WHERE page_id='$id'");
		sed_cache_clear('latestpages');
		header("Location: admin.php?m=page&s=queue");
		
		exit;
	}
	
	else { sed_die(); }
	
}

if ($a=='unvalidate') {
	
	sed_check_xg();
	$sql = sed_sql_query("SELECT page_cat FROM $db_pages WHERE page_id='$id'");
	
	if ($row = sed_sql_fetcharray($sql))  {
		
		$usr['isadmin_local'] = sed_auth('page', $row['page_cat'], 'A');
		sed_block($usr['isadmin_local']);
		$sql = sed_sql_query("UPDATE $db_pages SET page_state=1 WHERE page_id='$id'");
		sed_cache_clear('latestpages');
		header("Location: list.php?c=".$row['page_cat']);
		exit;
	
	}
	
	else { sed_die(); }
	
}

$sql = sed_sql_query("SELECT p.*, u.user_name 
	FROM $db_pages as p 
	LEFT JOIN $db_users AS u ON u.user_id=p.page_ownerid 
	WHERE page_state=1 ORDER by page_id DESC");

$adminmain .= "";

while ($row = sed_sql_fetcharray($sql))
	{
	//queue imgs.
	$go = "<img src=\"skins/ice/img/icons/ad_queue_accept.png\"/>";
	$edit = "<img src=\"skins/ice/img/icons/ad_queue_edit.png\"/>";
	
	$adminmenu .= "<div id=\"page_light\">";
	
	$adminmenu .= "<div style=\"padding-top:3px;padding-left:12px;padding-right:12px;\" >";
	$adminmenu .= "<div class=\"block_queue\">";
	$adminmenu .= "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" height=\"85\">";
	$adminmenu .= "<tr>";
	$adminmenu .= "<td width=\"115\"><img src=\"".$row['page_desc']."\"  width=\"114px\" heght=\"84px\"   /></td>";
	$adminmenu .= "<td>";
	$adminmenu .= "<div id=\"page_title\"> <a href=\"page.php?id=".$row['page_id']."\">".sed_cc($row['page_title'])."</a>  </div>";
	$adminmenu .= "<div id=\"page_subtitle\">";
	$adminmenu .= "<p><img border=\"0\" src=\"skins/{PHP.skin}/img/icons/page_sendin.png\">Oldal azonosító: #".$row['page_id']."</p>";
	$adminmenu .= "<p><img border=\"0\" src=\"skins/{PHP.skin}/img/icons/page_author.png\">Hozzáadta: ".$row['page_ownerid']." - ".$row['user_name']."</p>";
	$adminmenu .= "<p><img border=\"0\" src=\"skins/{PHP.skin}/img/icons/page_date.png\">Dátum: ".date($cfg['dateformat'], $row['page_date'] + $usr['timezone'] * 3600)."</p>";
	$adminmenu .= "</div>";
	$adminmenu .= "</div>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Category']." : ".$sed_cat[$row['page_cat']]['title']." (".$row["page_cat"].")<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Author']." : ".sed_cc($row['page_author'])."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['File']." : ".$sed_yesno[$row['page_file']]."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['URL']." : ".$row['page_url']."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Size']." : ".$row['page_size']."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Key']." : ".sed_cc($row['page_key'])."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Alias']." : ".sed_cc($row['page_alias'])."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Extrafield']." #1 : ".sed_cc($row['page_extra1'])."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Extrafield']." #2 : ".sed_cc($row['page_extra2'])."<br /></td></tr>";
	$adminmenu .= "<tr><td colspan=\"0\">".$L['Extrafield']." #3 : ".sed_cc($row['page_extra3'])."<br /></td></tr>";
	
		$adminmenu .= "<tr><td colspan=\"0\"><p style=\"padding-top:5px;\"></td></tr>";
			$adminmenu .= "<tr><td colspan=\"0\"><hr></td></tr>";
				$adminmenu .= "<tr><td colspan=\"0\"><p style=\"padding-top:5px;\"></td></tr>";
					$adminmenu .= "<tr><td colspan=\"0\">$go<a href=\"admin.php?m=page&amp;s=queue&amp;a=validate&amp;id=".$row['page_id']."&amp;".sed_xg()."\">".$L['Validate']."</a>&nbsp; $edit<a href=\"page.php?m=edit&amp;id=".$row["page_id"]."&amp;r=adm\">".$L['Edit']."</a></td></tr>";
	
	$adminmenu .= "</td>";
	$adminmenu .= "</tr>";
	$adminmenu .= "</table>";
	$adminmenu .= "</div>";
	$adminmenu .= "</div>";
	
	$adminmenu .= "</div>";
	
	}
	
$adminmain .= "";

$adminmain .= (sed_sql_numrows($sql)==0) ? "<p>".$L['None']."</p>" : '';

?>
