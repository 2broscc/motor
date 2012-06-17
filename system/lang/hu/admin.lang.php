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

$L['core_main'] = "Fõ beállítások";
$L['core_time'] = "Idõ és dátum";
$L['core_skin'] = "Skinek/Felületek";
$L['core_lang'] = "Nyelvek";
$L['core_menus'] = "Menük";
$L['core_comments'] = "Hozzászólások";
$L['core_forums'] = "Fórumok";
$L['core_page'] = "Oldalak";
$L['core_pfs'] = "Saját fájlok";
$L['core_plug'] = "Bovítmények";
$L['core_pm'] = "Privát üzenetek";
$L['core_polls'] = "Szavazások";
$L['core_ratings'] = "Értékelések";
$L['core_users'] = "Felhasználók";

/* ====== General ====== */

$L['editdeleteentries'] = "Elemek szerkesztése vagy törlése";
$L['viewdeleteentries'] = "Elemek megtekintése vagy törlése";
$L['addnewentry'] = "Új elem";
$L['adm_purgeall'] = "Teljes ürítés";
$L['adm_listisempty'] = "A lista üres";
$L['adm_totalsize'] = "Méret összesen";
$L['adm_showall'] = "Teljes megjelenítés";
$L['adm_area'] = "Terület";
$L['adm_option'] = "Opció";
$L['adm_setby'] = "Beállította";
$L['adm_more'] = "További eszközök...";
$L['adm_from'] = "Mettõl";
$L['adm_to'] = "Meddig";
$L['adm_confirm'] = "Megerõsítésül kérjük, kattintson az alábbi gombra: ";
$L['adm_done'] = "Rendben";
$L['adm_failed'] = "Nem sikerült";
$L['adm_warnings'] = "Figyelmeztetés";
$L['adm_valqueue'] = "Jóváhagyásra vár";
$L['adm_required'] = "(Hiányzik)";
$L['adm_clicktoedit'] = "(Szerkesztéshez kattints ide)";

/* ====== Banlist ====== */

$L['adm_ipmask'] = "IP maszk";
$L['adm_emailmask'] = "Email minta";
$L['adm_neverexpire'] = "Örökre";
$L['adm_help_banlist'] = "Példák IP maszkokra: 194.31.13.41 , 194.31.13.* , 194.31.*.* , 194.*.*.*<br />Példák email mintákra: @hotmail.com, @yahoo (Joker karakterek nem szerepelhetnek benne.)<br />Egy bejegyzés egyetlen IP maszkot vagy egyetlen email mintát vagy mindkettõt tartalmazhatja.<br />Az IP szûrés minden egyes megjelenített oldalra vonatkozik, míg az email minta csak a felhasználók regisztrációjára.";

/* ====== Cache ====== */

$L['adm_internalcache'] = "Belsõ cache";
$L['adm_help_cache'] = "Nem áll rendelkezésre";

/* ====== Configuration ====== */

