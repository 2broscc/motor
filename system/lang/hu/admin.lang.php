<?php

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
-----------------------
Seditio language pack
Language : Hungarian (code:hu)
Localization done by : ?
-----------------------
[BEGIN_SED]
File=system/core/admin/lang/hu/admin.lang.php
Version=100
Updated=2006-jan-01
Type=Lang
Author=Neocrome
Description=Admin panel
[END_SED]
==================== */

/* ====== Core ====== */

$L['core_main'] = "F� be�ll�t�sok";
$L['core_time'] = "Id� �s d�tum";
$L['core_skin'] = "Skinek/Fel�letek";
$L['core_lang'] = "Nyelvek";
$L['core_menus'] = "Men�k";
$L['core_comments'] = "Hozz�sz�l�sok";
$L['core_forums'] = "F�rumok";
$L['core_page'] = "Oldalak";
$L['core_pfs'] = "Saj�t f�jlok";
$L['core_plug'] = "Bov�tm�nyek";
$L['core_pm'] = "Priv�t �zenetek";
$L['core_polls'] = "Szavaz�sok";
$L['core_ratings'] = "�rt�kel�sek";
$L['core_users'] = "Felhaszn�l�k";

/* ====== General ====== */

$L['editdeleteentries'] = "Elemek szerkeszt�se vagy t�rl�se";
$L['viewdeleteentries'] = "Elemek megtekint�se vagy t�rl�se";
$L['addnewentry'] = "�j elem";
$L['adm_purgeall'] = "Teljes �r�t�s";
$L['adm_listisempty'] = "A lista �res";
$L['adm_totalsize'] = "M�ret �sszesen";
$L['adm_showall'] = "Teljes megjelen�t�s";
$L['adm_area'] = "Ter�let";
$L['adm_option'] = "Opci�";
$L['adm_setby'] = "Be�ll�totta";
$L['adm_more'] = "Tov�bbi eszk�z�k...";
$L['adm_from'] = "Mett�l";
$L['adm_to'] = "Meddig";
$L['adm_confirm'] = "Meger�s�t�s�l k�rj�k, kattintson az al�bbi gombra: ";
$L['adm_done'] = "Rendben";
$L['adm_failed'] = "Nem siker�lt";
$L['adm_warnings'] = "Figyelmeztet�s";
$L['adm_valqueue'] = "J�v�hagy�sra v�r";
$L['adm_required'] = "(Hi�nyzik)";
$L['adm_clicktoedit'] = "(Szerkeszt�shez kattints ide)";

/* ====== Banlist ====== */

$L['adm_ipmask'] = "IP maszk";
$L['adm_emailmask'] = "Email minta";
$L['adm_neverexpire'] = "�r�kre";
$L['adm_help_banlist'] = "P�ld�k IP maszkokra: 194.31.13.41 , 194.31.13.* , 194.31.*.* , 194.*.*.*<br />P�ld�k email mint�kra: @hotmail.com, @yahoo (Joker karakterek nem szerepelhetnek benne.)<br />Egy bejegyz�s egyetlen IP maszkot vagy egyetlen email mint�t vagy mindkett�t tartalmazhatja.<br />Az IP sz�r�s minden egyes megjelen�tett oldalra vonatkozik, m�g az email minta csak a felhaszn�l�k regisztr�ci�j�ra.";

/* ====== Cache ====== */

$L['adm_internalcache'] = "Bels� cache";
$L['adm_help_cache'] = "Nem �ll rendelkez�sre";

/* ====== Configuration ====== */

