<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=forums.php
Version=120
Updated=2007-jan-16
Type=Core
Author=Neocrome
Description=Forums
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$id = sed_import('id','G','INT');
$s = sed_import('s','G','INT');
$q = sed_import('q','G','INT');
$p = sed_import('p','G','INT');
$d = sed_import('d','G','INT');
$o = sed_import('o','G','ALP');
$w = sed_import('w','G','ALP',4);
$quote = sed_import('quote','G','INT');
$poll = sed_import('poll','G','INT');
$vote = sed_import('vote','G','INT');

/* === Hook === */
$extp = sed_getextplugins('forums.editpost.first');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

sed_blockguests();
sed_check_xg();

$sql = sed_sql_query("SELECT * FROM $db_forum_posts WHERE fp_id='$p' and fp_topicid='$q' and fp_sectionid='$s' LIMIT 1");

if ($row = sed_sql_fetcharray($sql))
	{
	$fp_text = $row['fp_text'];
	$fp_posterid = $row['fp_posterid'];
	$fp_postername = $row['fp_postername'];
	$fp_sectionid = $row['fp_sectionid'];
	$fp_topicid = $row['fp_topicid'];
	$fp_updated = $row['fp_updated'];
	$fp_updater = $row['fp_updater'];

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', $s);

	if (!$usr['isadmin'] && $fp_posterid!=$usr['id'])
		{
		sed_log("Attempt to edit a post without rights", 'sec');
		sed_die();
		}
	sed_block($usr['auth_read']);
	}
else
	{ sed_die(); }

$sql = sed_sql_query("SELECT fs_state, fs_title, fs_category, fs_allowbbcodes, fs_allowsmilies FROM $db_forum_sections WHERE fs_id='$s' LIMIT 1");

if ($row = sed_sql_fetcharray($sql))
	{
	if ($row['fs_state'])
		{
		header("Location: message.php?msg=602");
		exit;
		}

	$fs_title = $row['fs_title'];
	$fs_category = $row['fs_category'];
	$fs_allowbbcodes = $row['fs_allowbbcodes'];
	$fs_allowsmilies = $row['fs_allowsmilies'];
	}
	else
	{ sed_die(); }

$sql = sed_sql_query("SELECT ft_state, ft_mode, ft_title, ft_poll FROM $db_forum_topics WHERE ft_id='$q' LIMIT 1");

if ($row = sed_sql_fetcharray($sql))
	{
	if ($row['ft_state'] && !$usr['isadmin'])
		{
		header("Location: message.php?msg=603");
		exit;
		}
	$ft_title = sed_cc($row['ft_title']);
	$ft_fulltitle = ($row['ft_mode']==1) ? "# ".$ft_title : $ft_title;
	$sys['sublocation'] = 'q'.$q;
	}
else
	{ sed_die(); }

if ($a=='update')
	{
	/* === Hook === */
	$extp = sed_getextplugins('forums.editpost.update.first');
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	$rtext = sed_import('rtext','P','HTM');
	$rtopictitle = sed_import('rtopictitle','P','TXT');
	$rtext = sed_sql_prep($rtext);
	$rupdater = ($fp_posterid == $usr['id'] && ($sys['now_offset'] < $fp_updated + 300) && empty($fp_updater) ) ? '' : $usr['name'];

	$sql = sed_sql_query("UPDATE $db_forum_posts SET fp_text='$rtext', fp_updated='".$sys['now_offset']."', fp_updater='".sed_sql_prep($rupdater)."' WHERE fp_id='$p'");

	if (!empty($rtopictitle) && !empty($rtext))
		{
		$sql = sed_sql_query("SELECT fp_id FROM $db_forum_posts WHERE fp_topicid='$q' ORDER BY fp_id ASC LIMIT 1");
		if ($row = sed_sql_fetcharray($sql))
			{
			$fp_idp = $row['fp_id'];
			if ($fp_idp==$p)
				{
				if (substr($rtopictitle, 0 ,1)=="#")
					{ $rtopictitle = str_replace('#', '', $rtopictitle); }
				$rtopictitle = sed_sql_prep($rtopictitle);
				$sql = sed_sql_query("UPDATE $db_forum_topics SET ft_title='$rtopictitle' WHERE ft_id='$q'");
				}
			}
		}

	/* === Hook === */
	$extp = sed_getextplugins('forums.editpost.update.done');
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	sed_forum_sectionsetlast($fp_sectionid);
	header("Location: forums.php?m=posts&p=$p#$p");
	exit;
	}

$sql = sed_sql_query("SELECT fp_id FROM $db_forum_posts WHERE fp_topicid='$q' ORDER BY fp_id ASC LIMIT 1");

