// JavaScript Document

function openJS(){alert('loaded')}
function closeJS(){alert('closed')}

function downloadPDF() {
	params  = 'width='+screen.width;
	params += ', height='+screen.height;
	params += ', top=0, left=0';
	params += ', fullscreen=yes';
	newwin=window.open('descarga/diagnostico.pdf','_blank', params);
}
	
(function() {
	var 
		fullScreenApi = { 
			supportsFullScreen: false,
			isFullScreen: function() { return false; }, 
			requestFullScreen: function() {}, 
			cancelFullScreen: function() {},
			fullScreenEventName: '',
			prefix: ''
		},
		browserPrefixes = 'webkit moz o ms khtml'.split(' ');
	
	// check for native support
	if (typeof document.cancelFullScreen != 'undefined') {
		fullScreenApi.supportsFullScreen = true;
	} else {	 
		// check for fullscreen support by vendor prefix
		for (var i = 0, il = browserPrefixes.length; i < il; i++ ) {
			fullScreenApi.prefix = browserPrefixes[i];
			
			if (typeof document[fullScreenApi.prefix + 'CancelFullScreen' ] != 'undefined' ) {
				fullScreenApi.supportsFullScreen = true;
				
				break;
			}
		}
	}
	
	// update methods to do something useful
	if (fullScreenApi.supportsFullScreen) {
		fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';
		
		fullScreenApi.isFullScreen = function() {
			switch (this.prefix) {	
				case '':
					return document.fullScreen;
				case 'webkit':
					return document.webkitIsFullScreen;
				default:
					return document[this.prefix + 'FullScreen'];
			}
		}
		fullScreenApi.requestFullScreen = function(el) {
			return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
		}
		fullScreenApi.cancelFullScreen = function(el) {
			return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
		}		
	}

	// jQuery plugin
	if (typeof jQuery != 'undefined') {
		jQuery.fn.requestFullScreen = function() {
	
			return this.each(function() {
				var el = jQuery(this);
				if (fullScreenApi.supportsFullScreen) {
					fullScreenApi.requestFullScreen(el);
				}
			});
		};
	}

	// export api
	window.fullScreenApi = fullScreenApi;	
})();


// do something interesting with fullscreen support
var fsButton = document.getElementById('fsbutton'),
	fsElement = document.getElementById('body'),
	//fsStatus = document.getElementById('title'),
	cfsButton = document.getElementById('close');
	cfs1Button = document.getElementById('close1');


if (window.fullScreenApi.supportsFullScreen) {
	//fsStatus.innerHTML = 'YES: Your browser supports FullScreen';
	//fsStatus.className = 'fullScreenSupported';
	
	// handle button click
	fsButton.addEventListener('click', function() {
		window.fullScreenApi.requestFullScreen(fsElement);
		window.fullScreenApi.mozRequestFullScreen(fsElement);
	}, true);
	
	cfs1Button.addEventListener('click', function() {
		window.fullScreenApi.cancelFullScreen(fsElement);
	}, true);
	
	cfsButton.addEventListener('click', function() {
		window.fullScreenApi.cancelFullScreen(fsElement);
	}, true);
	
	fsElement.addEventListener(fullScreenApi.fullScreenEventName, function() {
		if (fullScreenApi.isFullScreen()) {
			document.getElementById("fsbutton").style.visibility = "hidden";
			document.getElementById("fsbutton").style.position = "absolute";
			document.getElementById("sfsbutton").style.visibility = "visible";
			document.getElementById("sfsbutton").style.position = "relative";
			document.getElementById("container").style.height = screen.height+"px";
			document.getElementById("container").style.backgroundColor = "#d8efc0";
		} else {
			document.getElementById("fsbutton").style.visibility = "visible";
			document.getElementById("fsbutton").style.position = "relative";
			document.getElementById("sfsbutton").style.visibility = "hidden";
			document.getElementById("sfsbutton").style.position = "absolute";
		}
	}, true);
	
} else {
	//fsStatus.innerHTML = 'SORRY: Your browser does not support FullScreen';
}


document.getElementById("fsbutton").style.visibility = "visible";
document.getElementById("fsbutton").style.position = "relative";
document.getElementById("sfsbutton").style.visibility = "hidden";
document.getElementById("sfsbutton").style.position = "absolute";

var numberOfPages = 74; 
// Adds the pages that the book will need
function addPage(page, book) {
	// 	First check if the page is already in the book
	if (!book.turn('hasPage', page)) {
		// Create an element for this page
		var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page}).html('<i class="loader"></i>');
		// If not then add the page
		book.turn('addPage', element, page);
		// Let's assum that the data is comming from the server and the request takes 1s.
		setTimeout(function(){
			element.html('<div class="data">Data for page '+page+'</div>');
		}, 1000);
	}
}

$(window).ready(function(){
	$('#magazine').turn({
		acceleration: true,
			display: 'double',
			pages: numberOfPages,
			elevation: 50,
			gradients: !$.isTouch,
			when: {
				turning: function(e, page, view) {

					// Gets the range of pages that the book needs right now
					var range = $(this).turn('range', page);

					// Check if each page is within the book
					for (page = range[0]; page<=range[1]; page++) 
						addPage(page, $(this));

				},

				turned: function(e, page) {
					$('#page-number').val(page);
				}
			}
		});

		$('#number-pages').html(numberOfPages);

		$('#page-number').keydown(function(e){

		if (e.keyCode==13){
			$('#magazine').turn('page', $('#page-number').val());
		}
	});
});
	
	
var t;
function playP() {
	t = clearTimeout(t);
	$('#magazine').turn('next');
	t = setTimeout("changeP()", 3000);
}

function changeP() {
	t = clearTimeout(t);
	$('#magazine').turn('next');
	t = setTimeout("playP()", 3000);
}

function playB() {
	t = clearTimeout(t);
	$('#magazine').turn('previous');
	t = setTimeout("changePB()", 3000);
}

function changePB() {
	t = clearTimeout(t);
	$('#magazine').turn('previous');
	t = setTimeout("playB()", 3000);
}

function pauseP() {
	t = clearTimeout(t);
}

function msg(msg) {
	document.getElementById("msg").innerHTML = msg;
}

$(window).bind('keydown', function(e){	
	if (e.keyCode==37) {
		$('#magazine').turn('previous');
	}else if (e.keyCode==39) {
		$('#magazine').turn('next');
	}
	if (e.keyCode==27) {
		document.getElementById("fsbutton").style.visibility = "visible";
		document.getElementById("fsbutton").style.position = "relative";
		document.getElementById("sfsbutton").style.visibility = "hidden";
		document.getElementById("sfsbutton").style.position = "absolute";
		document.body.style.height = window.innerHeight+"px";
	}
}
);