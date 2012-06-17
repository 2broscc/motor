<?php

/**
beta
loader.inc.php
*/


defined('SED_CODE') or die('Wrong URL');
@header('Content-Type: text/html; charset=ISO-8859-15');


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
				</table>";
		}
	
	return $mask;
}



//using this stuff @ dailystuff

function latest_entry_in_db_all() {

	$result = mysql_query("SELECT * FROM sed_pages WHERE page_state = 0  ORDER BY page_date DESC LIMIT 12");

	
		while( $row = mysql_fetch_array($result) ) {
			$img = $row['page_extra6'];
			
		/**type of the page*/	
		//echo	$type = $row['page_type'];
			
			//template of sed_parse
			//sed_parse($text, $parse_bbcodes=TRUE, $parse_smilies=TRUE, $parse_newlines=TRUE)
			
			//template of sed_bbcode
			//sed_bbcode($text) 
			
			
		/**switching between html and bbcode, default is the bbcode where page_type == 0*/
		
		switch($row['page_type'])  	{
	
		case '1':
		$news = $row['page_text'];
		break;

		default:
		$news = sed_parse(sed_bbcode(sed_cc($row['page_text'])), $cfg['parsebbcodepages'], $cfg['parsesmiliespages'], 1);
		break;
	}
			
			//$news = sed_bbcode($row['page_text'],1);
			
			$mask .= "
			
			<div style=\"padding-top:4px;padding-bottom:4px;\">
			<div align=\"justify\">
			<h3><a href=\"page.php?id=".$row['page_id']."\">".$row['page_title']."</a></h3>
					
			<br>
			<p>".$news."</p>
			
			<div id=\"pages\">
			

</div>
</div>
			
			
			
			</div>
			</div>

			";
		}
	
	return $mask;
}



//print latest_entry_in_db();

print latest_entry_in_db_all();
?>