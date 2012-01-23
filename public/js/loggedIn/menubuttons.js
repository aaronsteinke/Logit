// Buttons

//Ansicht Switch (Map/ Kalender)



$(document).ready(function() {
	$('#ajax').load('/alpha');
	$('#1').ansichtSwitch("on", function() {
		$('#main').load('/map');
	}, function() {
		$('#main').load('/timeline');
	}, {
		switch_on_container_path : 'images/ansicht_switch_container_off.png'
	});

	$("#eventsAnlegen").click(function() {
		window.location.hash = '#1';
	});
	$("#logsVerbessern").click(function() {
		window.location.hash = '#2';
	});
	$("#logsStatistiken").click(function() {
		window.location.hash = '#3';
	});
	$("#profileinstellungen").click(function() {
		window.location.hash = '#4';
	});
});





//Hauptnavi Dropdown
var timeoutID;
$(function(){
	$('.dropdown').mouseenter(function(){
		$('.sublinks').stop(false, true).hide();
		window.clearTimeout(timeoutID);
		var submenu = $(this).parent().next();

		submenu.css({
			position:'absolute',
			top: $(this).offset().top + $(this).height() + 'px',
			left: $(this).offset().left + 'px',
			zIndex:1000
		});
		
		submenu.stop().slideDown(300);
		
		submenu.mouseleave(function(){
			$(this).slideUp(300);
		});
		
		submenu.mouseenter(function(){
			window.clearTimeout(timeoutID);
		});
		
	});
	$('.dropdown').mouseleave(function(){
//		timeoutID = window.setTimeout(function() {$('.sublinks').stop(false, true).hide();}, 250);  // just hide
		timeoutID = window.setTimeout(function() {$('.sublinks').stop(false, true).slideUp(300);}, 250);  // slide up
	});
});
