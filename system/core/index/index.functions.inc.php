<?php 

/**

index.functions.inc.php
@03.08.2011
*/


defined('SED_CODE') or die('Wrong URL');
//require ("./datas/beallit.php");


/**
NIVO SLIDER
website: http://nivo.dev7studios.com/
*/



function nivo_slider() {

$slider_result = mysql_query("SELECT * FROM sed_slider ORDER BY sliderID DESC LIMIT 5");

	
		while( $row = mysql_fetch_array($slider_result) ) {
	
				$slider_mask .= "
				
				<a href=\"".$row['pageid']."\">
				<img src=\"".$row['url']."\" title=\"".$row['title']."\" width=\"$width\" alt=\"\" />
				</a>";
	
		}
	
return $slider_mask;
	

}


/**

VIDEO_THUMB


*/

function video_thmb()  {

$video_thmb_result = mysql_query("SELECT * FROM sed_pages WHERE page_state = 0 AND page_cat = 'videosarok' ORDER BY page_date DESC LIMIT 12");

	
		while( $row = mysql_fetch_array($video_thmb_result) ) {
	
				$thmb_mask .= "
				
				".$row['page_desc']."
				
				<a href=\"".$row['pageid']."\">
				<img src=\"".$row['url']."\" title=\"".$row['title']."\" width=\"$width\" alt=\"\" />
				</a>";
	
		}
	
return $thmb_mask;


}


/**

LATEST_ENTRY_IN_DB

*/



function latest_entry_in_db() {

$result = mysql_query("SELECT * FROM sed_pages WHERE page_state = 0  ORDER BY page_date DESC LIMIT 12");

	
		while( $row = mysql_fetch_array($result) ) {
		
		
		$img = $row['page_extra6'];
		
		
		$mask .= "
				
				
				<table>
					<tr>
					
						<td>
						
											
						<img class=\"img_news\" src=\"$img\" alt=\"picture\" width=\"60px\"  height=\"45px\" />
						
						</td>
						
						
						<td>
						
							<div stle=\"padding-left:8px;\">				
							<h5><a href=\"page.php?id=".$row['page_id']."\">".$row['page_title']."</a></h5>
							".substr($row['page_text'],0,80)."...
							</div>
							
							
						</td>
					
					</tr>
				
				</table>
				
			
				
				";
	
		}
	
return $mask;

}


/**

LATEST_NEWS

right now we dont use this function!


*/


function latest_news() {
	
$latest_news1 = sed_sql_query("SELECT * FROM sed_pages WHERE ( page_cat = 'news' AND page_state=0 ) ORDER by page_date DESC LIMIT 16");
	
	while( $row_new = mysql_fetch_array($latest_news1) ) {
	
	$mask_news_updates .= "
	

	<h5><a href=\"page.php?id=".$row_new['page_id']."\">".$row_new['page_title']."</a></h5>
	".substr($row_new['page_text'],0,120)."...
	";
	
	}
	
return $mask_news_updates;
	
}
	

/**

VIDEO OF THE WEEK

*/

function vow() {

$vow_result = mysql_query("SELECT * FROM sed_vow ORDER BY videoofweekID DESC LIMIT 1");

	while($row = mysql_fetch_array($vow_result)) {
	
	
		$vimeoid =	$row['vowvimeo'];
		$row['vow_link'];
	
			$mask_vow .= "
			
		<iframe src=\"http://player.vimeo.com/video/$vimeoid?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff\" width=\"580px\" height=\"320px\" frameborder=\"0\"></iframe>
			
			";
	
	}
	
return $mask_vow;
	
}



/* 

tets list

desc.

with a function i try to eliminate the separated function wich are have got the same functionalites around the site
with this function and global variables.

*/


function short_list($number_of_queries,$category) {

	$limit_races= $number_of_queries;
	$cat = $category;
	$races_result = sed_sql_query("SELECT * FROM sed_pages WHERE page_state=0 AND page_cat = '$cat' ORDER by page_date DESC LIMIT $limit_races");
	
	$szoveg = substr($row['page_text'],0,10);
	
	
		while( $row = mysql_fetch_array($races_result) )  {
	
		$res_mask .= "
		
		<h5><a href=\"page.php?id=".$row['page_id']."\">".$row['page_title']."</a></h5>
		".substr($row['page_text'],0,80)."...";
	
		}
		
		
return $res_mask;

}





	
	
/* 
Top News with big picture

 */
 
 
function kiemelt() { 

$topnews = mysql_query("SELECT page_id, page_title,page_text,page_id,page_extra6,page_cat,page_date FROM sed_pages WHERE ( page_cat = 'elektronika' OR page_cat = 'telekom' OR page_cat = 'games' OR page_cat = 'apple' OR page_cat = 'news' OR page_cat = 'articles'  AND page_state=0) ORDER BY page_id DESC  LIMIT 1  ");
	
	while( $row = mysql_fetch_array($topnews) ) {
	
	$row['page_title'];
	$row['page_text'];
	$row['page_id'];
	//echo  $row['page_extra6'];
	$row['page_cat'];
	
	

$news_mask .= "


<div align=\"center\">

	<div class=\"leading\" >

	<table>
	
	<tr>
	
	<td>
	
	
	<div id=\"index_latest_img_board\"><img  src=\"".$row['page_extra6']."\" width=\"300px\"  /></div>
	
	</td>
	
	<td>
	
	<div style=\"padding-left:12px;\">
		<div align=\"left\">
			<h9> <a href=\"page.php?id=".$row['page_id']."\">".$row['page_title']."</a></h9>
		</div>
	
	<div align=\"justify\"><h4>".substr($row['page_text'],0,250)."...</h4></div>
	
	
		<div id=\"index_latest_more\">
			<div align=\"right\"><h5>Beküldte: Kategória:".$row['page_cat']."<a href=\"page.php?id=".$row['page_id']."\">Tovább...</a></h5></div>
		</div>
	
	
	</td>
	
	</tr>
	
	</table>

			</div>
		</div>
	</div>
	
	";

}  //while end
	
	return $news_mask;

	}
	



?>