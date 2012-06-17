<?php
 /*
 
 Maintenance
 programmed by 2bros
 updated@26-01-2011
 
 
 */

if (!defined('SED_CODE')) { die('Wrong URL.'); }

require("datas/beallit.php");


print "<head><title>RidelineMTB - Karbantartás</title></head>";

print "

<div style=\"padding-top:0px;\" align=\"center\">
<table border=\"0\" width=\"640\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
		<td background=\"video.png\" width=\"640\" height=\"480\">
		<div align=\"center\">
		<div style=\"padding-top:0px;\">
		
		<html>
<head>
    
  
   
    <script type=\"text/javascript\">
    /*<![CDATA[*/
        var timeout = 120;
        function timerStart() {
            document.getElementById('refresh').innerHTML = timeout;
            if (timeout > 0) {
                timeout--;
                setTimeout('timerStart()', 1000);
            } else {
                
				document.location = 'index.php';
            }
        }
    /*]]>*/
    </script>
</head>
	<body style=\"color:#000;\" onload=\"timerStart()\">
    <p><img src=\"logo.png\" alt=\"RidelineMTB Logo\" /></p>
	<br>
    <div class=\"maintenance\">
	
	<div class=\"maintenancehead\">Karbantartás/Maintenance<br>
	
	<p>Jelenleg karbantartás zajlik az oldalon! Amint végzünk jövünk vissza!</p>
	
	</div>
  	
	
    <div style=\"padding-top:0px;\">
	
	<p><a href=\"index.php\">Frissítés</a>: <span id=\"refresh\"></span> másodperc múlva.
	<!--<a href=\"".$cfg['baseurl']."/users.php?m=auth\">Adminlogin</a></p>-->
	
	</div>
	
	</div>

</body>
</html>

		
		</div>
		</div>
		</td>
	</tr>
</table>
</div>


";

?>