/*

Filename: functions.js
Javascript file
Programmed by 2bros cc
Date:02-17-2011
Programmer: Peter Magyar
Email:ridelineonline@gmail.com


*/

var imgLoader = new Image();
var action = 0;
var currentstyle = false;
var buttonstates = new Array();
var wait = false;
var upl_submitted = false;
var dcTime = 250;				// doubleclick time
var dcDelay = 100;				// no clicks after doubleclick
var dcAt = 0;					// time of doubleclick
var savEvent = null;			// save Event for handling doClick().
var savEvtTime = 0;				// save time of click event.
var savTO = null;				// handle of click setTimeOut
var upl_frm_inited = false;
var styping = false;
var stimer;
var spage = 1;
var guianimations = true;		//guianimations 


//document ready stuff - akkor hajtódik végre, amikor az oldal töltõdik

$(document).ready(function() {



//switch thumb for listview

$("a.switch_thumb").toggle(function(){
	  $(this).addClass("swap"); 
	  $("ul.display").fadeOut("fast", function() {
	  	$(this).fadeIn("fast").addClass("thumb_view"); 
		 });
	  }, function () {
      $(this).removeClass("swap");
	  $("ul.display").fadeOut("fast", function() {
	  	$(this).fadeIn("fast").removeClass("thumb_view");
		});
	}); 
	
//to change the body background stuff

$("li.one").click( function(){ $
		("body").removeClass("bg2 , bg3").addClass("bg1");
	});

	$("li.two").click( function(){ $
		("body").removeClass("bg1 , bg3").addClass("bg2");
	});

	$("li.three").click( function(){ $
		("body").removeClass("bg1 , bg2").addClass("bg3");
	}); 

//$('#notice').slideDown(2000);

//$('#slider_form').load('');

//$(window.location).attr(\'href\', \'http://www.google.com\');

//pe-loading the img's at the site




$(function(){
	

	
	//loading query imgs @ index.tpl
	
	//$("#def_loader").preloader();

	$("#index_img_load").preloader();
	$("#index_img_load_tech").preloader();
	$("#index_img_load_test").preloader();
	$("#index_img_load_raceevent").preloader();
		
	

	});

}); 

/**

Carousel callback function and doc.ready stuff

*/

function mycarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: 2,
        wrap: 'last',
        initCallback: mycarousel_initCallback
    });
});


//go back in the history  with javascript
function goback() {
    history.back();
    return false;
}


//ez figyeli, hogy volt e kattintás
function clickevent(which,func) {
	fteonce = func;
	switch (which) {
		case "click": 
			var d = new Date();
			var now = d.getTime();
			if ((now - dcAt) < dcDelay) return false;
			savEvent = which;
			d = new Date();
			savEvtTime = d.getTime();
			savTO = setTimeout("doClick()", dcTime);
			break;
		case "dblclick":
			doDoubleClick();
			break;
		default:
	}
}



function doClick() {
	if (savEvtTime - dcAt <= 0) return false;
	setTimeout(fteonce, 1);
}

function doDoubleClick() {
	var d = new Date();
	dcAt = d.getTime();
	if (savTO != null) {
	clearTimeout(savTO);
	savTO = null;
	}
	setTimeout(fteonce, 1);
}


function timeout() {
	window.location.reload();
}

//warn stuff

function pulsatewarn() {
	action = 1;
	if($.id('warn') && $.id('infopanel').style.display == "block") {
		if(guianimations)
			$('#warn').Pulsate(300,4,function(){action = 0;});
		else
			action = 0;
	}
	else {
		action = 0;
	}
}

function cursors_wait(id) {
	$('a').css('cursor','wait');
	document.body.style.cursor = 'wait';
}

function cursors_normal(id) {
	$('a').css('cursor','pointer');
	document.body.style.cursor = 'default';
}

function collapse(id) {
	$('#article'+id).toggle();
	if($.id('article'+id).style.display == 'none')
		$('#button'+id).src($.id('button'+id).src.replace('collapse', 'expand'));
	else
		$('#button'+id).src($.id('button'+id).src.replace('expand', 'collapse'));
}



$.id = function(id) {
	if(document.getElementById) {
		var element = document.getElementById(id);
	}
	else if(document.all) {
		var element = document.all[id];
	}
	else if(document.layers) {
		var element = document.layers[id];
	}
	return(element);
}

