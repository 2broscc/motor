<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=system/functions.php
Version=161
Updated=2012-feb-15
Type=Core
Author=Neocrome
Description=Functions
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$cfg = array();
$out = array();
$plu = array();
$sys = array();
$usr = array();

/* ======== Xtemplate class ========= */

require('system/templates.php');

/* ======== Pre-sets ========= */

$i = explode(' ', microtime());
$sys['starttime'] = $i[1] + $i[0];

unset ($warnings, $moremetas, $morejavascript, $error_string,  $sed_cat, $sed_smilies, $sed_acc, $sed_catacc, $sed_rights, $sed_config, $sql_config, $sed_usersonline, $sed_plugins, $sed_parser, $sed_groups, $rsedition, $rseditiop, $rseditios, $tcount, $qcount);

// ALL the value below are DEFAULTS, change the value in datas/config.php if needed, NOT HERE.

$cfg['authmode'] = 3; 				// (1:cookies, 2:sessions, 3:cookies+sessions)
$cfg['enablecustomhf'] = FALSE;		// To enable header.$location.tpl and footer.$location.tpl
$cfg['pfs_dir'] = 'datas/users/';
$cfg['av_dir'] = 'datas/avatars/';
$cfg['photos_dir'] = 'datas/photos/';
$cfg['sig_dir'] = 'datas/signatures/';
$cfg['defav_dir'] = 'datas/defaultav/';
$cfg['th_dir'] = 'datas/thumbs/';
$cfg['res_dir'] = 'datas/resized/';
$cfg['gd_supported'] = array('jpg', 'jpeg', 'png', 'gif');
$cfg['pagination'] = ' [%s]';
$cfg['pagination_cur'] = ' <strong>&gt; %s &lt;</strong>';
$cfg['pfsmaxuploads'] = 5;
$cfg['sqldb'] = 'mysql';
$cfg['sqldbprefix'] = 'sed_';
$cfg['version'] = '161';

/* ======== Names of the SQL tables ========= */

$sed_dbnames = array ('auth', 'auth_default', 'banlist', 'cache', 'com', 'core', 'config', 'forum_sections', 'forum_structure', 'forum_topics', 'forum_posts', 'groups', 'groups_users', 'logger', 'online', 'pages', 'parser', 'pfs', 'pfs_folders', 'plugins', 'pm', 'polls_options', 'polls', 'polls_voters', 'rated', 'ratings', 'referers', 'smilies', 'stats', 'structure', 'trash', 'users');

foreach($sed_dbnames as $k => $i)
	{
	$j = 'db_'.$i;
	$$j = $cfg['sqldbprefix'].$i;
	}

/* ================== Replacements for PHP5-only functions ================== */

if (!function_exists('str_split'))
	{
	function str_split($txt, $length=1)
		{
		if ($length<1)
			{ return(FALSE); }
		$res = array();
		for ($i=0; $i<mb_strlen($txt); $i+=$length)
			{ $res[] = substr($txt, $i, $length); }
		return($res);
		}
	}

/* ------------------ */

if (!function_exists('stripos'))
	{
	function stripos($a, $b, $c=0)
		{ return strpos(strtolower($a), strtolower($b), $c); }
	}

/* ------------------ */

function sed_alphaonly($text)
	{
	return(preg_replace('/[^a-zA-Z0-9_]/', '', $text));
	}

/* ------------------ */

function sed_auth($area, $option, $mask='RWA')
	{
	global $sys, $usr;

	$mn['R'] = 1;
	$mn['W'] = 2;
	$mn['1'] = 4;
	$mn['2'] = 8;
	$mn['3'] = 16;
	$mn['4'] = 32;
	$mn['5'] = 64;
	$mn['A'] = 128;

	$masks = str_split($mask);
	$res = array();

	foreach($masks as $k => $ml)
		{
		if(empty($mn[$ml]))
			{
			$sys['auth_log'][] = $area.".".$option.".".$ml."=0";
			$res[] = FALSE;
			}
		elseif ($option=='any')
			{
			$cnt = 0;

			if (is_array($usr['auth'][$area]))
				{
				foreach($usr['auth'][$area] as $k => $g)
					{ $cnt += (($g & $mn[$ml]) == $mn[$ml]); }
				}
			$cnt = ($cnt==0 && $usr['auth']['admin']['a'] && $ml=='A') ? 1 : $cnt;

			$sys['auth_log'][] = ($cnt>0) ? $area.".".$option.".".$ml."=1" : $area.".".$option.".".$ml."=0";
			$res[] = ($cnt>0) ? TRUE : FALSE;
			}
		else
			{
			$sys['auth_log'][] = (($usr['auth'][$area][$option] & $mn[$ml]) == $mn[$ml]) ? $area.".".$option.".".$ml."=1" : $area.".".$option.".".$ml."=0";
	 		$res[] = (($usr['auth'][$area][$option] & $mn[$ml]) == $mn[$ml]) ? TRUE : FALSE;
			}
		}
	if (count($res)==1)
		{ return ($res[0]); }
	   else
		{ return($res); }
	}

/* ------------------ */

function sed_auth_build($userid, $maingrp=0)
	{
	global $db_auth, $db_groups_users;

	$groups = array();
	$authgrid = array();
	$tmpgrid = array();

	if ($userid==0 || $maingrp==0)
		{
		$groups[] = 1;
		}
	else
		{
		$groups[] = $maingrp;
		$sql = sed_sql_query("SELECT gru_groupid FROM $db_groups_users WHERE gru_userid='$userid'");

		while ($row = sed_sql_fetchassoc($sql))
			   { $groups[] = $row['gru_groupid']; }
		}

    $sql_groups = implode(',', $groups);
	$sql = sed_sql_query("SELECT auth_code, auth_option, auth_rights FROM $db_auth WHERE auth_groupid IN (".$sql_groups.") ORDER BY auth_code ASC, auth_option ASC");

	while ($row = sed_sql_fetchassoc($sql))
	    { $authgrid[$row['auth_code']][$row['auth_option']] |= $row['auth_rights']; }

   	return($authgrid);
	}

/* ------------------ */

function sed_auth_clear($id='all')
	{
	global $db_users;

	if($id=='all')
		{ $sql = sed_sql_query("UPDATE $db_users SET user_auth='' WHERE 1"); }
	else
		{ $sql = sed_sql_query("UPDATE $db_users SET user_auth='' WHERE user_id='$id'"); }
	return( sed_sql_affectedrows());
	}

/* ------------------ */

function sed_bbcode($text)
	{
	global $L, $skin, $sys, $cfg, $sed_groups, $sed_parser;

	$text = sed_bbcode_autourls($text);
	$text = " ".$text;

	foreach($sed_parser[0] as $bbcode => $bbcodehtml)
		{
		if (!empty($bbcodehtml['bb1']))
			{ $text = str_replace($bbcodehtml['bb1'], $bbcodehtml['code1'], $text); }
		if (!empty($bbcodehtml['bb2']))
			{ $text = str_replace($bbcodehtml['bb2'], $bbcodehtml['code2'], $text); }
		}

	foreach($sed_parser[1] as $bbcode => $bbcodehtml)
		{
		if (!empty($bbcodehtml['bb1']))
			{ $text = preg_replace($bbcodehtml['bb1'], $bbcodehtml['code1'], $text); }
		if (!empty($bbcodehtml['bb2']))
			{ $text = preg_replace($bbcodehtml['bb2'], $bbcodehtml['code2'], $text); }
		}

	return(substr($text,1));
	}

/* ------------------ */

function sed_bbcode_autourls($text)
	{
	$text = ' '.$text;
	$text = preg_replace("#([\n ])([a-z0-9]+?)://([^\t \n\r]+)#i", "\\1[url]\\2://\\3[/url]", $text);
	$text = preg_replace("#([\n ])([a-z0-9-_.]+?@[A-z0-9-]+\.[^,\t \n\r]+)#i", "\\1[email]\\2[/email]", $text);
	return(substr($text,1));
	}

/* ------------------ */

function sed_bbcode_urls($text)
	{
	global $cfg;
	// Deprecated
	return($text);
	}

/* ------------------ */

function sed_block($allowed)
	{
	if (!$allowed)
		{
		global $sys;
		header("Location: message.php?msg=930&".$sys['url_redirect']);
		exit;
		}
	return(FALSE);
	}


/* ------------------ */

function sed_blockguests()
	{
	global $usr, $sys;

	if ($usr['id']<1)
		{
		header("Location: message.php?msg=930&".$sys['url_redirect']);
		exit;
		}
	return(FALSE);
	}

/* ------------------ */

function sed_build_addtxt($c1, $c2)
	{
	$result = "
	function addtxt(text)
	{
	document.".$c1.".".$c2.".value  += text;
	document.".$c1.".".$c2.".focus();
	}
	";
	return($result);
	}

/* ------------------ */

function sed_build_age($birth)
	{
	global $sys;

	if ($birth==1)
		{ return ('?'); }

	$day1 = @date('d', $birth);
	$month1 = @date('m', $birth);
	$year1 = @date('Y', $birth);

	$day2 = @date('d', $sys['now_offset']);
	$month2 = @date('m', $sys['now_offset']);
	$year2 = @date('Y', $sys['now_offset']);

  	$age = ($year2-$year1)-1;

	if ($month1<$month2 || ($month1==$month2 && $day1<=$day2))
		{ $age++; }

	if($age < 0)
		{ $age += 136; }

	return ($age);
	}

/* ------------------ */

function sed_build_catpath($cat, $mask)
	{
	global $sed_cat, $cfg;

	$pathcodes = explode('.', $sed_cat[$cat]['path']);
	foreach($pathcodes as $k => $x)
		{ $tmp[]= sprintf($mask, $x, $sed_cat[$x]['title']); }
	$result = implode(' '.$cfg['separator'].' ', $tmp);
	return ($result);
	}

/* ------------------ */

