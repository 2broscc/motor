<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/gallery/gallery.logo.php
Version=100
Updated=2006-feb-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=gallery
Part=logo
File=gallery.logo
Hooks=pfs.upload.moved
Tags=
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if ( !defined('SED_CODE') ) { die("Wrong URL."); }

require_once("plugins/gallery/inc/gallery.inc.php");

if (in_array($f_extension, $gd_supported) && !empty($cfg['plugin']['gallery']['logofile']) && @file_exists($cfg['plugin']['gallery']['logofile']))
	{
	$img2_dotpos = strrpos($cfg['plugin']['gallery']['logofile'], ".")+1;
	$img2_extension = substr($cfg['plugin']['gallery']['logofile'], $img2_dotpos, 5);

	$pfs_dir=sed_pfs_path($usr['id']);

	sed_gallery_mergeimg($pfs_dir.$u_newname,
		$f_extension, $cfg['plugin']['gallery']['logofile'],
		$img2_extension,
		$img2_x,
		$img2_y,
		$cfg['plugin']['gallery']['logopos'],
		$cfg['plugin']['gallery']['logotrsp'],
		$cfg['plugin']['gallery']['logojpegqual']
			);
	}

?>