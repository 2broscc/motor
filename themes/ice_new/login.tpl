<!-- BEGIN: MAIN -->

<div id="main">


<div id="index_left_side">

<a href="#"><h5>{USERS_AUTH_TITLE}</h5></a>
		
	<form name="login" action="{USERS_AUTH_SEND}" method="post">
	
	

				
				
	<div  id="loginbox">
   
		
	<div style="padding-top:4px;padding-bottom:4px;">
		
	<table>
	
	<tr>
	
	<td align="right">{PHP.skinlang.usersauth.Username}</td>
	
	<td>{USERS_AUTH_USER}</td>
	
	</tr>
	
	<tr>
	
	<td align="right">{PHP.skinlang.usersauth.Password}</td>
	<td>{USERS_AUTH_PASSWORD}</td>
	
	</tr>
	
	
	</table>
		
		
		{PHP.skinlang.usersauth.Rememberme}{PHP.out.guest_cookiettl}<br>
		<input type="submit" value="{PHP.skinlang.usersauth.Login}">
			
		</div> <!--box content padding-->	


    </div>				
				
	</form>
					
	<a href="{USERS_AUTH_REGISTER}">{PHP.skinlang.usersauth.Register}</a> &nbsp; &nbsp;<a href="plug.php?e=passrecover">{PHP.skinlang.usersauth.Lostpassword}</a>
			
	
		
	
		</div>
	
	</div>
	

</div>

<!-- END: MAIN -->