<!-- BEGIN: MAIN -->

<div id="title">

	{SEND_MAIL_TITLE}

</div>

<div id="subtitle">

	{SEND_MAIL_SUBTITLE} &nbsp;

</div>

<div id="main">

<!-- BEGIN: SEND_MAIL_ERROR -->

<div class="error">

		{SEND_MAIL_ERROR_BODY}

</div>

<!-- END: SEND_MAIL_ERROR -->

<form action="{SEND_MAIL_FORM_SEND}" method="post" name="newmail">

<table class="cells">

	<tr>
		<td style="width:176px;">{PHP.skinlang.bd_Reciever} :
		</td>
		<td>{SEND_MAIL_FORM_TOUSER}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.bd_Subjectmail} :</td>
		<td>{SEND_MAIL_FORM_TITLE}</td>
	</tr>

	<tr>
		<td>{PHP.skinlang.bd_Details}</td>
		<td><div style="width:96%;">{SEND_MAIL_FORM_TEXTBOXER}</div>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="valid">
		<input type="submit" value="{PHP.L.Submit}">
		</td>
	</tr>

</table>

</form>

</div>

<!-- END: MAIN -->