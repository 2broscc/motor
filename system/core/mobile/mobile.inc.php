<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=page.inc.php
Version=125
Updated=2010-feb-21
Type=Core
Author=Neocrome
Description=Pages
[END_SED]
==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }


//sed_header();
//sed_javascript();


echo '<head>
'.$cfg['metas'].'
<title>RidelineMTB - Mobile Edition (Aplha version)</title>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>';


//hirek
$cat = "news";
$limit = 5;
$sql = mysql_query("SELECT * FROM $db_pages WHERE page_cat = '$cat' ORDER BY page_date DESC LIMIT $limit ");
	
	while( $row = mysql_fetch_array($sql) ) 
	
	{
	
	$mask .= "
	<div style=\"padding-bottom:4px;\">
	<div id=\"imglight\">
	
	<div style=\"padding-top:5px;padding-bottom:5px;\"><div class=\"pressed\">Kategória:".$row['page_cat']." | Dátum: $date</div></div>
	
	<div>
	
	<img height=\"32\" width=\"32\" src=\"".$row['page_desc']."\" alt=\"img\"/> <a href=\"mobile.php?m=page&id=".$row['page_id']."\">".$row['page_title']."</a>
	
	</div>
	</div></div>
	";
	
	//echo $row['page_title'];
	//$row['page_id'];
	//	echo $row['page_text'];
	//echo $row['page_cat'];
	
$date =	$row['page_date'] = @date($cfg['dateformat'], $row['page_date'] + $usr['timezone'] * 3600);

	}
	
//videosarok	
$cat_vid = "videosarok";
$limit_vid = 5;
$sql_1 = mysql_query("SELECT * FROM $db_pages WHERE page_cat = '$cat_vid' ORDER BY page_date DESC LIMIT $limit_vid ");
	
	while( $row = mysql_fetch_array($sql_1) ) 
	
	{
	
	$mask_vid .= "
	
	<div style=\"padding-bottom:4px;\">
	<div id=\"imglight\">
	
	<div style=\"padding-top:5px;padding-bottom:5px;\">
	
	<div class=\"pressed\">Kategória:".$row['page_cat']."</div></div>
	<div>
	
	<img height=\"32\" width=\"32\" src=\"".$row['page_desc']."\" alt=\"img\"/> <a href=\"#\">".$row['page_title']."</a> - $date
	
	</div></div></div></div>";
	
	//echo $row['page_title'];
	//echo $row['page_id'];
	//echo $row['page_cat'];
	//echo $row['page_desc'];
	
$date =	$row['page_date'] = @date($cfg['dateformat'], $row['page_date'] + $usr['timezone'] * 3600);

	}
	

	
print "<div style=\"padding-bottom:5px;\"><div id=\"imgdark\">Menu:</div></div>";

print "$mask<br><hr>";
print "$mask_vid";

print "<div id=\"imgdark\">Mobile Version of RidelineMTB - Alpha ver. ".$cfg['version']."</div>";


?>