/*-----------------------------------------------------------------------------------*/

//retrieve the cookie

function get_cookie(name) {
	var start = document.cookie.indexOf(name + "=");
	var len = start + name.length + 1;
	if((!start) && (name != document.cookie.substring(0, name.length)))
	{
			return null;
	}
	if(start == -1) return null;
	var end = document.cookie.indexOf(";", len);
	if(end == -1) end = document.cookie.length;
	return unescape(document.cookie.substring(len, end));
}

function set_cookie(name, value, expires, path, domain, secure) {
	// set time, it is in milliseconds
	var today = new Date();
	today.setTime(today.getTime());
	if(expires)
	{
			expires = expires * 1000 * 60;
	}
	var expires_date = new Date(today.getTime() + (expires));
	document.cookie = name + "=" +escape(value) +
		((expires) ? ";expires=" + expires_date.toGMTString() : "") + //expires.toGMTString()
		((path) ? ";path=" + path : "") + 
		((domain) ? ";domain=" + domain : "") +
		((secure) ? ";secure" : "");
}

function delete_cookie(name, path, domain) {
	if(get_cookie(name)) document.cookie = name + "=" +
		((path) ? ";path=" + path : "") +
		((domain) ? ";domain=" + domain : "") +
		";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

function Cookie(name, duration, path, domain, secure) {
	this.affix = "";
	if(duration) {		  
		var date = new Date();
		date.setTime(date.getTime() + (1000 * 60 * duration));
		this.affix = "; expires=" + date.toGMTString();
	}
	if(path) this.affix += "; path=" + path;
	if(domain) this.affix += "; domain=" + domain;
	if(secure) this.affix += "; secure=" + secure;
	function getValue() {
		var m = document.cookie.match(new RegExp("(" + name + "=[^;]*)(;|$)"));
		return m ? m[1] : null;	
	}
	this.cookieExists = function() {
		return getValue() ? true : false;
	}
	this.Delete = function() {
		document.cookie=name + "=noop; expires=Thu, 01-Jan-1970 00:00:01 GMT"; 
	}
	this.SetItem = function(key, value) {
		var ck = getValue();
		if(/[;, ]/.test(value)) {
			//Mac IE doesn not support encodeURI
			value = window.encodeURI ? encodeURI(value) : escape(value);
		}
		if(value) {
			var attrPair = "@" + key + value;
			if(ck) {
				if(new RegExp("@" + key).test(ck)) {
					document.cookie =
						ck.replace(new RegExp("@" + key + "[^@;]*"), attrPair) + this.affix;
				} else {
					document.cookie =
						ck.replace(new RegExp("(" + name + "=[^;]*)(;|$)"), "$1" + attrPair) + this.affix;
				}
			} else {
				document.cookie = name + "=" + attrPair + this.affix;
			}
		} else {		
			 if(new RegExp("@" + key).test(ck)) {
					document.cookie = ck.replace(new RegExp("@" + key + "[^@;]*"), "") + this.affix;
			 }
		}
	}
	this.GetItem = function(key) {
		var ck = getValue();
		if(ck) {
			var m = ck.match(new RegExp("@" + key + "([^@;]*)"));
			if(m) {
				var value = m[1];
				if(value) { 
					//Mac IE doesn not support decodeURI
					return window.decodeURI ? decodeURI(value) : unescape(value);
				}
			}
		}
	}
}


/* 

videos @ index.tpl

*/

var states = new Cookie("states", 30*24*60, "/");

function hide(obj, a, neg, noc) {
	if(action != 0) return false;
	action = 1;
	obj_style = $.id(obj).style;
	if(obj_style.display != "none") {
		if(obj == 'infopanel') {
			if(guianimations) {
				$('#infopanel').slideUp(400, function() { 
						obj_style.display = 'none';
						$('#infopanel_mini').slideDown(400, function() { action = 0; });
					});
			}
			else {
				$('#infopanel').hide();
				$('#infopanel_mini').show();
				action = 0;
			}
		}
		else {
			$('#'+obj).hide();
			action = 0;
		}
		if(obj != 'infopanel') a.parentNode.className = a.parentNode.className.replace(/expanded$/, 'collapsed');
		//
		if(noc != 1) states.SetItem(obj, (neg == 1) ? null : 1);
	}
	else {
		if(obj == 'infopanel') {
			if(guianimations) {
				$('#infopanel_mini').slideUp(600, function() { 
						$.id('infopanel_mini').style.display = 'none';
						$('#infopanel').slideDown(500, function() { pulsatewarn(); });
					});
			}
			else {
				$('#infopanel_mini').hide();
				$('#infopanel').show();
				action = 0;
			}
		}
		else {
			$('#'+obj).show();
			action = 0;
		}
		if(obj != 'infopanel') a.parentNode.className = a.parentNode.className.replace(/collapsed$/, 'expanded');
		if(noc != 1) states.SetItem(obj, (neg == 1) ? 1 : null);
	}
	return false;
}

/*

video.list.tpl

*/

/* 

videos @ index.tpl

*/

var videolist_top_video = new Cookie("videolist_top_video", 30*24*60, "/");

function hide(obj, a, neg, noc) {
	if(action != 0) return false;
	action = 1;
	obj_style = $.id(obj).style;
	if(obj_style.display != "none") {
		if(obj == 'infopanel') {
			if(guianimations) {
				$('#infopanel').slideUp(400, function() { 
						obj_style.display = 'none';
						$('#infopanel_mini').slideDown(400, function() { action = 0; });
					});
			}
			else {
				$('#infopanel').hide();
				$('#infopanel_mini').show();
				action = 0;
			}
		}
		else {
			$('#'+obj).hide();
			action = 0;
		}
		if(obj != 'infopanel') a.parentNode.className = a.parentNode.className.replace(/expanded$/, 'collapsed');
		//
		if(noc != 1) videolist_top_video.SetItem(obj, (neg == 1) ? null : 1);
	}
	else {
		if(obj == 'infopanel') {
			if(guianimations) {
				$('#infopanel_mini').slideUp(600, function() { 
						$.id('infopanel_mini').style.display = 'none';
						$('#infopanel').slideDown(500, function() { pulsatewarn(); });
					});
			}
			else {
				$('#infopanel_mini').hide();
				$('#infopanel').show();
				action = 0;
			}
		}
		else {
			$('#'+obj).show();
			action = 0;
		}
		if(obj != 'infopanel') a.parentNode.className = a.parentNode.className.replace(/collapsed$/, 'expanded');
		if(noc != 1) videolist_top_video.SetItem(obj, (neg == 1) ? 1 : null);
	}
	return false;
}


//cms js functions

function popup(code,w,h)
	{ window.open('plug.php?o='+code,'','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width='+w+',height='+h+',left=32,top=16'); }

function pfs(id,c1,c2)
	{ window.open('pfs.php?userid='+id+'&c1='+c1+'&c2='+c2,'PFS','status=1, toolbar=0,location=0,directories=0,menuBar=0,resizable=1,scrollbars=yes,width=754,height=512,left=32,top=16'); }

function help(rcode,c1,c2)
	{ window.open('plug.php?h='+rcode+'&c1='+c1+'&c2='+c2,'Help','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=32,top=16'); }

function comments(rcode)
	{ window.open('comments.php?id='+rcode,'Comments','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=16,top=16'); }

function ratings(rcode)
	{ window.open('ratings.php?id='+rcode,'Ratings','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=480,height=512,left=16,top=16'); }

function polls(rcode)
	{ window.open('polls.php?id='+rcode,'Polls','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=608,height=448,left=16,top=16'); }

function pollvote(rcode,rvote)
	{ window.open('polls.php?a=send&id='+rcode+'&vote='+rvote,'Polls','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=608,height=448,left=16,top=16'); }

function picture(url,sx,sy)
	{
  var ptop=(window.screen.height-200)/2;
  var pleft=(window.screen.width-200)/2;
  window.open(url,'Picture','toolbar=0,location=0,status=0, directories=0,menubar=0,resizable=1,scrollbars=yes,width='+sx+',height='+sy+',left='+pleft+',top='+ptop+'');
  }
  
function redirect(url)
	{ location.href = url.options[url.selectedIndex].value; }

function toggleblock(id)
	{
	var bl = document.getElementById(id);
	if(bl.style.display == 'none')
		{ bl.style.display = ''; }
	else
		{ bl.style.display = 'none'; }
	}
	
	
window.name='main';


