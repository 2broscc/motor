<!-- BEGIN: MAIN -->

<div id="main">

    <script type="text/javascript">
        $(function() {
    	   $("#type-size").change(function() {
    	       var graphicFileName = $("#type-size option:selected").attr("rel");
    	       var newCode = '<a href="http://aremysitesup.com/aff/xxxxx"><img src="http://css-tricks.com/amsu/' + graphicFileName + '" alt="Are My Sites Up?" /></a>';
               $("#code-box").text(newCode);
               $("#graphic-example-area").html(newCode);
    	   });
        });
    </script>
</head>

<body>

	<div id="page-wrap">

        <h3>RideineMTB banners</h3>
        
        <fieldset>
        
            <legend>Choose</legend>
        
            <form action="#" class="code-selector">
                <div>
                    <label for="type-size">Graphic Size: </label>
                    <select name="type-size" id="type-size">
                        <option selected="selected" rel="AMSU_Ad_125x125v2.png">125 x 125</option>
                        <option rel="AMSU_Ad_300x250v2.png">300 x 250</option>
                        <option rel="AMSU_Ad_465v2.png">465 x 55</option>
                        <option rel="AMSU_Ad_768x90v2.png">768 x 90</option>
                        <option rel="AMSU_Ad_120x240.png">120 x 240</option>
                        <option rel="AMSU_Ad_318x54.png">318 x 54</option>
                        <option rel="AMSU_Ad_50x50.png">50 x 50</option>
                    </select>
                </div>
                
                <div>
                    <label for="code-example">Code: </label>
                    <textarea rows="10" cols="25" id="code-box">&lt;a href="http://aremysitesup.com/aff/xxxxx"&gt;&lt;img src="http://css-tricks.com/amsu/AMSU_Ad_125x125v2.png" alt="Are My Sites Up?" /&gt;&lt;/a&gt;</textarea>
                    <p class="note">Just copy and paste the above text into your website. Your affiliate code has already been included!</p>
                </div>
            </form>
            
            <label>Example: </label>
            <div class="example-area" id="graphic-example-area">
        
                <a href="http://aremysitesup.com/aff/xxxxx"><img src="http://css-tricks.com/amsu/AMSU_Ad_125x125v2.png" alt="Are My Sites Up?" /></a>
            
            </div>
            <p class="note">Example graphic may be scaled down above, but won't be placed on your own page.</p>
        
        </fieldset>
        
    </div>
	
	</div>
	
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	var pageTracker = _gat._getTracker("UA-68528-29");
	pageTracker._initData();
	pageTracker._trackPageview();
	</script>

</body>



</div>

<!-- END: MAIN -->