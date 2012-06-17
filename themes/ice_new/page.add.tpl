<!-- BEGIN: MAIN -->
<div id="main_bg">
	<div id="main_postion">


<a href="#"><h5>{PAGEADD_PAGETITLE} {PAGEADD_SUBTITLE}</h5></a>
	
<!-- BEGIN: PAGEADD_ERROR -->

<div class="error">

		{PAGEADD_ERROR_BODY}

</div>

<!-- END: PAGEADD_ERROR -->

<div id="form_holder">

<form action="{PAGEADD_FORM_SEND}" method="post" name="newpage">

<div id="">

{PHP.skinlang.pageadd.Category}
{PAGEADD_FORM_CAT}
</div>


<div id="">
{PHP.skinlang.pageadd.Title}
{PAGEADD_FORM_TITLE}
</div>

<div id="">
{PHP.skinlang.pageadd.Description}
{PAGEADD_FORM_DESC}
</div>


<div id="">
{PHP.skinlang.pageadd.Author}
{PAGEADD_FORM_AUTHOR}
</div>

<div id="">

{PHP.skinlang.pageadd.Extrakey}
{PAGEADD_FORM_KEY}

</div>

<div id="">
{PHP.skinlang.pageadd.Extrakey}
{PAGEADD_FORM_KEY}
</div>



<div id="">
{PHP.skinlang.pageadd.Alias}
{PAGEADD_FORM_ALIAS}
</div>

<div id="">
{PHP.skinlang.pageadd.Owner}
{PAGEADD_FORM_OWNER}
</div>


<div id="">
{PHP.skinlang.pageadd.Begin}
{PAGEADD_FORM_BEGIN}

</div>


<div id="">
{PHP.skinlang.pageadd.Expire}
{PAGEADD_FORM_EXPIRE}
</div>



<div id="">
Kép
{PAGEADD_FORM_EXTRA6}
</div>

<div id="">
{PHP.skinlang.pageadd.Bodyofthepage}
{PAGEADD_FORM_TEXTBOXER}
</div>


<div id="">
Stuff
{PAGEADD_FORM_EXTRA7}
</div>


<div id="">
{PHP.skinlang.pageadd.File}
{PHP.skinlang.pageadd.Filehint}
{PAGEADD_FORM_FILE}
</div>

<div id="">

{PHP.skinlang.pageadd.URL}
{PHP.skinlang.pageadd.URLhint}
{PAGEADD_FORM_URL}


</div>


<div id="">

{PHP.skinlang.pageadd.Filesize}
{PHP.skinlang.pageadd.Filesizehint}
{PAGEADD_FORM_SIZE}

</div>


<div id="">
Tags
{PAGEADD_FORM_TAGS},{PAGEADD_TOP_TAGS},{PAGEADD_TOP_TAGS_HINT}
</div>


<div id="">{PHP.skinlang.pageadd.Formhint}</div>

<input type="submit" value="{PHP.skinlang.pageadd.Submit}">

</form>

	</div>
</div> 
<!-- END: MAIN -->