<?PHP

/*

Filename: mailer.inc.php
CMS Framework based on Seditio v121  www.neocrome.net
Re-programmed by 2bros cc
Date:02-02-2011
Programmer: Peter Magyar
Email:magyar.peter1@gmail.com

*/

if (!defined('SED_CODE')) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('pm', 'a');
sed_block($usr['auth_read']);

$id = sed_import('id','G','INT');
$f = sed_import('f','G','ALP');
$to = sed_import('to','G','TXT');
$q = sed_import('q','G','INT');
$d = sed_import('d','G','INT');

unset ($touser, $pm_editbox);
$totalrecipients = 0;
$touser_all =array();
$touser_sql = array();
$touser_ids = array();
$touser_names = array();

/* === Hook === */
$extp = sed_getextplugins('mailer.first');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pm WHERE pm_touserid='".$usr['id']."' AND pm_state=2");
$totalarchives = sed_sql_result($sql, 0, "COUNT(*)");
$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pm WHERE pm_fromuserid='".$usr['id']."' AND pm_state=0");
$totalsentbox = sed_sql_result($sql, 0, "COUNT(*)");
$sql = sed_sql_query("SELECT COUNT(*) FROM $db_pm WHERE pm_touserid='".$usr['id']."' AND pm_state<2");
$totalinbox = sed_sql_result($sql, 0, "COUNT(*)");

if (empty($d)) { $d = '0'; }
unset($pageprev, $pagenext);

if (!empty($id)) // -------------- Single mode
	{
	unset($mode);
	$sql1 = sed_sql_query("SELECT pm_touserid, pm_fromuserid, pm_state FROM $db_pm WHERE pm_id='".$id."'");
	sed_die(sed_sql_numrows($sql1)==0);
	$row1 = sed_sql_fetcharray($sql1);

	$title = "<a href=\"mailer.php\">".$L['Private_Messages']."</a> ".$cfg['separator'];

	if ($row1['pm_touserid']==$usr['id'] && $row1['pm_state']==2)
		{
		$f = 'archives';
		$title .= " <a href=\"mailer.php?f=archives\">".$L['pm_archives']."</a>";
		$subtitle = '';
		}
	elseif ($row1['pm_touserid']==$usr['id'] && $row1['pm_state']<2)
		{
		$f = 'inbox';
		$title .= " <a href=\"mailer.php?f=inbox\">".$L['pm_inbox']."</a>";
		$subtitle = '';

		if ($row1['pm_state']==0)
			{
			$sql1 = sed_sql_query("UPDATE $db_pm SET pm_state=1 WHERE pm_touserid='".$usr['id']."' AND pm_id='".$id."'");
			$sql1 = sed_sql_query("SELECT COUNT(*) FROM $db_pm WHERE pm_touserid='".$usr['id']."' AND pm_state=0");
			$notread = sed_sql_result($sql1,0,'COUNT(*)');
			if ($notread==0)	
				{ $sql = sed_sql_query("UPDATE $db_users SET user_newpm=0 WHERE user_id='".$usr['id']."'"); }
			}
		}
	elseif ($row1['pm_fromuserid']==$usr['id'] && $row1['pm_state']==0)
		{
		$f = 'sentbox';
		$title .= " <a href=\"mailer.php?f=sentbox\">".$L['pm_sentbox']."</a>";
		$subtitle = '';
		}
	else
		{
		sed_die();
		}

	$title .= ' '.$cfg['separator']." <a href=\"mailer.php?id=".$id."\">#".$id."</a>";
	$sql = sed_sql_query("SELECT *, u.user_name FROM $db_pm AS p LEFT JOIN $db_users AS u ON u.user_id=p.pm_touserid WHERE pm_id='".$id."'");
	}