$L['adm_help_config']= "Nem el�rheto";
$L['cfg_adminemail'] = array("Rendszergazda email c�me", "K�telez�");
$L['cfg_maintitle'] = array("Honlap c�me", "A honlap c�me (azaz megnevez�se), k�telez�");
$L['cfg_subtitle'] = array("Le�r�s", "Nem k�telez�, a honlap c�me ut�n jelenik meg");
$L['cfg_mainurl'] = array("A honlap URL-je", "Kezdete http://, a v�g�n ne legyen /!");
$L['cfg_hostip'] = array("Szerver IP", "A kiszolg�l� IP c�me, nem k�telez�."); 	// New in v800
$L['cfg_gzip'] = array("Gzip", "A HTML kimenet Gzip t�m�r�t�se"); 	// New in v800
$L['cfg_cache'] = array("Bels� cache", "A jobb teljes�tm�ny �rdek�ben �rdemes enged�lyezni"); 	// New in v800
$L['cfg_devmode'] = array("Hibakeres� �zemm�d", "�les �zemben nem szabad enged�lyezni"); 	// New in v800
$L['cfg_doctypeid'] = array("Dokument T�pus", "&lt;!DOCTYPE> of the HTML layout");
$L['cfg_charset'] = array("HTML charset", "");
$L['cfg_cookiedomain'] = array("Domain for cookies", "Alap�rtelmezett: �res");
$L['cfg_cookiepath'] = array("Path for cookies", "Default: empty");
$L['cfg_cookielifetime'] = array("Maximum cookie �lettartam", "M�sodpercben");
$L['cfg_metakeywords'] = array("HTML Meta keywords (comma separated)", "Search engines");
$L['cfg_disablesysinfos'] = array("Az oldal elo�ll�t�si idej�nek kikapcsol�sa", "footer.tpl f�jlban");
$L['cfg_keepcrbottom'] = array("Keep the copyright notice in the tag {FOOTER_BOTTOMLINE}", "In footer.tpl");
$L['cfg_showsqlstats'] = array("Show SQL queries statistics", "In footer.tpl");
$L['cfg_shieldenabled'] = array("Enable the Shield", "Anti-spamming and anti-hammering");
$L['cfg_shieldtadjust'] = array("Adjust Shield timers (in %)", "The higher, the harder to spam");
$L['cfg_shieldzhammer'] = array("Anti-hammer after * fast hits", "The smaller, the faster the auto-ban 3 minutes happens");
$L['cfg_dateformat'] = array("Main date mask", "Default: Y-m-d H:i");
$L['cfg_formatmonthday'] = array("Short date mask", "Default: m-d");
$L['cfg_formatyearmonthday'] = array("Medium date mask", "Default: Y-m-d");
$L['cfg_formatmonthdayhourmin'] = array("Forum date mask", "Default: m-d H:i");
$L['cfg_servertimezone'] = array("Server time zone", "Offset of the server from the GMT+00");
$L['cfg_defaulttimezone'] = array("Default time zone", "For guests and new members, from -12 to +12");
$L['cfg_timedout'] = array("Idle delay, in seconds", "After this delay, user is away");
$L['cfg_maxusersperpage'] = array("Maximum lines in userlist", "");
$L['cfg_regrequireadmin'] = array("Administrators must validate new accounts", "");
$L['cfg_regnoactivation'] = array("Skip email check for new users", "\"No\"recommended, for security reasons");
$L['cfg_useremailchange'] = array("Allow users to change their email address", "\"No\" recommended, for security reasons");
$L['cfg_usertextimg'] = array("Allow images and HTML in user signature", "\"No\" recommended, for security reasons");
$L['cfg_av_maxsize'] = array("Avatar, maximum f�jlm�ret", "Alap�rtelmezett: 8000 b�jt");
$L['cfg_av_maxx'] = array("Avatar, maximum sz�less�g", "Alap�rtelmezett: 64 pixel");
$L['cfg_av_maxy'] = array("Avatar, maximum magass�g", "Alap�rtelmezett: 64 pixel");
$L['cfg_usertextmax'] = array("Al��r�s maxim�lis hossz�s�ga", "Alap�rtelmezett: 300 karakter");
$L['cfg_sig_maxsize'] = array("Al��r�s, maximum f�jlm�ret", "Alap�rtelmezett: 50000 b�jt");
$L['cfg_sig_maxx'] = array("Signature, maximum sz�less�g", "Alap�rtelmezett: 468 pixel");
$L['cfg_sig_maxy'] = array("Signature, maximum magass�g", "Alap�rtelmezett: 60 pixel");
$L['cfg_ph_maxsize'] = array("Fot�, maximum f�jlm�ret", "Alap�rtelmezett: 8000 b�jt");
$L['cfg_ph_maxx'] = array("Fot�, maximum sz�less�g", "Alap�rtelmezett: 96 pixel");
$L['cfg_ph_maxy'] = array("Fot�, maximum magass�g", "Alap�rtelmezett: 96 pixel");
$L['cfg_maxrowsperpage'] = array("Maximum sorok a list�ban", "");
$L['cfg_countcomments'] = array("Count comments", "Display the count of comments near the icon");
$L['cfg_hideprivateforums'] = array("Priv�t f�rumok elrejt�se", "");
$L['cfg_hottopictrigger'] = array("H�ny hozz�sz�l�s kell ahhoz, hogy egy t�ma 'forr�' legyen", "");
$L['cfg_maxtopicsperpage'] = array("T�m�k vagy hozz�sz�l�sok max. sz�ma oldalank�nt", "");
$L['cfg_antibumpforums'] = array("T�lterhel�s-v�delem", "Megakad�lyozza, hogy a felhaszn�l�k egym�s ut�n k�tszer sz�ljanak hozz� ugyanahhoz a t�m�hoz"); // New in v800
$L['cfg_pfsuserfolder'] = array("Folder storage mode", "If enabled, will store the user files in subfolders /datas/users/USERID/... instead of prepending the USERID to the filename. Must be set at the FIRST setup of the site ONLY. As soon as a file is uploaded to any PFS, it's too late to change this");
$L['cfg_th_amode'] = array("Thumbnails generation", "");
$L['cfg_th_x'] = array("Minik�p, sz�less�g", "Alap�rtelmez�sben: 112 pixel");
$L['cfg_th_y'] = array("Minik�p, magass�g", "Alap�rtelmez�sben: 84 pixel, aj�nlott : sz�less�g x 0.75");
$L['cfg_th_border'] = array("Minik�p, szeg�ly vastags�ga", "Alap�rtelmez�sben: 4 pixel");
$L['cfg_th_keepratio'] = array("Minik�p, ar�nyok megtart�sa?", "");
$L['cfg_th_jpeg_quality'] = array("Minik�p, JPEG min�s�g", "Alap�rtelmez�sben: 85");
$L['cfg_th_colorbg'] = array("Minik�p, szeg�ly sz�ne", "Alap�rtelmez�sben: 000000, hex sz�nk�d");
$L['cfg_th_colortext'] = array("Minik�p, sz�veg sz�ne", "Alap�rtelmez�sben: FFFFFF, hex sz�nk�d");
$L['cfg_th_textsize'] = array("Minik�p, sz�veg m�rete", "");
$L['cfg_pm_maxsize'] = array("�zenetek maxim�lis hossza", "Alap�rtelmez�sben: 10000 karakter");
$L['cfg_pm_allownotifications'] = array("Szem�lyes �zenetekr�l �rtes�t�s emailben", "");
$L['cfg_disablehitstats'] = array("L�togat�si statisztik�k kikapcsol�sa", "HTTP Referers �s tal�latok naponta");
$L['cfg_disablereg'] = array("A regisztr�ci�s folyamat kikapcsol�sa", "A felhaszn�l�k nem hozhatnak l�tre �j felhaszn�l�i fi�kokat");
$L['cfg_disablewhosonline'] = array("A 'Jelenleg online' kikapcsol�sa", "Az LDU pajzs bekapcsol�sakor automatikusan ez is bekapcsol");
$L['cfg_keepoldpms'] = array("R�gebbi szem�lyes �zenetek mag�rz�se az adatb�zisban", "Ha 'igen', a t�r�lt szem�lyes �zenetek megmaradnak az adatb�zisban");
$L['cfg_allowphp_pages'] = array("PHP t�pus� oldal enged�lyez�se", "PHP k�d v�grehajt�sa az oldalakon. Haszn�lata k�r�ltekint�st ig�nyel!");
$L['cfg_parsebbcodecom'] = array("BBcode feldolgoz�sa megjegyz�sekben �s szem�lyes �zenetekben", "");
$L['cfg_parsebbcodepages'] = array("BBcode feldolgoz�sa az oldalakon", "");
$L['cfg_parsebbcodeusertext'] = array("BBcode feldolgoz�sa a felhaszn�l�i al��r�sban", "");
$L['cfg_parsebbcodeforums'] = array("BBcode feldolgoz�sa a f�rumban", "");
$L['cfg_parsesmiliescom'] = array("Smilies feldolgoz�sa megjegyz�sekben �s szem�lyes �zenetekben", "");
$L['cfg_parsesmiliespages'] = array("Smilies feldolgoz�sa az oldalakon", "");
$L['cfg_parsesmiliesusertext'] = array("Smilies feldolgoz�sa a felhaszn�l�i al��r�sban", "");
$L['cfg_parsesmiliesforums'] = array("Smilies feldolgoz�sa a f�rumban", "");
$L['cfg_forcedefaultskin'] = array("Az alap�rtelmezett felsz�n k�telez� minden felhaszn�l� sz�m�ra", "");
$L['cfg_forcedefaultlang'] = array("Az alap�rtelmezett nyelv k�telez� minden felhaszn�l� sz�m�ra", "");
$L['cfg_separator'] = array("�ltal�nos c�l� elv�laszt�", "Alap�rtelmez�sben: >");
$L['cfg_newwindows'] = array("K�ls� URL megnyit�sa �j ablakban", "");
$L['cfg_menu1'] = array("Men�hely #1<br />{PHP.cgf.menu1} minden tpl f�jlban", "");
$L['cfg_menu2'] = array("Men�hely #2<br />{PHP.cgf.menu2} minden tpl f�jlban", "");
$L['cfg_menu3'] = array("Men�hely #3<br />{PHP.cgf.menu3}minden tpl f�jlban", "");
$L['cfg_menu4'] = array("Men�hely #4<br />{PHP.cgf.menu4} minden tpl f�jlban", "");
$L['cfg_menu5'] = array("Men�hely #5<br />{PHP.cgf.menu5} minden tpl f�jlban", "");
$L['cfg_menu6'] = array("Men�hely #6<br />{PHP.cgf.menu6} minden tpl f�jlban", "");
$L['cfg_menu7'] = array("Men�hely #7<br />{PHP.cgf.menu7} minden tpl f�jlban", "");
$L['cfg_menu8'] = array("Men�hely #8<br />{PHP.cgf.menu8} minden tpl f�jlban", "");
$L['cfg_menu9'] = array("Men�hely #9<br />{PHP.cgf.menu9} minden tpl f�jlban", "");
$L['cfg_topline'] = array("Fels� sor<br />{HEADER_TOPLINE} a header.tpl-ben", "");
$L['cfg_banner'] = array("Banner<br />{HEADER_BANNER} a header.tpl-ben", "");
$L['cfg_motd'] = array("Napi �zenet<br />{NEWS_MOTD} az index.tpl-ben", "");
$L['cfg_bottomline'] = array("Als� sor<br />{FOOTER_BOTTOMLINE} a footer.tpl-ben", "");
$L['cfg_freetext1'] = array("Szabad sz�veg #1<br />{PHP.ldu_freetext1} minden tpl f�jlban", "");
$L['cfg_freetext2'] = array("Szabad sz�veg #2<br />{PHP.ldu_freetext2} minden tpl f�jlban", "");
$L['cfg_freetext3'] = array("Szabad sz�veg #3<br />{PHP.ldu_freetext3} minden tpl f�jlban", "");
$L['cfg_freetext4'] = array("Szabad sz�veg #4<br />{PHP.ldu_freetext4} minden tpl f�jlban", "");
$L['cfg_freetext5'] = array("Szabad sz�veg #5<br />{PHP.ldu_freetext5} minden tpl f�jlban", "");
$L['cfg_freetext6'] = array("Szabad sz�veg #6<br />{PHP.ldu_freetext6} minden tpl f�jlban", "");
$L['cfg_freetext7'] = array("Szabad sz�veg #7<br />{PHP.ldu_freetext7} minden tpl f�jlban", "");
$L['cfg_freetext8'] = array("Szabad sz�veg #8<br />{PHP.ldu_freetext8} minden tpl f�jlban", "");
$L['cfg_freetext9'] = array("Szabad sz�veg #9<br />{PHP.ldu_freetext9} minden tpl f�jlban", "");
$L['cfg_extra1title'] = array("Mez� #1 (String), megnevez�s", "");
$L['cfg_extra2title'] = array("Mez� #2 (String), megnevez�s", "");
$L['cfg_extra3title'] = array("Mez� #3 (String), megnevez�s", "");
$L['cfg_extra4title'] = array("Mez� #4 (String), megnevez�s", "");
$L['cfg_extra5title'] = array("Mez� #5 (String), megnevez�s", "");
$L['cfg_extra6title'] = array("Mez� #6 (Select box), megnevez�s", "");
$L['cfg_extra7title'] = array("Mez� #7 (Select box), megnevez�s", "");
$L['cfg_extra8title'] = array("Mez� #8 (Select box), megnevez�s", "");
$L['cfg_extra9title'] = array("Mez� #9 (Long text), megnevez�s", "");
$L['cfg_extra1tsetting'] = array("Max. karakter ebben a mez�ben", "");
$L['cfg_extra2tsetting'] = array("Max. karakter ebben a mez�ben", "");
$L['cfg_extra3tsetting'] = array("Max. karakter ebben a mez�ben", "");
$L['cfg_extra4tsetting'] = array("Max. karakter ebben a mez�ben", "");
$L['cfg_extra5tsetting'] = array("Max. karakter ebben a mez�ben", "");
$L['cfg_extra6tsetting'] = array("Select box �rt�kei, vessz�vel elv�lasztva", "");
$L['cfg_extra7tsetting'] = array("Select box �rt�kei, vessz�vel elv�lasztva", "");
$L['cfg_extra8tsetting'] = array("Select box �rt�kei, vessz�vel elv�lasztva", "");
$L['cfg_extra9tsetting'] = array("Sz�veg maxim�lis hossza", "");
$L['cfg_extra1uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra2uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra3uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra4uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra5uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra6uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra7uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra8uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_extra9uchange'] = array("Felhaszn�l�i profilban szerkeszthet�?", "");
$L['cfg_disable_comments'] = array("Hozz�sz�l�sok letilt�sa", "");
$L['cfg_disable_forums'] = array("F�rumok letilt�sa", "");
$L['cfg_disable_pfs'] = array("Saj�t f�jlok letilt�sa", "");
$L['cfg_disable_polls'] = array("Szavaz�sok letilt�sa", "");
$L['cfg_disable_pm'] = array("Priv�t �zenetek letilt�sa", "");
$L['cfg_disable_ratings'] = array("�rt�kel�sek letilt�sa", "");
$L['cfg_disable_page'] = array("Oldalak letilt�sa", "");
$L['cfg_disable_plug'] = array("Bov�tm�nyek letilt�sa", "");


