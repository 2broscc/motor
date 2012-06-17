<?PHP

/* ====================
Land Down Under - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/index/index.php
Version=0.1
Updated=19-Aug-2006
Type=Plugin
Author=Chris T.
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=index
Part=main
File=index
Hooks=standalone
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$f = sed_import('f','G','TXT');
$main_dir = "./".$cfg['plugin']['index']['t3_index_dir'];
$title = sed_cc($cfg['plugin']['index']['t3_index_title']);

$no_folders = explode(",", $cfg['plugin']['index']['t3_index_exclude_folders']);
$no_files = explode(",", $cfg['plugin']['index']['t3_index_exclude_files']);
$no_ext = explode(",", $cfg['plugin']['index']['t3_index_exclude_ext']);


$condom = $main_dir."/.htaccess";
if($cfg['plugin']['index']['t3_index_leech_protection'])
{
	if(!file_exists($condom)){
		$file = @fopen($condom, 'w');
		if ($file) 
			{	
			$patterns = array("http://", "https://", "www.", "WWW.");	
			$site_url =	str_replace($patterns, "", $cfg['mainurl']);  
		
			$cofipr = "RewriteEngine on\n";
			$cofipr .= "RewriteCond %{HTTP_REFERER} !^http://(www\.)?".$site_url."/(/)?.*$ [NC]\n";
			$cofipr .= "RewriteRule .*\.*$  http://www.".$site_url."/plug.php?e=index [R,NC]\n";
			$cofipr .= "Options -Indexes";

			fwrite($file, $cofipr);
			fclose($file);
			$condom_status = $L['index_protection_ON'];
			}
			
		else{
				$condom_status = $L['index_protection_failed'];
			}
	}
	else
	{
		$condom_status = $L['index_protection_ON'];
	}

}
elseif(!$cfg['plugin']['index']['t3_index_leech_protection'])
{
	if(file_exists($condom)) unlink($condom);
	$condom_status = $L['index_protection_OFF'];
}

if(empty($f) || $f == $main_dir)
{
	$f = $main_dir;
}
else{

	if(is_dir($f)) 
		{
		$patterns = array(".", "/");
		$real = str_replace($patterns, "", $main_dir);
		$check = str_replace($patterns, "", $f);
		$re = strlen($real);
		if(substr($check, 0, $re)!= $real) $f = $main_dir; 
		if(substr($f,0,2) == ".." || substr($f,0,1) == "/" || $f == "./" || stristr($f, '../')) $f = $main_dir; 
		}
	
	else{	
		$f = $main_dir; 
		}
}


$title = "<a href=\"plug.php?e=index\">".$title."</a> ";
$title_parts = preg_replace ( '/\.\//', '', $f);
$title_parts = explode("/", $title_parts);

foreach ($title_parts as $value) {

	$link .= "/".$value;
	if(strcmp ( $main_dir, ".".$link ) < 0){
	$title .= $cfg['separator']." <a href=\"plug.php?e=index&f=.$link\">$value</a> ";
}
}

$t-> assign(array(
		"INDEX_TITLE" => $title,
		"INDEX_SUBTITLE" => $L['index_subtitle'],
		"LEECH_PROTECTION" => ($usr['isadmin']) ? $condom_status : '', 
	));


$files = array();
if (is_dir($f) && $handle = opendir($f)) {
   /* This is the correct way to loop over the directory. */
	while (false !== ($file = readdir($handle))) { 
		if ($file != '..' && $file != '.'){

			$filesize = filesize($f."/".$file);
			if 	($filesize > 1073741823) { $filesize = sprintf("%.1f",($filesize/1073741824))." GB"; }
			elseif 	($filesize > 1048575) { $filesize = sprintf("%.1f",($filesize/1048576))." MB"; }
			elseif 	($filesize > 1023) { $filesize = sprintf("%.1f",($filesize/1024))." kB"; }
			else { $filesize = $filesize." byte"; }
			$date = gmdate("d M Y H:i",filemtime($f."/".$file));
			
			$files[] = array(
					"name" => $file,
					"size" => $filesize,
					"date" => $date
				);	
		}
   }
   closedir($handle);
}
else
{
$error_string = $L['index_no_dir_or_no_access'];
}

if(empty($error_string)){
$dir_jj=0;
$file_ii=0;	
sort($files);
while ( list($key, $file) = each($files) ) {
		$dir =$f."/".$file['name'];
		if(is_dir($dir) && !in_array($file['name'],$no_folders)){
			$dir_jj++;
			$t-> assign(array(
				"DIR_ROW_NAME" => $file['name'],
				"DIR_ROW_ICON" => "<img src=\"skins/$skin/img/system/icon-folder.gif\" alt=\"\" />",
				"DIR_ROW_URL" => "plug.php?e=index&f=$dir",
				"DIR_ROW_LAST_MODIFIED" => $file['date'],
				"DIR_ROW_ODDEVEN" => sed_build_oddeven($dir_jj)
				));	
			$t->parse("MAIN.DIRS.ROW");
		}
		
		if(is_file($dir) && !in_array($file['name'], $no_files) && !in_array(strtolower(substr(strrchr($file['name'], '.'), 1)),$no_ext)){
			$file_ii++;
			$dotpos = strrpos($dir,".")+1;
			$file['icon'] = (strlen($dir)-$dotpos>4) ? '' : "system/img/pfs/".strtolower(substr($dir, $dotpos, 5)).".gif";
			$file['icon'] = (file_exists($file['icon'])) ? $file['icon'] : "system/img/pfs/unknown.png";
			$file['icon'] = "<img src=\"".$file['icon']."\" alt=\"\" />";

			/* T3 example
			$pat[0] = '/\./';
			$pat[1] = '/\-/';
			$part = explode("_", $file['name']);
			$part[0] = preg_replace ( $pat, ' ', $part[0]);
			$dot = strrpos( basename( $part[1] ), '.' );
			$part[1] = substr( basename( $part[1] ), 0, $dot );
			$part[1] = (empty($part[1])) ? $L['index_unkown_version'] : $L['index_file_version'].$part[1];
			*/
			
			$dot = strrpos( basename( $file['name'] ), '.' );
			$file['name'] = substr( basename( $file['name'] ), 0, $dot );
			$pat[0] = '/\./';
			$pat[1] = '/\-/';
			$pat[2] = '/\_/';
			$file['name'] = preg_replace ( $pat, ' ', $file['name']);

			$t-> assign(array(
				//"FILE_ROW_NAME" => $part[0],   T3 Example 
				//"FILE_ROW_VERSION" => $part[1],T3 Example 		
				"FILE_ROW_NAME" => $file['name'],
				"FILE_ROW_SIZE" => $file['size'],
				"FILE_ROW_ICON" => $file['icon'],
				"FILE_ROW_URL" => $dir,
				"FILE_ROW_LAST_MODIFIED" => $file['date'],
				"FILE_ROW_ODDEVEN" => sed_build_oddeven($file_ii)
				));	
			$t->parse("MAIN.FILES.ROW");
		}			
	}
	if($dir_jj>0) $t->parse("MAIN.DIRS");
	if($file_ii>0) $t->parse("MAIN.FILES");

	$t->assign("INDEX_FOLDER_STATS", sprintf($L['index_folder_stats'], $dir_jj, $file_ii));

}
else
{

$t->assign("ERROR_STRING", $error_string);
$t->parse("MAIN.ERROR");
}
?>