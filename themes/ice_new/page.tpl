<!-- BEGIN: MAIN -->
<div id="main_bg">
	<div id="main_postion">
	
	
<table width="100">
<tr>

	<td>
	
		<div id="index_latest">
		
				<div id="index_left_side">	
				
				<div id="index_content_title"><h2>{PAGE_TITLE}</h2></div>
				<div id="index_content_title"><h5>
				
				{PHP.skinlang.page.Submittedby} {PAGE_OWNER} | {PHP.skinlang.page.Date} {PAGE_DATE} | Kategória: {PAGE_CAT}

	<!-- BEGIN: PAGE_ADMIN -->

	{PAGE_ADMIN_UNVALIDATE} &nbsp; {PAGE_ADMIN_EDIT} &nbsp; ({PAGE_ADMIN_COUNT})<br />

	<!-- END: PAGE_ADMIN -->	
				</h5></div>

			{PAGE_TEXT}
			
			
			
	<!-- BEGIN: PAGE_MULTI -->

		<div class="paging">

			{PAGE_MULTI_TABNAV}

		</div>

		<div class="block">
			<h5>{PHP.skinlang.page.Summary}</h5>

			{PAGE_MULTI_TABTITLES}

		</div>

	<!-- END: PAGE_MULTI -->

	<!-- BEGIN: PAGE_FILE -->

		<div class="download">

			<a href="{PAGE_FILE_URL}">Download : {PAGE_SHORTTITLE} {PAGE_FILE_ICON}</a><br/>
			Size: {PAGE_FILE_SIZE}KB, downloaded {PAGE_FILE_COUNT} times

		</div>

	<!-- END: PAGE_FILE -->
		
				</div>
		
	</div>
	
	</td>
	
	
	<!--right side-->
	<td>
	
	<div id="index_right_box_wrapper">
	
	<div id="index_right_box_bg">

		<div id="index_left_side">
		
		<div id="index_content_title"><h3>Hasonló cikkek</h3></div>
	
	
		
		</div>
	
	
	</div>
	
	
			
	
	</div>
	
	
	
	</div>
	
	</td>

</tr>

</table>



<div id="index_latest">
<div id="index_left_side">	

<div id="index_content_title"><h3>Facebook</h3></div>


{PAGE_UDEF_FACEBOOK_COMMENTS}


</div>
</div>







	</div>
</div>

<!-- END: MAIN -->