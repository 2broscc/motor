<!-- BEGIN: MAIN -->

<div id="title">

	{FORUMS_TOPICS_PAGETITLE}

</div>

<div id="subtitle">

	{FORUMS_TOPICS_SUBTITLE}<br />
	{PHP.skinlang.forumstopics.Viewers} : {FORUMS_TOPICS_VIEWERS}
</div>

<div id="main">

<div class="paging">

	{FORUMS_TOPICS_JUMPBOX} {FORUMS_TOPICS_PAGES} {FORUMS_TOPICS_PAGEPREV} {FORUMS_TOPICS_PAGENEXT}

</div>

<div class="disp">

     <a href="{FORUMS_TOPICS_NEWTOPICURL}"><img src="skins/{PHP.skin}/img/system/newtopic.gif" alt="" /></a>

</div>

<table class="cells">

	<tr>
		<td colspan="2" class="coltop">
		{FORUMS_TOPICS_TITLE_TOPICS} / {FORUMS_TOPICS_TITLE_STARTED}</td>
		<td class="coltop" style="width:176px;">
		{FORUMS_TOPICS_TITLE_LASTPOST}</td>
		<td class="coltop" style="width:56px;">
		{FORUMS_TOPICS_TITLE_POSTS}</td>
		<td class="coltop" style="width:56px;">
		{FORUMS_TOPICS_TITLE_VIEWS}</td>

	</tr>

	<!-- BEGIN: FORUMS_TOPICS_ROW -->

	<tr>
		<td style="width:32px;" class="centerall {FORUMS_TOPICS_ROW_ODDEVEN}">
		{FORUMS_TOPICS_ROW_ICON}
		</td>

		<td class="{FORUMS_TOPICS_ROW_ODDEVEN}">
		<strong><a href="{FORUMS_TOPICS_ROW_URL}">{FORUMS_TOPICS_ROW_TITLE}</a></strong><br />
		{FORUMS_TOPICS_ROW_PAGES} &nbsp; {FORUMS_TOPICS_ROW_CREATIONDATE} : {FORUMS_TOPICS_ROW_FIRSTPOSTER}
		</td>


		<td class="centerall {FORUMS_TOPICS_ROW_ODDEVEN}">
		{FORUMS_TOPICS_ROW_UPDATED} {FORUMS_TOPICS_ROW_LASTPOSTER}<br />
		{FORUMS_TOPICS_ROW_TIMEAGO}</span>
		</td>

		<td class="centerall {FORUMS_TOPICS_ROW_ODDEVEN}">
		{FORUMS_TOPICS_ROW_POSTCOUNT}
		</td>

		<td class="centerall {FORUMS_TOPICS_ROW_ODDEVEN}">
		{FORUMS_TOPICS_ROW_VIEWCOUNT}
		</td>

	</tr>

	<!-- END: FORUMS_TOPICS_ROW -->

</table>

<div class="paging">

	{FORUMS_TOPICS_PAGEPREV} &nbsp; {FORUMS_TOPICS_PAGENEXT} &nbsp; {FORUMS_TOPICS_PAGES}

</div>

<table class="main">

	<tr>
		<td><img src="skins/{PHP.skin}/img/system/posts.gif" alt="" /> : {PHP.skinlang.forumstopics.Nonewposts}</td>
		<td><img src="skins/{PHP.skin}/img/system/posts_new.gif" alt="" /> :{PHP.skinlang.forumstopics.Newposts}</td>
		<td><img src="skins/{PHP.skin}/img/system/posts_sticky.gif" alt="" /> : {PHP.skinlang.forumstopics.Sticky}</td>
	</tr>
	<tr>
		<td><img src="skins/{PHP.skin}/img/system/posts_hot.gif" alt="" /> : {PHP.skinlang.forumstopics.Nonewpostspopular}</td>
		<td><img src="skins/{PHP.skin}/img/system/posts_new_hot.gif" alt="" /> :{PHP.skinlang.forumstopics.Newpostspopular}</td>
		<td><img src="skins/{PHP.skin}/img/system/posts_new_sticky.gif" alt="" /> : {PHP.skinlang.forumstopics.Newpostssticky}</td>
	</tr>
	<tr>
		<td><img src="skins/{PHP.skin}/img/system/posts_locked.gif" alt="" /> : {PHP.skinlang.forumstopics.Locked}</td>
		<td><img src="skins/{PHP.skin}/img/system/posts_new_locked.gif" alt="" /> : {PHP.skinlang.forumstopics.Newpostslocked}</td>
		<td><img src="skins/{PHP.skin}/img/system/posts_sticky_locked.gif" alt="" /> : {PHP.skinlang.forumstopics.Announcment}</td>
	</tr>
	<tr>
		<td colspan="2">
		<img src="skins/{PHP.skin}/img/system/posts_moved.gif" alt="" /> : {PHP.skinlang.forumstopics.Movedoutofthissection}</td>
		<td><img src="skins/{PHP.skin}/img/system/posts_new_sticky_locked.gif" alt="" /> : {PHP.skinlang.forumstopics.Newannouncment}</td>
	</tr>

</table>

</div>

<!-- END: MAIN -->