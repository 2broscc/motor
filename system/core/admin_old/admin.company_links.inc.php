<?PHP

/*Header notice add form*/

if ( !defined('SED_CODE') || !defined('SED_ADMIN') ) { die('Wrong URL.'); }

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = sed_auth('admin', 'a');
sed_block($usr['isadmin']);

$adminpath[] = array ("admin.php?m=copmany_links", $L['RidlineMTB']);


$notice = mysql_query("SELECT * FROM $db_notice");

	while($row = mysql_fetch_array($notice)) {
	
		$n_status =	$row['notice_status'];
		$n_text =	$row['notice_text'];
		$n_title = $row['notice_title'];
		$n_date = $row['notice_date'];
			
	}


$p = sed_import('p','G','ALP');


//company links body

$adminmain .="<br>Company links<br>";
$adminmain .="<form action=\"queries/company_links_insert.php\" method=\"post\">
Kategória:<input type=\"text\" value=\"\" name=\"cl_cat\" /><br>
Cím:<input type=\"text\" value=\"\" name=\"cl_title\" /><br>
URL:<input type=\"text\" value=\"\" name=\"cl_text\" /><br>
<input type=\"submit\" />
</form>";

$adminmain .= "<br>";
?>
