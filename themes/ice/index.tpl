<!-- BEGIN: MAIN -->

<div id="main">


<div><h4>Tags:</h4> {INDEX_TAG_CLOUD} {INDEX_TOP_TAG_CLOUD}</div>

<div id="loading"><div id='facebook' >
             <div id='block_1' class='facebook_block'></div>
             <div id='block_2' class='facebook_block'></div>
             <div id='block_3' class='facebook_block'></div>
</div></div>
				
				
				
				
<div id="news"></div>



	<table class="flat">

		<tr>
			<td style="width:70%; vertical-align:top; padding:0 16px 0 16px;">

			
				
			
			

			<div class="block" style="margin-top:32px;">
				<h4>{PHP.skinlang.index.Newinforums}</h4>
				{PLUGIN_LATESTTOPICS}
			</div>

			<div class="block">
				<h4>{PHP.skinlang.index.Recentadditions}</h4>
				{PLUGIN_LATESTPAGES}
			</div>

			</td>

			<td style="width:30%; vertical-align:top;">

				<div class="block">
					<h4>{PHP.skinlang.index.Online}</h4>
					<a href="plug.php?e=whosonline">{PHP.out.whosonline}</a> :<br />
					{PHP.out.whosonline_reg_list}
				</div>

				<div class="block">
					<h4>{PHP.skinlang.index.Polls}</h4>
					{PLUGIN_LATESTPOLL}
				</div>

				<div class="block">
					<h4>...</h4>
					{PHP.cfg.menu2}<br />
					{PHP.cfg.menu3}<br />
					{PHP.cfg.menu4}
				</div>

			</td>

		</tr>

	</table>

</div>

<!-- END: MAIN -->