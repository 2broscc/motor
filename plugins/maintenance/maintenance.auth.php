<?PHP


/* ====================

Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=plugins/maintenance/maintenance.auth.php
Version=1.0
Updated=2006-apr-19
Type=Plugin
Author=riptide
Description=Plugin based on riptide's ldu forcepage
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=maintenance
Part=users.auth
File=maintenance.auth
Hooks=users.auth.tags
Order=10
Tags=users.auth.tpl:{MAINTENANCE}
[END_SED_EXTPLUGIN]


==================== */


if ( !defined('SED_CODE')) { die('Wrong URL.'); }

if ($cfg['plugin']['maintenance']['status'] == "Yes")
{
   $t-> assign(array(
   		"MAINTENANCE" => $cfg['plugin']['maintenance']['reason'],
      		));
}


?>