/* ====== Forums ====== */

$L['adm_diplaysignatures'] = "Display signatures";
$L['adm_enablebbcodes'] = "Enable BBcodes";
$L['adm_enablesmilies'] = "Enable smilies";
$L['adm_enableprvtopics'] = "Allow private topics";
$L['adm_countposts'] = "Count posts";
$L['adm_autoprune'] = "Auto-prune topics after * days";
$L['adm_postcounters'] = "Check the counters";
$L['adm_help_forums'] = "Not available";
$L['adm_forum_structure'] = "Structure of the forums (categories)";	// New in v110
$L['adm_help_forums_structure'] = "Not available";	// New in v110
$L['adm_defstate'] = "Default state";	// New in v110
$L['adm_defstate_0'] = "Folded";	// New in v110
$L['adm_defstate_1'] = "Unfolded";	// New in v110


/* ====== IP search ====== */

$L['adm_searchthisuser'] = "IP c�m keres�se a felhaszn�l�i adatb�zisban";	// New in v800
$L['adm_dnsrecord'] = "A c�mhez tartoz� DNS rekord";	// New in v800

/* ====== Smilies ====== */

$L['adm_help_smilies'] = "Nem �ll rendelkez�sre";

/* ====== PFS ====== */

$L['adm_gd'] = "GD grafikus k�nyvt�r";	// New in v800
$L['adm_allpfs'] = "Az �sszes saj�t f�jl";
$L['adm_allfiles'] = "Az �sszes f�jl";
$L['adm_thumbnails'] = "Minik�pek";
$L['adm_orphandbentries'] = "�rva t�telek az adatb�zisban";
$L['adm_orphanfiles'] = "�rva f�jlok";
$L['adm_delallthumbs'] = "�sszes minik�p t�rl�se";
$L['adm_rebuildallthumbs']= "�sszes minik�p t�rl�se �s �jb�li l�trehoz�sa";
$L['adm_help_pfsthumbs'] = "Nem �ll rendelkez�sre";
$L['adm_help_check1'] = "Nem �ll rendelkez�sre";
$L['adm_help_check2'] = "Nem �ll rendelkez�sre";
$L['adm_help_pfsfiles'] = "Nem �ll rendelkez�sre";
$L['adm_help_allpfs'] = "Nem �ll rendelkez�sre";
$L['adm_nogd'] = "The GD graphical library is not supported by this host, Seditio won't be able to create thumbnails for the PFS images. You must go into the configuration panel, tab 'Personal File Space', and set Thumbnails generation = 'Disabled'.";

