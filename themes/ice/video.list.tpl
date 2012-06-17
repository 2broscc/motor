<!--

Filename: video.list.tpl
RidelineMTB V2 skin
Copyright  2bros cc
Date:02-19-2011
Programmer: Peter Magyar
Email:ridelineonline@gmail.com
http://2bros.atw.hu

-->

<!-- BEGIN: MAIN -->


<div id="main">



<div id="wbox_top">
			
				<div id="menupadding">
					<a href="#"><h5>{LIST_PAGETITLE}</h5></a>
				</div>
			
	</div>

<div id="wbox_mid">
					
		<div id="content_pos">
		
			<div id="videolist_top_video">
			
			
			
			<script type="text/javascript">/*<![CDATA[*/ document.write('<div id="infopanel_mini" style="display: ' + ((videolist_top_video.GetItem('infopanel') == 1) ? 'block' : 'none') + '">'); /*]]>*/</script>
	
			<div id="infopanel_mini">
				
				
				<div style="padding-top:5px;padding-left:10px;padding-bottom:10px;"><h2>{PHP.skinlang.videolist.videolisttopvideo}</h2></div>
			
				<div style="padding-bottom:5px;" align="center">
					{LIST_UDEF_VIDEO}
				</div>
				
			
			<script type="text/javascript">/*<![CDATA[*/ document.write('<\/div>'); /*]]>*/</script>
		
			</div> <!--mini-->
	
			<script type="text/javascript">/*<![CDATA[*/ document.write('<div id="infopanel" style="display: ' + ((videolist_top_video.GetItem('infopanel') == 1) ? 'none' : 'block') + '">'); /*]]>*/</script>
	
			<div id="infopanel">
			
			<div style="padding-top:10px;" align="center">
				<h4>Jelenleg a kiemelt videó el van rejtve!</h4>
			</div>
				
				</div> <!--infopanel-->
			<script type="text/javascript">/*<![CDATA[*/ document.write('<\/div>'); /*]]>*/</script>
			<div id="toggle">
				<a id="togglebutton" href="#" onclick="return hide('infopanel',this)" title="Elrejt/Megjelenít">x</a>
			</div>
	
		</div> <!--videolist_top_video-->
			
			

	<div style="padding-top:5px;">
		
		<div id="page_light">
						
		
		
		<div>{LIST_CATDESC}  {LIST_SUBMITNEWPAGE}</div>
				
		<div align="right" style="padding-top:6px;padding-right:12px;">
		
			{LIST_TOP_PAGEPREV} {LIST_TOP_PAGENEXT} &nbsp; {PHP.skinlang.list.Page} {LIST_TOP_CURRENTPAGE}/ {LIST_TOP_TOTALPAGES} - {LIST_TOP_MAXPERPAGE} {PHP.skinlang.list.linesperpage} - {LIST_TOP_TOTALLINES} {PHP.skinlang.list.linesinthissection}
						
		</div>
		
				
		<table class="cells">

		<!-- BEGIN: LIST_ROWCAT -->

		<tr>
			<td colspan="5" style="background:transparent;">
			<strong><a href="video.php?m=videolist">{LIST_ROWCAT_TITLE} ...</a></strong><br />
			<span class="desc">{LIST_ROWCAT_DESC}</span>
			</td>
		</tr>

		<!-- END: LIST_ROWCAT -->

		<tr>
			<td class="coltop">&nbsp;</td>
			<td class="coltop">{LIST_TOP_TITLE} {LIST_TOP_COUNT}</td>
			<td class="coltop" style="width:96px;">{PHP.skinlang.list.Comments}</td>
			<td class="coltop" style="width:96px;">{PHP.skinlang.list.Ratings}</td>
			<td class="coltop" style="width:96px;">{LIST_TOP_DATE}</td>
		</tr>

		<!-- BEGIN: LIST_ROW -->

		<tr>
			<td width="116">
			<span class="desc">{LIST_ROW_DESC}</span></td>

			<td>
			<strong><a href="video.php?id={LIST_ROW_ID}">{LIST_ROW_TITLE}</a></strong> {LIST_ROW_FILEICON}<br />
			<span class="desc">&nbsp;({LIST_ROW_COUNT} {PHP.skinlang.list.hits})</span>
			</td>

			<td class="centerall">{LIST_ROW_COMMENTS}</td>
			<td class="centerall">{LIST_ROW_RATINGS}</td>
			<td class="centerall">{LIST_ROW_DATE}</td>
			</td>

		</tr>

	<!-- END: LIST_ROW -->

	</table>

	<div class="paging">

		{LIST_TOP_PAGEPREV} {LIST_TOP_PAGENEXT} &nbsp; {PHP.skinlang.list.Page} {LIST_TOP_CURRENTPAGE}/ {LIST_TOP_TOTALPAGES} - {LIST_TOP_MAXPERPAGE} {PHP.skinlang.list.linesperpage} - {LIST_TOP_TOTALLINES} {PHP.skinlang.list.linesinthissection}

	</div>
</div>
						
						</div>
		</div>
					
					
					
		</div>
	
	</div> 


	<div id="wbox_bot"></div>
	
</div>


<!-- END: MAIN -->