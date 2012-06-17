<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/gallery/gallery.admin.php
Version=100
Updated=2006-feb-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=gallery
Part=admin
File=gallery.admin
Hooks=admin.plug
Tags=
Minlevel=95
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$cfg['imp_dir'] = "datas/import";
$gd_supported = array('jpg', 'jpeg', 'png', 'gif');
// $movies_supported = array('avi', 'mpg', 'mpeg', 'mpeg', 'wmv', 'mov', 'rm', 'asf');

$plugin_title = $L['plu_title'];

$a = cv('a','G','ALP');

switch ($a)
	{
	case 'import':
	$folderid = cv('folderid','P','INT');

	$sql = sed_query("SELECT pff_id, pff_userid FROM $db_pfs_folders WHERE pff_id='$folderid'");
	sed_dieifzero(sed_num_rows($sql));
	$pff = sed_fetch_array($sql);

	require('system/config.extensions.php');

	$plugin_body .= "Importing...<ul>";

	$handle=opendir($cfg['imp_dir']);

	while ($f = readdir($handle))
		{
		if (($f != ".") && ($f != "..") && !is_dir($f))
			{
			$f_extension_ok = FALSE;
			$u_name = strtolower($f);
// Goral
	if ($cfg['pfsuserfolder'])
		{ $u_newname = $pff['pff_userid']."/".$u_name; }
	else
		{ $u_newname = $pff['pff_userid']."-".$u_name; }
	}
//			$u_newname = $pff['pff_userid']."-".$u_name;
//
			$u_sqlname = sed_addslashes($u_newname);
			$dotpos = strrpos($u_name,".")+1;
			$f_extension = substr($u_name, $dotpos, 5);
			$f_extension_ok = 0;

			foreach ($sed_extensions as $k => $line)
				{
				if (strtolower($f_extension) == $line[0])
					{ $f_extension_ok = TRUE; }
				}

			if ($f_extension_ok)
				{
				if (!file_exists($cfg['imp_dir']."/".$u_newname))
					{
					if ( rename($cfg['imp_dir']."/".$f, "datas/users/".$u_newname) )
			 			{
			 			@chmod($cfg['imp_dir']."/".$u_newname, 0766);
			 			$u_size = filesize($cfg['pfs_dir'].$u_newname);
						$sql = sed_query("INSERT INTO $db_pfs (pfs_userid, pfs_date, pfs_file, pfs_extension, pfs_folderid, pfs_desc, pfs_size, pfs_count) VALUES ('".$pff['pff_userid']."', '".$sys['now']."', '$u_sqlname', '$f_extension', '$folderid', '...', '$u_size', '0') ");
						$sql = sed_query("UPDATE $db_pfs_folders SET pff_updated='".$sys['now']."' WHERE pff_id='$folderid' " );

		 				$plugin_body .= "<li>File $f successfully imported.</li>";

						if ($cfg['th_amode']!='Disabled' && file_exists($cfg['pfs_dir'].$u_newname))
							{
							@unlink($cfg['th_dir'].$u_newname);

							$th_colortext = array(hexdec(substr($cfg['th_colortext'],0,2)), hexdec(substr($cfg['th_colortext'],2,2)), hexdec(substr($cfg['th_colortext'],4,2)));
							$th_colorbg = array(hexdec(substr($cfg['th_colorbg'],0,2)), hexdec(substr($cfg['th_colorbg'],2,2)), hexdec(substr($cfg['th_colorbg'],4,2)));

							if (in_array($f_extension, $gd_supported))
								{
								sed_createthumb($cfg['pfs_dir'].$u_newname, $cfg['th_dir'].$u_newname, $cfg['th_x'],$cfg['th_y'], $cfg['th_keepratio'], $f_extension, $pfs_file, $pfs_filesize, $th_colortext, $cfg['th_textsize'], $th_colorbg, $cfg['th_border'], $cfg['th_jpeg_quality']);
								}
							}
		 				}
				 	else
				 		{
				 		$plugin_body .= "<li>Failed to move the file $f into the folder /datas/users.</li>";
		 				}
					}
				else
					{
			 		$plugin_body .= "<li>Failed to move the file $f into the folder /datas/users, file already exists.</li>";
					}
				}
		  	else
		 		{
		 		$plugin_body .= "<li>Failed to import the file $f, extension was not allowed.</li>";
		 		}
			}
		}

	closedir($handle);

	$plugin_body .= "</ul>Done.";
	$plugin_body .= "<ul><li><a href=\"pfs.php?f=".$folderid."&amp;userid=".$pff['pff_userid']."\">Check this PFS folder</a></li>";
	$plugin_body .= "<li><a href=\"admin.php?m=plug&amp;p=gallery\">Upload a new set of files</a></li></ul>";


	break;


	default:

	$plugin_body .= "Searching in the folder datas/import for files to import...<ul>";
	$cnt = 0;

	$handle=opendir("datas/import");

	while ($f = readdir($handle))
		{
		if (($f != ".") && ($f != "..") && !is_dir($f))
			{
			$plugin_body .= "<li><a href=\"datas/import/".$f."\">".$f."</a></li>";
			$cnt++;
			}
		}
	closedir($handle);

	$plugin_body .= "</ul>";
	$plugin_body .= "Found $cnt files(s) ready to be imported.";

	if ($cnt>0)
		{

		$sql = sed_mysql_query(" SELECT DISTINCT u.user_id, u.user_name, f.*
			FROM $db_pfs_folders f
			LEFT JOIN $db_users u ON f.pff_userid=u.user_id
			ORDER BY u.user_name, f.pff_title");

		$selfolders =  "<select name=\"folderid\" size=\"1\">";

		while ($row = sed_fetch_array($sql))
			{
			$selfolders .= "<option value=\"".$row['pff_id']."\">".sed_cc($row['user_name'])." ".$cfg['separator']." ".sed_cc($row['pff_title'])."</option>";
			}

		$selfolders .= "</select>";

		$plugin_body .= "<form id=\"galimport\" action=\"admin.php?m=plug&amp;p=gallery&amp;a=import\" method=\"post\">";
		$plugin_body .= "Import all the files into the PFS folder : ".$selfolders." ";
		$plugin_body .= "<input type=\"submit\" class=\"submit\" value=\"".$L['Submit']."\" />";
		$plugin_body .= "</form>";
		}

	break;
	}



?>