<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=pfs.php
Version=120
Updated=2007-feb-20
Type=Core
Author=Neocrome
Description=PFS
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$id = sed_import('id','G','TXT');
$o = sed_import('o','G','TXT');
$f = sed_import('f','G','INT');
$v = sed_import('v','G','TXT');
$c1 = sed_import('c1','G','TXT');
$c2 = sed_import('c2','G','TXT');
$userid = sed_import('userid','G','INT');
$gd_supported = array('jpg', 'jpeg', 'png', 'gif');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('pfs', 'a');
sed_block($usr['auth_read']);

if (!$usr['isadmin'] || $userid=='')
	{
	$userid = $usr['id'];
	}
else
	{
	$more1 = "?userid=".$userid;
	$more = "&userid=".$userid;
	}

if ($userid!=$usr['id'])
	{ sed_block($usr['isadmin']); }

$files_count = 0;
$folders_count = 0;
$standalone = FALSE;
$user_info = sed_userinfo($userid);
$maingroup = ($userid==0) ? 5 : $user_info['user_maingrp'];

$cfg['pfs_dir_user'] = sed_pfs_path($userid);
$cfg['th_dir_user'] = sed_pfs_thumbpath($userid);
$cfg['rel_dir_user'] = sed_pfs_relpath($userid);

$sql = sed_sql_query("SELECT grp_pfs_maxfile, grp_pfs_maxtotal FROM $db_groups WHERE grp_id='$maingroup'");
if ($row = sed_sql_fetcharray($sql))
	{
	$maxfile = $row['grp_pfs_maxfile'];
	$maxtotal = $row['grp_pfs_maxtotal'];
	}
else
	{ sed_die(); }

if (($maxfile==0 || $maxtotal==0) && !$usr['isadmin'])
	{ sed_block(FALSE); }

if (!empty($c1) || !empty($c2))
	{
	$morejavascript = "
function addthumb(gfile,c1,c2)
	{ opener.document.".$c1.".".$c2.".value += '[thumb=".$cfg['th_dir_user']."'+gfile+']'+gfile+'[/thumb]'; }
function addpix(gfile,c1,c2)
	{ opener.document.".$c1.".".$c2.".value += '[img]'+gfile+'[/img]'; }
	";
	$more .= "&c1=".$c1."&c2=".$c2;
	$more1 .= ($more1=='') ? "?c1=".$c1."&c2=".$c2 : "&c1=".$c1."&c2=".$c2;
	$standalone = TRUE;
	}

reset($sed_extensions);
foreach ($sed_extensions as $k => $line)
	{
 	$icon[$line[0]] = "<img src=\"system/img/pfs/".$line[2].".gif\" alt=\"".$line[1]."\" />";
 	$filedesc[$line[0]] = $line[1];
 	}


$L['pfs_title'] = ($userid==0) ? $L['SFS'] : $L['pfs_title'];
$title = "<a href=\"pfs.php".$more1."\">".$L['pfs_title']."</a>";

if ($userid!=$usr['id'])
	{
	sed_block($usr['isadmin']);
	$title .= ($userid==0) ? '' : " (".sed_build_user($user_info['user_id'], $user_info['user_name']).")";
	}

/* === Hook === */
$extp = sed_getextplugins('pfs.first');
if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
/* ===== */


$u_totalsize=0;
$sql = sed_sql_query("SELECT SUM(pfs_size) FROM $db_pfs WHERE pfs_userid='$userid' ");
$pfs_totalsize = sed_sql_result($sql,0,"SUM(pfs_size)");

