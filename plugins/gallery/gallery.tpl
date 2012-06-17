<!-- BEGIN: MAIN -->

<div id="main">



<!--	{GALLERY_DESC}Click thumbnails to see larger images.-->


<!-- BEGIN: HOME -->
<div id="holder">
<table>
<tr>
<!--left side box-->
<td>

	<div>
		<div id="lbox_top">
		
			<div id="menupadding">
					<a href="#"><h5>Random Pic</h5></a>
				</div>
		
		</div>
		
		<div id="lbox_mid">
		
			<div id="content_pos">
			
			<div align="center"><a href="{HOME_RAND_VIEWURL_POPUP}" rel="clearbox">{HOME_RAND_THUMB}</a></div>
			<p>
			<!--<strong><a href="{HOME_RAND_VIEWURL_POPUP}">{HOME_RAND_DESC}</a></strong><br />-->
			</p>
				
				
				
				
			</div>
		
		</div>
		<div id="lbox_bot"></div>
	
	
	</div>


</td>
<!--left side box-->

<!--right side box-->
<td>
	<div>
		<div id="pagewidebox_top">
			<div id="page_icons">{PAGE_PRINT} {PAGE_EMAIL_ME}</div>
		</div>
		<div id="pagewidebox_mid">
		
		<div id="page_widebox_contentpos">
				<div id="page_title">{PAGE_TITLE}</div>
				

			
<div style="padding-top:5px;">
	<div id="page_light">
			
	<table width="100%">

	<tr>
		<td valign="top">
	</td>

	<td>


		<table class="cells">

			<tr>
				<td class="coltop">Gallery</td>
				<td style="width:128px;" class="coltop">Author</td>
				<td style="width:128px;" class="coltop">Pictures</td>
			</tr>

		<!-- BEGIN: ROW -->

		<tr>
			<td><a href="{HOME_ROW_URL}"><strong>{HOME_ROW_TITLE}</strong></a> {HOME_ROW_NEW}<br />
			{ROW_DESC}
			</td>
			<td style="text-align:center;">{HOME_ROW_AUTHOR}</td>
			<td style="text-align:center;">{HOME_ROW_COUNT}</td>
		</tr>

		<!-- END: ROW -->

		</table>

		<h4>Recent :</h4>

		<table class="cells">

			<tr>
				<td class="coltop">Preview</td>
				<td class="coltop">Description / Gallery / Author / Date</td>
			</tr>

		<!-- BEGIN: ROW_RPIC -->

		<tr>
			<td><a href="{HOME_RPIC_ROW_VIEWURL_POPUP}" rel="clearbox">{HOME_RPIC_ROW_THUMB}</a></td>
			<td style="width:100%;">
			<strong><a href="{HOME_RPIC_ROW_VIEWURL_POPUP}">{HOME_RPIC_ROW_DESC}</a></strong><br />
			From the gallery "<a href="{HOME_RPIC_ROW_PFF_URL}">{HOME_RPIC_ROW_PFF_TITLE}</a>", author is {HOME_RPIC_ROW_AUTHOR}.<br />
			{HOME_RPIC_ROW_DATE} {HOME_RPIC_ROW_NEW}

			</td>
		</tr>

		<!-- END: ROW_RPIC -->

		</table>


		<h4>Statistics :</h4>

		<p>
			There's currently a total of {HOME_TOTALFILES} pictures in {HOME_TOTALFOLDERS} galleries.<br />
			All pictures together were displayed {HOME_TOTALVIEWS} times.
		</p>

	</div>

	</td>

</tr>

</table>
				
			</div>
		</div>	
	</div>
</div>
		
		
		
<div id="pagewidebox_bot"></div>

</td>
<!--right side box-->


</tr>

</table>


</div> <!-- wbox holder -->



<!-- END: HOME -->



<!--Kiválasztott galéria-->

<!-- BEGIN: GALLERY -->

	<div id="wbox_top">
			
				<div id="menupadding">
					<a href="#"><h5>{HOME_TITLE}{GALLERY_TITLE}</h5></a>
				</div>
			
	</div>

	<div id="wbox_mid">
					
					<div id="content_pos">
					
					
<div id="page_ligth">
	<table width="100%">

		<!-- BEGIN: ROW -->

		{GALLERY_ROW_COND1}

		<td>
			<a href="datas/users/{GALLERY_ROW_URL_DIRECT}" rel="clearbox">{GALLERY_ROW_THUMB}</a>
		</td>

		<td><strong>{GALLERY_ROW_DESC}</strong>

		<p>
			{GALLERY_ROW_ICON} {GALLERY_ROW_DIMXY} {GALLERY_ROW_SIZE}, {GALLERY_ROW_COUNT} hits.<br />
			Updated : {GALLERY_ROW_DATE} {GALLERY_ROW_NEW}<br />
			Comments : {GALLERY_ROW_COMMENTS}<br />
			Rating : {GALLERY_ROW_RATING}<br />
			{GALLERY_ROW_ADMIN}
		</p>

		{GALLERY_ROW_COND2}

	<!-- END: ROW -->

	</table>
</div>
					
					
					</div>
	
	</div> 


	<div id="wbox_bot"></div>


<!-- END: GALLERY -->



</div>

<!-- BEGIN: ERROR -->

<div class="error">

	{ERROR_MESSAGE}

</div>

<!-- END: ERROR -->

</div> <!--main-->

<!-- END: MAIN -->