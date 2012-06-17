<!-- BEGIN: MAIN -->

<div  id="infopanel_container">

<div id="page_title">

	{PHP.skinlang.bd_Changeitem}

</div>

<!-- BEGIN: EDITITEM_ERROR -->

<div class="error">

	{EDIT_ITEM_ERROR_BODY}

</div>

<!-- END: EDITITEM_ERROR -->

<div id="infopanel_bottom">
<div align=right style="padding-top:5px;padding-right:14px;">{PAGE_EMAIL_ME} {PAGE_PRINT}</div>
</div> <!--infopanel end-->

<div id="main">

<div style="padding-left:10px;padding-right:2px;">

<form action="{EDIT_ITEM_FORM_SEND}" enctype="multipart/form-data" method="post" name="edit_item">
<!-- BEGIN: EDITITEM_ADMIN -->
<div style="padding-top:5px;">

<table class="cells">
	<tr>
	<td colspan="2" class="coltop">{PHP.skinlang.bd_Changeitem1}</td>
	</tr>
    <tr>
    <td>{PHP.skinlang.bd_Cat}</td>
    <td>{EDIT_ITEM_FORM_CAT_ID}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_KindObject}</td>
    <td>{EDIT_ITEM_FORM_MODE}</td>
    </tr>

</table>
</div>
<!-- END: EDITITEM_ADMIN -->
<!-- BEGIN: EDITITEM_USER -->
<div style="padding-top:5px;">
<table class="cells">
	<tr>
	<td class="coltop">{PHP.skinlang.bd_Objectstat}</td>
	</tr>
    <tr>
    <td>{EDIT_ITEM_FORM_STARTDATE} <br />
<br />
( {PHP.skinlang.bd_After} {EDIT_ITEM_FORM_STATELENGTH} {PHP.skinlang.bd_Monthsreact} )</td>
    </tr>
</table>
</div>

<div style="padding-top:5px;">
<table class="cells">
	<tr>
	<td colspan="2" class="coltop">{PHP.skinlang.bd_Changeitem}</td>
	</tr>
    <tr>
    <td>{PHP.skinlang.bd_Photo}</td>
    <td>{EDIT_ITEM_FORM_PHOTO}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Objectname}</td>
    <td>{EDIT_ITEM_FORM_NAME}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Itemsub}</td>
    <td>{EDIT_ITEM_FORM_SHORTDESC}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Details}</td>
    <td>{EDIT_ITEM_FORM_DETAILS}<br />
{ADD_ITEM_FORM_BBCODES} {ADD_ITEM_FORM_SMILIES} {ADD_ITEM_FORM_MYPFS}</td>
    </tr>

    <tr>
    <td>{PHP.skinlang.bd_Price}</td>
    <td>{EDIT_ITEM_FORM_PRICE}<br />
<b>{PHP.skinlang.bd_Amount}</b> {PHP.skinlang.bd_Valuta} | <b>F</b> = {PHP.skinlang.bd_F} | <b>N</b> = {PHP.skinlang.bd_N}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Keepmeupdated}</td>
    <td>{EDIT_ITEM_FORM_MAILPM}</td>
    </tr>

    <tr>
    <td>{PHP.skinlang.bd_Town}</td>
    <td>{EDIT_ITEM_FORM_LOCATION}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Phone}</td>
    <td>{EDIT_ITEM_FORM_PHONE}</td>
    </tr>
	<tr>
    <td colspan="2">{PHP.skinlang.bd_Catreq}</td>
    </tr>
	<tr>
		<td colspan="2" class="valid">
<input type="submit" name="submit" id="submit" value="{PHP.L.Submit}">
		</td>
    </tr>
</table>
</div>


{EDIT_ITEM_FORM_BIDS}
<!-- END: EDITITEM_USER -->
</form>


</div> <!--main alignment-->

</div> <!--main end-->

<div id="footer_forummainend"></div>

<!-- END: MAIN -->