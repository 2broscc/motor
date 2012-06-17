<?PHP
/*modified by widra for stalkerfansite
added direct access to the pictures and also added clearbox feature to show the piccuters
*/
/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/gallery/gallery.php
Version=100
Updated=2009-aug-18
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=gallery
Part=gallery
File=gallery
Hooks=standalone
Tags=
Minlevel=0
Order=10
[END_SED_EXTPLUGIN]
==================== */

if ( !defined('SED_CODE') || !defined('SED_PLUG') ) { die("Wrong URL."); }

require("system/config.extensions.php");
require("plugins/gallery/inc/gallery.inc.php");

$cfg_sortby = 'date';  //file, date
$cfg_sortway = 'DESC'; //ASC, DESC

reset($sed_extensions);
foreach ($sed_extensions as $line)
 	{
 	$icon[$line[0]] = "<img src=\"system/img/pfs/".$line[2].".gif\" alt=\"".$line[1]."\" />";
 	$filedesc[$line[0]] = $line[1];
 	}

$m = sed_import('m','G','ALP');
$a = sed_import('a','G','ALP');
$s = sed_import('s','G','TXT');
$w = sed_import('w','G','TXT');
$d = sed_import('d','G','TXT');
$f = sed_import('f','G','INT');
$id = sed_import('id','G','INT');
$v = sed_import('v','G','INT');
$u = sed_import('u','G','INT');

$m = ($f>0) ? 'gallery' : $m;
$m = ($v>0) ? 'view' : $m;