$L['adm_help_config']= "Nem elérheto";
$L['cfg_adminemail'] = array("Rendszergazda email címe", "Kötelezõ");
$L['cfg_maintitle'] = array("Honlap címe", "A honlap címe (azaz megnevezése), kötelezõ");
$L['cfg_subtitle'] = array("Leírás", "Nem kötelezõ, a honlap címe után jelenik meg");
$L['cfg_mainurl'] = array("A honlap URL-je", "Kezdete http://, a végén ne legyen /!");
$L['cfg_hostip'] = array("Szerver IP", "A kiszolgáló IP címe, nem kötelezõ."); 	// New in v800
$L['cfg_gzip'] = array("Gzip", "A HTML kimenet Gzip tömörítése"); 	// New in v800
$L['cfg_cache'] = array("Belsõ cache", "A jobb teljesítmény érdekében érdemes engedélyezni"); 	// New in v800
$L['cfg_devmode'] = array("Hibakeresõ üzemmód", "Éles üzemben nem szabad engedélyezni"); 	// New in v800
$L['cfg_doctypeid'] = array("Dokument Típus", "&lt;!DOCTYPE> of the HTML layout");
$L['cfg_charset'] = array("HTML charset", "");
$L['cfg_cookiedomain'] = array("Domain for cookies", "Alapértelmezett: üres");
$L['cfg_cookiepath'] = array("Path for cookies", "Default: empty");
$L['cfg_cookielifetime'] = array("Maximum cookie élettartam", "Másodpercben");
$L['cfg_metakeywords'] = array("HTML Meta keywords (comma separated)", "Search engines");
$L['cfg_disablesysinfos'] = array("Az oldal eloállítási idejének kikapcsolása", "footer.tpl fájlban");
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
$L['cfg_av_maxsize'] = array("Avatar, maximum fájlméret", "Alapértelmezett: 8000 bájt");
$L['cfg_av_maxx'] = array("Avatar, maximum szélesség", "Alapértelmezett: 64 pixel");
$L['cfg_av_maxy'] = array("Avatar, maximum magasság", "Alapértelmezett: 64 pixel");
$L['cfg_usertextmax'] = array("Aláírás maximális hosszúsága", "Alapértelmezett: 300 karakter");
$L['cfg_sig_maxsize'] = array("Aláírás, maximum fájlméret", "Alapértelmezett: 50000 bájt");
$L['cfg_sig_maxx'] = array("Signature, maximum szélesség", "Alapértelmezett: 468 pixel");
$L['cfg_sig_maxy'] = array("Signature, maximum magasság", "Alapértelmezett: 60 pixel");
$L['cfg_ph_maxsize'] = array("Fotó, maximum fájlméret", "Alapértelmezett: 8000 bájt");
$L['cfg_ph_maxx'] = array("Fotó, maximum szélesség", "Alapértelmezett: 96 pixel");
$L['cfg_ph_maxy'] = array("Fotó, maximum magasság", "Alapértelmezett: 96 pixel");
$L['cfg_maxrowsperpage'] = array("Maximum sorok a listában", "");
$L['cfg_countcomments'] = array("Count comments", "Display the count of comments near the icon");
$L['cfg_hideprivateforums'] = array("Privát fórumok elrejtése", "");
$L['cfg_hottopictrigger'] = array("Hány hozzászólás kell ahhoz, hogy egy téma 'forró' legyen", "");
$L['cfg_maxtopicsperpage'] = array("Témák vagy hozzászólások max. száma oldalanként", "");
$L['cfg_antibumpforums'] = array("Túlterhelés-védelem", "Megakadályozza, hogy a felhasználók egymás után kétszer szóljanak hozzá ugyanahhoz a témához"); // New in v800
$L['cfg_pfsuserfolder'] = array("Folder storage mode", "If enabled, will store the user files in subfolders /datas/users/USERID/... instead of prepending the USERID to the filename. Must be set at the FIRST setup of the site ONLY. As soon as a file is uploaded to any PFS, it's too late to change this");
$L['cfg_th_amode'] = array("Thumbnails generation", "");
$L['cfg_th_x'] = array("Minikép, szélesség", "Alapértelmezésben: 112 pixel");
$L['cfg_th_y'] = array("Minikép, magasság", "Alapértelmezésben: 84 pixel, ajánlott : szélesség x 0.75");
$L['cfg_th_border'] = array("Minikép, szegély vastagsága", "Alapértelmezésben: 4 pixel");
$L['cfg_th_keepratio'] = array("Minikép, arányok megtartása?", "");
$L['cfg_th_jpeg_quality'] = array("Minikép, JPEG minõség", "Alapértelmezésben: 85");
$L['cfg_th_colorbg'] = array("Minikép, szegély színe", "Alapértelmezésben: 000000, hex színkód");
$L['cfg_th_colortext'] = array("Minikép, szöveg színe", "Alapértelmezésben: FFFFFF, hex színkód");
$L['cfg_th_textsize'] = array("Minikép, szöveg mérete", "");
$L['cfg_pm_maxsize'] = array("Üzenetek maximális hossza", "Alapértelmezésben: 10000 karakter");
$L['cfg_pm_allownotifications'] = array("Személyes üzenetekrõl értesítés emailben", "");
$L['cfg_disablehitstats'] = array("Látogatási statisztikák kikapcsolása", "HTTP Referers és találatok naponta");
$L['cfg_disablereg'] = array("A regisztrációs folyamat kikapcsolása", "A felhasználók nem hozhatnak létre új felhasználói fiókokat");
$L['cfg_disablewhosonline'] = array("A 'Jelenleg online' kikapcsolása", "Az LDU pajzs bekapcsolásakor automatikusan ez is bekapcsol");
$L['cfg_keepoldpms'] = array("Régebbi személyes üzenetek magõrzése az adatbázisban", "Ha 'igen', a törölt személyes üzenetek megmaradnak az adatbázisban");
$L['cfg_allowphp_pages'] = array("PHP típusú oldal engedélyezése", "PHP kód végrehajtása az oldalakon. Használata körültekintést igényel!");
$L['cfg_parsebbcodecom'] = array("BBcode feldolgozása megjegyzésekben és személyes üzenetekben", "");
$L['cfg_parsebbcodepages'] = array("BBcode feldolgozása az oldalakon", "");
$L['cfg_parsebbcodeusertext'] = array("BBcode feldolgozása a felhasználói aláírásban", "");
$L['cfg_parsebbcodeforums'] = array("BBcode feldolgozása a fórumban", "");
$L['cfg_parsesmiliescom'] = array("Smilies feldolgozása megjegyzésekben és személyes üzenetekben", "");
$L['cfg_parsesmiliespages'] = array("Smilies feldolgozása az oldalakon", "");
$L['cfg_parsesmiliesusertext'] = array("Smilies feldolgozása a felhasználói aláírásban", "");
$L['cfg_parsesmiliesforums'] = array("Smilies feldolgozása a fórumban", "");
$L['cfg_forcedefaultskin'] = array("Az alapértelmezett felszín kötelezõ minden felhasználó számára", "");
$L['cfg_forcedefaultlang'] = array("Az alapértelmezett nyelv kötelezõ minden felhasználó számára", "");
$L['cfg_separator'] = array("Általános célú elválasztó", "Alapértelmezésben: >");
$L['cfg_newwindows'] = array("Külsõ URL megnyitása új ablakban", "");
$L['cfg_menu1'] = array("Menühely #1<br />{PHP.cgf.menu1} minden tpl fájlban", "");
$L['cfg_menu2'] = array("Menühely #2<br />{PHP.cgf.menu2} minden tpl fájlban", "");
$L['cfg_menu3'] = array("Menühely #3<br />{PHP.cgf.menu3}minden tpl fájlban", "");
$L['cfg_menu4'] = array("Menühely #4<br />{PHP.cgf.menu4} minden tpl fájlban", "");
$L['cfg_menu5'] = array("Menühely #5<br />{PHP.cgf.menu5} minden tpl fájlban", "");
$L['cfg_menu6'] = array("Menühely #6<br />{PHP.cgf.menu6} minden tpl fájlban", "");
$L['cfg_menu7'] = array("Menühely #7<br />{PHP.cgf.menu7} minden tpl fájlban", "");
$L['cfg_menu8'] = array("Menühely #8<br />{PHP.cgf.menu8} minden tpl fájlban", "");
$L['cfg_menu9'] = array("Menühely #9<br />{PHP.cgf.menu9} minden tpl fájlban", "");
$L['cfg_topline'] = array("Felsõ sor<br />{HEADER_TOPLINE} a header.tpl-ben", "");
$L['cfg_banner'] = array("Banner<br />{HEADER_BANNER} a header.tpl-ben", "");
$L['cfg_motd'] = array("Napi üzenet<br />{NEWS_MOTD} az index.tpl-ben", "");
$L['cfg_bottomline'] = array("Alsó sor<br />{FOOTER_BOTTOMLINE} a footer.tpl-ben", "");
$L['cfg_freetext1'] = array("Szabad szöveg #1<br />{PHP.ldu_freetext1} minden tpl fájlban", "");
$L['cfg_freetext2'] = array("Szabad szöveg #2<br />{PHP.ldu_freetext2} minden tpl fájlban", "");
$L['cfg_freetext3'] = array("Szabad szöveg #3<br />{PHP.ldu_freetext3} minden tpl fájlban", "");
$L['cfg_freetext4'] = array("Szabad szöveg #4<br />{PHP.ldu_freetext4} minden tpl fájlban", "");
$L['cfg_freetext5'] = array("Szabad szöveg #5<br />{PHP.ldu_freetext5} minden tpl fájlban", "");
$L['cfg_freetext6'] = array("Szabad szöveg #6<br />{PHP.ldu_freetext6} minden tpl fájlban", "");
$L['cfg_freetext7'] = array("Szabad szöveg #7<br />{PHP.ldu_freetext7} minden tpl fájlban", "");
$L['cfg_freetext8'] = array("Szabad szöveg #8<br />{PHP.ldu_freetext8} minden tpl fájlban", "");
$L['cfg_freetext9'] = array("Szabad szöveg #9<br />{PHP.ldu_freetext9} minden tpl fájlban", "");
$L['cfg_extra1title'] = array("Mezõ #1 (String), megnevezés", "");
$L['cfg_extra2title'] = array("Mezõ #2 (String), megnevezés", "");
$L['cfg_extra3title'] = array("Mezõ #3 (String), megnevezés", "");
$L['cfg_extra4title'] = array("Mezõ #4 (String), megnevezés", "");
$L['cfg_extra5title'] = array("Mezõ #5 (String), megnevezés", "");
$L['cfg_extra6title'] = array("Mezõ #6 (Select box), megnevezés", "");
$L['cfg_extra7title'] = array("Mezõ #7 (Select box), megnevezés", "");
$L['cfg_extra8title'] = array("Mezõ #8 (Select box), megnevezés", "");
$L['cfg_extra9title'] = array("Mezõ #9 (Long text), megnevezés", "");
$L['cfg_extra1tsetting'] = array("Max. karakter ebben a mezõben", "");
$L['cfg_extra2tsetting'] = array("Max. karakter ebben a mezõben", "");
$L['cfg_extra3tsetting'] = array("Max. karakter ebben a mezõben", "");
$L['cfg_extra4tsetting'] = array("Max. karakter ebben a mezõben", "");
$L['cfg_extra5tsetting'] = array("Max. karakter ebben a mezõben", "");
$L['cfg_extra6tsetting'] = array("Select box értékei, vesszõvel elválasztva", "");
$L['cfg_extra7tsetting'] = array("Select box értékei, vesszõvel elválasztva", "");
$L['cfg_extra8tsetting'] = array("Select box értékei, vesszõvel elválasztva", "");
$L['cfg_extra9tsetting'] = array("Szöveg maximális hossza", "");
$L['cfg_extra1uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra2uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra3uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra4uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra5uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra6uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra7uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra8uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_extra9uchange'] = array("Felhasználói profilban szerkeszthetõ?", "");
$L['cfg_disable_comments'] = array("Hozzászólások letiltása", "");
$L['cfg_disable_forums'] = array("Fórumok letiltása", "");
$L['cfg_disable_pfs'] = array("Saját fájlok letiltása", "");
$L['cfg_disable_polls'] = array("Szavazások letiltása", "");
$L['cfg_disable_pm'] = array("Privát üzenetek letiltása", "");
$L['cfg_disable_ratings'] = array("Értékelések letiltása", "");
$L['cfg_disable_page'] = array("Oldalak letiltása", "");
$L['cfg_disable_plug'] = array("Bovítmények letiltása", "");


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

