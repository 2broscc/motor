<!-- BEGIN: MAIN -->

<div  id="infopanel_container">
<div id="page_title">RidelineMTB - CMS engine (Changelog)</div>
<div id="page_subtitle">/dev. log/ modded seditio 121 core</div>
</div>

<div id="infopanel_bottom"></div>


<div id="page_main">

	<table border="0" width="960" cellspacing="0" cellpadding="0">
		<tr>
			<td width="177" valign="top">
<!--LEFT SIDE CONTENT-->
<div align="left" style="padding-left:10px;padding-top:5px;">
			<table border="0" width="139" cellpadding="0">
				<tr>
					<td><a href="plug.php?e=contactus">Elérhetõségek</a></td>
				</tr>
				<tr>
					<td>
<!--SITE EDITORS-->
<a href="#" onclick="return hs.htmlExpand(this, { contentId: 'highslide-html' } )" class="highslide">Szerkesztõk</a>	
<div class="highslide-html-content" id="highslide-html">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">Bezár</a>
			</li>
		</ul>	    
	</div>
	<div class="highslide-body">
<!--CONTENT-->
Az oldalt szerkesztik: péter,gabesz
<!--CONTENT-->
	</div>
    <div class="highslide-footer">
        <div>
            <span class="highslide-resize" title="Resize">
                <span></span>
            </span>
        </div>
    </div>
</div>

</div>
<!--SITE EDITORS-->
					</td>
				</tr>
				<tr>
					<td><a href="rideline.php?m=disclaimer">Általános felhasználási feltételek</a></td>
				</tr>
				<tr>
					<td><a href="rideline.php?m=jogi">Jogi nyilatkozat</a></td>
				</tr>
				<tr>
					<td>Reklámozás</td>
				</tr>
				<tr>
					<td>Bannerek</td>
				</tr>
				<tr>
					<td>Partnerek</td>
				</tr>
				<tr>
					<td>GYIK</td>
				</tr>
				<tr>
					<td><a href="rideline.php?m=changelog">Changelog</a></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
</div>
<!--LEFT SIDE CONTENT-->
			</td>
			<td valign="top">
