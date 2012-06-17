<!-- BEGIN: MAIN -->

<div id="title">

	{PAGEADD_PAGETITLE}

</div>

<div id="subtitle">

	{PAGEADD_SUBTITLE}

</div>

<div id="main">

<!-- BEGIN: PAGEADD_ERROR -->

<div class="error">

		{PAGEADD_ERROR_BODY}

</div>

<!-- END: PAGEADD_ERROR -->

<form action="{PAGEADD_FORM_SEND}" method="post" name="newpage">

<table class="cells">

	<tr>
		<td style="width:176px;">{PHP.skinlang.pageadd.Category}</td>
		<td>{PAGEADD_FORM_CAT}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Title}</td>
		<td>{PAGEADD_FORM_TITLE}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Description}</td>
		<td>{PAGEADD_FORM_DESC}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Author}</td>
		<td>{PAGEADD_FORM_AUTHOR}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Extrakey}</td>
		<td>{PAGEADD_FORM_KEY}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Alias}</td>
		<td>{PAGEADD_FORM_ALIAS}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Owner}</td>
		<td>{PAGEADD_FORM_OWNER}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Begin}</td>
		<td>{PAGEADD_FORM_BEGIN}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Expire}</td>
		<td>{PAGEADD_FORM_EXPIRE}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Bodyofthepage}</td>
		<td><div style="width:96%;">{PAGEADD_FORM_TEXTBOXER}</div></td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.File}<br />
		{PHP.skinlang.pageadd.Filehint}</td>
		<td>{PAGEADD_FORM_FILE}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.URL}<br />
		{PHP.skinlang.pageadd.URLhint}</td>
		<td>{PAGEADD_FORM_URL}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.pageadd.Filesize}<br />
		{PHP.skinlang.pageadd.Filesizehint}</td>
		<td>{PAGEADD_FORM_SIZE}</td>
	</tr>
	
	<p>{PAGEADD_FORM_TAGS}{PAGEADD_TOP_TAGS}{PAGEADD_TOP_TAGS_HINT}</p>

	<tr>
		<td colspan="2">{PHP.skinlang.pageadd.Formhint}</td>
	</tr>

	<tr>
		<td colspan="2" class="valid">
		<input type="submit" value="{PHP.skinlang.pageadd.Submit}">
		</td>
	</tr>

</table>

</form>

</div>

<!-- END: MAIN -->