$L['adm_searchthisuser'] = "IP cím keresése a felhasználói adatbázisban";	// New in v800
$L['adm_dnsrecord'] = "A címhez tartozó DNS rekord";	// New in v800

/* ====== Smilies ====== */

$L['adm_help_smilies'] = "Nem áll rendelkezésre";

/* ====== PFS ====== */

$L['adm_gd'] = "GD grafikus könyvtár";	// New in v800
$L['adm_allpfs'] = "Az összes saját fájl";
$L['adm_allfiles'] = "Az összes fájl";
$L['adm_thumbnails'] = "Miniképek";
$L['adm_orphandbentries'] = "Árva tételek az adatbázisban";
$L['adm_orphanfiles'] = "Árva fájlok";
$L['adm_delallthumbs'] = "Összes minikép törlése";
$L['adm_rebuildallthumbs']= "Összes minikép törlése és újbóli létrehozása";
$L['adm_help_pfsthumbs'] = "Nem áll rendelkezésre";
$L['adm_help_check1'] = "Nem áll rendelkezésre";
$L['adm_help_check2'] = "Nem áll rendelkezésre";
$L['adm_help_pfsfiles'] = "Nem áll rendelkezésre";
$L['adm_help_allpfs'] = "Nem áll rendelkezésre";
$L['adm_nogd'] = "The GD graphical library is not supported by this host, Seditio won't be able to create thumbnails for the PFS images. You must go into the configuration panel, tab 'Personal File Space', and set Thumbnails generation = 'Disabled'.";

