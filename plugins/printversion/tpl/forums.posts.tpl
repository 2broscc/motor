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
<b>&raquo;{FORUMS_POSTS_FORUMTITLE}</b>
<br>&nbsp;&nbsp;{FORUMS_POSTS_FORUMTITLEURL}<br>
<b>&raquo;{FORUMS_POSTS_CATEGORYTITLE}</b>
<br>&nbsp;&nbsp;{FORUMS_POSTS_CATEGORYTITLEURL}<br>
<b>&raquo;{FORUMS_POSTS_SECTIONTITLE}</b>
<br>&nbsp;&nbsp;{FORUMS_POSTS_SECTIONTITLEURL}<br>
<b>&raquo;{FORUMS_POSTS_TOPICTITLE}</b>
<br>&nbsp;&nbsp;{FORUMS_POSTS_TOPICTITLEURL}
</tr>
</table>
<br>
<table cellpadding=4 cellspacing=1 border=0 width=95% bgcolor=#999999 align=center>
<!-- BEGIN: FORUMS_POSTS_ROW -->
<tr bgcolor=#FFFFFF class=dats>
<td>
<b>{PHP.L.plu_Author}:</b> {FORUMS_POSTS_ROW_POSTERNAME}, <b>{PHP.L.plu_Posted}:</b> {FORUMS_POSTS_ROW_CREATION}. {FORUMS_POSTS_ROW_UPDATEDBY}</td>
</tr>
<tr bgcolor=#FFFFFF>
<td class=post>
{FORUMS_POSTS_ROW_TEXT}</td>
</tr>
<!-- END: FORUMS_POSTS_ROW -->
</table>
<br>
<table width=95% align=center class=dats><tr><td><a href="http://www.neocrome.net">Powered by Seditio</a></td><td style="text-align:right"><a href="http://almaz.freehostia.com">Print version</a></td></tr></table>
</body>
</html>
<!-- END: MAIN -->