/* ====== Pages ====== */

$L['adm_structure'] = "Oldalak fel�p�t�se (kateg�ri�k)";
$L['adm_syspages'] = "'Rendszer' kateg�ri�k megjelen�t�se";
$L['adm_help_page'] = "The pages that belongs to the category 'system' are not displayed in the public listings, it's to make standalone pages.";
$L['adm_sortingorder'] = "Set a default sorting order for the categories";
$L['adm_fileyesno'] = "F�jl (igen/nem)";
$L['adm_fileurl'] = "F�jl URL";
$L['adm_filesize'] = "F�jlm�ret";
$L['adm_filecount'] = "Ennyiszer kattintottak a f�jlra";

/* ====== Polls ====== */

$L['adm_help_polls'] = "Once you created a new poll topics, select 'Edit' to add options (choices) for this poll.<br />'Delete' will delete the selected poll, the options, and all related votes.<br />'Reset' will delete all votes for the selected poll. It won't delete the poll itself or the options.<br />'Bump' will change the poll creation date to the current date, and so will make the poll 'current', top of the list.";

/* ====== Statistics ====== */

$L['adm_phpver'] = "PHP engine version";
$L['adm_zendver'] = "Zend engine version";
$L['adm_interface'] = "Interface between webserver and PHP";
$L['adm_os'] = "Operating system";
$L['adm_clocks'] = "Clocks";
$L['adm_time1'] = "#1 : Raw server time";
$L['adm_time2'] = "#2 : GMT time returned by the server";
$L['adm_time3'] = "#3 : GMT time + server offset (Seditio reference)";
$L['adm_time4'] = "#4 : Your local time, adjusted from your profil";
$L['adm_help_versions'] = "Adjust the Server time zone <a href=\"admin.php?m=config&amp;n=edit&amp;o=core&amp;p=time\">here</a> to have the clock #3 properlly set.<br />Clock #4 depends of the timezone setting in your profile.<br />Clocks #1 and #2 are ignored by Seditio.";
$L['adm_log'] = "System log";
$L['adm_infos'] = "Inform�ci�k";
$L['adm_versiondclocks'] = "Versions and clocks";
$L['adm_checkcoreskins'] = "Motor �s skin f�jlok ellenorz�se";
$L['adm_checkcorenow'] = "A motor f�jljainak ellenorz�se most!";
$L['adm_checkingcore'] = "Motor f�jljainak ellenorz�se...";
$L['adm_checkskins'] = "A jelenlegi skin �sszes f�jlj�nak ellenorz�se";
$L['adm_checkskin'] = "A skin TPL f�jljainak ellenorz�se";
$L['adm_checkingskin'] = "Skin ellenorz�se...";
$L['adm_hits'] = "Tal�latok";
$L['adm_check_ok'] = "Ok";
$L['adm_check_missing'] = "Hi�nyzik";
$L['adm_ref_lowhits'] = "Purge entries where hits are lower than 5";

