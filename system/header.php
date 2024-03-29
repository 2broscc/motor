<?PHP

/**
*/

defined('SED_CODE') or die ("Wrong URL");

require("system/core/browser.php");

sed_long_string();


/* === Hook === */

$extp = sed_getextplugins('header.first');
if (is_array($extp)) { 
		foreach($extp as $k => $pl) { 
			include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); 
		} 
	}
	
/* ===== */

$out['logstatus'] = ($usr['id']>0) ? $L['hea_youareloggedas'].' '.$usr['name'] : $L['hea_youarenotlogged'];
$out['userlist'] = (sed_auth('users', 'a', 'R')) ? "<a id=\"userbar_link\" href=\"users.php\">".$L['Users']."</a>" : '';
$out['metas'] = sed_htmlmetas().$moremetas;
$out['compopup'] = sed_javascript($morejavascript);
$out['fulltitle'] = $cfg['maintitle'];
$out['subtitle'] = (empty($out['subtitle'])) ? $cfg['subtitle'] : $out['subtitle'];
$out['fulltitle'] .= (empty($out['subtitle'])) ? '' : ' - '.$out['subtitle'];

//rss output
/**$out['rss'] = "
<link rel=\"alternate\" target=\"\" type=\"application/rss+xml\" title=\"".$cfg["rss_titles_news"]."\" href=\"".$cfg['rss_channels_news']."\" />
<link rel=\"alternate\" target=\"\" type=\"application/rss+xml\" title=\"".$cfg['rss_titles_articles']."\" href=\"".$cfg['rss_channels_articles']."\" />
<link rel=\"alternate\" target=\"\" type=\"application/rss+xml\" title=\"".$cfg['rss_titles_forums']."\" href=\"".$cfg['rss_channels_forums']."\" />
<link rel=\"alternate\" target=\"\" type=\"application/rss+xml\" title=\"".$cfg['rss_titles_videosarok']."\" href=\"".$cfg['rss_channels_videosarok']."\" />
";*/

//RSS - todo

sed_rss("h�rek","news.php");


if (sed_auth('page', 'any', 'A')) {
	
	$sqltmp2 = sed_sql_query("SELECT COUNT(*) FROM $db_pages WHERE page_state=1");
	$sys['pagesqueued'] = sed_sql_result($sqltmp2,0,'COUNT(*)');

	if ($sys['pagesqueued']>0) {
		
		$out['notices'] .= $L['hea_valqueues'];

		if ($sys['pagesqueued']==1) { 
				$out['notices'] .= "<a id=\"userbar_link\" href=\"admin.php?m=page&amp;s=queue\">"."1 ".$L['Page']."</a> "; }
		
			elseif ($sys['pagesqueued']>1) { 
			
				$out['notices'] .= "<a id=\"userbar_link\" href=\"admin.php?m=page&amp;s=queue\">".$sys['pagesqueued']." ".$L['Pages']."</a> ";

			}
		}
	}

sed_sendheaders();

/* === Hook === */
$extp = sed_getextplugins('header.main');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

//header notice

$notice = mysql_query("SELECT * FROM $db_notice");

	while($row = mysql_fetch_array($notice)) {
	
$n_status =	$row['notice_status'];
$n_text =	$row['notice_text'];
$n_title = $row['notice_title'];
$n_date = $row['notice_date'];
			
	}
	
if  ( $n_status ==1) { 

		$n_mask .= "
		
	
			<div id=\"wbox_top\">
				
					<div id=\"menupadding\">
						<h5>�rtes�t�s/Felh�v�s</h5></a>
					</div>
			</div>
				
				<div id=\"wbox_mid\">
					<div id=\"content_pos\">
						<div id=\"notice_light\">
							<div><h4><b>+ $n_title - $n_date</b></h4></div>
							<div class=\"notice_text\">$n_text</div>
						</div>
					</div>
				</div>
	
		
			<div id=\"wbox_bot\"></div>
		
		
		";

		} 

	else {/*do nothing - it means the div and the content does not show*/ }
	
	

if ($cfg['enablecustomhf']) { 

				$mskin = sed_skinfile(array('header', strtolower($location))); 
	}
	else { 
			$mskin = "$user_skin_dir/".$usr['skin']."/header.tpl"; 
			
		}
		
		
$t = new XTemplate($mskin);

