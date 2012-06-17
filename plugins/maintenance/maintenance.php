<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/maintenance/maintenance.php
Version=1.0
Updated=2006-apr-19
Type=Plugin
Author=riptide
Description=Plugin based on riptide's ldu forcepage
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=maintenance
Part=global
File=maintenance
Hooks=global
Minlevel=0
Order=10
Tags=
[END_SED_EXTPLUGIN]

==================== */

if ( !defined('SED_CODE') ) { die('Wrong URL.'); }

$administrate  = sed_auth('plug', 'maintenance', 'A');

if ($cfg['plugin']['maintenance']['status'] == "Yes" && $cfg['plugin']['maintenance']['userauth'] == "Yes")
		{
if ($administrate)
{
}
else
   {
	if (strpos($_SERVER['PHP_SELF'], "users.php") != 0 && $_GET['m'] == "auth") { /* do nothing */ }
	    elseif (strpos($_SERVER['PHP_SELF'], "users.php?m=auth") == 0)
    	{
    	header("Location: users.php?m=auth");
    	exit;
    	}
   }

		}

if ($cfg['plugin']['maintenance']['status'] == "Yes" && $cfg['plugin']['maintenance']['standalone'] == "Yes")
		{
if ($administrate)
{
}
else
   {
	if (strpos($_SERVER['PHP_SELF'], "users.php") != 0 && $_GET['m'] == "auth") { /* do nothing */ }
    		elseif (strpos($_SERVER['PHP_SELF'], $cfg['plugin']['maintenance']['page']) == 0)
    	{
    	header("Location: ".$cfg['plugin']['maintenance']['page']);
    	exit;
    	}
   }

		}

?>