/* ====== Pages ====== */

$L['adm_structure'] = "Oldalak felépítése (kategóriák)";
$L['adm_syspages'] = "'Rendszer' kategóriák megjelenítése";
$L['adm_help_page'] = "The pages that belongs to the category 'system' are not displayed in the public listings, it's to make standalone pages.";
$L['adm_sortingorder'] = "Set a default sorting order for the categories";
$L['adm_fileyesno'] = "Fájl (igen/nem)";
$L['adm_fileurl'] = "Fájl URL";
$L['adm_filesize'] = "Fájlméret";
$L['adm_filecount'] = "Ennyiszer kattintottak a fájlra";

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
$L['adm_infos'] = "Információk";
$L['adm_versiondclocks'] = "Versions and clocks";
$L['adm_checkcoreskins'] = "Motor és skin fájlok ellenorzése";
$L['adm_checkcorenow'] = "A motor fájljainak ellenorzése most!";
$L['adm_checkingcore'] = "Motor fájljainak ellenorzése...";
$L['adm_checkskins'] = "A jelenlegi skin összes fájljának ellenorzése";
$L['adm_checkskin'] = "A skin TPL fájljainak ellenorzése";
$L['adm_checkingskin'] = "Skin ellenorzése...";
$L['adm_hits'] = "Találatok";
$L['adm_check_ok'] = "Ok";
$L['adm_check_missing'] = "Hiányzik";
$L['adm_ref_lowhits'] = "Purge entries where hits are lower than 5";

