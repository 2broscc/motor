<!-- BEGIN: MAIN -->

<div id="title">

	{USERS_REGISTER_TITLE}

</div>

<div id="subtitle">

	{USERS_REGISTER_SUBTITLE}

</div>

<!-- BEGIN: USERS_REGISTER_ERROR -->

<div class="error">

	{USERS_REGISTER_ERROR_BODY}

</div>

<!-- END: USERS_REGISTER_ERROR -->

<div id="main">

<form name="login" action="{USERS_REGISTER_SEND}" method="post">

<table class="cells">

		<tr>
			<td style="width:176px;">{PHP.skinlang.usersregister.Username}</td>
			<td>{USERS_REGISTER_USER} *</td>
		</tr>
		<tr>
			<td>{PHP.skinlang.usersregister.Validemail}</td>
			<td>{USERS_REGISTER_EMAIL} *<br />
			{PHP.skinlang.usersregister.Validemailhint}</td>
		</tr>
		<tr>
			<td>{PHP.skinlang.usersregister.Password}</td>
			<td>{USERS_REGISTER_PASSWORD} *</td>
		</tr>
		<tr>
			<td>{PHP.skinlang.usersregister.Confirmpassword}</td>
			<td>{USERS_REGISTER_PASSWORDREPEAT} *</td>
		</tr>
		<tr>
			<td>{PHP.skinlang.usersregister.Country}</td>
			<td>{USERS_REGISTER_COUNTRY}</td>
		</tr>
		<tr>
			<td colspan="2">{PHP.skinlang.usersregister.Formhint}
			</td>
		</tr>
		<tr>
			<td colspan="2" class="valid">
			<input type="submit" value="{PHP.skinlang.usersregister.Submit}"></td>
		</tr>

</table>

</form>

</div>

<!-- END: MAIN -->
