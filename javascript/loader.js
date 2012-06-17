$(document).ready(function() {
		
/**
Display Loading Image
*/

function Display_Load() {
	   
	$("#loading").fadeIn(900,0);
	//$("#loading").html("<img src='loading.gif' alt='loading' />");
	
}

/**
Hide Loading Image
*/

function Hide_Load() {
	
		$("#loading").fadeOut('slow');
};
	

/**
Default Starting Page Results
*/
   
	
	Display_Load();
	
	$("#news").load("loader.php", Hide_Load());
	

});