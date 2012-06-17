<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=admin.config.skin.inc.php
Version=161
Updated=2012-feb-02
Type=Core.admin
Author=Neocrome
Description=Administration panel
[END_SED]
==================== */

if (!defined('SED_CODE') || !defined('SED_ADMIN')) { die('Wrong URL.'); }


$adminmain .= "<h3>".$L['core_skin']." :</h3>";

$handle = opendir("skins/");

while ($f = readdir($handle))
	{
	if (strpos($f, '.')  === FALSE)
		{ $skinlist[] = $f; }
	}

closedir($handle);
sort($skinlist);

$adminmain .= "<table class=\"cells\">";
$adminmain .= "<tr><td class=\"coltop\">".$L['core_skin']."</td>";
$adminmain .= "<td class=\"coltop\">".$L['Preview']."</td>";
$adminmain .= "<td class=\"coltop\">&nbsp;</td>";
$adminmain .= "<td class=\"coltop\">".$L['Default']."</td>";
$adminmain .= "<td class=\"coltop\">".$L['Set']."</td></tr>";

while(list($i,$x) = each($skinlist))
	{
	$skininfo = "skins/".$x."/".$x.".php";
	$info = sed_infoget($skininfo);

  $adminmain .= "</tr>";
  $adminmain .= "<td style=\"width:20%;\"><strong>"; 	
	$adminmain .= (!empty($info['Error'])) ? $x." (".$info['Error'].")" : $info['Name'];
  $adminmain .= "</strong>";	
  $adminmain .= "</td><td><img src=\"skins/$x/$x.png\" alt=\"".$info['Name']."\" />";
  $adminmain .= "<td style=\"width:60%;\">"; 	   
	$adminmain .= $L['Version']." : ".$info['Version']."<br />";
	$adminmain .= $L['Updated']." : ".$info['Updated']."<br />";
  $adminmain .= $L['Author']." : ".$info['Author']."<br />";
  $adminmain .= $L['URL']." : ".$info['Url']."<br />";
  $adminmain .= $L['Description']." : ".$info['Description']."";  
  $adminmain .= "</td><td style=\"text-align:center; vertical-align:middle; width:10%;\">";  
	$adminmain .= ($x == $cfg['defaultskin']) ? $out['img_checked'] : '';
  $adminmain .= "</td><td style=\"text-align:center; vertical-align:middle; width:10%;\">";
	$adminmain .= ($x == $skin) ? $out['img_checked'] : '';
  $adminmain .= "</td></tr>"; 

  }
$adminmain .= "</table>";


?>
