<!-- BEGIN: MAIN -->
<div id="title">{INDEX_TITLE}</div>
<div id="subtitle">{INDEX_SUBTITLE}</div>

<div id="main">
<!-- BEGIN: ERROR -->
<div class="error">{ERROR_STRING}</div>
<!-- END: ERROR -->

<!-- BEGIN: DIRS -->
<table class="cells">
	<tr>
		<td class="coltop">{PHP.L.index_name}</td>
		<td class="coltop">{PHP.L.index_timemod}</td>
	</tr>
<!-- BEGIN: ROW -->
	<tr>
		<td class="{DIR_ROW_ODDEVEN}">{DIR_ROW_ICON} <a href="{DIR_ROW_URL}">{DIR_ROW_NAME}</a></td>
		<td class="{DIR_ROW_ODDEVEN}">{DIR_ROW_LAST_MODIFIED}</td>
	</tr>
<!-- END: ROW -->
</table>
<br />
<br />
<!-- END: DIRS -->

<!-- BEGIN: FILES -->
<table class="cells">
	<tr>
		<td class="coltop">{PHP.L.index_name}</td>
		<td class="coltop">{PHP.L.index_size}</td>
		<!--<td class="coltop">{PHP.L.index_version}</td> T3 Example-->
		<td class="coltop">{PHP.L.index_timemod}</td>
	</tr>
<!-- BEGIN: ROW -->
	<tr>
		<td class="{FILE_ROW_ODDEVEN}">{FILE_ROW_ICON} <a href="{FILE_ROW_URL}">{FILE_ROW_NAME}</a></td>
		<td class="{FILE_ROW_ODDEVEN}">{FILE_ROW_SIZE}</td>
		<!--<td class="{FILE_ROW_ODDEVEN}">{FILE_ROW_VERSION}</td> T3 Example-->
		<td class="{FILE_ROW_ODDEVEN}">{FILE_ROW_LAST_MODIFIED}</td>
	</tr>
<!-- END: ROW -->
</table>
<!-- END: FILES -->
<div class="paging" style="color:#739E48; font-weight:bold; text-align:right;">{LEECH_PROTECTION}  {INDEX_FOLDER_STATS}</div>

</div>

<!-- END: MAIN -->