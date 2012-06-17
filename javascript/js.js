$(document).ready(function(){
		
/**
Display Loading Image
*/

function Display_Load() {
	   
	$("#loading").fadeIn(900,0);
	$("#loading").html("<img src='loading.gif' />");
	
}

/**
Hide Loading Image
*/

function Hide_Load() {
	
		$("#latest_news_holder").fadeOut('slow');
};
	

/**
Default Starting Page Results
*/
   
	
	Display_Load();
	
	$("#content").load("../loader.php", Hide_Load());



	
	
});