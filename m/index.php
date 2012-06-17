<? 

/*

mobile version

*/

if(!isset($_GET['r']))  { 
echo "
<script language=\"JavaScript\"> 
<!--  
document.location=\"$PHP_SELF?r=1&width=\"+screen.width+\"&height=\"+screen.height; 
//--> 
</script>"; 
} 

else {     

// Code to be displayed if resolutoin is detected 
     if(isset($_GET['width']) && isset($_GET['height'])) { 
	 
		$width = $_GET['width'];
		
		print "$width";

			if ($width< "1024") {
			
			
			
			
			}
			
			else {
			
				echo "<script type=\"text/javascript\">
				/*<![CDATA[*/
                   
				document.location = 'http://ridelinemtb.hu';
     
				/*]]>*/
				</script>";
			
			}
			
		


			  // Resolution  detected 
     } 
     else { 
               // Resolution not detected 
     } 
} 

?>





