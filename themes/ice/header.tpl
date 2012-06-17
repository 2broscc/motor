<!-- BEGIN: HEADER -->
{HEADER_DOCTYPE}
<html>
<head>
{HEADER_METAS}
{HEADER_COMPOPUP}
<title>{HEADER_TITLE}</title>

<link href="themes/{PHP.skin}/{PHP.skin}.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="{HEADER_UDEF_JS_DIR}/jquery.js"></script>
<script type="text/javascript" src="{HEADER_UDEF_JS_DIR}/loader.js"></script>
<script type="text/javascript" src="{HEADER_UDEF_JS_DIR}/functions.js"></script>

<script type="text/javascript">

</script>

</head>

<body>

<table style="width:100%;">
<tr>
<td width="25%"></td>
<td>


<div id="container">
	
	<div id="header">

	<a href="index.php"></a>

	</div>

<div id="nav">

	{PHP.cfg.menu1}

</div>

<div id="user">

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
<!-- END: HEADER -->