else // --------------- List mode

	{
	unset($id);

	$title = "<a href=\"mailer.php\">".$L['Private_Messages']."</a> ".$cfg['separator'];

	if ($f=='archives')
		{
		$totallines = $totalarchives;
		$sql = sed_sql_query("SELECT * FROM $db_pm
			WHERE pm_touserid='".$usr['id']."' AND pm_state=2
			ORDER BY pm_date DESC LIMIT $d,".$cfg['maxrowsperpage']);
       	$title .= " <a href=\"mailer.php?f=archives\">".$L['pm_archives']."</a>";
       	$subtitle = $L['pm_arcsubtitle'];
		}
	elseif ($f=='sentbox')
		{
    	$totallines = $totalsentbox;
    	$sql = sed_sql_query("SELECT p.*, u.user_name FROM $db_pm p, $db_users u
       		WHERE p.pm_fromuserid='".$usr['id']."' AND p.pm_state=0 AND u.user_id=p.pm_touserid
			ORDER BY pm_date DESC LIMIT $d,".$cfg['maxrowsperpage']);
		$title .= " <a href=\"mailer.php?f=sentbox\">".$L['pm_sentbox']."</a>";
		$subtitle = $L['pm_sentboxsubtitle'];
     	}
	else
     	{
     	$f = 'inbox';
  		$totallines = $totalinbox;
		$sql = sed_sql_query("SELECT * FROM $db_pm
			WHERE pm_touserid='".$usr['id']."' AND pm_state<2
			ORDER BY pm_date DESC LIMIT  $d,".$cfg['maxrowsperpage']);
		$title .= " <a href=\"mailer.php\">".$L['pm_inbox']."</a>";
		$subtitle = $L['pm_inboxsubtitle'];
      }

	$pm_totalpages = ceil($totallines / $cfg['maxrowsperpage']);
	$pm_currentpage = ceil ($d / $cfg['maxrowsperpage'])+1;

	if ($d>0)
		{
		$prevpage = $d - $cfg['maxrowsperpage'];
		if ($prevpage < 0)
	   	{ $prevpage=0; }
		$pm_pageprev = "<a href=\"mailer.php?f=$f&amp;d=$prevpage\">".$L['Previous']." $sed_img_left</a>";
		}

	if (($d + $cfg['maxrowsperpage']) < $totallines)
		{
		$nextpage = $d + $cfg['maxrowsperpage'];
		$pm_pagenext = "<a href=\"mailer.php?f=$f&amp;d=$nextpage\">$sed_img_right ".$L['Next']."</a>";
		}
	}

$out['subtitle'] = $L['Private_Messages'];

/* === Hook === */
$extp = sed_getextplugins('pm.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$pm_sendlink = ($usr['auth_write']) ? "<a href=\"mailer.php?m=send\">".$L['pm_sendnew']."</a>" : '';

require("system/header.php");
$t = new XTemplate("$user_skin_dir/".$skin."/pm.tpl");

if ($pm_totalpages=='0') {$pm_totalpages = '1'; }

$t-> assign(array(
	"PM_PAGETITLE" => $title,
	"PM_SUBTITLE" => $subtitle,
	"PM_SENDNEWPM" => $pm_sendlink,
	"PM_INBOX" => "<a href=\"mailer.php\">".$L['pm_inbox']."</a>:".$totalinbox,
	"PM_ARCHIVES" => "<a href=\"mailer.php?f=archives\">".$L['pm_archives']."</a>:".$totalarchives,
	"PM_SENTBOX" => "<a href=\"mailer.php?f=sentbox\">".$L['pm_sentbox']."</a>:".$totalsentbox,
	"PM_TOP_PAGEPREV" => $pm_pageprev,
	"PM_TOP_PAGENEXT" => $pm_pagenext,
	"PM_TOP_CURRENTPAGE" => $pm_currentpage,
	"PM_TOP_TOTALPAGES" => $pm_totalpages,
		));

$jj=0;

/* === Hook - Part1 : Set === */
$extp = sed_getextplugins('pm.loop');
/* ===== */

while ($row = sed_sql_fetcharray($sql) and ($jj<$cfg['maxrowsperpage']))
	{
	$jj++;
	$row['pm_icon_status'] = ($row['pm_state']=='0' && $f!='sentbox') ? "<a href=\"mailer.php?id=".$row['pm_id']."\"><img src=\"skins/".$skin."/img/system/icon-pm-new.gif\" alt=\"\" /></a>" : "<a href=\"mailer.php?id=".$row['pm_id']."\"><img src=\"skins/".$skin."/img/system/icon-pm.gif\" alt=\"\" /></a>";

	if ($f=='sentbox')
		{
		$pm_fromuserid = $usr['id'];
		$pm_fromuser = sed_cc($usr['name']);
		$pm_touserid = $row['pm_touserid'];
		$pm_touser = sed_cc($row['user_name']);
		$pm_fromortouser = sed_build_user($pm_touserid, $pm_touser);
		$row['pm_icon_action'] = "<a href=\"mailer.php?m=edit&amp;a=delete&amp;".sed_xg()."&amp;id=".$row['pm_id']."&amp;f=".$f."\"><img src=\"skins/".$skin."/img/system/icon-pm-trashcan.gif\" alt=\"".$L['Delete']."\" /></a>";

		if (!empty($id))
			{
			$pm_editbox = "<h4>".$L['Edit']." :</h4>";
			$pm_editbox .= "<form id=\"newlink\" action=\"mailer.php?m=edit&amp;a=update&amp;".sed_xg()."&amp;id=".$id."\" method=\"post\">";
			$pm_editbox .= "<textarea name=\"newpmtext\" rows=\"8\" cols=\"56\">".sed_cc($row['pm_text'])."</textarea>";
			$pm_editbox .= "<br />&nbsp;<br /><input type=\"submit\" class=\"submit\" value=\"".$L['Update']."\" /></form>";
			}
		}
	elseif ($f=='archives')
		{
		$pm_fromuserid = $row['pm_fromuserid'];
		$pm_fromuser = sed_cc($row['pm_fromuser']);
		$pm_touserid = $usr['id'];
		$pm_touser = sed_cc($usr['name']);
		$pm_fromortouser = sed_build_user($pm_fromuserid, $pm_fromuser);
		$row['pm_icon_action'] = "<a href=\"mailer.php?m=send&amp;to=".$row['pm_fromuserid']."&amp;q=".$row['pm_id']."\"><img src=\"skins/".$skin."/img/system/icon-pm-reply.gif\" alt=\"".$L['pm_replyto']."\" /></a> <a href=\"mailer.php?m=edit&amp;a=delete&amp;".sed_xg()."&amp;id=".$row['pm_id']."&amp;f=".$f."\"><img src=\"skins/".$skin."/img/system/icon-pm-trashcan.gif\" alt=\"".$L['Delete']."\" /></a>";
		}
	else
		{
		$pm_fromuserid = $row['pm_fromuserid'];
		$pm_fromuser = sed_cc($row['pm_fromuser']);
		$pm_touserid = $usr['id'];
		$pm_touser = sed_cc($usr['name']);
		$pm_fromortouser = sed_build_user($pm_fromuserid, $pm_fromuser);
		$row['pm_icon_action'] = "<a href=\"mailer.php?m=send&amp;to=".$row['pm_fromuserid']."&amp;q=".$row['pm_id']."\"><img src=\"skins/".$skin."/img/system/icon-pm-reply.gif\" alt=\"".$L['pm_replyto']."\" /></a> <a href=\"mailer.php?m=edit&amp;a=archive&amp;".sed_xg()."&amp;id=".$row['pm_id']."\"><img src=\"skins/".$skin."/img/system/icon-pm-archive.gif\" alt=\"".$L['pm_putinarchives']."\" /></a>";
		$row['pm_icon_action'] .= ($row['pm_state']>0) ? " <a href=\"mailer.php?m=edit&amp;a=delete&amp;".sed_xg()."&amp;id=".$row['pm_id']."&amp;f=".$f."\"><img src=\"skins/".$skin."/img/system/icon-pm-trashcan.gif\" alt=\"".$L['Delete']."\" /></a>" : '';
		}

	$t-> assign(array(
		"PM_ROW_ID" => $row['pm_id'],
		"PM_ROW_STATE" => $row['pm_state'],
		"PM_ROW_DATE" => @date($cfg['dateformat'], $row['pm_date'] + $usr['timezone'] * 3600),
		"PM_ROW_FROMUSERID" => $pm_fromuserid,
		"PM_ROW_FROMUSER" => sed_build_user($pm_fromuserid, $pm_fromuser),
		"PM_ROW_TOUSERID" => $pm_touserid,
		"PM_ROW_TOUSER" => sed_build_user($pm_touserid, $pm_touser),
		"PM_ROW_TITLE" => "<a href=\"mailer.php?id=".$row['pm_id']."\">".sed_cc($row['pm_title'])."</a>",
		"PM_ROW_TEXT" => sed_parse(sed_cc($row['pm_text']), $cfg['parsebbcodecom'], $cfg['parsesmiliescom'], 1).$pm_editbox,
		"PM_ROW_TEXTBOXER" => sed_parse(sed_cc($row['pm_text']), $cfg['parsebbcodecom'], $cfg['parsesmiliescom'], 1).$pm_editbox,
		"PM_ROW_FROMORTOUSER" => $pm_fromortouser,
		"PM_ROW_ICON_STATUS" => $row['pm_icon_status'],
		"PM_ROW_ICON_ACTION" => $row['pm_icon_action'],
		"PM_ROW_ODDEVEN" => sed_build_oddeven($jj)
			));

	/* === Hook - Part2 : Include === */
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	if (empty($id))
		{ $t->parse("MAIN.PM_ROW"); }
       else
       	{ $t->parse("MAIN.PM_DETAILS"); }

       }

if (empty($id))
	{
	if ($f=='sentbox')
		{ $t->parse("MAIN.PM_TITLE_SENTBOX"); }
       else
       	{ $t->parse("MAIN.PM_TITLE"); }

	if ($jj==0)
		{ $t->parse("MAIN.PM_ROW_EMPTY"); }

	$t->parse("MAIN.PM_FOOTER");
	}

/* === Hook === */
$extp = sed_getextplugins('pm.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>