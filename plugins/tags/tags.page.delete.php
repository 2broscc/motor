<?PHP
/* ====================
[BEGIN_SED_EXTPLUGIN]
Code=tags
Part=page.delete
File=tags.page.delete
Hooks=page.edit.delete.done
Tags=
Order=10
[END_SED_EXTPLUGIN]
==================== */


defined('SED_CODE') or die('Wrong URL');

if($cfg['plugin']['tags']['pages'] && sed_auth('plug', 'tags', 'W')) {
	
	sed_tag_remove_all($id);
}

?>