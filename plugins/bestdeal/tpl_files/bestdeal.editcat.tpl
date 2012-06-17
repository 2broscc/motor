<!-- BEGIN: MAIN -->

<div id="title">

{PHP.skinlang.bd_Changecat} {EDIT_CAT_FORM_TITLE}

</div>

<div id="subtitle">

</div>

<div id="main">

<!-- BEGIN: EDITCAT_ERROR -->

<div class="error">

	{EDIT_CAT_ERROR_BODY}

</div>

<!-- END: EDITCAT_ERROR -->


<form action="{EDIT_CAT_FORM_SEND}" method="post" name="edit_cat">
<table class="cells">
	<tr>
	<td colspan="2" class="coltop">{PHP.skinlang.bd_Changecat} {EDIT_CAT_FORM_TITLE}</td>
	</tr>
    <tr>
    <td>{PHP.skinlang.bd_Catname}</td>
    <td>{EDIT_CAT_FORM_NAME}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Catsub}</td>
    <td>{EDIT_CAT_FORM_SHORTDESC}<br />
{EDIT_CAT_FORM_BBCODES} {EDIT_CAT_FORM_SMILIES} {EDIT_CAT_FORM_MYPFS}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Catlevel}</td>
    <td>{EDIT_CAT_FORM_LEVEL}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Catmodus}</td>
    <td>{EDIT_CAT_FORM_FMODE}</td>
    </tr>
     <tr>
    <td>{PHP.skinlang.bd_Catdel}</td>
    <td>{EDIT_CAT_FORM_DELETE} ( {PHP.skinlang.bd_Catdelnote} )</td>
    </tr>
    <tr>
    <td colspan="2">{PHP.skinlang.bd_Catreq}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Catreactivate}</td>
    <td>{EDIT_CAT_FORM_TIMEBEFOREREACT}</td>
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