/* ====== Ratings ====== */

$L['adm_ratings_totalitems'] = "Összes értékelt oldal";
$L['adm_ratings_totalvotes'] = "Összes szavazat";
$L['adm_help_ratings'] = "Értékelések alaphelyzetbe állításához szimplán törölje. It will be re-created with the first new vote.";

/* ====== Users ====== */

$L['adm_defauth_members'] = "Tagok alapértelmezett jogai";
$L['adm_deflock_members'] = "Lock mask for the members";
$L['adm_defauth_guests'] = "Vendégek alapértelmezett jogai";
$L['adm_deflock_guests'] = "Lock mask for the guests";
$L['adm_rightspergroup'] = "Csoportok jogai";
$L['adm_copyrightsfrom'] = "Set the same rights as the group";
$L['adm_maxsizesingle'] = "Saját fájl maximális mérete (KB)";
$L['adm_maxsizeallpfs'] = "Az összes saját fájl maximális mérete (KB)";
$L['adm_rights_allow10'] = "Engedélyezett";
$L['adm_rights_allow00'] = "Megtagadva";
$L['adm_rights_allow11'] = "Allowed and locked for security reasons";
$L['adm_rights_allow01'] = "Denied and locked for security reasons";

/* ====== Plugins ====== */

$L['adm_extplugins'] = "Extended plugins";
$L['adm_present'] = "Jelen";
$L['adm_missing'] = "Hiányzik";
$L['adm_paused'] = "Felfüggesztve";
$L['adm_running'] = "Fut";
$L['adm_partrunning'] = "Részlegesen fut";
$L['adm_notinstalled'] = "Nem telepített";

$L['adm_opt_installall'] = "Mindegyik telepítése";
$L['adm_opt_installall_explain'] = "Installálja vagy alaphelyzetbe állítja a bovítményt.";
$L['adm_opt_uninstallall'] = "Mindegyik eltávolítása</a></td>";
$L['adm_opt_uninstallall_explain'] = "Eltávolítja a bovítményt, de fizikálisan nem távolítja el.";
$L['adm_opt_pauseall'] = "Mindegyik felfüggesztése";
$L['adm_opt_pauseall_explain'] = "Felfüggezti a bovítmény minden elemének muködését.";
$L['adm_opt_unpauseall'] = "Mindegyik indítása";
$L['adm_opt_unpauseall_explain'] = "Folytatja a bovítmény minden elemének muködését.";

/* ====== Private messages ====== */

$L['adm_pm_totaldb'] = "Privát üzenetek az adatbázisban";
$L['adm_pm_totalsent'] = "Az eddigi sszes elküldött privát üzenet";

?>