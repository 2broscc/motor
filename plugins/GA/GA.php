<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/GA/GA.php
Version=120
Updated=2008-jun-19
Type=Plugin
Author=mooibly (Leo)
Description=Add Google Analytics to the website
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=GA
Part=Main
File=GA
Hooks=footer.tags
Tags=footer.tpl:{PLUGIN_GA}
Minlevel=0
Order=11
[END_SED_EXTPLUGIN]

==================== */

/*
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try{var pageTracker = _gat._getTracker("UA-xxxxxx-x");pageTracker._trackPageview();} catch(err) {}
</script>
*/

if (!defined('SED_CODE')) { die('Wrong URL.'); }


if ($cfg['plugin']['GA']['GA_Enable']=="Yes" && strlen($cfg['plugin']['GA']['GA_Code'])>0)
	{
	$GAcode = $cfg['plugin']['GA']['GA_Code'];

	$GA_js = "<script type=\"text/javascript\">\n";
	$GA_js .= "var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");\n";
	$GA_js .= "document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));\n";
	$GA_js .= "</script><script type=\"text/javascript\">\n";
	$GA_js .= "try{var pageTracker = _gat._getTracker(\"".$GAcode."\");pageTracker._trackPageview();} catch(err) {}\n";
	$GA_js .= "</script>";
	$t->assign("PLUGIN_GA", $GA_js);
	}

?>