<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/sedplus/lang/sedplus.functions.php
Version=1.06
Updated=2007-Jun-24
Type=
Author=Tefra
Description=Functions
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$path_lang_def	= "plugins/sedplus/lang/sedplus.en.lang.php";
$path_lang_alt	= "plugins/sedplus/lang/sedplus.$lang.lang.php";
if (file_exists($path_lang_alt))
{ require($path_lang_alt); }
elseif (file_exists($path_lang_def))
{ require($path_lang_def); }


if(!function_exists("sed_build_www")) {
	function sed_build_www($url)
	{
		global $cfg;
		if (!empty($url))
		{
			if (!eregi('http://', $url))
			{ $url='http://'. $url; }
			$url = sed_cc($url);
		}	
		return($url);
	}
}

if(!function_exists("t3_build_sed_pagnav")) {
	function t3_build_sed_pagnav($totalitems, $perpage, $address, $pagenumber)
	{
		global $L, $cfg;
		$each_side = $cfg['plugin']['sedplus']['linksperside'];
		if ($totalitems <= $perpage) return;
		if ($pagenumber > 0)
		{
			$prev = $pagenumber - $perpage;
			if ($prev < 0) { $prev = 0; }
			$prev = "<span class=\"pagenav_prev\"><a href=\"".$address.$prev."\">".$L['t3_pagnav_prev']."</a></span>";
		}

		if (($pagenumber + $perpage) < $totalitems)
		{
			$next = $pagenumber + $perpage;
			$next = "<span class=\"pagenav_next\">&nbsp;<a href=\"".$address.$next."\">".$L['t3_pagnav_next']."</a></span>";
		}

		$totalpages = ceil($totalitems / $perpage);
		$currentpage = $pagenumber / $perpage;
	
		if(($each_side * 2) >= $totalpages)
		{
			for ($k = 0; $k < $totalpages; $k++)
			{	$l = $k * $perpage;
				if ($k==$currentpage)
				{ $pages .= "<span class=\"pagenav_current\">".($k+1)."</span>"; }
				else
				{ $pages .= "<span class=\"pagenav_pages\"><a href=\"".$address.$l."\">".($k+1)."</a></span>"; }
			}
		}
		else
		{
			if ($currentpage > $each_side) 
			{
				$first = "<span class=\"pagenav_first\"><a href=\"".$address."0\">".$L['t3_pagnav_first']."</a></span>";
			}
		 	if ($currentpage < $totalpages-$each_side) 
		 	{	
				$last = ($totalpages-1)*$perpage;
				$last = "<span class=\"pagenav_last\"><a href=\"".$address."$last\">".$L['t3_pagnav_last']."</a></span>";
			}
				
			$start = $currentpage - $each_side;
			if($start < 1) $start = 0;
			$end = $currentpage + $each_side + 1;
			if($end > $totalpages) $end = $totalpages;
			
			for($k = $start; $k < $end; $k++)
			{
				$l = $k * $perpage;
				if ($k==$currentpage)
				{ $pages .= "<span class=\"pagenav_current\">".($k+1)."</span>"; }
				else
				{ $pages .= "<span class=\"pagenav_pages\"><a href=\"".$address.$l."\">".($k+1)."</a></span>"; }
			}
		}
		$pagnav = "<span class=\"pagenav_pages\">".sprintf($L['t3_page_of'], $currentpage+1, $totalpages)."</span>";
		$pagnav .= $first;
		$pagnav .= $prev;
		$pagnav .= $pages;
		$pagnav .= $next;
		$pagnav .= $last;
		return($pagnav);
	}
}
?>