if ($a=='upload')
	{
	sed_block($usr['auth_write']);
	$folderid = sed_import('folderid','P','INT');
	$ndesc = sed_import('ndesc','P','ARR');

	/* === Hook === */
	$extp = sed_getextplugins('pfs.upload.first');
	if (is_array($extp))
		{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	if ($folder_id!=0)
		{
		$sql = sed_sql_query("SELECT pff_id FROM $db_pfs_folders WHERE pff_userid='$userid' AND pff_id='$folderid' ");
		sed_die(sed_sql_numrows($sql)==0);
		}

	$disp_errors = "<ul>";

	for ($ii = 0; $ii < $cfg['pfsmaxuploads']; $ii++)
		{
		$u_tmp_name = $_FILES['userfile']['tmp_name'][$ii];
		$u_type = $_FILES['userfile']['type'][$ii];
		$u_name = $_FILES['userfile']['name'][$ii];
		$u_size = $_FILES['userfile']['size'][$ii];
		$u_name  = str_replace("\'",'',$u_name );
		$u_name  = trim(str_replace("\"",'',$u_name ));

		if (!empty($u_name))
			{
			$disp_errors .= "<li>".$u_name." : ";
			$f_extension_ok = 0;
			$desc = $ndesc[$ii];
			$u_name = strtolower($u_name);
			$u_newname = ($cfg['pfsuserfolder']) ? $u_name : $userid."-".$u_name;
			$u_sqlname = sed_sql_prep($u_newname);
			$dotpos = strrpos($u_name,".")+1;
			$f_extension = substr($u_name, $dotpos, 5);
			$f_extension_ok = 0;

			if ($f_extension!='php' && $f_extension!='php3' && $f_extension!='php4')
				{
				foreach ($sed_extensions as $k => $line)
					{
					if (strtolower($f_extension) == $line[0])
						{ $f_extension_ok = 1; }
					}
				}

			if (is_uploaded_file($u_tmp_name) && $u_size>0 && $u_size<($maxfile*1024) && $f_extension_ok && ($pfs_totalsize+$u_size)<$maxtotal*1024   )
				{
				if (!file_exists($cfg['pfs_dir_user'].$u_newname))
					{
					if ($cfg['pfsuserfolder'])
						{
						if (!is_dir($cfg['pfs_dir_user']))
							{ mkdir($cfg['pfs_dir_user'], 0666); }
						if (!is_dir($cfg['th_dir_user']))
							{ mkdir($cfg['th_dir_user'], 0666); }
						}

					move_uploaded_file($u_tmp_name, $cfg['pfs_dir_user'].$u_newname);
					@chmod($cfg['pfs_dir_user'].$u_newname, 0766);

					/* === Hook === */
					$extp = sed_getextplugins('pfs.upload.moved');
					if (is_array($extp))
						{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
					/* ===== */

					$u_size = filesize($cfg['pfs_dir_user'].$u_newname);

					$sql = sed_sql_query("INSERT INTO $db_pfs
						(pfs_userid,
						pfs_date,
						pfs_file,
						pfs_extension,
						pfs_folderid,
						pfs_desc,
						pfs_size,
						pfs_count)
						VALUES
						(".(int)$userid.",
						".(int)$sys['now_offset'].",
						'".sed_sql_prep($u_sqlname)."',
						'".sed_sql_prep($f_extension)."',
						".(int)$folderid.",
						'".sed_sql_prep($desc)."',
						".(int)$u_size.",
						0) ");

					$sql = sed_sql_query("UPDATE $db_pfs_folders SET pff_updated='".$sys['now']."' WHERE pff_id='$folderid'");
					$disp_errors .= $L['Yes'];
					$pfs_totalsize += $u_size;

					/* === Hook === */
					$extp = sed_getextplugins('pfs.upload.done');
					if (is_array($extp))
						{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
					/* ===== */

					if (in_array($f_extension, $gd_supported) && $cfg['th_amode']!='Disabled' && file_exists($cfg['pfs_dir_user'].$u_newname))
						{
						@unlink($cfg['th_dir_user'].$u_newname);
						$th_colortext = array(hexdec(substr($cfg['th_colortext'],0,2)), hexdec(substr($cfg['th_colortext'],2,2)), hexdec(substr($cfg['th_colortext'],4,2)));
						$th_colorbg = array(hexdec(substr($cfg['th_colorbg'],0,2)), hexdec(substr($cfg['th_colorbg'],2,2)), hexdec(substr($cfg['th_colorbg'],4,2)));
						sed_createthumb($cfg['pfs_dir_user'].$u_newname, $cfg['th_dir_user'].$u_newname, $cfg['th_x'],$cfg['th_y'], $cfg['th_keepratio'], $f_extension, $u_newname, floor($u_size/1024), $th_colortext, $cfg['th_textsize'], $th_colorbg, $cfg['th_border'], $cfg['th_jpeg_quality'], $cfg['th_dimpriority']);
						}
					}
				else
					{
					$disp_errors .= $L['pfs_fileexists'];
					}
				}
			else
				{
				$disp_errors .= $L['pfs_filetoobigorext'];
				}
			$disp_errors .= "</li>";
			}
		}
	$disp_errors .= "</ul>";
	}
elseif ($a=='delete')
	{
	sed_block($usr['auth_write']);
	sed_check_xg();
	$sql = sed_sql_query("SELECT pfs_file, pfs_folderid FROM $db_pfs WHERE pfs_userid='$userid' AND pfs_id='$id' LIMIT 1");

	if ($row = sed_sql_fetcharray($sql))
		{
		$pfs_file = $row['pfs_file'];
		$f = $row['pfs_folderid'];
		$ff = $cfg['pfs_dir_user'].$pfs_file;

		if (file_exists($ff) && (substr($pfs_file, 0, strpos($pfs_file, "-"))==$userid || $usr['isadmin']))
			{
			@unlink($ff);
			if (file_exists($cfg['th_dir_user'].$pfs_file))
				{ @unlink($cfg['th_dir_user'].$pfs_file); }
			$sql = sed_sql_query("DELETE FROM $db_pfs WHERE pfs_id='$id'");
			header("Location: pfs.php?f=$f".$more."&o=".$o);
			exit;
			}
		}
	else
		{ sed_die(); }
	}
elseif ($a=='newfolder')
	{
	sed_block($usr['auth_write']);
	$ntitle = sed_import('ntitle','P','TXT');
	$ndesc = sed_import('ndesc','P','TXT');
	$nispublic = sed_import('nispublic','P','BOL');
	$nisgallery = sed_import('nisgallery','P','BOL');
	$ntitle = (empty($ntitle)) ? '???' : $ntitle;

	$sql = sed_sql_query("INSERT INTO $db_pfs_folders
		(pff_userid,
		pff_title,
		pff_date,
		pff_updated,
		pff_desc,
		pff_ispublic,
		pff_isgallery,
		pff_count)
		VALUES
		(".(int)$userid.",
		'".sed_sql_prep($ntitle)."',
		".(int)$sys['now'].",
		".(int)$sys['now'].",
		'".sed_sql_prep($ndesc)."',
		".(int)$nispublic.",
		".(int)$nisgallery.",
		0)");

	header("Location: pfs.php".$more1);
	exit;
	}

elseif ($a=='deletefolder')
	{
	sed_block($usr['auth_write']);
	sed_check_xg();
	$sql = sed_sql_query("DELETE FROM $db_pfs_folders WHERE pff_userid='$userid' AND pff_id='$f' ");
	$sql = sed_sql_query("UPDATE $db_pfs SET pfs_folderid=0 WHERE pfs_userid='$userid' AND pfs_folderid='$f' ");
	header("Location: pfs.php".$more1);
	exit;
	}

$f = (empty($f)) ? '0' : $f;

if ($f>0)
	{
	$sql1 = sed_sql_query("SELECT * FROM $db_pfs_folders WHERE pff_id='$f' AND pff_userid='$userid'");
	if ($row1 = sed_sql_fetcharray($sql1))
		{
		$pff_id = $row1['pff_id'];
		$pff_title = $row1['pff_title'];
		$pff_updated = $row1['pff_updated'];
		$pff_desc = $row1['pff_desc'];
		$pff_ispublic = $row1['pff_ispublic'];
		$pff_isgallery = $row1['pff_isgallery'];
		$pff_count = $row1['pff_count'];

		$sql = sed_sql_query("SELECT * FROM $db_pfs WHERE pfs_userid='$userid' AND pfs_folderid='$f' ORDER BY pfs_file ASC");
		$title .= " ".$cfg['separator']." <a href=\"pfs.php?f=".$pff_id.$more."\">".$pff_title."</a>";
		}
		else
		{ sed_die(); }
	$movebox = sed_selectbox_folders($userid,"",$f);
	}
else
	{
	$sql = sed_sql_query("SELECT * FROM $db_pfs WHERE pfs_userid='$userid' AND pfs_folderid=0 ORDER BY pfs_file ASC");
	$sql1 = sed_sql_query("SELECT * FROM $db_pfs_folders WHERE pff_userid='$userid' ORDER BY pff_isgallery ASC, pff_title ASC");
	$sql2 = sed_sql_query("SELECT COUNT(*) FROM $db_pfs WHERE pfs_folderid>0 AND pfs_userid='$userid'");
	$sql3 = sed_sql_query("SELECT pfs_folderid, COUNT(*), SUM(pfs_size) FROM $db_pfs WHERE pfs_userid='$userid' GROUP BY pfs_folderid");

	while ($row3 = sed_sql_fetcharray($sql3))
		{
		$pff_filescount[$row3['pfs_folderid']] = $row3['COUNT(*)'];
		$pff_filessize[$row3['pfs_folderid']] = $row3['SUM(pfs_size)'];
		}

	$folders_count = sed_sql_numrows($sql1);
	$subfiles_count = sed_sql_result($sql2,0,"COUNT(*)");
	$movebox = sed_selectbox_folders($userid,"/","");

	while ($row1 = sed_sql_fetcharray($sql1))
		{
		$pff_id = $row1['pff_id'];
		$pff_title = $row1['pff_title'];
		$pff_updated = $row1['pff_updated'];
		$pff_desc = $row1['pff_desc'];
		$pff_ispublic = $row1['pff_ispublic'];
		$pff_isgallery = $row1['pff_isgallery'];
		$pff_count = $row1['pff_count'];
		$pff_fcount = $pff_filescount[$pff_id];
		$pff_fsize = floor($pff_filessize[$pff_id]/1024);
		$pff_fcount = (empty($pff_fcount)) ? "0" : $pff_fcount;
		$pff_fssize = (empty($pff_fsize)) ? "0" : $pff_fsize;

		$list_folders .= "<tr><td>[<a href=\"pfs.php?a=deletefolder&amp;".sed_xg()."&amp;f=".$pff_id.$more."\">x</a>]</td>";
		$list_folders .= "<td><a href=\"pfs.php?m=editfolder&amp;f=".$pff_id.$more."\">".$L['Edit']."</a></td>";

		if ($pff_isgallery)
			{ $icon_f = "<img src=\"themes/$skin/img/system/icon-gallery.gif\" alt=\"\" />"; }
		else
			{ $icon_f = "<img src=\"themes/$skin/img/system/icon-folder.gif\" alt=\"\" />"; }

		$list_folders .= "<td><a href=\"pfs.php?f=".$pff_id.$more."\">".$icon_f."</a></td>";
		$list_folders .= "<td><a href=\"pfs.php?f=".$pff_id.$more."\">".$pff_title."</a></td>";
		$list_folders .= "<td style=\"text-align:right;\">".$pff_fcount."</td>";
		$list_folders .= "<td style=\"text-align:right;\">".$pff_fsize." ".$L['kb']."</td>";
		$list_folders .= "<td style=\"text-align:center;\">".date($cfg['dateformat'], $row1['pff_updated'] + $usr['timezone'] * 3600)."</td>";
		$list_folders .= "<td style=\"text-align:center;\">".$sed_yesno[$pff_ispublic]."</td>";
		$list_folders .= "<td>".sed_cutstring($pff_desc,32)."</td></tr>";
		}
	}

$files_count = sed_sql_numrows($sql);
$movebox = (empty($f)) ? sed_selectbox_folders($userid,"/","") : sed_selectbox_folders($userid,"$f","");
$th_colortext = array(hexdec(substr($cfg['th_colortext'],0,2)), hexdec(substr($cfg['th_colortext'],2,2)), hexdec(substr($cfg['th_colortext'],4,2)));
$th_colorbg = array(hexdec(substr($cfg['th_colorbg'],0,2)), hexdec(substr($cfg['th_colorbg'],2,2)), hexdec(substr($cfg['th_colorbg'],4,2)));

while ($row = sed_sql_fetcharray($sql))
	{
	$pfs_id = $row['pfs_id'];
	$pfs_file = $row['pfs_file'];
	$pfs_date = $row['pfs_date'];
	$pfs_extension = $row['pfs_extension'];
	$pfs_desc = $row['pfs_desc'];
	$pfs_fullfile = $cfg['pfs_dir_user'].$pfs_file;
	$pfs_filesize = floor($row['pfs_size']/1024);
	$pfs_icon = $icon[$pfs_extension];

	$dotpos = strrpos($pfs_file, ".")+1;
	$pfs_realext = strtolower(substr($pfs_file, $dotpos, 5));
	unset($add_thumbnail, $add_image);
	$add_file = ($standalone) ? "<a href=\"javascript:addfile('".$pfs_file."','".$c1."','".$c2."')\"><img src=\"themes/".$skin."/img/system/icon-pastefile.gif\" alt=\"\" /></a>" : '';

	if ($pfs_extension!=$pfs_realext);
		{
		$sql1 = sed_sql_query("UPDATE $db_pfs SET pfs_extension='$pfs_realext' WHERE pfs_id='$pfs_id' " );
		$pfs_extension = $pfs_realext;
		}

	if (in_array($pfs_extension, $gd_supported) && $cfg['th_amode']!='Disabled')
		{
		if (!file_exists($cfg['th_dir_user'].$pfs_file) && file_exists($cfg['pfs_dir_user'].$pfs_file))
			{
			$th_colortext = array(hexdec(substr($cfg['th_colortext'],0,2)), hexdec(substr($cfg['th_colortext'],2,2)), hexdec(substr($cfg['th_colortext'],4,2)));
			$th_colorbg = array(hexdec(substr($cfg['th_colorbg'],0,2)), hexdec(substr($cfg['th_colorbg'],2,2)), hexdec(substr($cfg['th_colorbg'],4,2)));
			sed_createthumb($cfg['pfs_dir_user'].$pfs_file, $cfg['th_dir_user'].$pfs_file, $cfg['th_x'],$cfg['th_y'], $cfg['th_keepratio'], $pfs_extension, $pfs_file, $pfs_filesize, $th_colortext, $cfg['th_textsize'], $th_colorbg, $cfg['th_border'], $cfg['th_jpeg_quality'], $cfg['th_dimpriority']);
			}

	   if ($standalone)
			{
			$add_thumbnail .= "<a href=\"javascript:addthumb('".$pfs_file."','".$c1."','".$c2."')\"><img src=\"themes/".$skin."/img/system/icon-pastethumb.gif\" alt=\"\" /></a>";
			$add_image = "<a href=\"javascript:addpix('".$cfg['pfs_dir_user'].$pfs_file."','".$c1."','".$c2."')\"><img src=\"themes/".$skin."/img/system/icon-pasteimage.gif\" alt=\"\" /></a>";
			}
		if ($o=='thumbs')
			{ $pfs_icon = "<a href=\"".$pfs_fullfile."\"><img src=\"".$cfg['th_dir_user'].$pfs_file."\" alt=\"".$pfs_file."\"></a>"; }
		}

	$list_files .= "<tr><td>[<a href=\"pfs.php?a=delete&amp;".sed_xg()."&amp;id=".$pfs_id.$more."&amp;o=".$o."\">x</a>]</td>";
	$list_files .= "<td><a href=\"pfs.php?m=edit&amp;id=".$pfs_id.$more."\">".$L['Edit']."</a></td>";
	$list_files .= "<td>".$pfs_icon."</td>";
	$list_files .= "<td><a href=\"".$pfs_fullfile."\">".$pfs_file."</a></td>";
	$list_files .= "<td>".date($cfg['dateformat'], $pfs_date + $usr['timezone'] * 3600)."</td>";
	$list_files .= "<td style=\"text-align:right;\">".$pfs_filesize.$L['kb']."</td>";
	$list_files .= "<td style=\"text-align:right;\">".$row['pfs_count']."</td>";
	$list_files .= "<td>".$filedesc[$pfs_extension]." / ".sed_cc($pfs_desc)."</td>";
	$list_files .= "<td>".$add_thumbnail.$add_image.$add_file."</td></tr>";
	$pfs_foldersize = $pfs_foldersize + $pfs_filesize;
	}

if ($files_count>0 || $folders_count>0)
	{
	if ($folders_count>0)
		{
		$disp_main .= "<h4>".$folders_count." ".$L['Folders']." / ".$subfiles_count." ".$L['Files']." :</h4>";
		$disp_main .= "<table class=\"cells\">";
		$disp_main .= "<tr><td><i>".$L['Delete']."</i></td>";
		$disp_main .= "<td><i>".$L['Edit']."</i></td>";
		$disp_main .= "<td colspan=\"2\" style=\"text-align:center;\"><i>".$L['Folder']."/".$L['Gallery']."</i></td>";
		$disp_main .= "<td><i>".$L['Files']."</i></td>";
		$disp_main .= "<td><i>".$L['Size']."</i></td>";
		$disp_main .= "<td><i>".$L['Updated']."</i></td>";
		$disp_main .= "<td><i>".$L['Public']."</i></td>";
		$disp_main .= "<td><i>".$L['Description']."</i></td></tr>";
		$disp_main .= $list_folders."</table>";
		}

	if ($files_count>0)
		{

	$disp_main .= "<h4>".$files_count." ";

		if ($f>0)
			{ $disp_main .= $L['pfs_filesinthisfolder']; }
		else
			{ $disp_main .= $L['pfs_filesintheroot']; }

		$disp_main .= "</h4><table class=\"cells\">";

		$disp_main .= "<tr><td><i>".$L['Delete']."</i></td>";
		$disp_main .= "<td><i>".$L['Edit']."</i></td>";
		$disp_main .= "<td colspan=\"2\" style=\"text-align:center;\"><i>".$L['File']."</i></td>";
		$disp_main .= "<td style=\"text-align:center;\"><i>".$L['Date']."</i></td>";
		$disp_main .= "<td style=\"text-align:right;\"><i>".$L['Size']."</i></td>";
		$disp_main .= "<td style=\"text-align:right;\"><i>".$L['Hits']."</i></td>";
		$disp_main .= "<td><i>".$L['Description']."</i></td>";
		$disp_main .= "<td>&nbsp;</td></tr>";
		$disp_main .= $list_files."</table>";
		}
	}
	else
	{
	$disp_main = $L['pfs_folderistempty'];
	}

// ========== Statistics =========

$pfs_precentbar = @floor(100 * $pfs_totalsize / 1024 / $maxtotal);
$disp_stats = $L['pfs_totalsize']." : ".floor($pfs_totalsize/1024).$L['kb']." / ".$maxtotal.$L['kb'];
$disp_stats .= " (".@floor(100*$pfs_totalsize/1024/$maxtotal)."%) ";
$disp_stats .= " &nbsp; ".$L['pfs_maxsize']." : ".$maxfile.$L['kb'];
$disp_stats .= ($o!='thumbs' && $files_count>0 && $cfg['th_amode']!='Disabled') ? " &nbsp; <a href=\"pfs.php?f=".$f.$more."&amp;o=thumbs\">".$L['Thumbnails']."</a>" : '';
$disp_stats .= "<div style=\"width:200px; margin-top:0;\"><div class=\"bar_back\">";
$disp_stats .= "<div class=\"bar_front\" style=\"width:".$pfs_precentbar."%;\"></div></div></div>";

// ========== Upload =========

$disp_upload = "<h4>".$L['pfs_newfile']."</h4>";
$disp_upload .= "<form enctype=\"multipart/form-data\" action=\"pfs.php?a=upload".$more."\" method=\"post\">";
$disp_upload .= "<table class=\"cells\"><tr><td colspan=\"3\">";
$disp_upload .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".($maxfile*1024)."\" />";
$disp_upload .= $L['Folder']." : ".sed_selectbox_folders($userid, "", $f)."</td></tr>";
$disp_upload .= "<tr><td>&nbsp;</td><td><i>".$L['Description']."</i></td>";
$disp_upload .= "<td style=\"width:100%;\"><i>".$L['File']."</i></td></tr>";

for ($ii = 0; $ii < $cfg['pfsmaxuploads']; $ii++)
	{
	$disp_upload .= "<tr><td style=\"text-align:center;\">#".($ii+1)."</td>";
	$disp_upload .= "<td><input type=\"text\" class=\"text\" name=\"ndesc[$ii]\" value=\"\" size=\"40\" maxlength=\"255\" /></td>";
	$disp_upload .= "<td><input name=\"userfile[$ii]\" type=\"file\" class=\"file\" size=\"24\" /></td></tr>";
	}
$disp_upload .= "<tr><td colspan=\"3\" style=\"text-align:center;\">";
$disp_upload .= "<input type=\"submit\" class=\"submit\" value=\"".$L['Upload']."\" /></td></tr></table></form>";

// ========== Allowed =========

$disp_allowed = "<h4>".$L['pfs_extallowed']." :</h4><table class=\"cells\">";
reset($sed_extensions);
sort($sed_extensions);
foreach ($sed_extensions as $k => $line)
 	{
 	$disp_allowed .= "<tr><td style=\"width:24px; text-align:center;\">".$icon[$line[0]]."</td>";
 	$disp_allowed .= "<td style=\"width:80px;\">".$line[0]."</td><td>".$filedesc[$line[0]]."</td></tr>";
 	}
$disp_allowed .= "</table>";

// ========== Create a new folder =========

if ($f==0 && $usr['auth_write'])
	{
	$disp_newfolder = "<h4>".$L['pfs_newfolder']."</h4>";
	$disp_newfolder .= "<form id=\"newfolder\" action=\"pfs.php?a=newfolder".$more."\" method=\"post\">";
	$disp_newfolder .= "<table class=\"cells\"><tr><td>".$L['Title']."</td>";
	$disp_newfolder .= "<td><input type=\"text\" class=\"text\" name=\"ntitle\" value=\"\" size=\"32\" maxlength=\"64\" /></td></tr>";
	$disp_newfolder .= "<tr><td>".$L['Description']."</td>";
	$disp_newfolder .= "<td><input type=\"text\" class=\"text\" name=\"ndesc\" value=\"\" size=\"32\" maxlength=\"255\" /></td></tr>";
	$disp_newfolder .= "<tr><td>".$L['pfs_ispublic']."</td>";
	$disp_newfolder .= "<td><input type=\"radio\" class=\"radio\" name=\"nispublic\" value=\"1\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"nispublic\" value=\"0\" checked=\"checked\" />".$L['No']."</td></tr>";
	$disp_newfolder .= "<tr><td>".$L['pfs_isgallery']."</td>";
	$disp_newfolder .= "<td><input type=\"radio\" class=\"radio\" name=\"nisgallery\" value=\"1\" />".$L['Yes']." <input type=\"radio\" class=\"radio\" name=\"nisgallery\" value=\"0\" checked=\"checked\" />".$L['No']."</td></tr>";
	$disp_newfolder .= "<tr><td colspan=\"2\" style=\"text-align:center;\">";
	$disp_newfolder .= "<input type=\"submit\" class=\"submit\" value=\"".$L['Create']."\" /></td></tr>";
	$disp_newfolder .= "</table></form>";
	}

// ========== Putting all together =========

$body = "<p>".$disp_stats."</p>";
$body .= (!empty($disp_errors)) ? "<p>".$disp_errors."</p>" : '';
$body .= "<p>".$disp_main."</p>";
$body .= ($usr['auth_write']) ? "<p>".$disp_upload."</p>" : '';
$body .= ($usr['auth_write']) ? "<p>".$disp_newfolder."</p>" : '';
$body .= ($usr['auth_write']) ? "<p>".$disp_allowed."</p>" : '';

$out['subtitle'] = $L['Mypfs'];

/* ============= */

if ($standalone)
	{
	$pfs_header1 = $cfg['doctype']."<html><head>
<title>".$cfg['maintitle']."</title>".sed_htmlmetas()."
<script type=\"text/javascript\">
<!--
function help(rcode,c1,c2)
	{ window.open('plug.php?h='+rcode+'&c1='+c1+'&c2='+c2,'Help','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=512,top=16'); }
function addthumb(gfile,c1,c2)
	{ opener.document.".$c1.".".$c2.".value += '[thumb=".$cfg['th_dir_user']."'+gfile+']'+gfile+'[/thumb]'; }
function addpix(gfile,c1,c2)
	{ opener.document.".$c1.".".$c2.".value += '[img]'+gfile+'[/img]'; }
function addfile(gfile,c1,c2)
	{ opener.document.".$c1.".".$c2.".value += '[pfs]".$cfg['rel_dir_user']."'+gfile+'[/pfs]'; }
function addglink(id,c1,c2)
	{ opener.document.".$c1.".".$c2.".value += '[gallery='+id+']".$L["pfs_gallery"]." #'+id+'[/gallery]'; }
function comments(rcode)
	{ window.open('comments.php?id='+rcode,'Comments','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=576,top=64'); }
function picture(url,sx,sy)
	{ window.open('pfs.php?m=view&id='+url,'Picture','toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width='+sx+',height='+sy+',left=0,top=0'); }
function ratings(rcode)
	{ window.open('ratings.php?id='+rcode,'Ratings','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=16,top=16'); }
//-->
</script>
";

	$pfs_header2 = "</head><body>";
	$pfs_footer = "</body></html>";

	$t = new XTemplate("themes/".$skin."/pfs.tpl");

	$t->assign(array(
		"PFS_STANDALONE_HEADER1" => $pfs_header1,
		"PFS_STANDALONE_HEADER2" => $pfs_header2,
		"PFS_STANDALONE_FOOTER" => $pfs_footer,
			));

	$t->parse("MAIN.STANDALONE_HEADER");
	$t->parse("MAIN.STANDALONE_FOOTER");

	$t-> assign(array(
		"PFS_TITLE" => $title,
		"PFS_BODY" => $body
		));

	$t->parse("MAIN");
	$t->out("MAIN");
	}
else
	{
	require("system/header.php");

	$t = new XTemplate("themes/".$skin."/pfs.tpl");

	$t-> assign(array(
		"PFS_TITLE" => $title,
		"PFS_BODY" => $body
		));

	/* === Hook === */
	$extp = sed_getextplugins('pfs.tags');
	if (is_array($extp))
	{ foreach($extp as $k => $pl) { include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); } }
	/* ===== */

	$t->parse("MAIN");
	$t->out("MAIN");

	require("system/footer.php");
	}

?>