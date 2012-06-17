<?php

/**
test

loader.inc.php

*/

/**

LATEST_ENTRY_IN_DB

*/

defined('SED_CODE') or die('Wrong URL');

require("system/h_loader.php");

function latest_entry_in_db() {

$result = mysql_query("SELECT * FROM sed_pages WHERE page_state = 0  ORDER BY page_date DESC LIMIT 18");

	
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


print latest_entry_in_db();

//require("system/footer.php");

?>