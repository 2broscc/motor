<!-- BEGIN: HEADER -->
{HEADER_DOCTYPE}
<html>
<head>
{HEADER_METAS}
{HEADER_COMPOPUP}
<title>{HEADER_TITLE}</title>

<link href="themes/{PHP.skin}/{PHP.skin}.css" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" href="nivo/themes/default/default.css" type="text/css" media="screen" />

    <link rel="stylesheet" href="nivo/nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="nivo/demo/style.css" type="text/css" media="screen" />
	
	
<script type="text/javascript" src="{HEADER_UDEF_JS_DIR}/jquery.js"></script>
<script type="text/javascript" src="{HEADER_UDEF_JS_DIR}/functions.js"></script> 

<script type="text/javascript" src="datas/carousel/lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="datas/carousel/skins/tango/skin.css" />

<!--loader-->

<script type="text/javascript">

$(document).ready(function() {
		
/**
Display Loading Image
*/

function Display_Load() {
	   
	$("#loading").fadeIn(900,0);
	$("#loading").html("<img src='loading.gif' alt='loading' />");
	
}

/**
Hide Loading Image
*/

function Hide_Load() {
	
		$("#loading").fadeOut('slow');
};
	

/**
Default Starting Page Results
*/
   
	
	Display_Load();
	
	$("#latest_news_holder").load("loader.php", Hide_Load());
	

});



</script>

{HEADER_UDEF_FACEBOOK_API}


</head>

<body>

<table style="width:100%;">
<tr>
<td width="25%"></td>
<td>


<div id="container">

<div id="header">

	<div align="right"><div id="nav_holder"><div id="nav">{PHP.cfg.menu1}</div></div></div>

</div>


<div id="topper"></div><!--menu separator-->

<div id="main">
<div id="index_left_side">
<div id="login_user_menu_bg">
<div id="index_left_side">

<script type="text/javascript">/*<![CDATA[*/ document.write('<div id="infopanel_mini" style="display: ' + ((videolist_top_video.GetItem('infopanel') == 1) ? 'block' : 'none') + '">'); /*]]>*/</script>
	
			<div id="infopanel_mini">
				
				
				<p>A tartalom el van rejve.</p>
			
			
				
			
			<script type="text/javascript">/*<![CDATA[*/ document.write('<\/div>'); /*]]>*/</script>
		
			</div> <!--mini-->
	
			<script type="text/javascript">/*<![CDATA[*/ document.write('<div id="infopanel" style="display: ' + ((videolist_top_video.GetItem('infopanel') == 1) ? 'none' : 'block') + '">'); /*]]>*/</script>
	
			<div id="infopanel">
			
			<div style="padding-top:10px;" align="center">
				
								
									<div style="padding-bottom:5px;" align="center">
					
					
		<div id="nav">

			<!-- BEGIN: USER -->

			<ul>
				<li>{HEADER_NOTICES}</li>
				<li>{HEADER_LOGSTATUS}</li>
				<li>{HEADER_USER_ADMINPANEL}</li>
				<li>{HEADER_USERLIST}</li>
				<li>{HEADER_USER_PROFILE}</li>
				<li>{HEADER_USER_PFS}</li>
				<li>{HEADER_USER_PMREMINDER}</li>
				<li>{HEADER_USER_LOGINOUT}</li>

			</ul>	

			<!-- END: USER -->

			<!-- BEGIN: GUEST -->

			<ul>
				<li><a href="login.php">{PHP.skinlang.header.Login}</a></li>
				<li><a href="signup.php">{PHP.skinlang.header.Register}</a></li>
				<li><a href="plug.php?e=passrecover">{PHP.skinlang.header.Lostyourpassword}</a></li>
			</ul>
			<!-- END: GUEST -->
		</div>
				
				
		</div>
								
			</div>
				
				</div> <!--infopanel-->
			<script type="text/javascript">/*<![CDATA[*/ document.write('<\/div>'); /*]]>*/</script>
			<div id="toggle">
				<a id="togglebutton" href="#" onclick="return hide('infopanel',this)" title="Elrejt/Megjelenít">x</a>
			</div>


</div>
</div>
</div>
</div>





<!-- END: HEADER -->
