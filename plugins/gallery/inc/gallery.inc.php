<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/gallery/inc/gallery.inc.php
Version=100
Updated=2006-feb-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

==================== */

if ( !defined('SED_CODE') ) { die("Wrong URL."); }

//sed_pfs_path($userid);
//sed_pfs_thumbpath($userid);

function sed_gallery_thumb($extension, $file)
	{
	global $cfg, $th_dir;
	if (in_array($extension, sed_gallery_makearray($cfg['plugin']['gallery']['moviesext'])))
		{ return ("<img src=\"plugins/gallery/img/movie.gif\" alt=\"\" />"); }
	else
		{ return ("<img src=\"".$th_dir.$file."\" width=\"110px\" alt=\"\" />"); }
	}

function sed_gallery_ismovie($extension)
	{
	global $cfg;

	if (in_array($extension, sed_gallery_makearray($cfg['plugin']['gallery']['moviesext'])))
		{ return (TRUE); }
	else
		{ return (FALSE); }
	}

function sed_gallery_makearray($str)
	{
	$res = array();
	$lines = explode(',', $str);
	foreach($lines as $k => $i)
		{ $res[] = trim($i); }
	return($res);
	}

function sed_gallery_mergeimg($img1_file, $img1_extension, $img2_file, $img2_extension, $img2_x, $img2_y, $position,  $trsp=100, $jpegqual=100)
	{
	global $cfg;

	$gd_supported = array('jpg', 'jpeg', 'png', 'gif');

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

		default:
		$img2_x = $img1_w - 8 - $img2_w;
		$img2_y = $img1_h - 8 - $img2_h;
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


?>