<?php
/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/patcher/patcher.admin.php
Version=121
Updated=2007-jul-13
Type=Plugin
Author=Trustmaster
Description=Seditio code patcher
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=patcher
Part=admin
File=patcher.admin
Hooks=tools
Tags=
Order=10
[END_SED_EXTPLUGIN]

==================== */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

$plugin_title = 'Seditio Code Patcher';

$step = sed_import('step', 'P', 'INT');
$find = sed_import('find', 'P', 'TXT');
$repl = sed_import('repl', 'P', 'TXT');
$flst = sed_import('files', 'P', 'ARR');
$chk = sed_import('chk', 'P', 'ARR');

$file_cnt = 0;

// OS support
if(strpos(__FILE__, '\\') !== false)
	define('SEP', '\\');
else
	define('SEP', '/');

// Worker scan functions
function scan_dir($dir)
{
	$count = 0;
	$dp = opendir($dir);
	while($fn = readdir($dp))
	{
		if(is_dir($dir.SEP.$fn) && $fn[0] != '.')
			$count += scan_dir($dir.SEP.$fn);
		elseif(stripos($fn, '.php') == strlen($fn) - 4)
			$count += scan_file($dir.SEP.$fn);
	}
	closedir($dp);
	return $count;
}

function scan_file($file)
{
	global $plugin_body, $file_cnt, $find;
	$first = true;
	// We do not allow multiline scan, becuse it's very consuming
	$rw = is_writable($file) && is_writable(dirname($file)) ? '<span style="font-weight:bold;color:#00ff00;">Yes</span>' : '<span style="font-weight:bold;color:#ff0000;">No</span>';
	$fp = fopen($file, 'r');
	$line = 0;
	$count = 0;
	while($s = fgets($fp, 2048))
	{
		$line++;
		if(preg_match_all($find, $s, $matches, PREG_SET_ORDER))
		{
			for($i = 0; $i < count($matches); $i++)
			{
				if($first)
				{
					$plugin_body .= '<tr><td><input type="checkbox" name="chk['.$file_cnt.']" checked="checked" /><input type="hidden" name="files['.$file_cnt.']" value="'.$file.'" /></td>
					<td>'.$file.'</td><td>'.$line.'</td><td>'.sed_cc($matches[$i][0]).'</td><td>'.$rw.'</td></tr>';
					$file_cnt++;
					$first = false;
				}
				else
				$plugin_body .= '<tr><td>&nbsp;</td><td>'.$file.'</td><td>'.$line.'</td><td>'.sed_cc($matches[$i][0]).'</td><td>'.$rw.'</td></tr>';
			}
			$count += count($matches);
		}
	}
	fclose($fp);
	return $count;
}

// Worker patch function
function patch()
{
	global $plugin_body, $flst, $chk, $find, $repl;
	for($i = 0; $i < count($flst); $i++)
	{
		if(is_writeable($flst[$i]) && is_writable(dirname($flst[$i])) && $chk[$i] == true)
		{
			$fs = fopen($flst[$i], 'r');
			$fd = fopen($flst[$i].'.pth', 'w');
			while($s = fgets($fs, 2048))
				fputs($fd, preg_replace($find, $repl, $s));
			fclose($fd);
			fclose($fs);
			unlink($flst[$i]);
			rename($flst[$i].'.pth', $flst[$i]);
			$plugin_body .= '<tr><td>'.$flst[$i].'</td><td><span style="font-weight:bold;color:#00ff00;">OK</span></td></tr>';
		}
		elseif($chk[$i] == false)
			$plugin_body .= '<tr><td>'.$flst[$i].'</td><td><span style="font-weight:bold;color:#0000ff;">Skipped</span></td></tr>';
		else
			$plugin_body .= '<tr><td>'.$flst[$i].'</td><td><span style="font-weight:bold;color:#ff0000;">Error</span></td></tr>';
	}
}

// Before we start...
function patcher_start()
{
	global $plugin_body;
	$plugin_body = '<h4>Welcome to the Seditio Patcher tool</h4>';
	$plugin_body .= '<p>This tool will help you to change some text in your Seditio source tree by invoking a Perl-compatible regular expression. Use it carefully and do not run any untrusted expressions because it may cause damage to your Seditio installation.</p>';
	$plugin_body .= '<p>At the first step it will scan the source tree for the search expression and give you the list of files that are about to be patched and whether they are ready for patching or not. Please make sure you have made all the requested files writable before proceeding to the next step. Use checkboxes to uncheck the files you do not want to patch.</p>';
	$plugin_body .= '<p>At the second step it will apply the patch and modify the source files. No rollback available, so you should better backup before entering this step.</p>';
	$plugin_body .= '<p>If you are new to PCRE, please read <a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank">Pattern Syntax</a>, <a href="http://www.php.net/manual/en/reference.pcre.pattern.modifiers.php" target="_blank">Pattern Modifiers</a> and <a href="http://www.php.net/manual/en/function.preg-replace.php" target="_blank">preg_replace</a>.';
	$plugin_body .= '<form id="patch" action="admin.php?m=tools&p=patcher" method="post"><input type="hidden" name="step" value="1" />';
	$plugin_body .= '<label>Find: </label><input type="text" name="find" /> <em>example: #foo(\w+)#i</em><br /><label>Replace: </label><input type="text" name="repl" /> <em>example: bar\$1</em><br />';
	$plugin_body .= '<input type="submit" value="Scan" /></form><br />';
}

// Scans the Seditio source for files that need patching
function patcher_scan()
{
	global $plugin_body, $flst, $find, $repl;
	$plugin_body = '<h4>Source scan results:</h4>';
	$plugin_body .= '<form id="patch" action="admin.php?m=tools&p=patcher" method="post">';
	$plugin_body .= '<table class="cells"><tr><td colspan="2" class="coltop">File</td><td class="coltop">Line</td><td class="coltop">String</td><td class="coltop">Writable</td></tr>';
	$count = scan_dir(dirname($_SERVER['SCRIPT_FILENAME']));
	$plugin_body .= '<tr><td colspan="5"><strong>Total: </strong>'.$count.' matches in '.$file_cnt.' files.</td></tr>';
	$plugin_body .= '</table><p>Please make all the files writable and back them up before proceeding to the next step!</p>';
	$plugin_body .= '<input type="hidden" name="find" value="'.$find.'" /><input type="hidden" name="repl" value="'.$repl.'" />';
	$plugin_body .= '<input type="hidden" name="step" value="2" /><input type="submit" value="Patch!" /></form>';
	$plugin_body .= '<a href="admin.php?m=tools&p=patcher">Back</a><br /><br />';
}

// Rescans the files and patches them
function patcher_patch()
{
	global $plugin_body;
	$plugin_body = '<h4>Patching results:</h4>';
	$plugin_body .= '<table class="cells"><tr><td class="coltop">File</td><td class="coltop">Result</td></tr>';
	patch();
	$plugin_body .= '</table>';
	$plugin_body .= '<a href="admin.php?m=tools&p=patcher">Tool Main</a><br />';
}

switch($step)
{
	case 1:
		patcher_scan();
		break;
	case 2:
		patcher_patch();
		break;
	default:
		patcher_start();
}

?>