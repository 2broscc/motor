<!--
mobile version of the engine
--->

<!-- BEGIN: MAIN -->

<div id="menu">

<a href="index.php?m=mobile" >Index</a>
<a href="mobile.php?m=login" >Login</a>
<a href="mobile.php?m=logout" >Logout</a>


</div>

<div id="main">

<h2>Mobile version alpha!</h2>

<div><h4>Tags:</h4> {INDEX_TAG_CLOUD} {INDEX_TOP_TAG_CLOUD}</div>

<div id="loading"><div id='facebook' >
             <div id='block_1' class='facebook_block'></div>
             <div id='block_2' class='facebook_block'></div>
             <div id='block_3' class='facebook_block'></div>
</div></div>
				
		
<div id="news"></div>

		<div class="block">
				<h4>{PHP.skinlang.index.Recentadditions}</h4>
				{PLUGIN_PAGES}
			</div>
			
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

	

</div>
<!-- END: MAIN -->