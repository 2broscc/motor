<!-- BEGIN: MAIN -->
<link rel="stylesheet" type="text/css" href="plugins/bestdeal/tpl_files/styles.css" />

<div id="main">


	<div id="wbox_top">
			
				<div id="menupadding">
					<a href="#"><h5>{PHP.skinlang.admin.menu}</h5></a>
				</div>
			
	</div>

	<div id="wbox_mid">
					
					<div id="content_pos">
					
{VIEW_ITEM_USERPANEL}
{VIEW_ITEM_SHORTDESC}
{VIEW_ITEM_CATS}
<div>
{VIEW_ITEM_NAME} {PHP.skinlang.bd_Info}
{PHP.skinlang.bd_Views}{VIEW_ITEM_HITS}

</div>

   		
 <div id="view_item_actions">{VIEW_ITEM_ACTIONS}</div>
					
					</div>
	
	</div> 


	<div id="wbox_bot"></div>



<div id="holder">
<table>
<tr>
<!--left side box-->
<td>

	<div>
		<div id="lbox_top"></div>
		<div id="lbox_mid">
		
		
			<div style="padding-left:5px;padding-right:5px;">
			
				<div>{PHP.skinlang.bd_Price1}<h5>{VIEW_ITEM_PRICE}</h5></div>
		
				<div align="left">
			
				<h4>{PHP.skinlang.bd_Advertizer}</h4><br>
				{VIEW_ITEM_CONTACT}<br>
				{PHP.skinlang.bd_Advertizer} {VIEW_ITEM_USER}<br>
				{PHP.skinlang.bd_Phone1}{VIEW_ITEM_PHONE}<br>
				{PHP.skinlang.bd_Town}{VIEW_ITEM_LOCATION}

				</div>
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
	<div style="padding-top:4px;">
					<div id="menupadding"><h5>{VIEW_ITEM_NAME} - {PHP.skinlang.bd_Obdet}</h5></div>
				</div>
		</div>
		<div id="pagewidebox_mid">
		
		<div id="page_widebox_contentpos">

		
				
			
			
<div id="object_details">

	{VIEW_ITEM_DETAILS}

</div>

<div id="view_item_bids">
<!-- BEGIN: VIEW_ITEM_BIDS -->
<h4>{PHP.skinlang.bd_BidonOb}</h4><br>
{VIEW_ITEM_BIDS}
<!-- END: VIEW_ITEM_BIDS -->
</div>		
					
		</div>
	</div>
		
		
		
<div id="pagewidebox_bot"></div>


</td>
<!--right side box-->


</tr>

</table>


</div> <!-- wbox holder -->



</div>  <!--holder-->

<!-- END: MAIN -->

<!--unsused : {PHP.skinlang.bd_Datesub}{VIEW_ITEM_ADDDATE} | {PHP.skinlang.bd_Lastchanged}{VIEW_ITEM_EDITDATE}-->
