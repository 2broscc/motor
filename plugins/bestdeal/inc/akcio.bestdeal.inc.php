<?php
include("kiemelt.php");

/* Template stuff */	
$path_plugin_path	= "plugins/bestdeal/tpl_files/bestdeal.akcio.tpl";
$path_skin_path	= "skins/$skin/extplugin.bestdeal.akcio.tpl";	
		
if (file_exists($path_plugin_path))	{
			
			$path_skin= $path_plugin_path;
		}
	elseif (file_exists($path_skin_path)) {
			$path_skin = $path_skin_path;
		}
		else {
			header("Location: message.php?msg=907");
			exit;
		}	
		
$res_limit = 1;		
$result = mysql_query("SELECT * FROM $db_akciok ORDER BY akciokID DESC LIMIT ".$cfg['bestdeal_akciok_limit']." ");
	
	while ( $row = mysql_fetch_array($result)) {
	
	$akciok_mask .= "
		<div>
			<div><h4>".$row['title']."</h4></div>
			<div>".$row['content']."</div>
			<div><a href=\"".$row['url']."\" target=\"_blank\"\">".$row['url']."</a></div>
		</div>
		<br>
	";
	
	}	
		
$t = new XTemplate($path_skin);
	
$t->assign(array(
	
	"AKCIOK_MASK" => $akciok_mask,
	"INDEX_AD7" => $index_ad_7,
	"INDEX_AD6" => $index_ad_6,
	//"INDEX_AKCIOK" =>$bestdeal_akciok,
	"INDEX_INFO_CATS" => $index_info_cats,
	"INDEX_INFO_USERPANEL" => userpanel($usr['id']),
	"INDEX_INFO_SEARCH" => $search,
	"INDEX_INFO_CATONISER" => bestdeal_cat_o_niser('url','jumpbox',0,0),
	));
	

	
?>