if ($row = sed_sql_fetcharray($sql))
	{
	$fp_idp = $row['fp_id'];
	if ($fp_idp==$p)
		{
		$edittopictitle = ($fp_idp==$p) ? "<input type=\"text\" class=\"text\" name=\"rtopictitle\" value=\"".sed_cc($ft_title)."\" size=\"56\" maxlength=\"64\" /><br />" : '';
		}
	}

$bbcodes = ($cfg['parsebbcodeforums'] && $fs_allowbbcodes) ? sed_build_bbcodes('editpost', 'rtext', $L['BBcodes']) : '';
$bbcodes_local = ($cfg['parsebbcodeforums'] && $fs_allowbbcodes) ? sed_build_bbcodes_local(99) : '';
$smilies = ($cfg['parsesmiliesforums'] && $fs_allowsmilies) ? sed_build_smilies('editpost', 'rtext', $L['Smilies']) : '';
$smilies_local = ($cfg['parsesmiliesforums'] && $fs_allowsmilies) ? sed_build_smilies_local(20) : '';
$pfs = sed_build_pfs($usr['id'], 'editpost', 'rtext', $L['Mypfs']);
$pfs .= (sed_auth('pfs', 'a', 'A')) ? " &nbsp; ".sed_build_pfs(0, "editpost", "rtext", $L['SFS']) : '';
$morejavascript .= sed_build_addtxt('editpost', 'rtext');
$post_main = "<textarea name=\"rtext\" rows=\"20\" cols=\"56\">".sed_cc($fp_text)."</textarea>";


$toptitle = "<a href=\"forums.php\">".$L['Forums']."</a> ".$cfg['separator']." ".sed_build_forums($s, $fs_title, $fs_category)." ".$cfg['separator']." <a href=\"forums.php?m=newtopic&amp;s=".$s."\">".$L['for_newtopic']."</a>";
$toptitle .= ($usr['isadmin']) ? " *" : '';


$toptitle = "<a href=\"forums.php\">".$L['Forums']."</a> ".$cfg['separator']." ".sed_build_forums($s, $fs_title, $fs_category)." <a href=\"forums.php?m=topics&amp;s=".$s."\">  ".$cfg['separator']." <a href=\"forums.php?m=posts&amp;p=$p#$p\">".$ft_fulltitle."</a> ";
$toptitle .= $cfg['separator']." <a href=\"forums.php?m=editpost&amp;s=$s&amp;q=$q&amp;p=$p&amp;".sed_xg()."\">".$L['Edit']."</a>";
$toptitle .= ($usr['isadmin']) ? " *" : '';

$sys['sublocation'] = $fs_title;
$out['subtitle'] = $L['Forums'];

/* === Hook === */
$extp = sed_getextplugins('forums.editpost.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

require("system/header.php");

$mskin = sed_skinfile(array('forums', 'editpost', $fs_category, $fp_sectionid));
$t = new XTemplate($mskin);

if (!empty($error_string))
	{
	$t->assign("FORUMS_POSTS_EDITPOST_ERROR_BODY",$error_string);
	$t->parse("MAIN.FORUMS_EDITPOST_ERROR");
	}

$t->assign(array(
	"FORUMS_EDITPOST_PAGETITLE" => $toptitle,
	"FORUMS_EDITPOST_SUBTITLE" => "#".$fp_posterid." ".$fp_postername." - ".date($cfg['dateformat'], $fp_updated + $usr['timezone'] * 3600)." ".$usr['timetext'],
	"FORUMS_EDITPOST_SEND" => "forums.php?m=editpost&amp;a=update&amp;s=".$s."&amp;q=".$q."&amp;p=".$p."&amp;".sed_xg(),
	"FORUMS_EDITPOST_TEXT" => $edittopictitle.$post_main."<br />".$bbcodes." ".$smilies." ".$pfs,
	"FORUMS_EDITPOST_TEXTONLY" => $edittopictitle.$post_main,
	"FORUMS_EDITPOST_TEXTBOXER" => $edittopictitle.$post_main,
	"FORUMS_EDITPOST_SMILIES" => $smilies,
	"FORUMS_EDITPOST_BBCODES" => $bbcodes,
	"FORUMS_EDITPOST_MYPFS" => $pfs,
	"FORUMS_EDITPOST_SMILIESLOCAL" => $smilies_local,
	"FORUMS_EDITPOST_BBCODESLOCAL" => $bbcodes_local
		));

/* === Hook === */
$extp = sed_getextplugins('forums.editpost.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$t->parse("MAIN");
$t->out("MAIN");

require("system/footer.php");

?>