function sed_build_comments($code, $url, $display)
	{
	global $db_com, $db_users, $db_pages, $cfg, $usr, $L, $sys, $skin, $n, $b;

	list($usr['auth_read_com'], $usr['auth_write_com'], $usr['isadmin_com']) = sed_auth('comments', 'a');
	sed_block($usr['auth_read_com']);

	if ($cfg['disable_comments'] || !$usr['auth_read_com'])
		{ return (array('',''));  }

	if ($display)
		{
		if ($n=='send' && $usr['auth_write_com'])
			{
			sed_shield_protect();
			$rtext = sed_import('rtext','P','HTM');

			/* == Hook for the plugins == */
			$extp = sed_getextplugins('comments.send.first');
			if (is_array($extp))
				{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
			/* ===== */

			$error_string .= (mb_strlen($rtext)<2) ? $L['com_commenttooshort']."<br />" : '';
			$error_string .= (mb_strlen($rtext)>2000) ? $L['com_commenttoolong']."<br />" : '';

			if (empty($error_string))
				{
				$sql = sed_sql_query("INSERT INTO $db_com (com_code, com_author, com_authorid, com_authorip, com_text, com_text_ishtml, com_date) VALUES ('".sed_sql_prep($code)."', '".sed_sql_prep($usr['name'])."', ".(int)$usr['id'].", '".$usr['ip']."', '".sed_sql_prep($rtext)."', 1, ".(int)$sys['now_offset'].")");

				if (substr($code, 0, 1) =='p')
					{
					$page_id = substr($code, 1, 10);
					$sql = sed_sql_query("UPDATE $db_pages SET page_comcount='".sed_get_comcount($code)."' WHERE page_id='".$page_id."'");
					}

				/* == Hook for the plugins == */
					$extp = sed_getextplugins('comments.send.new');
				if (is_array($extp))
					{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
				/* ===== */

				sed_shield_update(20, "New comment");
				header("Location: $url&comments=1");
				exit;
				}
			}

		if ($n=='delete' && $usr['isadmin_com'])
			{
			sed_check_xg();
			$sql = sed_sql_query("SELECT * FROM $db_com WHERE com_id='$b' LIMIT 1");

			if ($row = sed_sql_fetchassoc($sql))
				{
				if ($cfg['trash_comment'])
					{ sed_trash_put('comment', $L['Comment']." #".$b." (".$row['com_author'].")", $b, $row); }

				$sql = sed_sql_query("DELETE FROM $db_com WHERE com_id='$b'");

				if (substr($row['com_code'], 0, 1) == 'p')
					{
					$page_id = substr($row['com_code'], 1, 10);
					$sql = sed_sql_query("UPDATE $db_pages SET page_comcount=".sed_get_comcount($row['com_code'])." WHERE page_id=".$page_id);
					}

				sed_log("Deleted comment #".$b." in '".$code."'",'adm');
				}

			header("Location: ".$url."&comments=1");
			exit;
			}
			      
		$error_string .= ($n=='added') ? $L['com_commentadded']."<br />" : '';

		$t = new XTemplate(sed_skinfile('comments'));

		/* == Hook for the plugins == */
			$extp = sed_getextplugins('comments.main');
		if (is_array($extp))
			{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
		/* ===== */

		$sql = sed_sql_query("SELECT c.*, u.user_avatar FROM $db_com AS c
				LEFT JOIN $db_users AS u ON u.user_id=c.com_authorid
				WHERE com_code='$code' ORDER BY com_id ASC");

		if (!empty($error_string))
			{
			$t->assign("COMMENTS_ERROR_BODY",$error_string);
			$t->parse("COMMENTS.COMMENTS_ERROR");
			}

		if ($usr['auth_write_com'])
			{
			$pfs = ($usr['id']>0) ? sed_build_pfs($usr['id'], "newcomment", "rtext", $L['Mypfs']) : '';
			$pfs .= (sed_auth('pfs', 'a', 'A')) ? " &nbsp; ".sed_build_pfs(0, "newcomment", "rtext", $L['SFS']) : '';
			$post_main = "<textarea name=\"rtext\" rows=\"6\" cols=\"64\">".$rtext."</textarea><br />".$pfs;
			}

		$t->assign(array(
			"COMMENTS_CODE" => $code,
			"COMMENTS_FORM_SEND" => $url."&amp;comments=1&amp;n=send",
			"COMMENTS_FORM_AUTHOR" => $usr['name'],
			"COMMENTS_FORM_AUTHORID" => $usr['id'],
			"COMMENTS_FORM_TEXT" => $post_main,
			"COMMENTS_FORM_TEXTBOXER" => $post_main,
			"COMMENTS_FORM_MYPFS" => $pfs
				));

		if ($usr['auth_write_com'])
			{

			/* == Hook for the plugins == */
			$extp = sed_getextplugins('comments.newcomment.tags');
			if (is_array($extp))
				{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
			/* ===== */

			$t->parse("COMMENTS.COMMENTS_NEWCOMMENT");
			}

		if (sed_sql_numrows($sql)>0)
			{
			$i = 0;

			/* === Hook - Part1 : Set === */
			$extp = sed_getextplugins('comments.loop');
			/* ===== */

			while ($row = sed_sql_fetchassoc($sql))
				{
				if (!$row['com_text_ishtml'])
				  {
				  $row['com_text'] = sed_parse(sed_cc($row['com_text']), 1, 1, 1);
          $sql3 = sed_sql_query("UPDATE $db_com SET com_text_ishtml=1, com_text='".sed_sql_prep($row['com_text'])."' WHERE com_id=".$row['com_id']); 
				  }
				  
				$i++;
				$com_author = sed_cc($row['com_author']);
				$com_text = "<div id=\"blkcom_".$row['com_id']."\" >".$row['com_text']."</div>";
				$com_admin = ($usr['isadmin_com']) ? $L['Ip'].":".sed_build_ipsearch($row['com_authorip'])." &nbsp;".$L['Delete'].":[<a href=\"".$url."&amp;comments=1&amp;n=delete&amp;b=".$row['com_id']."&amp;".sed_xg()."\">x</a>]" : '' ;
				$com_authorlink = ($row['com_authorid']>0) ? "<a href=\"users.php?m=details&amp;id=".$row['com_authorid']."\">".$com_author."</a>" : $com_author ;

				$t-> assign(array(
					"COMMENTS_ROW_ID" => $row['com_id'],
					"COMMENTS_ROW_ORDER" => $i,
					"COMMENTS_ROW_URL" => $url."&amp;comments=1#".$row['com_id'],
					"COMMENTS_ROW_AUTHOR" => $com_authorlink,
					"COMMENTS_ROW_AUTHORID" => $row['com_authorid'],
					"COMMENTS_ROW_AVATAR" => sed_build_userimage($row['user_avatar']),
					"COMMENTS_ROW_TEXT" => $com_text,
					"COMMENTS_ROW_DATE" => @date($cfg['dateformat'], $row['com_date'] + $usr['timezone'] * 3600),
					"COMMENTS_ROW_ADMIN" => $com_admin
						));

			/* === Hook - Part2 : Include === */
			if (is_array($extp))
				{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
			/* ===== */

				$t->parse("COMMENTS.COMMENTS_ROW");
				}
			}
		else
			{
			$t-> assign(array(
				"COMMENTS_EMPTYTEXT" => $L['com_nocommentsyet'],
					));
			$t->parse("COMMENTS.COMMENTS_EMPTY");
			}

		/* == Hook for the plugins == */
		$extp = sed_getextplugins('comments.tags');
		if (is_array($extp))
			{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
		/* ===== */

		$t->parse("COMMENTS");
		$res_display = $t->text("COMMENTS");
		}
	else
		{
		$res_display = '';
		}

	$res = "<a href=\"".$url."&amp;comments=1\"><img src=\"skins/".$usr['skin']."/img/system/icon-comment.gif\" alt=\"\" />";

	if ($cfg['countcomments'])
		{
		$nbcomment = sed_sql_result(sed_sql_query("SELECT COUNT(*) FROM $db_com where com_code='$code'"), 0, "COUNT(*)");
		$res .= " (".$nbcomment.")";
		}
	$res .= "</a>";

	return(array($res, $res_display, $nbcomment));
	}

/* ------------------ */

function sed_build_country($flag)
	{
	global $sed_countries;

	$flag = (empty($flag)) ? '00' : $flag;
	$result = '<a href="users.php?f=country_'.$flag.'">'.$sed_countries[$flag].'</a>';
	return($result);
	}

/* ------------------ */

function sed_build_email($email, $hide=0)
	{
	global $L;
	if ($hide)
		{ $result = $L['Hidden']; }
	elseif (!empty($email) && strpos($email, '@') !== FALSE)
		{
		$email = sed_cc($email);
		$result = "<a href=\"mailto:".$email."\">".$email."</a>";
		}

	return($result);
	}

/* ------------------ */

function sed_build_flag($flag)
	{
	$flag = (empty($flag)) ? '00' : $flag;
	$result = '<a href="users.php?f=country_'.$flag.'"><img src="system/img/flags/f-'.$flag.'.gif" alt="" /></a>';
	return($result);
	}

/* ------------------ */

function sed_build_forums($sectionid, $title, $category, $link=TRUE)
	{
	global $sed_forums_str, $cfg;

	$pathcodes = explode('.', $sed_forums_str[$category]['path']);

	if ($link)
		{
		foreach($pathcodes as $k => $x)
			{ $tmp[]= "<a href=\"forums.php?c=$x#$x\">".sed_cc($sed_forums_str[$x]['title'])."</a>"; }
		$tmp[]= "<a href=\"forums.php?m=topics&amp;s=$sectionid\">".sed_cc($title)."</a>";
		}
	else
		{
		foreach($pathcodes as $k => $x)
			{ $tmp[]= sed_cc($sed_forums_str[$x]['title']); }
		$tmp[]= sed_cc($title);
		}

	$result = implode(' '.$cfg['separator'].' ', $tmp);

	return($result);
	}


/* ------------------ */

function sed_build_gallery($id, $c1, $c2, $title)
	{
	return("<a href=\"javascript:gallery('".$id."','".$c1."','".$c2."')\">".$title."</a>");
	}

/* ------------------ */

function sed_build_group($grpid)
	{
	global $sed_groups, $L;

	if (empty($grpid))
		{ $res = ''; }
	else
		{
		if ($sed_groups[$grpid]['hidden'])
			{
			if (sed_auth('users', 'a', 'A'))
				{ $res = "<a href=\"users.php?gm=".$grpid."\">".$sed_groups[$grpid]['title']."</a> (".$L['Hidden'].')'; }
			else
				{ $res = $L['Hidden']; }
			}
		else
			{ $res = "<a href=\"users.php?gm=".$grpid."\">".$sed_groups[$grpid]['title']."</a>"; }
		}
	return($res);

	}

/* ------------------ */

function sed_build_groupsms($userid, $edit=FALSE, $maingrp=0)
	{
	global $db_groups_users, $sed_groups, $L;

	$sql = sed_sql_query("SELECT gru_groupid FROM $db_groups_users WHERE gru_userid='$userid'");

	while ($row = sed_sql_fetchassoc($sql))
		{ $member[$row['gru_groupid']] = TRUE;	}

	foreach($sed_groups as $k => $i)
		{
		$checked = ($member[$k]) ? "checked=\"checked\"" : '';
		$checked_maingrp = ($maingrp==$k) ? "checked=\"checked\"" : '';
		$readonly = (!$edit || $k==1 || $k==2 || $k==3 || ($k==5 && $userid==1)) ? "disabled=\"disabled\"" : '';
		$readonly_maingrp = (!$edit || $k==1 || ($k==2 && $userid==1) || ($k==3 && $userid==1)) ? "disabled=\"disabled\"" : '';

		if ($member[$k] || $edit)
			{
			if (!($sed_groups[$k]['hidden'] && !sed_auth('users', 'a', 'A')))
				{
				$res .= "<input type=\"radio\" class=\"radio\" name=\"rusermaingrp\" value=\"$k\" ".$checked_maingrp." ".$readonly_maingrp." /> \n";
				$res .= "<input type=\"checkbox\" class=\"checkbox\" name=\"rusergroupsms[$k]\" ".$checked." $readonly />\n";
				$res .= ($k==1) ? $sed_groups[$k]['title'] : "<a href=\"users.php?g=".$k."\">".$sed_groups[$k]['title']."</a>";
				$res .= ($sed_groups[$k]['hidden']) ? ' ('.$L['Hidden'].')' : '';
				$res .= "<br />";
				}
			}
		}

	return($res);
	}

/* ------------------ */

function sed_build_icq($text)
	{
	global $cfg;

	$text = sed_import($text, 'D', 'INT', 32);
	if ($text>0)
		{ $text = $text." <a href=\"http://www.icq.com/".$text."#pager\"><img src=\"http://web.icq.com/whitepages/online?icq=".$text."&amp;img=5\" alt=\"\" /></a>"; }
	return($text);
	}

/* ------------------ */

function sed_build_ipsearch($ip)
	{
	global $xk;

	if (!empty($ip))
		{
		$result = "<a href=\"admin.php?m=tools&amp;p=ipsearch&amp;a=search&amp;id=".$ip."&amp;x=".$xk."\">".$ip."</a>";
		}

	return($result);
	}

/* ------------------ */

function sed_build_msn($msn)
	{
	if (!empty($msn) && (strpos($msn, '@') !== FALSE))
		{
		$msn = sed_cc($msn);
		$result = "<a href=\"mailto:".$msn."\">".$msn."</a>";
		}

	return($result);
	}

/* ------------------ */

function sed_build_oddeven($number)
	{
	if ($number % 2 == 0 )
		{ return ('even'); }
	else
		{ return ('odd'); }
	}

/* ------------------ */

function sed_build_parser()
	{
	global $db_parser, $cfg, $L;

	$mode1 = array();
	$mode2 = array();

	$sql = sed_sql_query("SELECT * FROM $db_parser WHERE parser_mode=0 AND parser_active=1 ORDER BY parser_order ASC");

	while ($row = sed_sql_fetchassoc($sql))
		{
		$mode1[] = array('bb1' => $row['parser_bb1'],
		'bb2' => $row['parser_bb2'],
		'code1' => $row['parser_code1'],
		'code2' => $row['parser_code2']);
		}

	$sql = sed_sql_query("SELECT * FROM $db_parser WHERE parser_mode=1 AND parser_active=1 ORDER BY parser_order ASC");

	while ($row = sed_sql_fetchassoc($sql))
		{
		$mode2[] = array('bb1' => $row['parser_bb1'],
		'bb2' => $row['parser_bb2'],
		'code1' => $row['parser_code1'],
		'code2' => $row['parser_code2']);
		}

	return(array($mode1, $mode2));
	}

/* ------------------ */

function sed_build_pfs($id, $c1, $c2, $title)
	{
	global $L, $cfg, $usr, $sed_groups;
	if ($cfg['disable_pfs'])
		{ $res = ''; }
	else
		{
		if ($id==0)
			{ $res = "<a href=\"javascript:pfs('0','".$c1."','".$c2."')\">".$title."</a>"; }
		elseif ($sed_groups[$usr['maingrp']]['pfs_maxtotal']>0 && $sed_groups[$usr['maingrp']]['pfs_maxfile']>0 && sed_auth('pfs', 'a', 'R'))
			{ $res = "<a href=\"javascript:pfs('".$id."','".$c1."','".$c2."')\">".$title."</a>"; }
		else
			{ $res = ''; }
		}
	return($res);
	}

/* ------------------ */

function sed_build_pm($user)
	{
	global $usr, $cfg, $L;
	$result = "<a href=\"pm.php?m=send&amp;to=".$user."\"><img src=\"skins/".$usr['skin']."/img/system/icon-pm.gif\"  alt=\"\" /></a>";
	return($result);
	}

/* ------------------ */

function sed_build_ratings($code, $url, $display)
	{
	global $db_ratings, $db_rated, $db_users, $cfg, $usr, $sys, $L;

	list($usr['auth_read_rat'], $usr['auth_write_rat'], $usr['isadmin_rat']) = sed_auth('ratings', 'a');

	if ($cfg['disable_ratings'] || !$usr['auth_read_rat'])
		{ return (array('','')); }

	$sql = sed_sql_query("SELECT * FROM $db_ratings WHERE rating_code='$code' LIMIT 1");

	if ($row = sed_sql_fetchassoc($sql))
		{
		$rating_average = $row['rating_average'];
		$yetrated = TRUE;
		if ($rating_average<1)
			{ $rating_average = 1; }
		elseif ($rating_average>10)
			{ $rating_average = 10; }
		$rating_cntround = round($rating_average, 0);
		}
	else
		{
		$yetrated = FALSE;
		$rating_average = 0;
		$rating_cntround = 0;
		}

	$res = "<a href=\"".$url."&amp;ratings=1\"><img src=\"skins/".$usr['skin']."/img/system/vote".$rating_cntround.".gif\" alt=\"\" /></a>";

	if ($display)
		{
		$ina = sed_import('ina','G','ALP');
		$newrate = sed_import('newrate','P','INT');

		$alr_rated = sed_sql_result(sed_sql_query("SELECT COUNT(*) FROM ".$db_rated." WHERE rated_userid=".$usr['id']." AND rated_code = '".sed_sql_prep($code)."'"), 0, 'COUNT(*)');

		if ($ina=='send' && $newrate>=1 && $newrate<=10 && $usr['auth_write_rat'] && $alr_rated<=0)
			{
			/* == Hook for the plugins == */
			$extp = sed_getextplugins('ratings.send.first');
			if (is_array($extp))
				{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
			/* ===== */

			if (!$yetrated)
				{
				$sql = sed_sql_query("INSERT INTO $db_ratings (rating_code, rating_state, rating_average, rating_creationdate, rating_text) VALUES ('".sed_sql_prep($code)."', 0, ".(int)$newrate.", ".(int)$sys['now_offset'].", '') ");
				}

			$sql = sed_sql_query("INSERT INTO $db_rated (rated_code, rated_userid, rated_value) VALUES ('".sed_sql_prep($code)."', ".(int)$usr['id'].", ".(int)$newrate.")");
			$sql = sed_sql_query("SELECT COUNT(*) FROM $db_rated WHERE rated_code='$code'");
			$rating_voters = sed_sql_result($sql, 0, "COUNT(*)");
			$ratingnewaverage = ($rating_average * ($rating_voters - 1) + $newrate) / ( $rating_voters );
			$sql = sed_sql_query("UPDATE $db_ratings SET rating_average='$ratingnewaverage' WHERE rating_code='$code'");

			/* == Hook for the plugins == */
			$extp = sed_getextplugins('ratings.send.done');
			if (is_array($extp))
				{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
			/* ===== */

			header("Location: $url&ratings=1&ina=added");
			exit;
			}

		$votedcasted = ($ina=='added') ? 1 : 0;

		$rate_form = "<input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"1\" /><img src=\"skins/".$usr['skin']."/img/system/vote1.gif\" alt=\"\" /> 1 - ".$L['rat_choice1']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"2\" /><img src=\"skins/".$usr['skin']."/img/system/vote2.gif\" alt=\"\" /> 2 - ".$L['rat_choice2']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"3\" /><img src=\"skins/".$usr['skin']."/img/system/vote3.gif\" alt=\"\" /> 3 - ".$L['rat_choice3']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"4\" /><img src=\"skins/".$usr['skin']."/img/system/vote4.gif\" alt=\"\" /> 4 - ".$L['rat_choice4']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"5\" checked=\"checked\" /><img src=\"skins/".$usr['skin']."/img/system/vote5.gif\" alt=\"\" /> 5 - ".$L['rat_choice5']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"6\" /><img src=\"skins/".$usr['skin']."/img/system/vote6.gif\" alt=\"\" /> 6 - ".$L['rat_choice6']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"7\" /><img src=\"skins/".$usr['skin']."/img/system/vote7.gif\" alt=\"\" /> 7 - ".$L['rat_choice7']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"8\" /><img src=\"skins/".$usr['skin']."/img/system/vote8.gif\" alt=\"\" /> 8 - ".$L['rat_choice8']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"9\" /><img src=\"skins/".$usr['skin']."/img/system/vote9.gif\" alt=\"\" /> 9 - ".$L['rat_choice9']."<br /><input type=\"radio\" class=\"radio\" name=\"newrate\" value=\"10\" /><img src=\"skins/".$usr['skin']."/img/system/vote10.gif\" alt=\"\" /> 10 - ".$L['rat_choice10'];

		if ($usr['id']>0)
			{
			$sql1 = sed_sql_query("SELECT rated_value FROM $db_rated WHERE rated_code='$code' AND rated_userid='".$usr['id']."' LIMIT 1");

			if ($row1 = sed_sql_fetchassoc($sql1))
				{
				$alreadyvoted = TRUE;
				$rating_uservote = $L['rat_alreadyvoted']." (".$row1['rated_value'].")";
				}
			}

		$t = new XTemplate(sed_skinfile('ratings'));

		/* == Hook for the plugins == */
			$extp = sed_getextplugins('ratings.main');
		if (is_array($extp))
			{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
		/* ===== */

		if (!empty($error_string))
			{
			$t->assign("RATINGS_ERROR_BODY",$error_string);
			$t->parse("RATINGS.RATINGS_ERROR");
			}

		if ($yetrated)
			{
			$sql = sed_sql_query("SELECT COUNT(*) FROM $db_rated WHERE rated_code='$code' ");
			$rating_voters = sed_sql_result($sql, 0, "COUNT(*)");
			$rating_average = $row['rating_average'];
			$rating_since = $L['rat_since']." ".date($cfg['dateformat'], $row['rating_creationdate'] + $usr['timezone'] * 3600);
				if ($rating_average<1)
				{ $rating_average = 1; }
			elseif ($ratingaverage>10)
				{ $rating_average = 10; }

			$rating = round($rating_average,0);
			$rating_averageimg = "<img src=\"skins/".$usr['skin']."/img/system/vote".$rating.".gif\" alt=\"\" />";
			$sql = sed_sql_query("SELECT COUNT(*) FROM $db_rated WHERE rated_code='$code' ");
			$rating_voters = sed_sql_result($sql, 0, "COUNT(*)");
			}
		else
			{
			$rating_voters = 0;
			$rating_since = '';
			$rating_average = $L['rat_notyetrated'];
			$rating_averageimg = '';
			}

		$t->assign(array(
			"RATINGS_AVERAGE" => $rating_average,
			"RATINGS_AVERAGEIMG" => $rating_averageimg,
			"RATINGS_VOTERS" => $rating_voters,
			"RATINGS_SINCE" => $rating_since
				));


		if ($usr['id']>0 && $votedcasted)
			{
			$t->assign(array(
				"RATINGS_EXTRATEXT" => $L['rat_votecasted'],
					));
			$t->parse("RATINGS.RATINGS_EXTRA");
			}
		elseif ($usr['id']>0 && $alreadyvoted)
			{
			$t->assign(array(
				"RATINGS_EXTRATEXT" => $rating_uservote,
					));
			$t->parse("RATINGS.RATINGS_EXTRA");
			}
		elseif ($usr['id']==0)
			{
			$t->assign(array(
				"RATINGS_EXTRATEXT" => $L['rat_registeredonly'],
					));
			$t->parse("MAIN.RATINGS_EXTRA");
			}

		elseif ($usr['id']>0 && !$alreadyvoted)
			{
			$t->assign(array(
				"RATINGS_NEWRATE_FORM_SEND" => $url."&amp;ratings=1&amp;ina=send",
				"RATINGS_NEWRATE_FORM_VOTER" => $usr['name'],
				"RATINGS_NEWRATE_FORM_RATE" => $rate_form
					));
			$t->parse("RATINGS.RATINGS_NEWRATE");
			}

		/* == Hook for the plugins == */
		$extp = sed_getextplugins('ratings.tags');
		if (is_array($extp))
			{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
		/* ===== */

		$t->parse("RATINGS");
		$res_display = $t->text("RATINGS");
		}
	else
		{
		$res_display = '';
		}

	return(array($res, $res_display));
	}

/* ------------------ */

function sed_build_stars($level)
	{
	global $skin;

	if ($level>0 and $level<100)
		{ return("<img src=\"skins/$skin/img/system/stars".(floor($level/10)+1).".gif\" alt=\"\" />"); }
	else
		{ return(''); }
	}

/* ------------------ */

function sed_build_timegap($t1,$t2)
	{
	global $L;

	$gap = $t2 - $t1;

  if ($gap<=0 || !$t2)
    {
    $result = '';
    }
  elseif ($gap<60)
    {
    $result  = $gap.' '.$L['Seconds'];
	  }
  elseif ($gap<3600)
    {
    $gap = floor($gap/60);
    $result = ($gap<2) ? '1 '.$L['Minute'] : $gap.' '.$L['Minutes'];
    }
  elseif ($gap<86400)
    {
    $gap1 = floor($gap/3600);
    $gap2 = floor(($gap-$gap1*3600)/60);
		$result = ($gap1<2) ? '1 '.$L['Hour'].' ' : $gap1.' '.$L['Hours'].' ';
		
    if ($gap2>0)
			{ $result .= ($gap2<2) ? '1 '.$L['Minute'] : $gap2.' '.$L['Minutes']; }
    }
  else
    {
    $gap = floor($gap/86400);
    $result = ($gap<2) ? '1 '.$L['Day'] : $gap.' '.$L['Days'];
    }

  return($result);
  }

/* ------------------ */

function sed_build_timezone($tz)
	{
	global $L;

	$result = 'GMT';

	if ($tz==-1 OR $tz==1)
		{ $result .= $tz.' '.$L['Hour']; }
	elseif ($tz!=0)
		{ $result .= $tz.' '.$L['Hours']; }
	return($result);
	}

/* ------------------ */

function sed_build_url($text, $maxlen=64)
	{
	global $cfg;

	if (!empty($text))
		{
		$text = sed_cc($text);
		$url = $text;
		if (stripos($url, 'http://') === FALSE)
			{ $url='http://'. $url; }

		$text = "<a href=\"".$url."\">".sed_cutstring($text, $maxlen)."</a>";
		}
	return($text);
	}

/* ------------------ */

function sed_build_user($id, $user)
	{
	global $cfg;

	if (($id==0 && !empty($user)))
		{ $result = $user; }
	elseif ($id==0)
		{ $result = ''; }
	else
		{ $result = (!empty($user)) ? "<a href=\"users.php?m=details&amp;id=".$id."\">".$user."</a>" : '?';	}
	return($result);
	}

/* ------------------ */

function sed_build_userimage($image)
	{
	if (!empty($image))
	      { $result = "<img src=\"".$image."\" alt=\"\" class=\"avatar\" />"; }
	return($result);
	}

/* ------------------ */

function sed_br2nl($text)
	{
	return(preg_replace('#<br\s*/?>#i', "\n", $text));
	}
 
/* ------------------ */

function sed_cache_clear($name)
	{
	global $db_cache;

	$sql = sed_sql_query("DELETE FROM $db_cache WHERE c_name='$name'");
	return(TRUE);
	}

/* ------------------ */

function sed_cache_clearall()
	{
	global $db_cache;
	$sql = sed_sql_query("DELETE FROM $db_cache");
	return(TRUE);
	}

/* ------------------ */

function sed_cache_get($name)
	{
	global $cfg, $sys, $db_cache;

	if (!$cfg['cache'])
          	{ return FALSE; }
	$sql = sed_sql_query("SELECT c_value FROM $db_cache WHERE c_name='$name' AND c_expire>'".$sys['now']."'");
	if ($row = sed_sql_fetchassoc($sql))
		{ return(unserialize($row['c_value'])); }
	else
    	{ return(FALSE); }
	}

/* ------------------ */

function sed_cache_getall($auto="1")
	{
	global $cfg, $sys, $db_cache;

	if (!$cfg['cache'])
          	{ return FALSE; }
	$sql = sed_sql_query("DELETE FROM $db_cache WHERE c_expire<'".$sys['now']."'");
	if ($auto)
		{ $sql = sed_sql_query("SELECT c_name, c_value FROM $db_cache WHERE c_auto=1"); }
       else
		{ $sql = sed_sql_query("SELECT c_name, c_value FROM $db_cache"); }
	if (sed_sql_numrows($sql)>0)
		{ return($sql); }
	else
    	{ return(FALSE); }
	}

/* ------------------ */

function sed_cache_store($name,$value,$expire,$auto="1")
	{
	global $db_cache, $sys, $cfg;

	if (!$cfg['cache'])
     	{ return(FALSE); }
	$sql = sed_sql_query("REPLACE INTO $db_cache (c_name, c_value, c_expire, c_auto) VALUES ('$name', '".sed_sql_prep(serialize($value))."', '".($expire + $sys['now'])."', '$auto')");
	return(TRUE);
	}

/* ------------------ */

function sed_cc($text)
	{
  
	$text = preg_replace('/&#([0-9]{2,4});/is','&&#35$1;',$text);
	$text = str_replace(
	array('{', '<', '>' , '$', '\'', '"', '\\', '&amp;', '&nbsp;'),
	array('&#123;', '&lt;', '&gt;', '&#036;', '&#039;', '&quot;', '&#92;', '&amp;amp;', '&amp;nbsp;'), $text);
	
  return($text);
	}

/* ------------------ */

function sed_check_xg()
	{
	global $xg, $cfg;

	if ($xg!=sed_sourcekey())
		{ sed_diefatal('Wrong parameter in the URL.'); }
	return (TRUE);
	}

/* ------------------ */

function sed_check_xp()
	{
	global $xp;

	$sk = sed_sourcekey();
	if ($_SERVER["REQUEST_METHOD"]=='POST' && !defined('SED_AUTH') && !defined('SED_DISABLE_XFORM') )
		{
		if ( empty($xp) || $xp!=$sk)
			{ sed_diefatal('Wrong parameter in the URL.'); }
		}
	return ($sk);
	}

/* ------------------ */

function sed_cutstring($res,$l)
	{
	global $cfg;

	$enc = strtolower($cfg['charset']);
	if ($enc=='utf-8')
		{
		if(mb_strlen($res)>$l)
			{ $res = mb_substr($res, 0, ($l-3), $enc).'...'; }
		}
	else
		{
		if(mb_strlen($res)>$l)
			{ $res = substr($res, 0, ($l-3)).'...'; }
		}
       return($res);
    }

/* ------------------ */

function sed_createthumb($img_big, $img_small, $small_x, $small_y, $keepratio, $extension, $filen, $fsize, $textcolor, $textsize, $bgcolor, $bordersize, $jpegquality, $dim_priority="Width")
	{
	if (!function_exists('gd_info'))
		{ return; }

	global $cfg;

	switch($extension)
		{
		case 'gif':
		$source = imagecreatefromgif($img_big);
		break;

		case 'png':
		$source = imagecreatefrompng($img_big);
		break;

		default:
		$source = imagecreatefromjpeg($img_big);
		break;
		}

	$big_x = imagesx($source);
	$big_y = imagesy($source);

	if (!$keepratio)
		{
		$thumb_x = $small_x;
		$thumb_y = $small_y;
		}
	elseif ($dim_priority=="Width")
		{
		$thumb_x = $small_x;
		$thumb_y = floor($big_y * ($small_x / $big_x));
		}
	else
		{
		$thumb_x = floor($big_x * ($small_y / $big_y));
		$thumb_y = $small_y;
		}

	if ($textsize==0)
		{
		if ($cfg['th_amode']=='GD1')
			{ $new = imagecreate($thumb_x+$bordersize*2, $thumb_y+$bordersize*2); }
		else
			{ $new = imagecreatetruecolor($thumb_x+$bordersize*2, $thumb_y+$bordersize*2); }

		$background_color = imagecolorallocate ($new, $bgcolor[0], $bgcolor[1] ,$bgcolor[2]);
		imagefilledrectangle ($new, 0,0, $thumb_x+$bordersize*2, $thumb_y+$bordersize*2, $background_color);

		if ($cfg['th_amode']=='GD1')
			{ imagecopyresized($new, $source, $bordersize, $bordersize, 0, 0, $thumb_x, $thumb_y, $big_x, $big_y); }
		else
			{ imagecopyresampled($new, $source, $bordersize, $bordersize, 0, 0, $thumb_x, $thumb_y, $big_x, $big_y); }

		}
   else
		{
		if ($cfg['th_amode']=='GD1')
			{ $new = imagecreate($thumb_x+$bordersize*2, $thumb_y+$bordersize*2+$textsize*3.5+6); }
		else
			{ $new = imagecreatetruecolor($thumb_x+$bordersize*2, $thumb_y+$bordersize*2+$textsize*3.5+6); }

		$background_color = imagecolorallocate($new, $bgcolor[0], $bgcolor[1] ,$bgcolor[2]);
		imagefilledrectangle ($new, 0,0, $thumb_x+$bordersize*2, $thumb_y+$bordersize*2+$textsize*4+14, $background_color);
		$text_color = imagecolorallocate($new, $textcolor[0],$textcolor[1],$textcolor[2]);

		if ($cfg['th_amode']=='GD1')
			{ imagecopyresized($new, $source, $bordersize, $bordersize, 0, 0, $thumb_x, $thumb_y, $big_x, $big_y); }
		else
			{ imagecopyresampled($new, $source, $bordersize, $bordersize, 0, 0, $thumb_x, $thumb_y, $big_x, $big_y); }

		imagestring ($new, $textsize, $bordersize, $thumb_y+$bordersize+$textsize+1, $big_x."x".$big_y." ".$fsize."kb", $text_color);
		}

	switch($extension)
		{
		case 'gif':
		imagegif($new, $img_small);
		break;

		case 'png':
		imagepng($new, $img_small);
		break;

		default:
		imagejpeg($new, $img_small, $jpegquality);
		break;
		}

	imagedestroy($new);
	imagedestroy($source);
	return;
	}

/* ------------------ */

function sed_die($cond=TRUE)
	{
	if ($cond)
		{
		header("Location: message.php?msg=950");
		exit;
		}
	return(FALSE);
	}

/* ------------------ */

function sed_diefatal($text='Reason is unknown.', $title='Fatal error')
	{
	global $cfg;

	$disp = "<strong><a href=\"".$cfg['mainurl']."\">".$cfg['maintitle']."</a></strong><br />";
	$disp .= @date('Y-m-d H:i').'<br />'.$title.' : '.$text;
	die($disp);
	}

/* ------------------ */

function sed_dieifdisabled($disabled)
	{
	if ($disabled)
		{
		header("Location: message.php?msg=940");
		exit;
		}
	return;
	}

/* ------------------ */

function sed_forum_info($id)
	{
	global $db_forum_sections;

	$sql = sed_sql_query("SELECT * FROM $db_forum_sections WHERE fs_id='$id'");
	if ($res = sed_sql_fetchassoc($sql))
		{ return ($res); }
	else
		{ return (''); }
	}

/* ------------------ */

function sed_forum_prunetopics($mode, $section, $param)
	{
	global $cfg, $sys, $db_forum_topics, $db_forum_posts, $db_forum_sections, $L;

	$num = 0;
	$num1 = 0;

	switch ($mode)
		{
		case 'updated':
		$limit = $sys['now'] - ($param*86400);
		$sql1 = sed_sql_query("SELECT * FROM $db_forum_topics WHERE ft_sectionid='$section' AND ft_updated<'$limit' AND ft_sticky='0'");
		break;

		case 'single':
		$sql1 = sed_sql_query("SELECT * FROM $db_forum_topics WHERE ft_sectionid='$section' AND ft_id='$param'");
		break;
		}

	if (sed_sql_numrows($sql1)>0)
		{
		while ($row1 = sed_sql_fetchassoc($sql1))
			{
			$q = $row1['ft_id'];

			if ($cfg['trash_forum'])
				{
				$sql = sed_sql_query("SELECT * FROM $db_forum_posts WHERE fp_topicid='$q' ORDER BY fp_id DESC");

				while ($row = sed_sql_fetchassoc($sql))
					{ sed_trash_put('forumpost', $L['Post']." #".$row['fp_id']." from topic #".$q, "p".$row['fp_id']."-q".$q, $row); }
				}

			$sql = sed_sql_query("DELETE FROM $db_forum_posts WHERE fp_topicid='$q'");
			$num += sed_sql_affectedrows();

			if ($cfg['trash_forum'])
				{
				$sql = sed_sql_query("SELECT * FROM $db_forum_topics WHERE ft_id='$q'");

				while ($row = sed_sql_fetchassoc($sql))
					{ sed_trash_put('forumtopic', $L['Topic']." #".$q." (no post left)", "q".$q, $row); }
				}

			$sql = sed_sql_query("DELETE FROM $db_forum_topics WHERE ft_id='$q'");
			$num1 += sed_sql_affectedrows();
			}

		$sql = sed_sql_query("DELETE FROM $db_forum_topics WHERE ft_movedto='$q'");
		$sql = sed_sql_query("UPDATE $db_forum_sections SET fs_topiccount=fs_topiccount-'$num1', fs_postcount=fs_postcount-'$num', fs_topiccount_pruned=fs_topiccount_pruned+'$num1', fs_postcount_pruned=fs_postcount_pruned+'$num' WHERE fs_id='$section'");
		}
       $num1 = ($num1=='') ? '0' : $num1;
	return($num1);
	}

/* ------------------ */

function sed_forum_sectionsetlast($id)
	{
	global $db_forum_topics, $db_forum_sections;

	$sql = sed_sql_query("SELECT ft_id, ft_lastposterid, ft_lastpostername, ft_updated, ft_title, ft_poll FROM $db_forum_topics WHERE ft_sectionid='$id' AND ft_movedto='0' and ft_mode='0' ORDER BY ft_updated DESC LIMIT 1");
	$row = sed_sql_fetchassoc($sql);
	$sql = sed_sql_query("UPDATE $db_forum_sections SET fs_lt_id=".(int)$row['ft_id'].", fs_lt_title='".sed_sql_prep($row['ft_title'])."', fs_lt_date=".(int)$row['ft_updated'].", fs_lt_posterid=".(int)$row['ft_lastposterid'].", fs_lt_postername='".sed_sql_prep($row['ft_lastpostername'])."' WHERE fs_id='$id'");
	return;
	}

/* ------------------ */

function sed_getextplugins($hook, $cond='R')
	{
	global $sed_plugins, $cfg, $sys;

	if (is_array($sed_plugins))
		{
		foreach($sed_plugins as $i => $k)
			{
			if ($k['pl_hook']==$hook && sed_auth('plug', $k['pl_code'], $cond))
        { 
        $extplugins[$i] = $k; 
        if ($cfg['devmode'])
		      { $sys['devmode']['hooks'][] = $k; } 
  
        }

			}
		}
   
	return ($extplugins);
	}

/* ------------------ */

function sed_get_comcount($code)
	{
	global $db_com;

	$sql = sed_sql_query("SELECT DISTINCT com_code, COUNT(*) FROM $db_com WHERE com_code='$code' GROUP BY com_code");

	if ($row = sed_sql_fetchassoc($sql))
		{ return($row['COUNT(*)']); }
	else
		{ return("0"); }
	}

/* ------------------ */


function sed_getcurrenturl()
  {
  $url = 'http';
  if ($_SERVER["HTTPS"] == "on") {$url .= "s";}
  $url .= "://";
  if ($_SERVER["SERVER_PORT"] != "80")
    { $url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; }
  else
    { $url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; }
 return(url);
}


function sed_htmlmetas()
	{
	global $cfg;
	$contenttype = "text/html";
	$result = "<meta http-equiv=\"content-type\" content=\"".$contenttype."; charset=".$cfg['charset']."\" />
<meta name=\"description\" content=\"".$cfg['maintitle']." - ".$cfg['subtitle']."\" />
<meta name=\"keywords\" content=\"".$cfg['metakeywords']."\" />
<meta name=\"generator\" content=\"Seditio by Neocrome http://www.neocrome.net\" />
<meta http-equiv=\"expires\" content=\"Fri, Apr 01 1974 00:00:00 GMT\" />
<meta http-equiv=\"pragma\" content=\"no-cache\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\" />
<meta http-equiv=\"last-modified\" content=\"".gmdate("D, d M Y H:i:s")." GMT\" />
<link rel=\"shortcut icon\" href=\"favicon.ico\" />
";
	return ($result);
	}

/* ------------------ */

function sed_image_merge($img1_file, $img1_extension, $img2_file, $img2_extension, $img2_x1, $img2_y1, $position='Param', $trsp=100, $jpegqual=100)
	{
	global $cfg;

	switch($img1_extension)
		{
		case 'gif':
		$img1 = imagecreatefromgif($img1_file);
		break;

		case 'png':
		$img1 = imagecreatefrompng($img1_file);
		break;

		default:
		$img1 = imagecreatefromjpeg($img1_file);
		break;
		}

	switch($img2_extension)
		{
		case 'gif':
		$img2 = imagecreatefromgif($img2_file);
		break;

		case 'png':
		$img2 = imagecreatefrompng($img2_file);
		break;

		default:
		$img2 = imagecreatefromjpeg($img2_file);
		break;
		}

	$img1_w = imagesx($img1);
	$img1_h = imagesy($img1);
	$img2_w = imagesx($img2);
	$img2_h = imagesy($img2);

	switch($position)
		{
		case 'Top left':
		$img2_x = 8;
		$img2_y = 8;
		break;

		case 'Top right':
		$img2_x = $img1_w - 8 - $img2_w;
		$img2_y = 8;
		break;

		case 'Bottom left':
		$img2_x = 8;
		$img2_y = $img1_h - 8 - $img2_h;
		break;

		case 'Bottom right':
		$img2_x = $img1_w - 8 - $img2_w;
		$img2_y = $img1_h - 8 - $img2_h;
		break;

		default:
		$img2_x = $img2_x1;
		$img2_y = $img2_y1;
		break;
		}

	imagecopymerge($img1, $img2, $img2_x, $img2_y, 0, 0, $img2_w, $img2_h, $trsp);

	switch($img1_extension)
		{
		case 'gif':
		imagegif($img1, $img1_file);
		break;

		case 'png':
		imagepng($img1, $img1_file);
		break;

		default:
		imagejpeg($img1, $img1_file, $jpegqual);
		break;
		}

	imagedestroy($img1);
	imagedestroy($img2);
	}

 /* ------------------ */

function sed_image_resize($img_big, $img_small, $small_x, $extension, $jpegquality)
	{
	if (!function_exists('gd_info'))
		{ return; }

	global $cfg;

	switch($extension)
		{
		case 'gif':
		$source = imagecreatefromgif($img_big);
		break;

		case 'png':
		$source = imagecreatefrompng($img_big);
		break;

		default:
		$source = imagecreatefromjpeg($img_big);
		break;
		}

	$big_x = imagesx($source);
	$big_y = imagesy($source);

	$thumb_x = $small_x;
	$thumb_y = floor($big_y * ($small_x / $big_x));

	if ($cfg['th_amode']=='GD1')
		{ $new = imagecreate($thumb_x, $thumb_y); }
	else
		{ $new = imagecreatetruecolor($thumb_x, $thumb_y); }

	if ($cfg['th_amode']=='GD1')
		{ imagecopyresized($new, $source, 0, 0, 0, 0, $thumb_x, $thumb_y, $big_x, $big_y); }
	else
		{ imagecopyresampled($new, $source, 0, 0, 0, 0, $thumb_x, $thumb_y, $big_x, $big_y); }

	switch($extension)
		{
		case 'gif':
		imagegif($new, $img_small);
		break;

		case 'png':
		imagepng($new, $img_small);
		break;

		default:
		imagejpeg($new, $img_small, $jpegquality);
		break;
		}

	imagedestroy($new);
	imagedestroy($source);
	return;
	}


/* ------------------ */

function sed_import($name, $source, $filter, $maxlen=0, $dieonerror=FALSE)
	{
	switch($source)
		{
		case 'G':
		$v = $_GET[$name];
		$log = TRUE;
		break;

		case 'P':
		$v = $_POST[$name];
		$log = TRUE;
		if ($filter=='ARR') { return($v); }
		break;

		case 'C':
		$v = $_COOKIE[$name];
		$log = TRUE;
		break;

		case 'D':
		$v = $name;
		$log = FALSE;
		break;

		default:
		sed_diefatal('Unknown source for a variable : <br />Name = '.$name.'<br />Source = '.$source.' ? (must be G, P, C or D)');
		break;
		}

	if ($v=='')
       	{ return(''); }

    if ($maxlen>0)
    	{ $v = substr($v, 0, $maxlen); }

	$pass = FALSE;
	$defret = NULL;
	$filter = ($filter=='STX') ? 'TXT' : $filter;

	switch($filter)
		{
		case 'INT':
		if (is_numeric($v)==TRUE && floor($v)==$v)
	       	{ $pass = TRUE; }
		break;

		case 'NUM':
		if (is_numeric($v)==TRUE)
	       	{ $pass = TRUE; }
		break;

		case 'TXT':
		$v = trim($v);
		if (strpos($v, '<')===FALSE)
	       	{ $pass = TRUE; }
       else
			{ $defret = str_replace('<', '&lt;', $v); }
		break;

		case 'SLU':
		$v = trim($v);
		$f = preg_replace('/[^a-zA-Z0-9_=\/]/', '', $v);
		if ($v == $f)
	       	{ $pass = TRUE; }
     	else
			{ $defret = ''; }
		break;

		case 'ALP':
		$v = trim($v);
		$f = sed_alphaonly($v);
		if ($v == $f)
	       	{ $pass = TRUE; }
       else
			{ $defret = $f; }
		break;

		case 'PSW':
		$v = trim($v);
		$f = sed_alphaonly($v);
		$f = substr($f, 0 ,32);

		if ($v == $f)
	    { $pass = TRUE; }
		else
			{ $defret = $f; }
		break;

		case 'H32':
		$v = trim($v);
		$f = sed_alphaonly($v);
		$f = substr($f, 0 ,32);

		if ($v == $f)
	    { $pass = TRUE; }
		else
			{ $defret = $f; }
		break;

		case 'HTM':
		$v = trim($v);
		$pass = TRUE;
		break;

		case 'ARR':
		if (TRUE)	// !!!!!!!!!!!
	       	{ $pass = TRUE; }
		break;

		case 'BOL':
		if ($v=="1" || $v=="on")
	       	{
	       	$pass = TRUE;
	       	$v = "1";
	       	}
		elseif ($v=="0" || $v=="off")
	       	{
	       	$pass = TRUE;
	       	$v = "0";
	       	}
	   	else
	       	{
	       	$defret = "0";
	       	}
		break;

		case 'LVL':
		if (is_numeric($v)==TRUE && $v>=0 && $v<=100 && floor($v)==$v)
	       	{ $pass = TRUE; }
		else
			{ $defret = NULL; }
		break;

		case 'NOC':
		$pass = TRUE;
		break;

		default:
		sed_diefatal('Unknown filter for a variable : <br />Var = '.$cv_v.'<br />Filter = '.$filter.' ?');
		break;
		}

	if ($pass)
		{ return($v); }
	else
		{
		if ($log) { sed_log_sed_import($source, $filter, $name, $v); }
		if ($dieonerror)
			{ sed_diefatal('Wrong input.'); }
		else
			{ return($defret); }
		}
	}


/* ------------------ */

function sed_infoget($file, $limiter='SED', $maxsize=32768)
	{
	$result = array();

	if ($fp = @fopen($file, 'r'))
		{
		$limiter_begin = "[BEGIN_".$limiter."]";
		$limiter_end = "[END_".$limiter."]";
		$data = fread($fp, $maxsize);
		$begin = strpos($data, $limiter_begin);
		$end = strpos($data, $limiter_end);

		if ($end>$begin && $begin>0)
			{
			$lines = substr($data, $begin+8+mb_strlen($limiter), $end-$begin-mb_strlen($limiter)-8);
			$lines = explode ("\n",$lines);

			foreach ($lines as $k => $line)
				{
				$linex = explode ("=", $line);
				$ii=1;
				while (!empty($linex[$ii]))
					{
					$result[$linex[0]] .= trim($linex[$ii]);
					$ii++;
					}
				}
			}
		elseif (substr(strtolower($file), strlen($file)-12) == ".install.php")
			{ $result['Error'] = 'Optional install file'; }
		elseif (substr(strtolower($file), strlen($file)-14) == ".uninstall.php")
			{ $result['Error'] = 'Optional uninstall file'; }
		else
			{ $result['Error'] = 'Warning: No markers found in '.$file; }
		}
	else
		{ $result['Error'] = 'Error: File '.$file.' is missing!'; }
	@fclose($fp);
	return ($result);
	}

/* ------------------ */

function sed_javascript($more='')
	{
	$result = "<script type=\"text/javascript\">
<!--

function popup(code,w,h)
	{ window.open('plug.php?o='+code,'','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width='+w+',height='+h+',left=32,top=16'); }

function pfs(id,c1,c2)
	{ window.open('pfs.php?userid='+id+'&c1='+c1+'&c2='+c2,'PFS','status=1, toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width=754,height=512,left=32,top=16'); }

function help(rcode,c1,c2)
	{ window.open('plug.php?h='+rcode+'&c1='+c1+'&c2='+c2,'Help','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=32,top=16'); }

function comments(rcode)
	{ window.open('comments.php?id='+rcode,'Comments','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=16,top=16'); }

function ratings(rcode)
	{ window.open('ratings.php?id='+rcode,'Ratings','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=16,top=16'); }

function polls(rcode)
	{ window.open('polls.php?id='+rcode,'Polls','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=608,height=448,left=16,top=16'); }

function pollvote(rcode,rvote)
	{ window.open('polls.php?a=send&id='+rcode+'&vote='+rvote,'Polls','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=608,height=448,left=16,top=16'); }

function picture(url,sx,sy)
	{
  var ptop=(window.screen.height-200)/2;
  var pleft=(window.screen.width-200)/2;
  window.open(url,'Picture','toolbar=0,location=0,status=0, directories=0,menubar=0,resizable=1,scrollbars=yes,width='+sx+',height='+sy+',left='+pleft+',top='+ptop+'');
  }

function redirect(url)
	{ location.href = url.options[url.selectedIndex].value; }

function toggleblock(id)
	{
	var bl = document.getElementById(id);
	if(bl.style.display == 'none')
		{ bl.style.display = ''; }
	else
		{ bl.style.display = 'none'; }
	}

window.name='main';

function sed_ajax_getxmlhttp()
	{
  	var xmlhttp = false;
  	if (window.XMLHttpRequest)
  		{ xmlhttp = new XMLHttpRequest() }
	else if (window.ActiveXObject)
		{
		try
    		{ xmlhttp = new ActiveXObject(\"Msxml2.XMLHTTP\") }
		catch (e)
			{
			try
				{ xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\") }
			catch (E)
				{ xmlhttp=false }
			}
		}
	return xmlhttp;
	}

function sed_ajax_pass(url, callbackFunction, params)
	{
	var xmlhttp = new sed_ajax_getxmlhttp();

	if (xmlhttp)
		{
		xmlhttp.onreadystatechange =
		function ()
           	{
           	if (xmlhttp && xmlhttp.readyState==4)
           		{
				if (xmlhttp.status==200)
					{
               		var response = xmlhttp.responseText;
               		var functionToCall = callbackFunction + '(response,'+params+')';
					eval(functionToCall);
					}
				}
			}
    	xmlhttp.open(\"GET\",url,true);
    	xmlhttp.send(null);
		}
	}

function sed_ajax_set(url, obj_id)
	{
	var xmlhttp = new sed_ajax_getxmlhttp();

	if (xmlhttp)
		{
    	xmlhttp.onreadystatechange =
		function ()
			{
			if (xmlhttp && xmlhttp.readyState==4)
				{
                if (xmlhttp.status==200)
	                {
                  	if(typeof obj_id == 'object')
                  		{ obj_id.innerHTML = xmlhttp.responseText; }
                  	else
                  		{ document.getElementById(obj_id).innerHTML = xmlhttp.responseText; }
                	}
                }
            }
    	xmlhttp.open(\"GET\",url,true);
		xmlhttp.send(null);
		}
	}







".$more."

//-->
</script>";
	return ($result);
	}

/* ------------------ */

function sed_loadbbcodes()
	{
	global $location;

	$result = array();
	$result[]=array('[b][/b]','bold');
	$result[]=array('[u][/u]','underline');
	$result[]=array('[i][/i]','italic');
	$result[]=array('[left][/left]','left');
	$result[]=array('[center][/center]','center');
	$result[]=array('[right][/right]','right');
	$result[]=array('[_]','spacer');
	$result[]=array('[code][/code]','code');
	$result[]=array('[quote][/quote]','quote');
	$result[]=array('\n[list]1\n2\n3\[/list]','list');
	$result[]=array('[t=thumbnail]fullsize[/t]','thumb');
	$result[]=array('[img][/img]','image');
	$result[]=array('[colleft][/colleft]','colleft');
	$result[]=array('[colright][/colright]','colright');
	$result[]=array('[url][/url]','url');
	$result[]=array('[url=][/url]','urlp');
	$result[]=array('[email][/email]','email');
	$result[]=array('[email=][/email]','emailp');
	$result[]=array('[user=][/user]','user');
	$result[]=array('[page=][/page]','page');
	$result[]=array('[link=][/link]','link');
	$result[]=array('[p][/p]','p');
	$result[]=array('[ac=][/ac]','ac');
	$result[]=array('[topic=][/topic]','topic');
	$result[]=array('[post=][/post]','post');
	$result[]=array('[black][/black]','black');
	$result[]=array('[grey][/grey]','grey');
	$result[]=array('[sea][/sea]','sea');
	$result[]=array('[blue][/blue]','blue');
	$result[]=array('[sky][/sky]','sky');
	$result[]=array('[green][/green]','green');
	$result[]=array('[yellow][/yellow]','yellow');
	$result[]=array('[orange][/orange]','orange');
	$result[]=array('[red][/red]','red');
	$result[]=array('[white][/white]','white');
	$result[]=array('[pink][/pink]','pink');
	$result[]=array('[purple][/purple]','purple');
	$result[]=array('[hr]','hr');
	$result[]=array('[f][/f]','flag');
	$result[]=array('[style=1][/style]','style1');
	$result[]=array('[style=2][/style]','style2');
	$result[]=array('[style=3][/style]','style3');
	$result[]=array('[style=4][/style]','style4');
	$result[]=array('[style=5][/style]','style5');
	$result[]=array('[style=6][/style]','style6');
	$result[]=array('[style=7][/style]','style7');
	$result[]=array('[style=8][/style]','style8');
	$result[]=array('[style=9][/style]','style9');

	if ($location=='Pages')
		{ $result[]=array('[newpage]\n[title]...[/title]','multipages'); }
	elseif ($location=='Newstopic')
		{ $result[]=array('[more]','more'); }

	return($result);
	}

/* ------------------ */

function sed_load_structure()
	{
	global $db_structure, $cfg, $L;

	$res = array();
	$sql = sed_sql_query("SELECT * FROM $db_structure ORDER BY structure_path ASC");

	while ($row = sed_sql_fetchassoc($sql))
		{
		if (!empty($row['structure_icon']))
			{ $row['structure_icon'] = "<img src=\"".$row['structure_icon']."\" alt=\"\" />"; }

		$path2 = strrpos($row['structure_path'], '.');

		$row['structure_tpl'] = (empty($row['structure_tpl'])) ? $row['structure_code'] : $row['structure_tpl'];

		if ($path2>0)
			{
			$path1 = substr($row['structure_path'],0,($path2));
			$path[$row['structure_path']] = $path[$path1].'.'.$row['structure_code'];
			$tpath[$row['structure_path']] = $tpath[$path1].' '.$cfg['separator'].' '.$row['structure_title'];
			$row['structure_tpl'] = ($row['structure_tpl']=='same_as_parent') ? $parent_tpl : $row['structure_tpl'];
			}
		else
			{
			$path[$row['structure_path']] = $row['structure_code'];
			$tpath[$row['structure_path']] = $row['structure_title'];
			}

		$order = explode('.',$row['structure_order']);
		$parent_tpl = $row['structure_tpl'];

		$res[$row['structure_code']] = array (
			'path' => $path[$row['structure_path']],
			'tpath' => $tpath[$row['structure_path']],
			'rpath' => $row['structure_path'],
			'tpl' => $row['structure_tpl'],
			'title' => $row['structure_title'],
			'desc' => $row['structure_desc'],
			'icon' => $row['structure_icon'],
			'group' => $row['structure_group'],
			'order' => $order[0],
			'way' => $order[1]
				);
		}

	return($res);
	}

/* ------------------ */

function sed_load_forum_structure()
	{
	global $db_forum_structure, $cfg, $L;

	$res = array();
	$sql = sed_sql_query("SELECT * FROM $db_forum_structure ORDER BY fn_path ASC");

	while ($row = sed_sql_fetchassoc($sql))
		{
		if (!empty($row['fn_icon']))
			{ $row['fn_icon'] = "<img src=\"".$row['fn_icon']."\" alt=\"\" />"; }

		$path2 = strrpos($row['fn_path'], '.');

		$row['fn_tpl'] = (empty($row['fn_tpl'])) ? $row['fn_code'] : $row['fn_tpl'];

		if ($path2>0)
			{
			$path1 = substr($row['fn_path'],0,($path2));
			$path[$row['fn_path']] = $path[$path1].'.'.$row['fn_code'];
			$tpath[$row['fn_path']] = $tpath[$path1].' '.$cfg['separator'].' '.$row['fn_title'];
			$row['fn_tpl'] = ($row['fn_tpl']=='same_as_parent') ? $parent_tpl : $row['fn_tpl'];
			}
		else
			{
			$path[$row['fn_path']] = $row['fn_code'];
			$tpath[$row['fn_path']] = $row['fn_title'];
			}

		$parent_tpl = $row['fn_tpl'];

		$res[$row['fn_code']] = array (
			'path' => $path[$row['fn_path']],
			'tpath' => $tpath[$row['fn_path']],
			'rpath' => $row['fn_path'],
			'tpl' => $row['fn_tpl'],
			'title' => $row['fn_title'],
			'desc' => $row['fn_desc'],
			'icon' => $row['fn_icon'],
			'defstate' => $row['fn_defstate']
				);
		}

	return($res);
	}

/* ------------------ */

function sed_log($text, $group='def')
	{
	global $db_logger, $sys, $usr, $_SERVER;

	$sql = sed_sql_query("INSERT INTO $db_logger (log_date, log_ip, log_name, log_group, log_text) VALUES (".(int)$sys['now_offset'].", '".$usr['ip']."', '".sed_sql_prep($usr['name'])."', '$group', '".sed_sql_prep($text.' - '.$_SERVER['REQUEST_URI'])."')");
	return;
	}

/* ------------------ */

function sed_log_sed_import($s, $e, $v, $o)
	{
	$text = "A variable type check failed, expecting ".$s."/".$e." for '".$v."' : ".$o;
	sed_log($text, 'sec');
	return;
	}

/* ------------------ */

function sed_mail($fmail, $subject, $body, $headers='', $param='', $content='plain')
	{
	global $cfg;

	if(empty($fmail))
		{
		return(FALSE);
		}
	else
		{
		$headers = (empty($headers)) ? "From: \"".$cfg['maintitle']."\" <".$cfg['adminemail'].">\n"."Reply-To: <".$cfg['adminemail'].">\n"."Content-Type: text/".$content."; charset=".$cfg['charset']."\n" : $headers;
		$param = empty($param) ? "-f".$cfg['adminemail'] : $param;
		$body .= "\n\n".$cfg['maintitle']." - ".$cfg['mainurl']."\n".$cfg['subtitle'];
		mail($fmail, $subject, $body, $headers, $param);
		sed_stat_inc('totalmailsent');
		return(TRUE);
		}
	}

/* ------------------ */

function sed_mktime($hour = false, $minute = false, $second = false, $month = false, $date = false, $year = false)
	{
    // Code from http://www.php.net/date
    // Author rickenmeer at hotmail dot com
    // 12-Jan-2004 12:30

	if ($hour === false)  $hour  = Date ('G');
	if ($minute === false) $minute = Date ('i');
	if ($second === false) $second = Date ('s');
	if ($month === false)  $month  = Date ('n');
	if ($date === false)  $date  = Date ('j');
	if ($year === false)  $year  = Date ('Y');

	if ($year >= 1970) return mktime ($hour, $minute, $second, $month, $date, $year);

	$m_days = Array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	if ($year % 4 == 0 && ($year % 100 > 0 || $year % 400 == 0))
		{ $m_days[1] = 29;  }

	$d_year = 1970 - $year;
	$days = 0 - $d_year * 365;
	$days -= floor ($d_year / 4);
	$days += floor (($d_year - 70) / 100);
	$days -= floor (($d_year - 370) / 400);

	for ($i = 1; $i < $month; $i++)
		{ $days += $m_days [$i - 1]; }
	$days += $date - 1;

	$stamp = $days * 86400;
	$stamp += $hour * 3600;
	$stamp += $minute * 60;
	$stamp += $second;

	return $stamp;
   }

/* ------------------ */

function sed_mobile_detect()
	{
	if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']))
		{ return(TRUE); }

	if (isset ($_SERVER['HTTP_ACCEPT']))
    {
    if (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'wap') !== FALSE)
			{ return(TRUE); }
    }

  if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
    if (strpos ($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== FALSE)
      { return(TRUE); }

    if (strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
      { return(TRUE); }
    }
    return(FALSE);
  }

/* ------------------ */

function sed_outputfilters($output)
	{
	global $cfg;

	/* === Hook === */
	$extp = sed_getextplugins('output');
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ==== */

  if (!defined('SED_DISABLE_XFORM'))
    {
    $output = str_replace('</FORM>', '</form>', $output);
    $output = str_replace('</form>', sed_xp().'</form>', $output);
    }

  return($output);
  }

/* ------------------ */

function sed_pagination($url, $current, $entries, $perpage)
	{
	global $cfg;

	if ($entries<=$perpage)
		{ return (""); }

	$totalpages = ceil($entries / $perpage);
	$currentpage = $current / $perpage;

	for ($i = 0; $i < $totalpages; $i++)
		{
		$j = $i * $perpage;
		if ($i==$currentpage)
			{ $res .= sprintf($cfg['pagination_cur'], "<a href=\"".$url."&amp;d=".$j."\">".($i+1)."</a>"); }
		elseif (is_int(($i+1)/10) || $i<4 || ($totalpages-$i)<4 || abs($i-$currentpage)<4)
			{ $res .= sprintf($cfg['pagination'], "<a href=\"".$url."&amp;d=".$j."\">".($i+1)."</a>"); }
		}
	return ($res);
	}

/* ------------------ */

function sed_pagination_pn($url, $current, $entries, $perpage, $res_array=FALSE)
	{
	global $L, $sed_img_left, $sed_img_right;

	if ($current>0)
		{
		$prevpage = $current - $perpage;
		if ($prevpage<0)
			{ $prevpage = 0; }
		$res_l = "<a href=\"".$url."&amp;d=".$prevpage."\">".$L['Previous']." $sed_img_left</a>";
		}

	if (($current + $perpage)<$entries)
		{
		$nextpage = $current + $perpage;
		$res_r = "<a href=\"".$url."&amp;d=".$nextpage."\">$sed_img_right ".$L['Next']."</a>";
		}
	if ($res_array)
		{ return (array($res_l, $res_r)); }
	else
		{ return ($res_l." ".$res_r); }
	}
/* ------------------ */

function sed_parse($text, $parse_bbcodes=TRUE, $parse_smilies=TRUE, $parse_newlines=TRUE)
	{
	global  $sys, $sed_smilies, $L;

	$text = ' '.$text;
	$code = array();
	$unique_seed = $sys['unique'];
	$ii = 10000;

	if ($parse_bbcodes)
		{
		$p1 = 1;
		$p2 = 1;
		while ($p1>0 && $p2>0 && $ii<10031)
			{
			$ii++;
			$p1 = strpos($text, '[code]');
			$p2 = strpos($text, '[/code]');
			if ($p2>$p1 && $p1>0)
				{
				$key = '**'.$ii.$unique_seed.'**';
				$code[$key]= substr ($text, $p1+6, ($p2-$p1)-6);
				$code_len = mb_strlen($code[$key])+13;
				$code[$key] = str_replace('\t','&nbsp; &nbsp;', $code[$key]);
				$code[$key] = str_replace('  ', '&nbsp; ', $code[$key]);
				$code[$key] = str_replace('  ', ' &nbsp;', $code[$key]);
				$code[$key] = str_replace(
				array('{', '<', '>' , '\'', '"', "<!--", '$' ),
				array('&#123;', '&lt;', '&gt;', '&#039;', '&quot;', '"&#60;&#33;--"', '&#036;' ),$code[$key]);
				$code[$key] = "<div class=\"codetitle\">".$L['bbcodes_code'].":</div><div class=\"code\">".trim($code[$key])."</div>";
				$text = substr_replace($text, $key, $p1, $code_len);
				}
			}
		}

	if ($parse_smilies && is_array($sed_smilies))
		{
		reset($sed_smilies);
		while ((list($j,$dat) = each($sed_smilies)))
			{
			$ii++;
			$key = '**'.$ii.$unique_seed.'**';
			$code[$key]= "<img src=\"".$dat['smilie_image']."\" alt=\"\" />";
			$text = str_replace($dat['smilie_code'], $key, $text);
			}
		}

	if ($parse_bbcodes)
		{ $text = sed_bbcode($text); }

	if ($parse_bbcodes || $parse_smilies)
		{
		foreach($code as $x => $y)
			{ $text = str_replace($x, $y, $text); }
		}

	if ($parse_newlines)
		{ $text = nl2br($text); }

       return(substr($text, 1));
	}

/* ------------------ */

function sed_pfs_deleteall($userid)
	{
	global $db_pfs_folders, $db_pfs, $cfg;

	if (!$userid)
		{ return; }
	$sql = sed_sql_query("DELETE FROM $db_pfs_folders WHERE pff_userid='$userid'");
	$num = $num + sed_sql_affectedrows();
	$sql = sed_sql_query("DELETE FROM $db_pfs WHERE pfs_userid='$userid'");
	$num = $num + sed_sql_affectedrows();

	$bg = $userid.'-';
	$bgl = mb_strlen($bg);

	$handle = @opendir($cfg['pfs_dir']);
	while ($f = @readdir($handle))
		{
		if (substr($f, 0, $bgl)==$bg)
			{ @unlink($cfg['pfs_dir'].$f); }
		}
	@closedir($handle);

	$handle = @opendir($cfg['th_dir']);
	while ($f = @readdir($handle))
		{
		if (substr($f, 0, $bgl)==$bg)
			{ @unlink($cfg['th_dir'].$f); }
		}
	@closedir($handle);

	return($num);
	}




/* ------------------ */

function sed_readraw($file)
	{
	if ($fp = @fopen($file, 'r'))
		{
		$res = fread($fp, 256000);
		@fclose($fp);
		}
	else
		{
		$res = "File not found : ".$file;
		}
	return($res);
	}

/* ------------------ */

function sed_redirect($url)
	{
	global $cfg;

	if ($cfg['redirmode'])
		{
		$output = $cfg['doctype']."
		<html>
		<head>
		<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />
		<meta http-equiv=\"refresh\" content=\"0; url=".$url."\" />
		<title>Redirecting...</title></head>
		<body>Redirecting to <a href=\"".$url."\">".$cfg['mainurl']."/".$url."</a>
		</body>
		</html>";
		header("Refresh: 0; URL=".$url);
		echo($output);
		exit;
		}
	else
		{
		header("Location: ".$url);
		exit;
		}
	return;
	}

/* ------------------ */

function sed_selectbox($check, $name, $values)
	{
	$check = trim($check);
	$values = explode(',', $values);
	$selected = (empty($check) || $check=="00") ? "selected=\"selected\"" : '';
	$result =  "<select name=\"$name\" size=\"1\"><option value=\"\" $selected>---</option>";
	foreach ($values as $k => $x)
		{
		$x = trim($x);
		$selected = ($x == $check) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$x\" $selected>".sed_cc($x)."</option>";
		}
	$result .= "</select>";
	return($result);
	}

/* ------------------ */

function sed_selectbox_categories($check, $name, $hideprivate=TRUE)
	{
	global $db_structure, $usr, $sed_cat, $L;

	$result =  "<select name=\"$name\" size=\"1\">";

	foreach($sed_cat as $i => $x)
		{
		$display = ($hideprivate) ? sed_auth('page', $i, 'W') : TRUE;

		if (sed_auth('page', $i, 'R') && $i!='all' && $display)
			{
			$selected = ($i==$check) ? "selected=\"selected\"" : '';
			$result .= "<option value=\"".$i."\" $selected> ".$x['tpath']."</option>";
			}
		}
	$result .= "</select>";
	return($result);
	}

/* ------------------ */

function sed_selectbox_countries($check,$name)
	{
	global $sed_countries;

	$selected = (empty($check) || $check=='00') ? "selected=\"selected\"" : '';
	$result =  "<select name=\"$name\" size=\"1\">";
	foreach($sed_countries as $i => $x)
		{
		$selected = ($i==$check) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$i\" $selected>".$x."</option>";
		}
	$result .= "</select>";

	return($result);
	}

/* ------------------ */

function sed_selectbox_date($utime, $mode, $ext='')
	{
	global $L;
	list($s_year, $s_month, $s_day, $s_hour, $s_minute) = explode('-', @date('Y-m-d-H-i', $utime));
	$p_monthes = array();
	$p_monthes[] = array(1, $L['January']);
	$p_monthes[] = array(2, $L['February']);
	$p_monthes[] = array(3, $L['March']);
	$p_monthes[] = array(4, $L['April']);
	$p_monthes[] = array(5, $L['May']);
	$p_monthes[] = array(6, $L['June']);
	$p_monthes[] = array(7, $L['July']);
	$p_monthes[] = array(8, $L['August']);
	$p_monthes[] = array(9, $L['September']);
	$p_monthes[] = array(10, $L['October']);
	$p_monthes[] = array(11, $L['November']);
	$p_monthes[] = array(12, $L['December']);

	$result = "<select name=\"ryear".$ext."\">";
	for ($i = 1902; $i<2030; $i++)
		{
		$selected = ($i==$s_year) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$i\" $selected>$i</option>";
		}
	$result .= ($utime==0) ? "<option value=\"0\" selected=\"selected\">---</option>" : "<option value=\"0\">---</option>";

	$result .= "</select><select name=\"rmonth".$ext."\">";
	reset($p_monthes);
	foreach ($p_monthes as $k => $line)
		{
		$selected = ($line[0]==$s_month) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"".$line[0]."\" $selected>".$line[1]."</option>";
		}
	$result .= ($utime==0) ? "<option value=\"0\" selected=\"selected\">---</option>" : "<option value=\"0\">---</option>";

	$result .= "</select><select name=\"rday".$ext."\">";
	for ($i = 1; $i<32; $i++)
		{
		$selected = ($i==$s_day) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$i\" $selected>$i</option>";
		}
	$result .= ($utime==0) ? "<option value=\"0\" selected=\"selected\">---</option>" : "<option value=\"0\">---</option>";
	$result .= "</select> ";

	if ($mode=='short')
		{ return ($result); }

	$result .= " <select name=\"rhour".$ext."\">";
	for ($i = 0; $i<24; $i++)
		{
		$selected = ($i==$s_hour) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$i\" $selected>".sprintf("%02d",$i)."</option>";
		}
	$result .= ($utime==0) ? "<option value=\"0\" selected=\"selected\">---</option>" : "<option value=\"0\">---</option>";

	$result .= "</select>:<select name=\"rminute".$ext."\">";
	for ($i = 0; $i<60; $i=$i+1)
		{
		$selected = ($i==$s_minute) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$i\" $selected>".sprintf("%02d",$i)."</option>";
		}
	$result .= ($utime==0) ? "<option value=\"0\" selected=\"selected\">---</option>" : "<option value=\"0\">---</option>";
	$result .= "</select>";

	return ($result);
	}

/* ------------------ */

function sed_selectbox_folders($user, $skip, $check)
	{
	global $db_pfs_folders;

	$sql = sed_sql_query("SELECT pff_id, pff_title, pff_type FROM $db_pfs_folders WHERE pff_userid='$user' ORDER BY pff_title ASC");

	$result =  "<select name=\"folderid\" size=\"1\">";

	if ($skip!="/" && $skip!="0")
		{
		$selected = (empty($check) || $check=="/") ? "selected=\"selected\"" : '';
		$result .=  "<option value=\"0\" $selected>/ &nbsp; &nbsp;</option>";
		}

	while ($row = sed_sql_fetchassoc($sql))
		{
		if ($skip!=$row['pff_id'])
			{
			$selected = ($row['pff_id']==$check) ? "selected=\"selected\"" : '';
			$result .= "<option value=\"".$row['pff_id']."\" $selected>".sed_cc($row['pff_title'])."</option>";
			}
		}
	$result .= "</select>";
	return ($result);
	}

/* ------------------ */

function sed_selectbox_forumcat($check, $name)
	{
	global $usr, $sed_forums_str, $L;

	$result =  "<select name=\"$name\" size=\"1\">";

	foreach($sed_forums_str as $i => $x)
		{
		$selected = ($i==$check) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"".$i."\" $selected> ".$x['tpath']."</option>";
		}
	$result .= "</select>";
	return($result);
	}


/* ------------------ */

function sed_selectbox_gender($check,$name)
	{
	global $L;

	$genlist = array ('U', 'M', 'F');
	$result =  "<select name=\"$name\" size=\"1\">";
	foreach(array ('U', 'M', 'F') as $i)
		{
		$selected = ($i==$check) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"$i\" $selected>".$L['Gender_'.$i]."</option>";
		}
	$result .= "</select>";
	return($result);
	}

/* ------------------ */

function sed_selectbox_groups($check, $name, $skip=array(0))
	{
	global $sed_groups;

	$res = "<select name=\"$name\" size=\"1\">";

	foreach($sed_groups as $k => $i)
		{
		$selected = ($k==$check) ? "selected=\"selected\"" : '';
		$res .= (in_array($k, $skip)) ? '' : "<option value=\"$k\" $selected>".$sed_groups[$k]['title']."</option>";
		}
	$res .= "</select>";

	return($res);
	}

/* ------------------ */

function sed_selectbox_lang($check, $name)
	{
	global $sed_languages, $sed_countries;

	$handle = opendir("system/lang/");
	while ($f = readdir($handle))
		{
		if ($f[0] != '.')
			{ $langlist[] = $f; }
		}
	closedir($handle);
	sort($langlist);

	$result = "<select name=\"$name\" size=\"1\">";
	while(list($i,$x) = each($langlist))
		{
		$selected = ($x==$check) ? "selected=\"selected\"" : '';
		$lng = (empty($sed_languages[$x])) ? $sed_countries[$x] : $sed_languages[$x];
		$result .= "<option value=\"$x\" $selected>".$lng." (".$x.")</option>";
		}
	$result .= "</select>";

	return($result);
	}

/* ------------------ */

function sed_selectbox_sections($check, $name)
	{
	global $db_forum_sections, $cfg;

	$sql = sed_sql_query("SELECT fs_id, fs_title, fs_category FROM $db_forum_sections WHERE 1 ORDER by fs_order ASC");
	$result = "<select name=\"$name\" size=\"1\">";
	while ($row = sed_sql_fetchassoc($sql))
			{
			$selected = ($row['fs_id'] == $check) ? "selected=\"selected\"" : '';
			$result .= "<option value=\"".$row['fs_id']."\" $selected>".sed_cc(sed_cutstring($row['fs_category'], 24));
			$result .= ' '.$cfg['separator'].' '.sed_cc(sed_cutstring($row['fs_title'], 32));
			}
	$result .= "</select>";
	return($result);
	}

/* ------------------ */

function sed_selectbox_skin($check, $name)
	{
	$handle = opendir("skins/");
	while ($f = readdir($handle))
		{
		if (strpos($f, '.')  === FALSE)
			{ $skinlist[] = $f; }
		}
	closedir($handle);
	sort($skinlist);

	$result = "<select name=\"$name\" size=\"1\">";
	while(list($i,$x) = each($skinlist))
		{
		$selected = ($x==$check) ? "selected=\"selected\"" : '';
		$skininfo = "skins/".$x."/".$x.".php";
		if (file_exists($skininfo))
			{
			$info = sed_infoget($skininfo);
			$result .= (!empty($info['Error'])) ? "<option value=\"$x\" $selected>".$x." (".$info['Error'].")" : "<option value=\"$x\" $selected>".$info['Name'];
			}
		else
			{ $result .= "<option value=\"$x\" $selected>".$x; }
		$result .= "</option>";
		}
	$result .= "</select>";

	return($result);
	}

/* ------------------ */

function sed_radiobox_skin($check, $name)
	{
	$handle = opendir("skins/");
	while ($f = readdir($handle))
		{
		if (strpos($f, '.')  === FALSE)
			{ $skinlist[] = $f; }
		}
	closedir($handle);
	sort($skinlist);

	while(list($i,$x) = each($skinlist))
		{
		$checked = ($x==$check) ? "checked=\"checked\"" : '';
		$skininfo = "skins/".$x."/".$x.".php";
		$info = sed_infoget($skininfo);
		$result .= (!empty($info['Error'])) ? $x." (".$info['Error'].")" : "<table class=\"flat\"><tr><td><img src=\"skins/$x/$x.png\" alt=\"$name\" /></td><td style=\"vertical-align:top;\"><input type=\"radio\" name=\"$name\" value=\"$x\" $checked> <strong>".$info['Name']."</strong><br />&nbsp;<br />Version : ".$info['Version']."<br />Updated : ".$info['Updated']."<br />Author : ".$info['Author']."</td></tr></table>";

		}

	return($result);
	}

/* ------------------ */

function sed_selectbox_users($to)
	{
	global $db_users;

	$result = "<select name=\"userid\">";
	$sql = sed_sql_query("SELECT user_id, user_name FROM $db_users ORDER BY user_name ASC");
	while ($row = sed_sql_fetchassoc($sql))
		{
		$selected = ($row['user_id']==$to) ? "selected=\"selected\"" : '';
		$result .= "<option value=\"".$row['user_id']."\" $selected>".sed_cc($row['user_name'])."</option>";
		}
	$result .= "</select>";
	return($result);
	}

/* ------------------ */

function sed_sendheaders()
	{
	global $cfg;
	$contenttype = 'text/html';
	header('Expires: Fri, Apr 01 1974 00:00:00 GMT');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: post-check=0,pre-check=0', FALSE);
	header('Content-Type: '.$contenttype);
	header('Cache-Control: no-store,no-cache,must-revalidate');
	header('Cache-Control: post-check=0,pre-check=0', FALSE);
	header('Pragma: no-cache');
	return(TRUE);
	}

/* ------------------ */

function sed_setdoctype($type)
	{
	switch($type)
		{
		case '0': // HTML 4.01
		return ("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">");
		break;

		case '1': // HTML 4.01 Transitional
		return ("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">");
		break;

		case '2': // HTML 4.01 Frameset
		return ("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">");
		break;

		case '3': // XHTML 1.0 Strict
		return ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">");
		break;

		case '4': // XHTML 1.0 Transitional
		return ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");
		break;

		case '5': // XHTML 1.0 Frameset
		return ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">");
		break;

		case '6': // XHTML 1.1
		return ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">");
		break;

		case '7': // XHTML 2 
		return ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 2//EN\" \"http://www.w3.org/TR/xhtml2/DTD/xhtml2.dtd\">");
		break;

		case '8': // HTML 5
		return ("<!DOCTYPE html>");
		break;

		default: // ...
		return ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");
		break;
		}
	}

/* ------------------ */

function sed_shield_clearaction()
	{
	global  $db_online, $usr;

	$sql = sed_sql_query("UPDATE $db_online SET online_action='' WHERE online_ip='".$usr['ip']."'");
	return;
	}

/* ------------------ */

function sed_shield_hammer($hammer,$action, $lastseen)
	{
	global $cfg, $sys, $usr;

	if ($action=='Hammering')
		{
		sed_shield_protect();
		sed_shield_clearaction();
		sed_stat_inc('totalantihammer');
		}

	if (($sys['now']-$lastseen)<4)
		{
		$hammer++;
		if($hammer>$cfg['shieldzhammer'])
			{
			sed_shield_update(180, 'Hammering');
			sed_log('IP banned 3 mins, was hammering', 'sec');
			$hammer = 0;
			}
		}
	else
		{
		if ($hammer>0)
			{ $hammer--; }
		}
	return($hammer);
	}

/* ------------------ */

function sed_shield_protect()
	{
	global $cfg, $sys, $online_count, $shield_limit, $shield_action;

	if ($cfg['shieldenabled'] && $online_count>0 && $shield_limit>$sys['now'])
		{
		sed_diefatal('Shield protection activated, please retry in '.($shield_limit-$sys['now']).' seconds...<br />After this duration, you can refresh the current page to continue.<br />Last action was : '.$shield_action);
		}
	return;
	}

/* ------------------ */

function sed_shield_update($shield_add, $shield_newaction)
	{
	global $cfg, $usr, $sys, $db_online;
	if ($cfg['shieldenabled'])
		{
		$shield_newlimit = $sys['now'] + floor($shield_add * $cfg['shieldtadjust'] /100);
		$sql = sed_sql_query("UPDATE $db_online SET online_shield='$shield_newlimit', online_action='$shield_newaction' WHERE online_ip='".$usr['ip']."'");
		}
	return;
	}

/* ------------------ */

function sed_skinfile($base)
	{
	global $usr;
	$base_depth = count($base);
	if ($base_depth==1) { return($skinfile = 'skins/'.$usr['skin'].'/'.$base.'.tpl'); }

	for($i=$base_depth; $i>1; $i--)
		{
		$levels = array_slice($base, 0, $i);
		$skinfile = 'skins/'.$usr['skin'].'/'.implode('.', $levels).'.tpl';
		if(file_exists($skinfile)) { return($skinfile); }
		}
	return('skins/'.$usr['skin'].'/'.$base[0].'.tpl');
	}

/* ------------------ */

function sed_smilies($res)
	{
	global $sed_smilies;

	if (is_array($sed_smilies))
		{
		foreach($sed_smilies as $k => $v)
			{ $res = str_replace($v['smilie_code'],"<img src=\"".$v['smilie_image']."\" alt=\"\" />", $res); }
		}
	return($res);
	}

/* ------------------ */

function sed_sourcekey()
	{
	global $usr;

	$result = ($usr['id']>0) ? strtoupper(substr($usr['sessionid'], 0, 6)) : 'GUEST';
	return ($result);
	}

/* ------------------ */

function sed_stat_create($name, $value=1)
	{
	global $db_stats;

	$sql = sed_sql_query("INSERT INTO $db_stats (stat_name, stat_value) VALUES ('".sed_sql_prep($name)."', '".sed_sql_prep($value)."')");
	return;
	}

/* ------------------ */

function sed_stat_get($name)
	{
	global $db_stats;

	$sql = sed_sql_query("SELECT stat_value FROM $db_stats where stat_name='$name' LIMIT 1");
	$result = (sed_sql_numrows($sql)>0) ? sed_sql_result($sql, 0, 'stat_value') : FALSE;
	return($result);
	}

/* ------------------ */


function sed_stat_inc($name)
	{
	global $db_stats;

	$sql = sed_sql_query("UPDATE $db_stats SET stat_value=stat_value+1 WHERE stat_name='$name'");
	return;
	}

/* ------------------ */


function sed_stat_set($name, $value)
	{
	global $db_stats;

	$sql = sed_sql_query("UPDATE $db_stats SET stat_value='$value' WHERE stat_name='$name'");
	return;
	}

/* ------------------ */

function sed_stringinfile($file, $str, $maxsize=32768)
	{
	if ($fp = @fopen($file, 'r'))
		{
		$data = fread($fp, $maxsize);
		$pos = strpos($data, $str);
		$result = ($pos===FALSE) ? FALSE : TRUE;
		}
	else
		{ $result = FALSE; }
	@fclose($fp);
	return ($result);
	}

/* ------------------ */

function sed_trash_put($type, $title, $itemid, $datas)
	{
	global $db_trash, $sys, $usr;

	$sql = sed_sql_query("INSERT INTO $db_trash (tr_date, tr_type, tr_title, tr_itemid, tr_trashedby, tr_datas)
		VALUES
		(".$sys['now_offset'].", '".sed_sql_prep($type)."', '".sed_sql_prep($title)."', '".sed_sql_prep($itemid)."', ".$usr['id'].", '".sed_sql_prep(serialize($datas))."')");

	return;
	}

/* ------------------ */

function sed_unique($l=16)
	{
	return(substr(md5(mt_rand(0,1000000)), 0, $l));
	}

/* ------------------ */

function sed_userinfo($id)
	{
	global $db_users;

	$sql = sed_sql_query("SELECT * FROM $db_users WHERE user_id='$id'");
	if ($res = sed_sql_fetchassoc($sql))
		{ return ($res); }
	else
		{
		$res['user_name'] = '?';
		return ($res);
		}
	}

/* ------------------ */

function sed_userisonline($id)
	{
	global $sed_usersonline;

	$res = FALSE;
	if (is_array($sed_usersonline))
		{ $res = (in_array($id,$sed_usersonline)) ? TRUE : FALSE; }
	return ($res);
	}

/* ------------------ */

function sed_wraptext($str,$wrap=128)
	{
	if (!empty($str))
		{ $str = preg_replace("/([^\n\r ?&\.\/<>\"\\-]{80})/i"," \\1\n", $str); }
	return($str);
	}

/* ------------------ */

function sed_xg()
	{
	return ('x='.sed_sourcekey());
	}

/* ------------------ */

function sed_xp()
	{
	return ("<div><input type=\"hidden\" id=\"x\" name=\"x\" value=\"".sed_sourcekey()."\" /></div>");
	}


/* ============== FLAGS AND COUNTRIES (ISO 3166) =============== */

$sed_languages['de']= 'Deutsch';
$sed_languages['dk']= 'Dansk';
$sed_languages['es']= 'Español';
$sed_languages['fi']= 'Suomi';
$sed_languages['fr']= 'Français';
$sed_languages['it']= 'Italiano';
$sed_languages['nl']= 'Nederlands';
$sed_languages['ru']= '&#1056;&#1091;&#1089;&#1089;&#1082;&#1086;';
$sed_languages['se']= 'Svenska';
$sed_languages['en']= 'English';
$sed_languages['pl']= 'Polski';
$sed_languages['pt']= 'Portugese';
$sed_languages['cn']= '&#27721;&#35821;';
$sed_languages['gr']= 'Greek';
$sed_languages['hu']= 'Hungarian';
$sed_languages['jp']= '&#26085;&#26412;&#35486;';
$sed_languages['kr']= '&#54620;&#44397;&#47568;';

$sed_countries = array (
'00' => '---',
'af' => 'Afghanistan',
'al' => 'Albania',
'dz' => 'Algeria',
'as' => 'American Samoa',
'ad' => 'Andorra',
'ao' => 'Angola',
'ai' => 'Anguilla',
'aq' => 'Antarctica',
'ag' => 'Antigua And Barbuda',
'ar' => 'Argentina',
'am' => 'Armenia',
'aw' => 'Aruba',
'au' => 'Australia',
'at' => 'Austria',
'az' => 'Azerbaijan',
'bs' => 'Bahamas',
'bh' => 'Bahrain',
'bd' => 'Bangladesh',
'bb' => 'Barbados',
'by' => 'Belarus',
'be' => 'Belgium',
'bz' => 'Belize',
'bj' => 'Benin',
'bm' => 'Bermuda',
'bt' => 'Bhutan',
'bo' => 'Bolivia',
'ba' => 'Bosnia And Herzegovina',
'bw' => 'Botswana',
'bv' => 'Bouvet Island',
'br' => 'Brazil',
'io' => 'British Indian Ocean Territory',
'bn' => 'Brunei Darussalam',
'bg' => 'Bulgaria',
'bf' => 'Burkina Faso',
'bi' => 'Burundi',
'kh' => 'Cambodia',
'cm' => 'Cameroon',
'ca' => 'Canada',
'cv' => 'Cape Verde',
'ky' => 'Cayman Islands',
'cf' => 'Central African Republic',
'td' => 'Chad',
'cl' => 'Chile',
'cn' => 'China',
'cx' => 'Christmas Island',
'cc' => 'Cocos Islands',
'co' => 'Colombia',
'km' => 'Comoros',
'cg' => 'Congo',
'ck' => 'Cook Islands',
'cr' => 'Costa Rica',
'ci' => 'Cote D\'ivoire',
'hr' => 'Croatia',
'cu' => 'Cuba',
'cy' => 'Cyprus',
'cz' => 'Czech Republic',
'dk' => 'Denmark',
'dj' => 'Djibouti',
'dm' => 'Dominica',
'do' => 'Dominican Republic',
'tp' => 'East Timor',
'ec' => 'Ecuador',
'eg' => 'Egypt',
'sv' => 'El Salvador',
'en' => 'England',
'gq' => 'Equatorial Guinea',
'er' => 'Eritrea',
'ee' => 'Estonia',
'et' => 'Ethiopia',
'eu' => 'Europe',
'fk' => 'Falkland Islands',
'fo' => 'Faeroe Islands',
'fj' => 'Fiji',
'fi' => 'Finland',
'fr' => 'France',
'gf' => 'French Guiana',
'pf' => 'French Polynesia',
'tf' => 'French Southern Territories',
'ga' => 'Gabon',
'gm' => 'Gambia',
'ge' => 'Georgia',
'de' => 'Germany',
'gh' => 'Ghana',
'gi' => 'Gibraltar',
'gr' => 'Greece',
'gl' => 'Greenland',
'gd' => 'Grenada',
'gp' => 'Guadeloupe',
'gu' => 'Guam',
'gt' => 'Guatemala',
'gn' => 'Guinea',
'gw' => 'Guinea-bissau',
'gy' => 'Guyana',
'ht' => 'Haiti',
'hm' => 'Heard And Mc Donald Islands',
'hn' => 'Honduras',
'hk' => 'Hong Kong',
'hu' => 'Hungary',
'is' => 'Iceland',
'in' => 'India',
'id' => 'Indonesia',
'ir' => 'Iran',
'iq' => 'Iraq',
'ie' => 'Ireland',
'il' => 'Israel',
'it' => 'Italy',
'jm' => 'Jamaica',
'jp' => 'Japan',
'jo' => 'Jordan',
'kz' => 'Kazakhstan',
'ke' => 'Kenya',
'ki' => 'Kiribati',
'kp' => 'North Korea',
'kr' => 'South Korea',
'kw' => 'Kuwait',
'kg' => 'Kyrgyzstan',
'la' => 'Laos',
'lv' => 'Latvia',
'lb' => 'Lebanon',
'ls' => 'Lesotho',
'lr' => 'Liberia',
'ly' => 'Libya',
'li' => 'Liechtenstein',
'lt' => 'Lithuania',
'lu' => 'Luxembourg',
'mo' => 'Macau',
'mk' => 'Macedonia',
'mg' => 'Madagascar',
'mw' => 'Malawi',
'my' => 'Malaysia',
'mv' => 'Maldives',
'ml' => 'Mali',
'mt' => 'Malta',
'mh' => 'Marshall Islands',
'mq' => 'Martinique',
'mr' => 'Mauritania',
'mu' => 'Mauritius',
'yt' => 'Mayotte',
'mx' => 'Mexico',
'fm' => 'Micronesia',
'md' => 'Moldavia',
'mc' => 'Monaco',
'mn' => 'Mongolia',
'ms' => 'Montserrat',
'ma' => 'Morocco',
'mz' => 'Mozambique',
'mm' => 'Myanmar',
'na' => 'Namibia',
'nr' => 'Nauru',
'np' => 'Nepal',
'nl' => 'Netherlands',
'an' => 'Netherlands Antilles',
'nc' => 'New Caledonia',
'nz' => 'New Zealand',
'ni' => 'Nicaragua',
'ne' => 'Niger',
'ng' => 'Nigeria',
'nu' => 'Niue',
'nf' => 'Norfolk Island',
'mp' => 'Northern Mariana Islands',
'no' => 'Norway',
'om' => 'Oman',
'pk' => 'Pakistan',
'pw' => 'Palau',
'ps' => 'Palestine',
'pa' => 'Panama',
'pg' => 'Papua New Guinea',
'py' => 'Paraguay',
'pe' => 'Peru',
'ph' => 'Philippines',
'pn' => 'Pitcairn',
'pl' => 'Poland',
'pt' => 'Portugal',
'pr' => 'Puerto Rico',
'qa' => 'Qatar',
're' => 'Reunion',
'ro' => 'Romania',
'ru' => 'Russia',
'rw' => 'Rwanda',
'kn' => 'Saint Kitts And Nevis',
'lc' => 'Saint Lucia',
'vc' => 'Saint Vincent',
'ws' => 'Samoa',
'sm' => 'San Marino',
'st' => 'Sao Tome And Principe',
'sa' => 'Saudi Arabia',
'sx' => 'Scotland',
'sn' => 'Senegal',
'sc' => 'Seychelles',
'sl' => 'Sierra Leone',
'sg' => 'Singapore',
'sk' => 'Slovakia',
'si' => 'Slovenia',
'sb' => 'Solomon Islands',
'so' => 'Somalia',
'za' => 'South Africa',
'gs' => 'South Georgia',
'es' => 'Spain',
'lk' => 'Sri Lanka',
'sh' => 'St. Helena',
'pm' => 'St. Pierre And Miquelon',
'sd' => 'Sudan',
'sr' => 'Suriname',
'sj' => 'Svalbard And Jan Mayen Islands',
'sz' => 'Swaziland',
'se' => 'Sweden',
'ch' => 'Switzerland',
'sy' => 'Syria',
'tw' => 'Taiwan',
'tj' => 'Tajikistan',
'tz' => 'Tanzania',
'th' => 'Thailand',
'tg' => 'Togo',
'tk' => 'Tokelau',
'to' => 'Tonga',
'tt' => 'Trinidad And Tobago',
'tn' => 'Tunisia',
'tr' => 'Turkiye',
'tm' => 'Turkmenistan',
'tc' => 'Turks And Caicos Islands',
'tv' => 'Tuvalu',
'ug' => 'Uganda',
'ua' => 'Ukraine',
'ae' => 'United Arab Emirates',
'uk' => 'United Kingdom',
'us' => 'United States',
'uy' => 'Uruguay',
'uz' => 'Uzbekistan',
'vu' => 'Vanuatu',
'va' => 'Vatican',
've' => 'Venezuela',
'vn' => 'Vietnam',
'vg' => 'Virgin Islands (british)',
'vi' => 'Virgin Islands (u.s.)',
'wa' => 'Wales',
'wf' => 'Wallis And Futuna Islands',
'eh' => 'Western Sahara',
'ye' => 'Yemen',
'yu' => 'Yugoslavia',
'zr' => 'Zaire',
'zm' => 'Zambia',
'zw' => 'Zimbabwe'
	);


?>