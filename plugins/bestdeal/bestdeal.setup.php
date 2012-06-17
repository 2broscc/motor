<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net
[BEGIN_SED]
File=plugins/bestdeal/bestdeal.setup.php
Version=1.0
Updated=30-05-07
Type=Plugin
Author=J3ll3nl
Description= Webshop/animocheck (Not yer implemented)
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=bestdeal
Name=RidersGear
Description=
Version=0.5
Date=2006-mar-30
Author=Neocrome
Copyright=
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=RW123
Lock_members=
[END_SED_EXTPLUGIN]
[BEGIN_SED_EXTPLUGIN_CONFIG]
autovalidation=11:radio:1,0:0: Autovalidation ?
admin_mail=12:string:::Admin-email (Leave empty to set sender email to user email)
state_active=13:string::2: Months before reactivation
maxitemsperpage=14:select:5,6,7,8,9,10,15,20,30,40,50,100:10: Max items to show in categorie
valuta=15:string::€: Valuta-sign
delphotoatclose=16:radio:1,0:1: Delete Photo after an item is closed
max_size_item_photo=17:string::500000: Max photo-size in bytes
max_x_item_photo=18:string::500: Max photo-width
max_y_item_photo=19:string::500: Max photo-height
ParseBBcodes=20:radio:1,0:1: Parse bbcodes?
ParseSmilies=21:radio:1,0:1: Parse Smilies?
[END_SED_EXTPLUGIN_CONFIG]
==================== */

?>