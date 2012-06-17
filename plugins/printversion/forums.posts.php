<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/printversion/forums.posts.php
Version=110
Updated=2006-jun-27
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=printversion
Part=main
File=forums.posts
Hooks=forums.posts.first
Tags=
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$printver = sed_import('print','G','ALP',24);

require('plugins/printversion/lang/printversion.'.$usr['lang'].'.lang.php');

if ($printver=='topic' && !empty($q))
	{

	$sql = sed_sql_query("SELECT ft_sectionid FROM $db_forum_topics WHERE ft_id='$q' LIMIT 1");

	if ($row = sed_sql_fetcharray($sql))
		{ $s = $row['ft_sectionid']; }
	else
		{ sed_die(); }

	$sql = sed_sql_query("SELECT s.*, n.fn_title FROM $db_forum_sections AS s LEFT JOIN 
	$db_forum_structure AS n ON n.fn_code=s.fs_category WHERE s.fs_id='$s' LIMIT 1");


	if ($row = sed_sql_fetcharray($sql))
		{
		$fs_title = $row['fs_title'];
		$fs_category = $row['fs_category'];
		$fs_state = $row['fs_state'];
		$fs_allowusertext = $row['fs_allowusertext'];
		$fs_allowbbcodes = $row['fs_allowbbcodes'];
		$fs_allowsmilies = $row['fs_allowsmilies'];
		$fs_countposts = $row['fs_countposts'];
		$fn_title = $row['fn_title'];

		list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('forums', $s);
		sed_block($usr['auth_read']);

		if ($fs_state)
			{
			header("Location: message.php?msg=602");
			exit;
			}
		}
	else

		{ sed_die(); }

	$sql2 = sed_sql_query("SELECT fp_id FROM $db_forum_posts WHERE fp_topicid='$q' ORDER BY fp_id ASC LIMIT 2");

	while ($row2 = sed_sql_fetcharray($sql2))
		{ $post12[] = $row2['fp_id']; }

	$sql = sed_sql_query("SELECT ft_title, ft_mode, ft_state, ft_poll, ft_firstposterid FROM $db_forum_topics WHERE ft_id='$q'");

	if ($row = sed_sql_fetcharray($sql))
		{
		$ft_title = $row['ft_title'];
		$ft_mode = $row['ft_mode'];
		$ft_state = $row['ft_state'];
		$ft_poll = $row['ft_poll'];
		$ft_firstposterid = $row['ft_firstposterid'];

		if ($ft_mode==1 && !($usr['isadmin'] || $ft_firstposterid==$usr['id']))
			{ sed_die(); }
		}
	else

		{ sed_die(); }

	$sql = sed_sql_query("SELECT COUNT(*) FROM $db_forum_posts WHERE fp_topicid='$q'");
	$totalposts = sed_sql_result($sql,0,"COUNT(*)");

	$sql = sed_sql_query("SELECT p.*, u.user_text, u.user_maingrp, u.user_avatar, u.user_photo, u.user_signature,
		   u.user_extra1, u.user_extra2, u.user_extra3, u.user_extra4, u.user_extra5, u.user_extra6, u.user_extra7, u.user_extra8, u.user_extra9,
		   u.user_country, u.user_occupation, u.user_location, u.user_website, u.user_email, u.user_hideemail, u.user_gender, u.user_birthdate,
		   u.user_jrnpagescount, u.user_jrnupdated, u.user_gallerycount, u.user_postcount
			FROM $db_forum_posts AS p LEFT JOIN $db_users AS u ON u.user_id=p.fp_posterid
			WHERE fp_topicid='$q'
			ORDER BY fp_id ");

	$ft_title = ($ft_mode==1) ? "# ".sed_cc($ft_title) : sed_cc($ft_title);

	$tpl_file = "plugins/printversion/tpl/forums.posts.tpl";
	$t=new XTemplate ($tpl_file);

	$t->assign(array(
		"FORUMS_POSTS_FORUMTITLE" => $L['Forums'],
		"FORUMS_POSTS_FORUMTITLEURL" => $cfg['mainurl']."/forums.php",
		"FORUMS_POSTS_CATEGORYTITLE" => sed_cc($fn_title),
		"FORUMS_POSTS_CATEGORYTITLEURL" => $cfg['mainurl']."/forums.php?c=$fs_category#$fs_category",
		"FORUMS_POSTS_SECTIONTITLE" => sed_cc($fs_title),
		"FORUMS_POSTS_SECTIONTITLEURL" => $cfg['mainurl']."/forums.php?m=topics&amp;s=".$s,
		"FORUMS_POSTS_TOPICTITLE" => sed_cc($ft_title),
		"FORUMS_POSTS_TOPICTITLEURL" => $cfg['mainurl']."/forums.php?m=posts&amp;q=".$q,
		"FORUMS_POSTS_POLL" => $poll_result,
			));

	$totalposts = sed_sql_numrows($sql);

	while ($row = sed_sql_fetcharray($sql))
		{
		$row['fp_text'] = sed_cc($row['fp_text']);
		$row['fp_created'] = @date($cfg['dateformat'], $row['fp_creation'] + $usr['timezone'] * 3600)." ".$usr['timetext'];
		$row['fp_updated_ago'] = sed_build_timegap($row['fp_updated'], $sys['now_offset']);
		$row['fp_updated'] = @date($cfg['dateformat'], $row['fp_updated'] + $usr['timezone'] * 3600)." ".$usr['timetext'];
		$row['user_text'] = ($fs_allowusertext) ? $row['user_text'] : '';
		$lastposterid = $row['fp_posterid'];
		$lastposterip = $row['fp_posterip'];
		$fp_num++;

	//поддержка плагина Post Hide
	if (file_exists('plugins/posthide/inc/posthide.functions.php') && strpos($row['fp_text'],'[/hide]')>0)
		{
		require('plugins/posthide/inc/posthide.functions.php');
		$row['fp_text'] = sed_posthide($row['fp_text'], 'ForumQuote', 0, 0, 0, 0, $usr['lang'], '000000');
		}

	$row['fp_posterip'] = ($usr['isadmin']) ? sed_build_ipsearch($row['fp_posterip']) : '';
	$row['fp_text'] = sed_parse($row['fp_text'], ($cfg['parsebbcodeforums'] && $fs_allowbbcodes), ($cfg['parsesmiliesforums'] && $fs_allowsmilies), 1);
	$row['fp_useronline'] = (sed_userisonline($row['fp_posterid'])) ? "1" : "0";

	if (!empty($row['fp_updater']))
		{ $row['fp_updatedby'] = sprintf($L['plu_updatedby'], sed_cc($row['fp_updater']), $row['fp_updated'], $row['fp_updated_ago']); }

	if (!$cache[$row['fp_posterid']]['cached'])
		{
		$row['user_text'] = sed_build_usertext($row['user_text']);
		$row['user_age'] = ($row['user_birthdate']!=0) ? sed_build_age($row['user_birthdate']) : '';
		$cache[$row['fp_posterid']]['user_text'] = $row['user_text'];
		$cache[$row['fp_posterid']]['user_age']= $row['user_age'];
		$cache[$row['fp_posterid']]['cached'] = TRUE;
		}
	else
		{
		$row['user_text'] = $cache[$row['fp_posterid']]['user_text'];
		$row['user_journal'] = $cache[$row['fp_posterid']]['user_journal'];
		$row['user_age'] = $cache[$row['fp_posterid']]['user_age'];
		}

	$t-> assign(array(
		"FORUMS_POSTS_ROW_ID" => $row['fp_id'],
		"FORUMS_POSTS_ROW_IDURL" => "<a id=\"".$row['fp_id']."\" href=\"forums.php?m=posts&amp;p=".$row['fp_id']."#".$row['fp_id']."\">".$row['fp_id']."</a>",
		"FORUMS_POSTS_ROW_CREATION" => $row['fp_created'],
		"FORUMS_POSTS_ROW_UPDATED" => $row['fp_updated'],
		"FORUMS_POSTS_ROW_UPDATER" => sed_cc($row['fp_updater']),
		"FORUMS_POSTS_ROW_UPDATEDBY" => $row['fp_updatedby'],
		"FORUMS_POSTS_ROW_TEXT" => $row['fp_text'],
		"FORUMS_POSTS_ROW_POSTERNAMEURL" => sed_build_user($row['fp_posterid'], sed_cc($row['fp_postername'])),
		"FORUMS_POSTS_ROW_POSTERNAME" => sed_cc($row['fp_postername']),
		"FORUMS_POSTS_ROW_POSTERID" => $row['fp_posterid'],
		"FORUMS_POSTS_ROW_MAINGRP" => sed_build_group($row['user_maingrp']),
		"FORUMS_POSTS_ROW_MAINGRPID" => $row['user_maingrp'],
		"FORUMS_POSTS_ROW_MAINGRPSTARS" => sed_build_stars($sed_groups[$row['user_maingrp']]['level']),
		"FORUMS_POSTS_ROW_MAINGRPICON" => sed_build_userimage($sed_groups[$row['user_maingrp']]['icon']),
		"FORUMS_POSTS_ROW_USERTEXT" => $row['user_text'],
		"FORUMS_POSTS_ROW_AVATAR" => sed_build_userimage($row['user_avatar']),
		"FORUMS_POSTS_ROW_PHOTO" => sed_build_userimage($row['user_photo']),
		"FORUMS_POSTS_ROW_SIGNATURE" => sed_build_userimage($row['user_signature']),
		"FORUMS_POSTS_ROW_GENDER" => $row['user_gender'] = ($row['user_gender']=='' || $row['user_gender']=='U') ? '' : $L["Gender_".$row['user_gender']],
		"FORUMS_POSTS_ROW_USEREXTRA1" => sed_cc($row['user_extra1']),
		"FORUMS_POSTS_ROW_USEREXTRA2" => sed_cc($row['user_extra2']),
		"FORUMS_POSTS_ROW_USEREXTRA3" => sed_cc($row['user_extra3']),
		"FORUMS_POSTS_ROW_USEREXTRA4" => sed_cc($row['user_extra4']),
		"FORUMS_POSTS_ROW_USEREXTRA5" => sed_cc($row['user_extra5']),
		"FORUMS_POSTS_ROW_USEREXTRA6" => sed_cc($row['user_extra6']),
		"FORUMS_POSTS_ROW_USEREXTRA7" => sed_cc($row['user_extra7']),
		"FORUMS_POSTS_ROW_USEREXTRA8" => sed_cc($row['user_extra8']),
		"FORUMS_POSTS_ROW_USEREXTRA9" => sed_cc($row['user_extra9']),
		"FORUMS_POSTS_ROW_POSTERIP" => $row['fp_posterip'],
		"FORUMS_POSTS_ROW_USERONLINE" => $row['fp_useronline'],
		"FORUMS_POSTS_ROW_COUNTRY" => $sed_countries[$row['user_country']],
		"FORUMS_POSTS_ROW_COUNTRYFLAG" => sed_build_flag($row['user_country']),
		"FORUMS_POSTS_ROW_WEBSITE" => sed_build_url($row['user_website'], 36),
		"FORUMS_POSTS_ROW_WEBSITERAW" => $row['user_website'],
		"FORUMS_POSTS_ROW_JOURNAL" => $row['user_journal'],
		"FORUMS_POSTS_ROW_EMAIL" => sed_build_email($row['user_email'], $row['user_hideemail']),
		"FORUMS_POSTS_ROW_LOCATION" => sed_cc($row['user_location']),
		"FORUMS_POSTS_ROW_OCCUPATION" => sed_cc($row['user_occupation']),
		"FORUMS_POSTS_ROW_AGE" => $row['user_age'],
		"FORUMS_POSTS_ROW_POSTCOUNT" => $row['user_postcount'],
		"FORUMS_POSTS_ROW_ODDEVEN" => sed_build_oddeven($fp_num),
		"FORUMS_POSTS_ROW" => $row,
		));

		$t->parse("MAIN.FORUMS_POSTS_ROW");
		}

	$t->assign(array (
		"HEADER_TITLE" => $cfg['maintitle']." ".$cfg['separator']." ".$L['Forums']." ".$cfg['separator']." ".sed_build_forums($s, $fs_title, $fs_category, false)." ".$cfg['separator']." ".sed_cc($ft_title)." :: ".$L['plu_title'],
		));

	$t->parse("MAIN");
	$t->out("MAIN");

	//поддержка плагина BBClone v1.9 и выше (работающий через footer.tags)
	//иначе страницы в версии для печати не будут учитываться в статистике
	/* === Hook === */
	$extp = sed_getextplugins('footer.tags');
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	sed_sql_close();

	exit;
	}

?>
