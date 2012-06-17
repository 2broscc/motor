<!-- BEGIN: MAIN -->

<div  id="infopanel_container">

<div id="page_subtitle">
{USERPANEL_INFO_USERPANEL}
</div>

<div id="page_title">

{USERPANEL_INFO_TITLE}

</div>

<div id="infopanel_bottom">
<div align=right style="padding-top:5px;padding-right:14px;">{PAGE_EMAIL_ME} {PAGE_PRINT}</div>
</div> <!--infopanel end-->

<div id="main">

<div style="padding-left:10px;padding-right:2px;">

<table class="cells">
	<tr>
	<td colspan="6" class="coltop">{USERPANEL_INFO_TITLE}</td>
	</tr>
    <tr>
    <td class="coltop">{PHP.skinlang.bd_Picture}</td>
    <td class="coltop">{PHP.skinlang.bd_Details}</td>
    <td class="coltop">{PHP.skinlang.bd_Price1}</td>
    <td class="coltop">{PHP.skinlang.bd_Createdate} <br />
( {PHP.skinlang.bd_Lastchanged} )</td>
	<td class="coltop">{PHP.skinlang.bd_Hits}</td>
    <td class="coltop">{PHP.skinlang.bd_Inproper}</td>
    </tr>
    <!-- BEGIN:USERPANEL_ROW -->
    <tr>
    <td class="{USERPANEL_ITEMROW_ODDEVEN}"  style="vertical-align:middle; text-align:center;"><img {USERPANEL_ITEMROW_PHOTO} style="max-height:40px; max-width:40px;" /></td>
    <td class="{USERPANEL_ITEMROW_ODDEVEN}">
    <b>{USERPANEL_ITEMROW_NAME} - {USERPANEL_ITEMROW_SHORTDESC}</b><br />
    {USERPANEL_ITEMROW_DETAILS}
    <hr />
    {USERPANEL_ITEMROW_ACTIONS}
    </td>
    <td class="{USERPANEL_ITEMROW_ODDEVEN}">{USERPANEL_ITEMROW_PRICE}</td>
    <td class="{USERPANEL_ITEMROW_ODDEVEN}">{USERPANEL_ITEMROW_EDITDATE} <br />
({USERPANEL_ITEMROW_EDITDATE})</td>
    <td class="{USERPANEL_ITEMROW_ODDEVEN} centerall">{USERPANEL_ITEMROW_HITS}</td>
    <td class="{USERPANEL_ITEMROW_ODDEVEN}">{USERPANEL_ITEMROW_USER},<br/>{USERPANEL_ITEMROW_LOCATION}</td>
    </tr>
    <tr>
    
    </tr>
    <!-- END:USERPANEL_ROW -->
    <!-- BEGIN:USERPANEL_ROW_EMPTY -->
    <tr>
    <td class="centerall" colspan="6">
    {PHP.skinlang.bd_Noob}
    </td>
    </tr>
    <!-- END:USERPANEL_ROW_EMPTY -->
    <tr>
    <td colspan="18" class="centerall">
    {USERPANEL_INFO_PAGES}
    </td>
    </tr>
</table>

</div> <!--main alignment-->

</div> <!--main end-->

<div id="footer_forummainend"></div>
<!-- END: MAIN -->