$t->assign(array (

		
	"HEADER_NOTICE_ONOFF" => $off,
	"HEADER_NOTICE_TEXT" => $noticebar_text,
 	"HEADER_NOTICE_BAR" => $notice_mask,
	"HEADER_TITLE" => $out['fulltitle'],
	"HEADER_METAS" => $out['metas'],
	"HEADER_DOCTYPE" => $cfg['doctype'],
	"HEADER_CSS" => $cfg['css'],
	"HEADER_COMPOPUP" => $out['compopup'],
	"HEADER_LOGSTATUS" => $out['logstatus'],
	"HEADER_WHOSONLINE" => $out['whosonline'],
	"HEADER_TOPLINE" => $cfg['topline'],
	"HEADER_BANNER" => $cfg['banner'],
	"HEADER_GMTTIME" => $usr['gmttime'],
	"HEADER_USERLIST" => $out['userlist'],
	"HEADER_NOTICES" => $out['notices'],
	"HEADER_RSS" => $out['rss'],
	"HEADER_JS_DIR" => $cfg['javascript_dir'],
	"HEADER_URL" => $cfg['header_url'],
	"HEADER_SKIN_POS" => $cfg['skinposition'],
	
	/*User defined tags it has to starts with HEADER_UDEF_*/
	
	"HEADER_UDEF_NOTICE_MASK" => $n_mask,
	"HEADER_UDEF_FACEBOOK_API" => sed_facebook_init("147938528592694"), //init the facebook api. the code is the personal api code!
	"HEADER_UDEF_JS_DIR" => $cfg['javascript_dir'],
	
	));

if ($usr['id']>0) {

	$out['adminpanel'] = (sed_auth('admin', 'any', 'R')) ? "<a id=\"userbar_link\" href=\"admin.php\">".$L['Administration']."</a>" : '';
	$out['loginout_url'] = "logout.php?".sed_xg();
	$out['loginout'] = "<a id=\"userbar_link\" href=\"".$out['loginout_url']."\">".$L['Logout']."</a>";
	//profile
	$out['profile'] = "<a id=\"userbar_link\" href=\"users.php?m=profile\">".$L['Profile']."</a>";
	//private messages
	$out['pms'] = ($cfg['disable_pm']) ? '' : "<a id=\"userbar_link\" href=\"mailer.php\">".$L['Private_Messages']."</a>";
	//personal file space
	$out['pfs'] = ($cfg['disable_pfs'] || !sed_auth('pfs', 'a', 'R') || $sed_groups[$usr['maingrp']]['pfs_maxtotal']==0 || 	$sed_groups[$usr['maingrp']]['pfs_maxfile']==0) ? '' : "<a id=\"userbar_link\" href=\"pfs.php\">".$L['Mypfs']."</a>";

	if (!$cfg['disable_pm']) {
		
		if ($usr['newpm']) {
			$sqlpm = sed_sql_query("SELECT COUNT(*) FROM $db_pm WHERE pm_touserid='".$usr['id']."' AND pm_state=0");
			$usr['messages'] = sed_sql_result($sqlpm,0,'COUNT(*)');
			
		}
		
		$out['pmreminder'] = "<a id=\"userbar_link\" href=\"mailer.php\">";
		$out['pmreminder'] .= ($usr['messages']>0) ? $usr['messages'].' '.$L['hea_privatemessages'] : $L['hea_noprivatemessages'];
		$out['pmreminder'] .= "</a>";
	}

	$t->assign(array (
	
		"HEADER_USER_NAME" => $usr['name'],
		"HEADER_USER_ADMINPANEL" => $out['adminpanel'],
		"HEADER_USER_LOGINOUT" => $out['loginout'],
		"HEADER_USER_PROFILE" => $out['profile'],
		"HEADER_USER_PMS" => $out['pms'],
		"HEADER_USER_PFS" => $out['pfs'],
		"HEADER_USER_PMREMINDER" => $out['pmreminder'],
		"HEADER_USER_MESSAGES" => $usr['messages']
			
			));

	$t->parse("HEADER.USER");
	}
else
	{
	$out['guest_username'] = "<input type=\"text\" class=\"skinned\" name=\"rusername\" size=\"12\" maxlength=\"32\" />";
	$out['guest_password'] = "<input type=\"password\" class=\"skinned\" name=\"rpassword\" size=\"12\" maxlength=\"32\" />";
	$out['guest_register'] = "<a id=\"userbar_link\" href=\"users.php?m=register\">".$L["Register"]."</a>";
//remember me stuff
	$out['guest_cookiettl'] = "<select class=\"skinned\" name=\"rcookiettl\" size=\"1\">";
	$out['guest_cookiettl'] .= "<option value=\"0\" selected=\"selected\">".$L['No']."</option>";

	$i =array (1800, 3600, 7200, 14400, 28800, 43200, 86400, 172800, 259200, 604800, 1296000, 2592000, 5184000);

	foreach($i as $k => $x) {
		$out['guest_cookiettl'] .= ($x<=$cfg['cookielifetime']) ? "<option value=\"$x\">".sed_build_timegap($sys['now_offset'], $sys['now_offset']+$x)."</option>": '';
		
	}
	$out['guest_cookiettl'] .= "</select>";
	
	$t->assign(array (
		"HEADER_GUEST_USERNAME" => $out['guest_username'],
		"HEADER_GUEST_PASSWORD" => $out['guest_password'],
		"HEADER_GUEST_REGISTER" => $out['guest_register'],
		"HEADER_GUEST_COOKIETTL" => $out['guest_cookiettl']
			));

	$t->parse("HEADER.GUEST");
	
	}

/* === Hook === */
$extp = sed_getextplugins('header.tags');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */

$t->parse("HEADER");
$t->out("HEADER");

?>