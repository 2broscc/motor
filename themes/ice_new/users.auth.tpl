<!-- BEGIN: MAIN -->

<div id="title">

	{USERS_AUTH_TITLE}

</div>

<div id="main">

<div class="block" style="padding:32px; text-align:center;">

     <form name="login" action="{USERS_AUTH_SEND}" method="post">
		<p>{PHP.skinlang.usersauth.Username} {USERS_AUTH_USER}</p>
		<p>{PHP.skinlang.usersauth.Password} {USERS_AUTH_PASSWORD}</p>
		<p>{PHP.skinlang.usersauth.Rememberme} &nbsp;  {PHP.out.guest_cookiettl} &nbsp; <input type="submit" value="{PHP.skinlang.usersauth.Login}"></p>
     </form>

</div>

<div class="block" style="padding:32px; text-align:center;">

		<a href="{USERS_AUTH_REGISTER}">{PHP.skinlang.usersauth.Register}</a> &nbsp; &nbsp;
		<a href="plug.php?e=passrecover">{PHP.skinlang.usersauth.Lostpassword}</a>

</div>

</div>

<!-- END: MAIN -->