<?PHP

/**
logout.inc.php
*/

defined('SED_CODE') or die('Wrong URL.');
sed_check_xg();

/* === Hook === */

$extp = sed_getextplugins('users.logout');
if (is_array($extp)) { 

		foreach ($extp as $pl) { 
		
			include('plugins/'.$pl['pl_code'].'/'.$pl['pl_file'].'.php'); 
		} 
	}
	
/* ===== */

if ($cfg['authmode']==1 || $cfg['authmode']==3) {
	
		setcookie("SEDITIO", "", time()-63072000, $cfg['cookiepath'], $cfg['cookiedomain']);
	
	}

if ($cfg['authmode']==2 || $cfg['authmode']==3) {
	
		session_unset();
		session_destroy();
	
	}

if ($usr['id']>0) {
	
		$sql = sed_sql_query("DELETE FROM $db_online WHERE online_ip='".$usr['ip']."'");
		sed_redirect("message.php?msg=102");
	exit;
	
	}
	
	else {
	
		sed_redirect("message.php?msg=101");
		exit;
	
	}

?>
