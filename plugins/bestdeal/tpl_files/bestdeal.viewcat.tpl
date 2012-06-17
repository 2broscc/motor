<!-- BEGIN: MAIN -->


<div id="main">

<div id="page_subtitle">
{VIEW_CAT_INFO_USERPANEL}
<br />
{VIEW_CAT_INFO_ADDITEM} {VIEW_CAT_INFO_ADDSUBCAT} {VIEW_CAT_INFO_EDITCAT}
</div>



<div style="padding-bottom:5px;">
	<div id="wbox_top">
			
				<div id="menupadding">
					<a href="#"><h5>{PHP.skinlang.admin.menu}</h5></a>
				</div>
			
	</div>

	<div id="wbox_mid">
					
					<div id="content_pos">
		
			<h2>{VIEW_CAT_INFO_TITLE}</h2>
			{VIEW_CAT_INFO_SHORTDESC} <br>
			
			<p>{PHP.skinlang.category_links}:{VIEW_CAT_INFO_SUBCATS}</p>
		
		</div>
	
	</div> 


	<div id="wbox_bot"></div>
</div>




<!--dinamikus tartalom innen-->

	<div id="wbox_top">
			
				<div id="menupadding">
					<a href="#"><h5>{PHP.skinlang.admin.menu}</h5></a>
				</div>
			
	</div>

	<div id="wbox_mid">
					
		<div id="content_pos">
						<!-- BEGIN: VIEWCAT -->

<table class="cells">
	<tr>
	<td colspan="6" class="coltop">{PHP.skinlang.bd_ObinCat} {VIEW_CAT_INFO_TITLE}</td>
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
    <!-- BEGIN:VIEW_CAT_ROW -->
    <tr>
    <td class="{VIEW_CAT_ITEMROW_ODDEVEN}" style="vertical-align:middle; text-align:center;"><a href="plug.php?e=bestdeal&id={VIEW_CAT_ITEMROW_ID}"><img {VIEW_CAT_ITEMROW_PHOTO} style="max-height:40px; max-width:40px; width:40px;" /></a></td>
    <td class="{VIEW_CAT_ITEMROW_ODDEVEN}">
    <a href="plug.php?e=bestdeal&id={VIEW_CAT_ITEMROW_ID}">{VIEW_CAT_ITEMROW_NAME} - {VIEW_CAT_ITEMROW_SHORTDESC}</a><br />
    {VIEW_CAT_ITEMROW_DETAILS}
    </td>
    <td class="{VIEW_CAT_ITEMROW_ODDEVEN}">{VIEW_CAT_ITEMROW_PRICE}</td>
    <td class="{VIEW_CAT_ITEMROW_ODDEVEN}">{VIEW_CAT_ITEMROW_EDITDATE} <br />
({VIEW_CAT_ITEMROW_EDITDATE})</td>
    <td class="{VIEW_CAT_ITEMROW_ODDEVEN} centerall">{VIEW_CAT_ITEMROW_HITS}</td>
    <td class="{VIEW_CAT_ITEMROW_ODDEVEN}">{VIEW_CAT_ITEMROW_USER},<br />
{VIEW_CAT_ITEMROW_LOCATION}</td>
    </tr>
    <tr>
    
    </tr>
    <!-- END:VIEW_CAT_ROW -->
    <!-- BEGIN:VIEW_CAT_ROW_EMPTY -->
    <tr>
    <td class="odd centerall" colspan="6">
    {PHP.skinlang.bd_Noob}
    </td>
    </tr>
    <!-- END:VIEW_CAT_ROW_EMPTY -->
    <tr>
    <td colspan="18" class="centerall">
    {VIEW_CAT_INFO_PAGES}
    </td>
    </tr>
</table>

<!-- END: VIEWCAT -->

<!-- BEGIN: VIEWCATLIST -->
<table style="width:100%">
<!-- BEGIN: VIEWCAT_INFO_LASTINHEADCATS -->
{VIEW_CAT_INFO_ROWSTART}
<div class="block">
<h4><a href="plug.php?e=bestdeal&amp;page=viewcat&amp;cat={VIEW_CAT_INFO_ID}">{VIEW_CAT_INFO_NAME}</a></h4>
<table width="100%">
<!-- BEGIN: ROW -->
<tr>
<td width="50%">
<a href="plug.php?e=bestdeal&amp;id={VIEW_ITEM_INFO_ID}">{VIEW_ITEM_INFO_NAME}</a>
<td>
<td width="50%" style="text-align:right">
{VIEW_ITEM_INFO_PRICE}
</td>
</tr>
<!-- END: ROW -->
<!-- BEGIN: ROW_EMPTY -->
<tr>
<td colspan="2">
{PHP.skinlang.bd_NoobinCat}
<td>
</tr>
<!-- END: ROW_EMPTY -->
</table>
</div>
{VIEW_CAT_INFO_ROWEND}
<!-- END: VIEWCAT_INFO_LASTINHEADCATS -->
</table>



<!-- END: VIEWCATLIST -->

<div style="padding-top:5px;">
<table class="cells">
    <tr>
    <td>
    {PHP.skinlang.bd_Searchfor} : {VIEW_CAT_INFO_SEARCH}
    </td>
    
    <td style="text-align:right;">
    {VIEW_CAT_INFO_CATONISER}
    </td>
    </tr>
</table>
</div> <!--table-->
					
					
					
					
					
					
					
					
					
		</div>
	
	</div> 


	<div id="wbox_bot"></div>






</div> <!--main div end-->



<!-- END: MAIN -->