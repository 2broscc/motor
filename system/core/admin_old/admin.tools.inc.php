<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.tools.inc.php
Version=110
Updated=2006-jun-06
Type=Core.admin
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=tools", $L['Tools']);
$adminhelp = $L['adm_help_tools'];

$p = sed_import('p','G','ALP');

if (!empty($p))
	{
	$path_lang_def	= "plugins/$p/lang/$p.en.lang.php";
	$path_lang_alt	= "plugins/$p/lang/$p.$lang.lang.php";

	if (@file_exists($path_lang_alt))
		{ require($path_lang_alt); }
	elseif (@file_exists($path_lang_def))
		{ require($path_lang_def); }

	$extp = array();

	if (is_array($sed_plugins))
		{
		foreach($sed_plugins as $i => $k)
			{
			if ($k['pl_hook']=='tools' && $k['pl_code']==$p)
				{ $extp[$i] = $k; }
			}
		}

	if (count($extp)==0)
		{
		header("Location: message.php?msg=907");
		exit;
		}

	$extplugin_info = "plugins/".$p."/".$p.".setup.php";

	if (file_exists($extplugin_info))
		{
		$info = sed_infoget($extplugin_info, 'SED_EXTPLUGIN');
		}
	else
		{
		header("Location: message.php?msg=907");
		exit;
		}

	if (is_array($extp))
		{
		foreach($extp as $k => $pl)
			 {
			 include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php');
			 $adminmain .= $plugin_body;
			 }
		}

	$adminpath[] = array ("admin.php?m=tools&amp;p=$p", sed_cc($info['Name']));
	$adminhelp = $L['Description']." : ".$info['Description']."<br />".$L['Version']." : ".$info['Version']."<br />".$L['Date']." : ".$info['Date']."<br />".$L['Author']." : ".$info['Author']."<br />".$L['Copyright']." : ".$info['Copyright']."<br />".$L['Notes']." : ".$info['Notes'];

	}
else
	{
	$plugins = array();

	function cmp ($a, $b, $k=1)
		{
		if ($a[$k] == $b[$k]) return 0;
		return ($a[$k] < $b[$k]) ? -1 : 1;
		}

	/* === Hook === */
	$extp = sed_getextplugins('tools');
	
	if (is_array($extp))
		{
		foreach($extp as $k => $pl)
			{
			$plugins[]= array ($pl['pl_code'], $pl['pl_title']);
			}
			
		usort($plugins, "cmp");

		$adminmain .= "<table class=\"cells\">";
		$adminmain .= "<tr><td style=\"text-align:center;\" class=\"coltop\">".$L['Tools']."</td></tr>";

		while (list($i,$x) = each($plugins))
			{
			$extplugin_info = "plugins/".$x[0]."/".$x[0].".setup.php";
		
			if (file_exists($extplugin_info))
				{
				$info = sed_infoget($extplugin_info, 'SED_EXTPLUGIN');
				}
			else
				{
				include ("system/lang/".$usr['lang']."/message.lang.php");
				$info['Name'] = $x[0]." : ".$L['msg907_1'];
				}

			$plugin_icon = (empty($x[1])) ? 'plugins' : $x[1];
			$adminmain  .= "<tr><td><a href=\"admin.php?m=tools&amp;p=".$x[0]."\">";
			$adminmain  .= "<img src=\"system/img/admin/tools.gif\" alt=\"\" /> ".$info['Name']."</a></td></tr>";
			}
		$adminmain .= "</table>";				
		}
	else
		{
		$adminmain = $L['adm_listisempty'];
		}
	}
?>
