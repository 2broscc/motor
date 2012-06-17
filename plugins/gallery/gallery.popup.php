<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/gallery/gallery.popup.php
Version=100
Updated=2006-feb-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=gallery
Part=popup
File=gallery.popup
Hooks=popup
Tags=
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if ( !defined('SED_CODE') ) { die("Wrong URL."); }

$v = sed_import('v','G','INT');

$sql = sed_sql_query("SELECT p.pfs_userid, p.pfs_file, f.pff_ispublic, f.pff_isgallery
	FROM $db_pfs AS p
	LEFT JOIN $db_pfs_folders AS f ON f.pff_id=p.pfs_folderid
	WHERE p.pfs_id='$v' LIMIT 1");

sed_die(sed_sql_numrows($sql)==0);
$img = sed_sql_fetcharray($sql);

if (!$img['pff_ispublic'] || !$img['pff_isgallery'])
   { sed_die(); }

$sql = sed_sql_query("UPDATE $db_pfs SET pfs_count=pfs_count+1 WHERE pfs_id='$v' LIMIT 1");

//Goral		
		$pfs_dir=sed_pfs_path($img['pfs_userid']);
		$th_dir=sed_pfs_thumbpath($img['pfs_userid']);
//
$popup_body = "<img src=\"".$pfs_dir.$img['pfs_file']."\" alt=\"\" />"

?>