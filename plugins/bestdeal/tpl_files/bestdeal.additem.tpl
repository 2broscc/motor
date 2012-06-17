<!-- BEGIN: MAIN -->


<div id="title">

	{PHP.skinlang.bd_Objectsub} {ADD_ITEM_FORM_CAT_TITLE}

</div>

<!-- BEGIN: ADDITEM_ERROR -->

<div class="error">

	{ADD_ITEM_ERROR_BODY}

</div>

<!-- END: ADDITEM_ERROR -->

<div id="main">

<form action="{ADD_ITEM_FORM_SEND}" enctype="multipart/form-data" method="post" name="add_item">

<table class="cells">
	<tr>
	<td colspan="2" class="coltop">{PHP.skinlang.bd_Objectsub1}</td>
	</tr>
    <tr>
    <td>{PHP.skinlang.bd_Cat}</td>
    <td>{ADD_ITEM_FORM_CAT_ID}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_KindObject}</td>
    <td>{ADD_ITEM_FORM_MODE}</td>
    </tr>
     <tr>
    <td></td>
    <td>{ADD_ITEM_FORM_STARTDATE} ( {PHP.skinlang.bd_After} {ADD_ITEM_FORM_STATELENGTH} {PHP.skinlang.bd_Monthsreact} )</td>
    </tr>
</table>

<table class="cells">
	<tr>
	<td colspan="2" class="coltop">{PHP.skinlang.bd_Objectsub}</td>
	</tr>
    <tr>
    <td>{PHP.skinlang.bd_Photo}</td>
    <td>{ADD_ITEM_FORM_PHOTO}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Objectname}</td>
    <td>{ADD_ITEM_FORM_NAME}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Catsub}</td>
    <td>{ADD_ITEM_FORM_SHORTDESC}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Details}</td>
    <td>{ADD_ITEM_FORM_DETAILS}<br />
{ADD_ITEM_FORM_BBCODES} {ADD_ITEM_FORM_SMILIES} {ADD_ITEM_FORM_MYPFS}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Price}</td>
    <td>{ADD_ITEM_FORM_PRICE}<br />
<b>{PHP.skinlang.bd_Amount}</b> {PHP.skinlang.bd_Valuta} | <b>F</b> = {PHP.skinlang.bd_F} | <b>N</b> = {PHP.skinlang.bd_N}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Keepmeupdated}</td>
    <td>{ADD_ITEM_FORM_MAILPM}</td>
    </tr>

    <tr>
    <td>{PHP.skinlang.bd_Town}</td>
    <td>{ADD_ITEM_FORM_LOCATION}</td>
    </tr>
    <tr>
    <td>{PHP.skinlang.bd_Phone}</td>
    <td>{ADD_ITEM_FORM_PHONE}</td>
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

</form>

</div>

<!-- END: MAIN -->