switch($m)
	{
	/* ==================================== */
	case 'edit':
	/* ==================================== */

	sed_block($usr['isadmin']);

	switch($a)
		{
		case 'potw':

		$sql = sed_sql_query("UPDATE $db_config SET config_value='$id' WHERE config_owner='plug' AND config_cat='gallery' AND config_name='potw'");
		header("Location: plug.php?e=gallery");
		exit;

		break;

		default:

		sed_die();

		break;

		}

	break;


	/* ==================================== */
	case 'gallery':
	/* ==================================== */

	$jj=0;
	$sql_pff = sed_sql_query("SELECT f.*, u.user_name FROM $db_pfs_folders f, $db_users u WHERE pff_id='$f' AND pff_ispublic=1 AND pff_isgallery=1 AND f.pff_userid=u.user_id");

	sed_die(mysql_num_rows($sql_pff)==0);
	$pff = sed_sql_fetcharray($sql_pff);

	$sql = sed_sql_query("SELECT * FROM $db_pfs WHERE pfs_folderid='$f' ORDER BY pfs_$cfg_sortby $cfg_sortway");
	$nbitems = sed_sql_numrows($sql_pff);
	$pff['pff_title'] = sed_cc($pff['pff_title']);
	$userid = $pff['pff_userid'];

	$t->assign(array(
		"GALLERY_ID" => $pff['pff_id'],
		"GALLERY_TITLE" => "<a href=\"plug.php?e=gallery\">".$L['gal_gallery']."</a> ".$cfg['separator']." <a href=\"plug.php?e=gallery&amp;u=".$pff['pff_userid']."\">".sed_cc($pff['user_name'])."</a> ".$cfg['separator']."<a href=\"plug.php?e=gallery&amp;f=".$pff['pff_id']."\"> ".$pff['pff_title']."</a>",
		"GALLERY_SHORTTITLE" => $pff['pff_title'],
		"GALLERY_DESC" => sed_cc($pff['pff_desc']),
		"GALLERY_COUNT" => $pff['pff_count'],
//		"GALLERY_COMMENTS" => $pff['comments'],
//		"GALLERY_RATING" => $pff['ratings'],
		"GALLERY_AUTHOR" => $pff['author']
			));

//	$pff['comments'] = sed_comments('g'.$pff['pff_id']);
//	$pff['ratings'] = sed_ratings('g'.$pff['pff_id']);

	while ($pfs = sed_sql_fetcharray($sql))
		{
		$jj++;
//Goral		

		//fileok helyének a kiiratása csak is teszt céljából!
		
		//print "$pfs_dir";
		$pfs_dir=sed_pfs_path($pfs['pfs_userid']);
		
		//print "$th_dir";
		$th_dir=sed_pfs_thumbpath($pfs['pfs_userid']);
//
		$pfs['pfs_fullfile'] = $pfs_dir.$pfs['pfs_file'];
		$pfs['pfs_filesize'] = floor($pfs['pfs_size']/1024);

		if (($pfs['extension']=='jpg' || $pfs['extension']=='jpeg' || $pfs['extension']=='png') && $cfg['th_amode']!='Disabled')
			{
			if (!file_exists($th_dir.$pfs['pfs_file']) && file_exists($pfs_dir.$pfs['pfs_file']))
			{
				$pfs['th_colortext'] = array(
					hexdec(substr($cfg['th_colortext'], 0, 2)),
					hexdec(substr($cfg['th_colortext'], 2 ,2)),
					hexdec(substr($cfg['th_colortext'], 4 ,2))
						);

				$pfs['th_colorbg'] = array(
					hexdec(substr($cfg['th_colorbg'], 0, 2)),
					hexdec(substr($cfg['th_colorbg'], 2, 2)),
					hexdec(substr($cfg['th_colorbg'], 4, 2))
						);

				sed_createthumb(
					$pfs_dir.$pfs['pfs_file'],
					$th_dir.$pfs['pfs_file'],
					$cfg['th_x'],
					$cfg['th_y'],
					$cfg['th_keepratio'],
					$pfs['pfs_extension'],
					$pfs['pfs_file'],
					$pfs['pfs_filesize'],
					$pfs['th_colortext'],
					$cfg['th_textsize'],
					$pfs['th_colorbg'],
					$cfg['th_border'],
					$cfg['th_jpeg_quality']
						);
				}
	 		}

		if ($cfg['plugin']['gallery']['columns']==1)
			{
			$pfs['cond1'] = '<tr>';
			$pfs['cond2'] = '</tr>';
			}
		elseif ($jj==1)
			{
			$pfs['cond1'] = '<tr>';
			$pfs['cond2'] = '';
			}
		elseif ($jj==$cfg['plugin']['gallery']['columns'])
			{
			$jj=0;
			$pfs['cond1'] = '';
			$pfs['cond2'] = '</tr>';
			}
		else
			{
			$pfs['cond1'] = '';
			$pfs['cond2'] = '';
			}


		$pfs['picturecode'] = 'g'.$pff['pff_id'].'-'.$pfs['pfs_id'];
//		$pfs['comments'] = sed_comments($pfs['picturecode']);
//		$pfs['ratings'] = sed_ratings($pfs['picturecode']);
		$pfs['new'] = ($pfs['pfs_date']+$cfg['plugin']['gallery']['newdelay']*86400>$sys['now']) ? $cfg['plugin']['gallery']['newtext'] : '';

		if (sed_gallery_ismovie($pfs['pfs_extension']))
			{
			$pfs['pfs_imgsize'] = array ('?','?');
			$pfs['pfs_imgsize_xy'] = '';
			$pfs['popup'] = "plug.php?e=gallery&amp;v=".$pfs['pfs_id'];
			}
		else
			{
			$pfs['pfs_imgsize'] = @getimagesize($pfs['pfs_fullfile']);
			$pfs['pfs_imgsize_xy'] = $pfs['pfs_imgsize'][0].'x'.$pfs['pfs_imgsize'][1];
			$pfs['popup'] = "javascript:popup('gallery&amp;v=".$pfs['pfs_id']."',".($pfs['pfs_imgsize'][0]+$cfg['plugin']['gallery']['popupmargin']).",".($pfs['pfs_imgsize'][1]+$cfg['plugin']['gallery']['popupmargin']).")";
			
			}

		if ($usr['isadmin'])
			{
			$pfs['admin'] = "<a href=\"pfs.php?m=edit&amp;id=".$pfs['pfs_id']."&amp;userid=".$userid."\">".$L['Edit']."</a>";
			$pfs['admin'] .= " &nbsp; <a href=\"plug.php?e=gallery&amp;m=edit&amp;a=potw&amp;id=".$pfs['pfs_id']."\">".$L['gal_setaspotw']."</a>";
			}
		//ez pedig a filenév lesz
		//print "".$pfs['pfs_file']."";
		
		$t-> assign(array(
			"GALLERY_ROW_ID" => $pfs['pfs_id'],
			"GALLERY_ROW_VIEWURL" => "plug.php?e=gallery&amp;v=".$pfs['pfs_id'],
			//közvetlen megjelenítése a képeknek, nem ilyen popup vacak
			"GALLERY_ROW_URL_DIRECT" => $pfs['pfs_file'],
			//"GALLERY_ROW_VIEWURL_POPUP" => $pfs['popup'],
			"GALLERY_ROW_VIEWURL_POPUP" => $pfs['popup'],
			"GALLERY_ROW_FILE" => $pfs['pfs_file'],
			"GALLERY_ROW_FULLFILE" => $pfs['pfs_fullfile'],
			"GALLERY_ROW_THUMB" => sed_gallery_thumb($pfs['pfs_extension'], $pfs['pfs_file']),
			"GALLERY_ROW_ICON" => $icon[$pfs['pfs_extension']],
			"GALLERY_ROW_DESC" => sed_cc($pfs['pfs_desc']),
			"GALLERY_ROW_SHORTDESC" => sed_cc($pfs['pfs_desc'], 64),
			"GALLERY_ROW_DATE" => date($cfg['dateformat'], $pfs['pfs_date'] + $usr['timezone'] * 3600),
			"GALLERY_ROW_NEW" => $pfs['new'],
			"GALLERY_ROW_SIZE" => $pfs['pfs_filesize'].$L['kb'],
			"GALLERY_ROW_DIMX" => $pfs['pfs_imgsize'][0],
			"GALLERY_ROW_DIMY" => $pfs['pfs_imgsize'][1],
			"GALLERY_ROW_DIMXY" => $pfs['pfs_imgsize_xy'],
			"GALLERY_ROW_COUNT" => $pfs['pfs_count'],
//			"GALLERY_ROW_COMMENTS" => $pfs['comments'],
//			"GALLERY_ROW_RATING" => $pfs['ratings'],
			"GALLERY_ROW_ADMIN" => $pfs['admin'],
			"GALLERY_ROW_COND1" => $pfs['cond1'],
			"GALLERY_ROW_COND2" => $pfs['cond2']
				));
		$t->parse("MAIN.GALLERY.ROW");
		}
	$t->parse("MAIN.GALLERY");

	break;

	/* ==================================== */
	case 'view':
	/* ==================================== */

	$sql = sed_sql_query("SELECT p.*, u.user_name, f.pff_ispublic, f.pff_isgallery
			FROM $db_pfs AS p
			LEFT JOIN $db_users AS u ON u.user_id=p.pfs_userid
			LEFT JOIN $db_pfs_folders AS f ON f.pff_id=p.pfs_folderid
			WHERE p.pfs_id='$v' LIMIT 1");

	sed_die(sed_sql_numrows($sql)==0);
	$img = sed_sql_fetcharray($sql);

	if (!$img['pff_ispublic'] || !$img['pff_isgallery'])
		{ sed_die(); }

//Goral		
		$pfs_dir=sed_pfs_path($img['pfs_userid']);
		$th_dir=sed_pfs_thumbpath($img['pfs_userid']);
//
	$sql = sed_sql_query("UPDATE $db_pfs SET pfs_count=pfs_count+1 WHERE pfs_id='$v' LIMIT 1");

	$view_header1 = "<html><head>
		<meta name=\"title' content=\"".$cfg['maintitle']."\" />
		<meta name=\"description\" content=\"".$cfg['maintitle']."\" />
		<meta name=\"generator\" content=\"Seditio Copyright Neocrome http://www.neocrome.net\" />
		<meta http-equiv=\"content-type\" content=\"text/html; charset=".$cfg['charset']."\" />
		<meta http-equiv=\"expires\" content=\"Fri, Apr 01 1974 00:00:00 GMT\" />
		<meta http-equiv=\"pragma\" content\"=no-cache\" />
		<meta http-equiv=\"cache-control\" content=\"no-cache\" />";
	$view_header2 = "</head><body>";
	$view_footer = "</body></html>";

	if (sed_gallery_ismovie($img['pfs_extension']))
		{
		$filename = $pfs_dir.$img['pfs_file'];
		$img['image'] = "<div style=\"margin:32px 8px 32px 8px; text-align:center;\"><a href=\"".$cfg['mainurl']."/".$filename."\">Click here to download the file :  ".$img['pfs_file']."</a></div>";
		$img['thumb'] = "";
		$img['pfs_imgsize'] = array ('?','?');
		$img['pfs_imgsize_xy'] = '';

		}
	else
		{
		$img['size'] = @getimagesize($img['path']);
		$img['size_xy'] = $img['size'][0].'x'.$img['size'][1];
		$img['path'] = $pfs_dir.$img['pfs_file'];
		$img['thumbpath'] = $th_dir.$img['pfs_file'];
		$img['image'] = "<img src=\"".$img['path']."\" rel=\"clearbox\"  alt=\"\" />";
		$img['thumb'] = "<img src=\"".$img['thumbpath']."\" rel=\"\" alt=\"\" />";
		}

	$t->assign(array(
		//"VIEW_HEADER1" => $view_header1,
		//"VIEW_HEADER2" => $view_header2,
		//"VIEW_FOOTER" => $view_footer,
		"VIEW_DATE" => date($cfg['dateformat'], $img['pfs_date'] + $usr['timezone'] * 3600),
		"VIEW_ID" => $img['pfs_id'],
		"VIEW_USERID" => $img['pfs_userid'],
		"VIEW_USERNAME" => sed_build_user($pfs['pfs_userid'], sed_cc($img['user_name'])),
		"VIEW_DESC" => sed_cc($img['pfs_desc']),
		"VIEW_COUNT" => $img['pfs_count'],
		"VIEW_SIZE" => floor($img['pfs_size']/1024),
		"VIEW_SIZEX" => $img['size'][0],
		"VIEW_SIZEY" => $img['size'][1],
		"VIEW_SIZEXY" => $img['size_xy'],
		"VIEW_IMAGE" => $img['image'],
		"VIEW_THUMB" => $img['thumb']
			));

	$t->parse("MAIN.VIEW");

	break;

	/* ==================================== */
	default:
	/* ==================================== */

	$gals = 0;
	$gals_t = 0;

	$sql_add = ($u>0) ? " AND pff_userid='".$u."' " : '';
	$gals_title = "<a href=\"plug.php?e=gallery\">".$L['gal_gallery']."</a>";

	$sql = sed_sql_query(" SELECT DISTINCT u.user_id, u.user_name, f.*, COUNT(*)
			FROM $db_users u, $db_pfs p, $db_pfs_folders f
			WHERE p.pfs_userid=u.user_id
			AND p.pfs_folderid=f.pff_id
			AND f.pff_isgallery=1
			AND f.pff_ispublic=1
			$sql_add
			GROUP BY f.pff_id
			ORDER BY u.user_name, f.pff_title");

	$sql_au = sed_sql_query("SELECT DISTINCT u.user_id, u.user_name, COUNT(*)
			FROM $db_pfs_folders f
			LEFT JOIN $db_users AS u on u.user_id=f.pff_userid
			WHERE f.pff_isgallery=1
			AND f.pff_ispublic=1
			GROUP BY f.pff_userid
			ORDER BY u.user_name ASC");

	$sql_rpic = sed_sql_query("SELECT p.*, u.user_id, u.user_name, f.pff_id, f.pff_title, f.pff_desc, f.pff_updated
			FROM $db_users u, $db_pfs p, $db_pfs_folders f
			WHERE p.pfs_userid=u.user_id
			AND p.pfs_folderid=f.pff_id
			AND f.pff_isgallery=1
			AND f.pff_ispublic=1
			$sql_add
			ORDER BY pfs_date DESC LIMIT ".$cfg['plugin']['gallery']['recent']);

	$sql_rand = sed_sql_query("SELECT p.*, u.user_id, u.user_name, f.pff_id, f.pff_title, f.pff_desc
			FROM $db_users u, $db_pfs p, $db_pfs_folders f
			WHERE p.pfs_userid=u.user_id
			AND p.pfs_folderid=f.pff_id
			AND f.pff_isgallery=1
			AND f.pff_ispublic=1
			$sql_add
			ORDER BY RAND() LIMIT 1 ");

	$sql2 = sed_sql_query("SELECT SUM(pfs_count), SUM(pfs_size)
			FROM $db_pfs p
			LEFT JOIN $db_pfs_folders f ON p.pfs_folderid=f.pff_id
			WHERE f.pff_isgallery=1
			AND f.pff_ispublic=1");

	$totalviews = sed_sql_result($sql2, 0, "SUM(pfs_count)");
	$totalsize = floor(sed_sql_result($sql2, 0, "SUM(pfs_size)")/1024);

	if ($rnd = sed_sql_fetcharray($sql_rand))
		{
//Goral		
		$pfs_dir=sed_pfs_path($rnd['pfs_userid']);
		$th_dir=sed_pfs_thumbpath($rnd['pfs_userid']);
//
		$rnd['pfs_fullfile'] = $pfs_dir.$rnd['pfs_file'];
		$rnd['pfs_desc'] = sed_cc($rnd['pfs_desc']);
		$rnd['pfs_filesize'] = floor($rnd['pfs_size']/1024);
		$rnd_picturecode = 'g'.$rnd['pff_id'].'-'.$rnd['pfs_id'];
//		$rnd_comments = sed_comments($rnd_picturecode);
//		$rnd_ratings = sed_ratings($rnd_picturecode);
		$rnd['new'] = ($rnd['pfs_date']+$cfg['plugin']['gallery']['newdelay']*86400>$sys['now']) ? $cfg['plugin']['gallery']['newtext'] : '';

		if (sed_gallery_ismovie($rnd['pfs_extension']))
			{
			$rnd['pfs_imgsize'] = array ('?','?');
			$rnd['pfs_imgsize_xy'] = '';
			$rnd['popup'] = "plug.php?e=gallery&amp;v=".$rnd['pfs_id'];
			}
		else
			{
			$rnd['pfs_imgsize'] = @getimagesize($rnd['pfs_fullfile']);
			$rnd['pfs_imgsize_xy'] = $rnd['pfs_imgsize'][0].'x'.$rnd['pfs_imgsize'][1];
			$rnd['popup'] = "javascript:popup('gallery&amp;v=".$rnd['pfs_id']."',".($rnd['pfs_imgsize'][0]+$cfg['plugin']['gallery']['popupmargin']).",".($rnd['pfs_imgsize'][1]+$cfg['plugin']['gallery']['popupmargin']).")";
			}

		$t-> assign(array(
			"HOME_RAND_ID" => $rnd['pfs_id'],
			"HOME_RAND_VIEWURL" => "plug.php?e=gallery&amp;v=".$rnd['pfs_id'],
			"HOME_RAND_VIEWURL_POPUP" =>"datas/users/".$rnd['pfs_file']."",
			"HOME_RAND_FILE" => $rnd['pfs_file'],
			"HOME_RAND_FULLFILE" => $pfs_dir.$rnd['pfs_file'],
			"HOME_RAND_THUMB" => sed_gallery_thumb($rnd['pfs_extension'], $rnd['pfs_file']),
			"HOME_RAND_ICON" => $icon[$rnd['pfs_extension']],
			"HOME_RAND_DESC" => $rnd['pfs_desc'],
			"HOME_RAND_SHORTDESC" => sed_cutstring($rnd['pfs_desc'],64),
			"HOME_RAND_SIZE" => $rnd['pfs_filesize'].$L['kb'],
			"HOME_RAND_DIMX" => $rnd['pfs_imgsize'][0],
			"HOME_RAND_DIMY" => $rnd['pfs_imgsize'][1],
			"HOME_RAND_DIMXY" => $rnd['pfs_imgsize_xy'],
			"HOME_RAND_DATE" => date($cfg['dateformat'], $rnd['pfs_date'] + $usr['timezone'] * 3600),
			"HOME_RAND_NEW" => $rnd['new'],
			"HOME_RAND_COUNT" => $rnd['pfs_count'],
//			"HOME_RAND_COMMENTS" => $rnd_comments,
//			"HOME_RAND_RATING" => $rnd_ratings,
			"HOME_RAND_PFF_URL" => "plug.php?e=gallery&amp;f=".$rnd['pff_id'],
			"HOME_RAND_PFF_TITLE" => sed_cc($rnd['pff_title']),
			"HOME_RAND_PFF_DESC" => sed_cc($rnd['pff_desc']),
			"HOME_RAND_AUTHOR" => sed_build_user($rnd['user_id'], sed_cc($rnd['user_name']))
				));
		}

	while ($rau = sed_sql_fetcharray($sql_au))
		{
		$t-> assign(array(
			"HOME_RAU_URL" => 'plug.php?e=gallery&amp;u='.$rau['user_id'],
			"HOME_RAU_COUNT" => $rau['COUNT(*)'],
			"HOME_RAU_AUTHOR" => sed_cc($rau['user_name'])
					));
		$t->parse("MAIN.HOME.RAU");
		}

	while ($row = sed_sql_fetcharray($sql))
		{
		$gals++;
		$gals_t += $row['COUNT(*)'];
		$row['new'] = ($row['pff_updated']+$cfg['plugin']['gallery']['newdelay']*86400>$sys['now']) ? $cfg['plugin']['gallery']['newtext'] : '';
		$prev_userid = $row['user_id'];
		$prev_username = $row['user_name'];

		$t-> assign(array(
			"HOME_ROW_URL" => 'plug.php?e=gallery&amp;f='.$row['pff_id'],
			"HOME_ROW_TITLE" => sed_cc($row['pff_title']),
			"HOME_ROW_DESC" => sed_cc($row['pff_desc']),
			"HOME_ROW_COUNT" => $row['COUNT(*)'],
			"HOME_ROW_AUTHOR" => sed_build_user($row['user_id'], sed_cc($row['user_name'])),
			"HOME_ROW_NEW" => $row['new']
			));
		$t->parse("MAIN.HOME.ROW");
		}


	$gals_title .= ($u>0) ? " ".$cfg['separator']." <a href=\"plug.php?e=gallery&amp;u=".$prev_userid."\">".sed_cc($prev_username)."</a>" : '';

	while ($row = sed_sql_fetcharray($sql_rpic))
		{
//Goral		
		$pfs_dir=sed_pfs_path($row['pfs_userid']);
		$th_dir=sed_pfs_thumbpath($row['pfs_userid']);
//
		$row['new'] = ($row['pff_updated']+$cfg['plugin']['gallery']['newdelay']*86400>$sys['now']) ? $cfg['plugin']['gallery']['newtext'] : '';
		$row['pfs_desc'] = sed_cc($row['pfs_desc']);
		$row['pfs_fullfile'] = $pfs_dir.$row['pfs_file'];
		$row['pfs_filesize'] = floor($row['pfs_size']/1024);

		if (sed_gallery_ismovie($row['pfs_extension']))
			{
			$row['pfs_imgsize'] = array ('?','?');
			$row['pfs_imgsize_xy'] = '';
			$row['popup'] = "plug.php?e=gallery&amp;v=".$row['pfs_id'];
			}
		else
			{
			$row['pfs_imgsize'] = @getimagesize($row['pfs_fullfile']);
			$row['pfs_imgsize_xy'] = $row['pfs_imgsize'][0].'x'.$row['pfs_imgsize'][1];
			$row['popup'] = "javascript:popup('gallery&amp;v=".$row['pfs_id']."',".($row['pfs_imgsize'][0]+$cfg['plugin']['gallery']['popupmargin']).",".($row['pfs_imgsize'][1]+$cfg['plugin']['gallery']['popupmargin']).")";
			}

		$t-> assign(array(
			"HOME_RPIC_ROW_ID" => $row['pfs_id'],
			"HOME_RPIC_ROW_VIEWURL" => "plug.php?e=gallery&amp;v=".$row['pfs_id'],
			"HOME_RPIC_ROW_VIEWURL_POPUP" => "datas/users/".$row['pfs_file']."",
			"HOME_RPIC_ROW_THUMB" => sed_gallery_thumb($row['pfs_extension'], $row['pfs_file']),
			"HOME_RPIC_ROW_FILE" => $row['pfs_file'],
			"HOME_RPIC_ROW_FULLFILE" => $row['pfs_fullfile'],
			"HOME_RPIC_ROW_DESC" => $row['pfs_desc'],
			"HOME_RPIC_ROW_SHORTDESC" => sed_cutstring($row['pfs_desc'],64),
			"HOME_RPIC_ROW_SIZE" => $row['pfs_filesize'].$L['kb'],
			"HOME_RPIC_ROW_DIMX" => $row['pfs_imgsize'][0],
			"HOME_RPIC_ROW_DIMY" => $row['pfs_imgsize'][1],
			"HOME_RPIC_ROW_DIMXY" => $row['pfs_imgsize_xy'],
			"HOME_RPIC_ROW_COUNT" => $row['COUNT(*)'],
			"HOME_RPIC_ROW_AUTHOR" => sed_build_user($row['user_id'], sed_cc($row['user_name'])),
			"HOME_RPIC_ROW_DATE" => date($cfg['dateformat'], $row['pfs_date'] + $usr['timezone'] * 3600),
			"HOME_RPIC_ROW_PFF_URL" => "plug.php?e=gallery&amp;f=".$row['pff_id'],
			"HOME_RPIC_ROW_PFF_TITLE" => sed_cc($row['pff_title']),
			"HOME_RPIC_ROW_NEW" => $row['new']
			));
		$t->parse("MAIN.HOME.ROW_RPIC");
		}


	$t-> assign(array(
		"HOME_TITLE" => $gals_title,
		"HOME_TOTALFOLDERS" => $gals,
		"HOME_TOTALFILES" => $gals_t,
		"HOME_TOTALSIZE" => $totalsize,
		"HOME_TOTALVIEWS" => $totalviews
			));

	if ($cfg['plugin']['gallery']['potw']>0)
		{
		$sql_potw = sed_sql_query("SELECT p.*, u.user_id, u.user_name, f.pff_id, f.pff_title, f.pff_desc
			FROM $db_users AS u, $db_pfs AS p, $db_pfs_folders AS f
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
//			$potw_comments = ($cfg['disablecomments']) ? '' : sed_comments($potw_picturecode);
//			$potw_ratings = ($cfg['disableratings']) ? '' : sed_ratings($potw_picturecode);
			$potw['new'] = ($potw['pfs_date']+$cfg['plugin']['gallery']['newdelay']*86400>$sys['now']) ? $cfg['plugin']['gallery']['newtext'] : '';

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
//				"POTW_COMMENTS" => $potw_comments,
//				"POTW_RATING" => $potw_ratings,
				"POTW_PFF_URL" => "plug.php?e=gallery&amp;f=".$potw['pff_id'],
				"POTW_PFF_TITLE" => sed_cc($potw['pff_title']),
				"POTW_PFF_DESC" => sed_cc($potw['pff_desc'])
				));
			$t->parse("MAIN.HOME.GALLERY_POTW");
			}
		}

	$t->parse("MAIN.HOME");

	break;

	}

?>