<div align=justify style="padding-left:5px;padding-right:8px;padding-top:5px;">
2009.12.11 added features<br>
rev. name 121b<br>
-rss support all over the site (included the header.php)<br>
-rss structure has been modified now the user can be add display feeds without 
to modify the source code<br>
-renamed and added some new tags to config.pgp which has got a new name called 
beallit.php<br>
-modified the main access to the beallit.php in every routing php file.<br>
-added mini image support to pages<br>
-i just modded the core files in the way of renamed the pages_desc which was a 
description field. now it's called list picture<br>
-added some .htaccess file to protect the core files and the skin files (*.tpl)<br>
-added javascript functions <br>
- collapsable divider with state cookie which means if the user closed the div 
and then reload the site the div be able to hold their own state<br>
-added ridelinemtb.js where can be found the global functions like gui 
animations etc.<br>
<br>
2009.12.12 added features<br>
<br>
-flv player called ridelinemtb player now it's possible to use our own 
videoplayer on the site<br>
-added some new variables to the beallit.php like baseurl, videoplayer directory 
path etc.<br>
-added global variable to the video bbcodes now it can be globally set the width 
and the height from the beallit.php<br>
-added $cfg['skinposition'] i called it display alignment. now it 's very easy 
to set the right, left or center postion of the site. just enter the right 
number in percent and it's done.<br>
<br>
2009.12.13 added features<br>
<br>
-ajax page and content loader added the source - doesn't work at the moment<br>
<br>
2009.12.15 added features<br>
rev. name 121c<br>
-added start index.php which is useful when the cms is in a subdir it's got 
states that means if state is equal with 1 the srcript will you redir. <br>
the subdir if it is equal with 2 shows a littel advert and after a time delay 
redir to the site<br>
-changed the project version number now it is 121c.<br>
-i've added some extra code for the start index.php<br>
<br>
2009.12.25 added features<br>
<br>
-added separate video list and video page. <br>
<br>
2009.12.26 added features<br>
rev. name Seditio 1.00<br>
-changed the versrion number now it starting from 1.0 <br>
-added if empty page_pic options which fills the empty field with a default img.<br>
-added to admin.page.queue preview pic<br>
-added fixed width and heigth to the preview picture on page.php<br>
<br>
2010.01.01 added features<br>
rev. name Seditio 1.00<br>
-added img_border with fixed height and width and gives the picture a 3px of 
solid white border as well we can change the dimensions of the picture.<br>
-modified the rideline video player video location part which means if someone 
want to add a video need the whole url example.: http://something.com/video.mov<br>
<br>
2010.01.08 added features<br>
rev. name Seditio 1.01<br>
-added karbantartás.htm which is shows when we're doing some uprgrade at the 
site.<br>
-added loading picture<br>
-rewrited the index.php added switch funciton and separeted the main functions<br>
<br>
2010.01.16 added features<br>
rev. name Seditio 1.01<br>
-changed the top image slider now we are using jquery based slider<br>
-took the maintenance mode from index.php and made a single maintenance.php file.<br>
-added highslide window handling interface <br>
-added shorturl maker script from tinyurl.hu - does not work at the moment<br>
<br>
2010.01.20 added features<br>
rev. name Seditio 1.01<br>
-removed the dropdown menu from userbar<br>
-fixed and set up the top content slider<br>
-the whole source need some clean up<br>
-fixed startup index.php and cleaned by unused code parts.<br>
-fixed list.tpl image width and height problems<br>
<br>
2010.01.21 added features<br>
rev. name Seditio 1.01<br>
-added maxfileupload class<br>
-added kiemelt.php <br>
-changed the top content slider loading process. i've put the slider source into 
a html file and loaded into the index.tpl with ajax script<br>
-made some little fixies in the source code <br>
-fixed and changed the top content &quot;infopanel&quot; grapichal parts<br>
<br>
2010.01.22 added features<br>
rev. name Seditio 1.01<br>
-added some extra css parts<br>
-fixed the userbar background img<br>
-fixed and rewrited the rss part in header.php<br>
-fixed video list preview img issues<br>
-recreated the gallery template file, separated the gallery home page<br>
-removed some items from page.tpl like preview pic and author and gave two new 
img called date and postedby<br>
<br>
2010.01.23 added features<br>
rev. name Seditio 1.01<br>
-fixed recentitems plugin<br>
-removed recentitems_news plugin<br>
<br>
2010.01.23 added features<br>
rev. name Seditio 1.01<br>
-added new right sied header and some new classes to css file<br>
-created the rideline disclaimer and contact us part.<br>
-fixed some tipycal bug<br>
<br>
<br>
2010.01.30 added features<br>
rev. name Seditio 1.01<br>
-added newest articles with img on the index.tpl<br>
-added text shorter by Gabesz<br>
<br>
2010.01.31 added features<br>
rev. name Seditio 1.01 r100<br>
-added decline flash video player to the functions core file<br>
-from now we're using sub version numbers. it's starts with r100 and included 
all the previous changes<br>
<br>
2010.02.01 added features<br>
rev. name Seditio 1.01 r101<br>
-added some information in the footer about the creators<br>
-removed from the index.tpl the who is online statistics (i'll find another 
place where we'll display it.)<br>
-created the header_notice bar which is provides informations about the site 
state or just informations about the site.<br>
-fixed some graphical issues<br>
-fixed some div object padding issues<br>
-fixed page.tpl content and comment issues <br>
-added new next and previous button on list.tpl<br>
<br>
2010.02.02 added features<br>
rev. name Seditio 1.01 r102<br>
-reworked the video.tpl template file mainly the title part and added three more 
icons to the page i.e author,date, and who's sent in the news icon.<br>
-the site runs on great firefox,safari,chrome not yet tesetd opera and IE 7 and 
above<br>
-changed the way to change the state of start index.php now everything can be 
modify from kiemelt.php<br>
<br>
2010.02.03 added features<br>
rev. name Seditio 1.01 r103<br>
<br>
-spearated &quot;álló&quot; and &quot;fekvõ&quot; imgborder : [img_border_f]; [img_border_a]<br>
-fhinished with the registration page<br>
-added password strenght meter<br>
-online users displayed in the footer section<br>
<br>
<br>
2010.02.06 added features<br>
rev. name Seditio 1.01 r104<br>
<br>
-added sajx feature to the core. now sedito is able to sends form via. ajax<br>
<br>
2010.02.07 added features<br>
rev. name Seditio 1.01 r105<br>
<br>
-added glass avatars feature<br>
-added qpatcha for registration page (cot plugin into sed + sql)<br>
-integrated sed_url function which cab be found in cotonti. now we're able to 
using cot plugins in seditio<br>
-added new page notifying plugin. it means when a new page will'be added then 
the mailer sends a message like: a new page waiting for validation<br>
<br>
<br>
2010.02.08 added features<br>
rev. name Seditio 1.01 r106<br>
<br>
-added some patched soruce code from sed 126<br>
-disabled the sed_prase thing because we handle this in another way.<br>
-added the sed 126 admin core files to our build<br>
-updated the whole forum core files also the sql tables.<br>
<br>
2010.02.13 added features<br>
rev. name Seditio 1.01 r107<br>
<br>
-changed the footer part<br>
-added some extra code<br>
-added facebook social sharing button page.inc.php /with facebook sharing we've 
got some issues/<br>
-added tweetme button into page.inc.php<br>
<br>
2010.02.14 added features<br>
rev. name Seditio 1.01 r107<br>
<br>
-finished the footer section and redesigned the login user bar combo part.<br>
-optimized the source code<br>
<br>
2010.02.15 added features<br>
rev. name Seditio 1.01 r110<br>
<br>
-fixed and added some new code part for recentitems<br>
-added links manager for pages.inc.php<br>
<br>
2010.02.18 added features<br>
rev. name Seditio 1.01 r111<br>
<br>
-finished the slider.php<br>
-added some extra codes to kiemelt.php<br>
-updated and added latest lifestyle query to recentitems.php<br>
<br>
2010.02.20 added features<br>
rev. name Seditio 1.01 r117<br>
<br>
-changed the tweetme and facebook share button. now it is works fine and post 
the relevant messages<br>
-changed the way to show page informations<br>
-added some css class to admin.php<br>
-added hungarian laguage files and modified it to fit the main website look<br>
-reworked the page queue part at admin.php<br>
<br>
2010.02.21 added features<br>
rev. name Seditio 1.01 r118<br>
<br>
-fixed recent itemes race and event function because we forgot to change the 
query limit variables. it caused that shows the all query instead the last one.
<br>
-updated and fixed the core files of pages !note: need to add sql update because 
the new structure need it! !!SQL --&gt;(page_text2, text)<br>
<br>
<br>
2010.02.22 added features<br>
rev. name Seditio 1.01 r119<br>
<br>
-added partners and advetizers to footer <br>
-removed footer_top_container class from the css soruce code<br>
&nbsp;</div>
			</td>
		</tr>
		</table>

</div>
<div id="footer_pagemainend"></div>

<!-- END: MAIN -->