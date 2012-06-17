<? 
/*sql query in seditio
created by peter @ 2bros creative consultant
date:20-02-2010
email:magyar.peter1@gmail.com
updated:
*/


global $L, $db_pages, $usr, $cfg, $sed_cat, $plu_empty;

//used variables

$order = "DESC";
$limit	= 1;
$cat = "news";
//the sql query
$sql = sed_sql_query("SELECT page_id, page_alias, page_text, page_cat, page_desc, page_title, page_date FROM $db_pages WHERE page_state=0 AND page_cat = '$cat' ORDER by page_date $order LIMIT $limit");

while ($row = sed_sql_fetcharray($sql)) 

		{
		
		$mask = $row['page_desc'];
			
			
		}


?>