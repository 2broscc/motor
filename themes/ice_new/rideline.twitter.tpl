<!-- BEGIN: MAIN -->
<div id="title">Twitter</div>
<div id="main">
<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js" type="text/javascript"></script>
<script language="javascript" src="jquery.tweet.js" type="text/javascript"></script> 
<script type='text/javascript'>
    $(document).ready(function(){
        $(".tweet").tweet({
            username: "{RIDELINE_TWITTER_USERNAME}",
            join_text: "auto",
            avatar_size: 48,
            count: 5,
            auto_join_text_default: "we said,", 
            auto_join_text_ed: "we",
            auto_join_text_ing: "we were",
            auto_join_text_reply: "we replied to",
            auto_join_text_url: "we were checking out",
            loading_text: "loading tweets..."
        });
    });
</script> 
	<link href="jquery.tweet.css" media="all" rel="stylesheet" type="text/css"/> 
</head>
	
<body>
<div  class="tweet"></div> 
</body>
</div>

<!-- END: MAIN -->