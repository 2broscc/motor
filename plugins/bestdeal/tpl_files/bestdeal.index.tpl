<!-- BEGIN: MAIN -->

<!--
<div id="title_bg">
	<div id="title">{PHP.skinlang.bd_Version}</div>
</div>
-->

<div id="subtitle_bg">
	<div id="subtitle">
		{INDEX_INFO_USERPANEL}<br />
		{INDEX_INFO_ADDCAT}
	</div>

</div>


<!-- MAIN CONTENT HOLDER COMES HERE -->
<div id="main">


<!--search-->
<div style="padding-top:5px;">
<div id="wbox_top">
	<div id="menupadding"><h5>{PHP.skinlang.bd_kereses}</h5></div>
</div>

<div id="wbox_mid">

	<div id="content_pos">
		<div id="kereses">{INDEX_INFO_SEARCH}</div>
	</div>
	
</div> 
<div id="wbox_bot"></div>
</div>
<!--search end-->
	
	
<!-- table -->
<table border="0">
<tr>


<td> 	
<!--left side content and bg holder-->
<div id="l_holder">

	<div id="lbox_top">
		<div id="menupadding"><h5>{PHP.skinlang.bd_menu}</h5></div>
	</div>

		<div id="lbox_mid">
			<div id="lbox_c_holder">
			{INDEX_INFO_CATS}
			</div>
		</div>
	
	<div id="lbox_bot"></div>

</div>
<!--left side content and bg holder-->

</td>

<td> <!--content center-->
<div id="holder">
	<div id="cbox_top"></div>
	<div id="cbox_mid">

		<div id="content_pos">
		
		
		<div align="center">
			<div id="ad">
			{INDEX_ADVERT}
			</div>
							
			<div id="akciok">{INDEX_AKCIOK}</div>
		
		</div>
	
			<!-- BEGIN: INDEX_INFO_LASTINHEADCATS -->
<div id="last_in_headcats">
	<div id="content_pos">
		
		<h3>{VIEW_CAT_INFO_NAME}</h3>
		<!-- BEGIN: ROW -->
		<br>
		<a href="plug.php?e=bestdeal&amp;id={VIEW_ITEM_INFO_ID}">{VIEW_ITEM_INFO_NAME}</a>
		<br>
		{VIEW_ITEM_INFO_PRICE}
		<!-- END: ROW -->
	
	</div>

</div>
<!-- END: INDEX_INFO_LASTINHEADCATS -->
	
		</div>
		
	
	
	
	</div>
	<div id="cbox_bot"></div>
</div>
</td><!--content center-->

<td> 	<!-- Right box TD -->

<div id="r_holder">


<!--PARTNERS-->
<div id="r_box_pos">
<div id="rbox_top">

	<div id="content_pos">
		<div id="newstitle">RidersGear</div>
	</div>

</div>
</div>

<div id="rbox_mid">

	<div id="r_box_content">
		<div align="center">{INDEX_AD6}</div>
		<div style="padding-top:4px;" align="center">{INDEX_AD7}</div>

	</div>
</div>


</div>
<div id="rbox_bot"></div>
<!--PARTNERS-->

<div id="r_box_pos">
<div id="rbox_top">

	<div id="content_pos">
		<div id="newstitle">Ride Cast</div>
	</div>

</div>
</div>
<div id="rbox_mid">

	<div id="r_box_content">{PLUGIN_LATESTRIDECAST}</div>


</div>
<div id="rbox_bot"></div>




</td>



</tr>

</table> 

<!-- table -->

	
	</div> <!--main end-->


<!-- END: MAIN -->