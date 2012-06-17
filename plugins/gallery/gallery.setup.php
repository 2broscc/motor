<?PHP

/* ====================
Seditio - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_SED]
File=plugins/gallery/gallery.setup.php
Version=100
Updated=2006-feb-24
Type=Plugin
Author=Neocrome
Description=
[END_SED]

[BEGIN_SED_EXTPLUGIN]
Code=gallery
Name=Gallery
Description=Displays the PFS images from the users, when marked 'public' and 'gallery'.
Version=3.0
Date=2006-jun-24
Author=Neocrome
Icon=pfs
Copyright=
Notes=
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=RW
Lock_members=12345
[END_SED_EXTPLUGIN]

[BEGIN_SED_EXTPLUGIN_CONFIG]
columns=01:select:1,2,3,4,5,6,7,8,9,10:2:Columns
recent=02:select:0,1,2,3,4,5,6,7,8,9,10,15,20:5:Recent pictures
potw=03:string:::ID of the picture of the week, leave empty to disable
newdelay=04:string::7:Marked as new if less than * days
newtext=05:string::<strong>NEW!</strong>:Text if new
popupmargin=06:string::64:Margins for the popup mode
moviesext=07:string::avi,mpg,mpeg,wmv,mov,rm,asf:Video files extensions
logofile=08:string::plugins/gallery/img/logo.png:Png/jpeg/Gif logo that will be added to all the new PFS images, leave empty to disable
logopos=09:select:Top left,Top right,Bottom left,Bottom right:Top left:Position of the logo in the PFS images
logotrsp=10:select:0,5,10,20,30,40,50,60,70,80,90,95,100:50:Merging level for the logo
logojpegqual=11:select:0,5,10,20,30,40,50,60,70,80,90,95,100:100:Quality of the final image afer the logo is inserted, if it's a Jpeg
[END_SED_EXTPLUGIN_CONFIG]

==================== */

if ( !defined('SED_CODE') ) { die("Wrong URL."); }

?>