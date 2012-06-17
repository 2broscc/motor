<?PHP

/* ====================
Land Down Under - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/index/index.setup.php
Version=100+
Updated=19-Aug-2006
Type=Plugin
Author=Chris Tefra
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=index
Name=T3 File Indexor
Description=A simple file indexing with custom rules
Version=0.4
Author=Chris T.
Updated=19-Aug-2006
Copyright=http://www.T3-Design.com
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=12345
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
t3_index_title=01:string::T3 Indexor:Title of your indexor
t3_index_dir=02:string::folder/folder:The relative path where your files are no tralling  slash /
t3_index_exclude_folders=03:text::templates,ldb:Exclude folders, separate by commas (,)
t3_index_exclude_files=04:text::.htaccess,.htpasswd:Exclude files,separate by commas
t3_index_exclude_ext=05:text::php,php3,php4:Exclude file types,separate by commas
t3_index_leech_protection=6:radio::1:Enable leech protection (.htaccess)
[END_SED_EXTPLUGIN_CONFIG]
==================== */


if ( !defined('SED_CODE') ) { die("Wrong URL."); }

?>