/* ====== Ratings ====== */

$L['adm_ratings_totalitems'] = "�sszes �rt�kelt oldal";
$L['adm_ratings_totalvotes'] = "�sszes szavazat";
$L['adm_help_ratings'] = "�rt�kel�sek alaphelyzetbe �ll�t�s�hoz szimpl�n t�r�lje. It will be re-created with the first new vote.";

/* ====== Users ====== */

$L['adm_defauth_members'] = "Tagok alap�rtelmezett jogai";
$L['adm_deflock_members'] = "Lock mask for the members";
$L['adm_defauth_guests'] = "Vend�gek alap�rtelmezett jogai";
$L['adm_deflock_guests'] = "Lock mask for the guests";
$L['adm_rightspergroup'] = "Csoportok jogai";
$L['adm_copyrightsfrom'] = "Set the same rights as the group";
$L['adm_maxsizesingle'] = "Saj�t f�jl maxim�lis m�rete (KB)";
$L['adm_maxsizeallpfs'] = "Az �sszes saj�t f�jl maxim�lis m�rete (KB)";
$L['adm_rights_allow10'] = "Enged�lyezett";
$L['adm_rights_allow00'] = "Megtagadva";
$L['adm_rights_allow11'] = "Allowed and locked for security reasons";
$L['adm_rights_allow01'] = "Denied and locked for security reasons";

