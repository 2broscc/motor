<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/news/inc/functions.php
Version=1.5
Updated=19-Sep-2006
Type=Plugin.extended
Author=Chris T
Description=News Functions
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

function sed_default_pagination($totalitems, $perpage, $address, $pagenumber)
{
	if ($pagenumber>0)
		{
			$prev = $pagenumber - $perpage;
			if ($prev<0) { $prev = 0; }
			$prev = "<a href=\"".$address."&amp;d=$prev\">".$L['Previous']." $sed_img_left</a>"; 
		}

		if (($pagenumber + $perpage)<$totalitems)
		{
			$next = $pagenumber + $perpage;
			$next = "<a href=\"".$address."&amp;d=$next\">$sed_img_right ".$L['Next']."</a>"; 
		}

	$totalpages = ceil($totalitems / $perpage);
	$currentpage = $pagenumber / $perpage;

	for ($i = 0; $i < $totalpages; $i++)
		{
		$j = $i * $perpage;
		if ($i==$currentpage)
			{ 
			$pagination .= "&gt; <a href=\"".$address.$j."\">".($i+1)."</a> &lt; "; 
			}
		elseif (is_int(($i+1)/5) || $i<10 || $i+1==$totalpages)
			{ 
			$pagination .= "[<a href=\"".$address.$j."\">".($i+1)."</a>] "; 
			}
		}

	$pagnav = $prev;
	$pagnav .= $pagination;
	$pagnav .= $next;

	return $pagnav;
}



?>