<!-- BEGIN: MAIN -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={PHP.cfg.charset}">
<meta http-equiv="Cache-Control" content="no-cache">
<link rel="stylesheet" href="plugins/printversion/tpl/print.css" type="text/css">
<title>{HEADER_TITLE}</title>
</head>
<body bgcolor="#ffffff" alink="#333333" vlink="#333333" link="#333333" topmargin="2" leftmargin="0">
<table cellpadding=4 cellspacing=0 border=0 width=95% bgcolor=#999999 align=center>
<tr>
<td bgcolor=#FFFFFF class=big>
<b>&raquo;{PAGE_TITLE}</b><br>
&raquo;{PAGE_DESC}
<br>&nbsp;&nbsp;{PAGE_TITLEURL}<br>
</tr>
</table>
<br>
<table cellpadding=4 cellspacing=1 border=0 width=95% bgcolor=#999999 align=center>
<tr bgcolor=#FFFFFF class=dats>
<td>
<b>{PHP.L.plu_Author}:</b> {PAGE_AUTHOR}, <b>{PHP.L.plu_Posted}:</b> {PAGE_DATE}.</td>
</tr>
<tr bgcolor=#FFFFFF>
<td class=post>
{PAGE_TEXT}
<!-- BEGIN: PAGE_MULTI -->
{PAGE_MULTI_TABNAV}<br>
{PHP.skinlang.page.Summary}
{PAGE_MULTI_TABTITLES}
<!-- END: PAGE_MULTI -->
</td>
</tr>
<!-- BEGIN: PAGE_FILE -->
<tr>
<td bgcolor=#FFFFFF class=big>
Download: <a href="{PAGE_FILE_URL}">{PAGE_SHORTTITLE} {PAGE_FILE_ICON}</a> 
Size: {PAGE_FILE_SIZE}KB, downloaded {PAGE_FILE_COUNT} times
</td>
</tr>
<!-- END: PAGE_FILE -->
</table>
<br>
</body>
</html>
<!-- END: MAIN -->