/* ====== Plugins ====== */

$L['adm_extplugins'] = "Extended plugins";
$L['adm_present'] = "Jelen";
$L['adm_missing'] = "Hi�nyzik";
$L['adm_paused'] = "Felf�ggesztve";
$L['adm_running'] = "Fut";
$L['adm_partrunning'] = "R�szlegesen fut";
$L['adm_notinstalled'] = "Nem telep�tett";

$L['adm_opt_installall'] = "Mindegyik telep�t�se";
$L['adm_opt_installall_explain'] = "Install�lja vagy alaphelyzetbe �ll�tja a bov�tm�nyt.";
$L['adm_opt_uninstallall'] = "Mindegyik elt�vol�t�sa</a></td>";
$L['adm_opt_uninstallall_explain'] = "Elt�vol�tja a bov�tm�nyt, de fizik�lisan nem t�vol�tja el.";
$L['adm_opt_pauseall'] = "Mindegyik felf�ggeszt�se";
$L['adm_opt_pauseall_explain'] = "Felf�ggezti a bov�tm�ny minden elem�nek muk�d�s�t.";
$L['adm_opt_unpauseall'] = "Mindegyik ind�t�sa";
$L['adm_opt_unpauseall_explain'] = "Folytatja a bov�tm�ny minden elem�nek muk�d�s�t.";

/* ====== Private messages ====== */

$L['adm_pm_totaldb'] = "Priv�t �zenetek az adatb�zisban";
$L['adm_pm_totalsent'] = "Az eddigi sszes elk�ld�tt priv�t �zenet";

?>