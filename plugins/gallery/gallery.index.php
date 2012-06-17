<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/gallery/gallery.index.php
Version=100
Updated=2006-feb-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=gallery
Part=index
File=gallery.index
Hooks=index.tags
Tags=
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]

==================== */

if ( !defined('SED_CODE') ) { die("Wrong URL."); }


require("plugins/gallery/inc/gallery.inc.php");

if ($cfg['plugin']['gallery']['potw']>0)
	{
	$sql_potw = sed_sql_query("SELECT p.*, u.user_id, u.user_name, f.pff_id, f.pff_title, f.pff_desc
			FROM $db_users u, $db_pfs p, $db_pfs_folders f
			WHERE p.pfs_userid=u.user_id
			AND p.pfs_folderid=f.pff_id
			AND f.pff_isgallery=1
			AND f.pff_ispublic=1
			AND p.pfs_id='".$cfg['plugin']['gallery']['potw']."' LIMIT 1");

	if ($potw = sed_sql_fetcharray($sql_potw))
		{
//Goral		
		$pfs_dir=sed_pfs_path($potw['pfs_userid']);
		$th_dir=sed_pfs_thumbpath($potw['pfs_userid']);
//
		$potw['pfs_fullfile'] = $pfs_dir.$potw['pfs_file'];
		$potw['pfs_desc'] = sed_cc($potw['pfs_desc']);
		$potw['pfs_filesize'] = floor($potw['pfs_size']/1024);
		$potw_picturecode = 'g'.$potw['pff_id'].'-'.$potw['pfs_id'];
	//	$potw_comments = ($cfg['disablecomments']) ? '' : sed_comments($potw_picturecode);
	//	$potw_ratings = ($cfg['disableratings']) ? '' : sed_ratings($potw_picturecode);

		if (sed_gallery_ismovie($row['pfs_extension']))
			{
			$potw['pfs_imgsize'] = array ('?','?');
			$potw['pfs_imgsize_xy'] = '';
			$potw['popup'] = "plug.php?e=gallery&amp;v=".$potw['pfs_id'];
			}
		else
			{
			$potw['pfs_imgsize'] = @getimagesize($potw['pfs_fullfile']);
			$potw['pfs_imgsize_xy'] = $potw['pfs_imgsize'][0].'x'.$potw['pfs_imgsize'][1];
			$potw['popup'] = "javascript:popup('gallery&amp;v=".$potw['pfs_id']."',".($potw['pfs_imgsize'][0]+$cfg['plugin']['gallery']['popupmargin']).",".($potw['pfs_imgsize'][1]+$cfg['plugin']['gallery']['popupmargin']).")";
			}

		$t-> assign(array(
			"POTW_ID" => $potw['pfs_id'],
			"POTW_VIEWURL" => "plug.php?e=gallery&amp;v=".$potw['pfs_id'],
			"POTW_VIEWURL_POPUP" => $potw['popup'],
			"POTW_FILE" => $potw['pfs_file'],
			"POTW_AUTHOR" => sed_build_user($potw['user_id'], sed_cc($potw['user_name'])),
			"POTW_FULLFILE" => $pfs_dir.$potw['pfs_file'],
			"POTW_THUMB" => sed_gallery_thumb($potw['pfs_extension'], $potw['pfs_file']),
			"POTW_ICON" => $icon[$potw['pfs_extension']],
			"POTW_DESC" => $potw['pfs_desc'],
			"POTW_SHORTDESC" => sed_cutstring($potw['pfs_desc'],64),
			"POTW_SIZE" => $potw['pfs_filesize'].$L['kb'],
			"POTW_DIMX" => $potw['pfs_imgsize'][0],
			"POTW_DIMY" => $potw['pfs_imgsize'][1],
			"POTW_DIMXY" => $potw['pfs_imgsize_xy'],
			"POTW_DATE" => date($cfg['dateformat'], $potw['pfs_date'] + $usr['timezone'] * 3600),
			"POTW_NEW" => $potw['new'],
			"POTW_COUNT" => $potw['pfs_count'],
			"POTW_COMMENTS" => $potw_comments,
			"POTW_RATING" => $potw_ratings,
			"POTW_PFF_URL" => "plug.php?e=gallery&amp;f=".$potw['pff_id'],
			"POTW_PFF_TITLE" => sed_cc($potw['pff_title']),
			"POTW_PFF_DESC" => sed_cc($potw['pff_desc'])
			));

		$t->parse("MAIN.GALLERY_POTW");
		}
	}



?>