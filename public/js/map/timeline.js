var windowWidth;
var imageWidthAll;
var numberOfImages;

var firstDate = Date.today().add(-1).days();
var secondDate = Date.today();
var minimalDate = Date.parse("01.01.1900");
var maximalDate = (Date.today().add((Date.today() - minimalDate) / (1000*60)).minutes());

var minuteDifference = Math.round(secondDate - firstDate) / (1000*60);
var maximalMinuteDifference = 100000000;

var buttonPlusActiv = 1;
var buttonMinusActiv = 1;
var userNickname;

var numberOfFriends = 0;

var isFriend;

var myFriends = new Array();

var resizeIt = false;
$(window).resize(function() {

 if(resizeIt !== false)
    clearTimeout(resizeIt);
 resizeIt = setTimeout(sendImageRequest, 200); 
});

function initializeMapTimeline(minimalDate, maximalDate, userNick){
	userNickname = userNick
	initializeMapTimelineFirstContent();
}

function initializeMapTimelineFirstContent(){
	$('#bilderInhalt' + numberOfFriends).load('map/get-timeline/username/' + userNickname, startgetDateImages());
	myFriends.push(userNickname);
	console.log(myFriends.length);
	numberOfFriends ++;
}

function startgetDateImages(){	
	initializeDatepicker();
	initializeEvents();
	initializeAddFriends();
}

function initializeDatepicker(){
	var dates = $( "#zeitraumStartEingabefeldId, #zeitraumEndeEingabefeldId" ).datepicker({
		showOn: "button",	
		buttonImage: "images/calendar.gif",
		buttonImageOnly: true,
		showButtonPanel: true,
		defaultDate: "+1w",
		dateFormat: 'dd.mm.yy',
					
		onSelect: function( selectedDate ) {
			var option = this.id == "zeitraumStartEingabefeldId" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ), 
				date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, 
				selectedDate, 
				instance.settings);
				dates.not( this ).datepicker( "option", option, date );
				parseDate();	
				sendImageRequest();
			}				
	});	
	setDatePicker();
	sendImageRequest();
}

function initializeEvents(){
	$('#zeitraumPlus').click(function zoomIn() {
		if(buttonPlusActiv == 1){
			buttonMinusActiv = 1;
			if(minuteDifference > 24*60){
				firstDate = firstDate.addMinutes(minuteDifference/4);
				secondDate = secondDate.addMinutes(-minuteDifference/4);
			} else if(minuteDifference > 120){
				firstDate = firstDate.addMinutes(60);
				secondDate = secondDate.addMinutes(-60);	
			} else if(minuteDifference > 0){
				firstDate = firstDate.addMinutes(10);
				secondDate = secondDate.addMinutes(- 10);
			} 
			checkDateArea();
			setDatePicker();
			sendImageRequest();
		}
	});
	
	$('#zeitraumMinus').click(function zoomOut() {	
		if(buttonMinusActiv == 1){
			buttonPlusActiv = 1;
			if(minuteDifference >= maximalMinuteDifference){
				buttonMinusActiv = 0;
			}else if(minuteDifference >= 1051200){
				firstDate = firstDate.addMinutes(-1051200);
				secondDate = secondDate.addMinutes(1051200);
			}else if(minuteDifference >= 24*60){
				firstDate = firstDate.addMinutes(-minuteDifference);
				secondDate = secondDate.addMinutes(minuteDifference);
			} else if (minuteDifference >= 120){
				firstDate = firstDate.addMinutes(-60);
				secondDate = secondDate.addMinutes(60);
			} else if (minuteDifference >= 0){
				firstDate = firstDate.addMinutes(-10);
				secondDate = secondDate.addMinutes(10);	
			}
			checkDateArea();
			setDatePicker();
			sendImageRequest();
		}
	});
	
	$('#zeitraumScrollMinus').click(function ScrollLeft() {
		firstDate = firstDate.addMinutes(-minuteDifference);
		secondDate = secondDate.addMinutes(-minuteDifference);
		setDatePicker();
		sendImageRequest();
	});
	
	$('#zeitraumScrollPlus').click(function ScrollRight () {
		firstDate = firstDate.addMinutes(minuteDifference);
		secondDate = secondDate.addMinutes(minuteDifference);
		setDatePicker();
		sendImageRequest();
	});	
	
	$("zeitraum").change( function() {
		parseDate();
		sendImageRequest();
	});
}



function parseDate(){
	firstDate =	Date.parse($(zeitraumStartEingabefeldId).val() + "," + $(zeitraumStartEingabefeldUhrzeitId).val());
	secondDate = Date.parse($(zeitraumEndeEingabefeldId).val() + "," + $(zeitraumEndeEingabefeldUhrzeitId).val());
}

function setDateDifference(){
	minuteDifference = Math.round(secondDate - firstDate) / (1000*60);
	if (minuteDifference <= 0){
		buttonPlusActiv = 0;
	} 		
} 

function checkDateArea(){	
	if (firstDate.compareTo(minimalDate) <= 0){
		firstDate = new Date(minimalDate);
		secondDate = new Date(maximalDate);
	}
}

function setDatePicker(){
		$("#zeitraumStartEingabefeldId").datepicker('setDate', firstDate);
		$("#zeitraumEndeEingabefeldId").datepicker('setDate', secondDate);
		$("#zeitraumEndeEingabefeldId").datepicker("option", "minDate", firstDate.toString('d.M.yyyy'));
		$("#zeitraumStartEingabefeldId").datepicker("option", "maxDate", secondDate.toString('d.M.yyyy'));
		$("#zeitraumStartEingabefeldUhrzeitId").val(firstDate.toString('HH:mm'));
		$("#zeitraumEndeEingabefeldUhrzeitId").val(secondDate.toString('HH:mm'));
}


//////////////////////////////////////////
/////Image Request bilderInhalt1////////////////
////////////////////////////////////////


function howMuchImages(){
	windowWidth =$(document).width(); 
	imageWidthAll = (windowWidth - 24 - $("#profilImage").width() - $("#profilInfo").width() - 11); 
	numberOfImages = Math.round(imageWidthAll / (48 + 3));
}


function sendImageRequest(){
	setDateDifference();
	howMuchImages();
	for(var i = 0; i < myFriends.length; i++){
		var bildZahl = i;
		console.log(myFriends[i]);
		$('#bilderInhalt' + bildZahl +' .images').load('map/get-images-for-timeline/number-of-images/' + numberOfImages + "/first-date/" + firstDate.toString('yyyy-M-d') + "/first-time/"+ firstDate.toString('HH:mm') + "/second-date/" + secondDate.toString('yyyy-M-d') + "/second-time/"+ secondDate.toString('HH:mm') + "/username/" + myFriends[i]);
	}
}


//////////////////////////////////////////
/////Freunde zur Timeline////////////////
////////////////////////////////////////



function initializeAddFriends(){
		
	$("#addFriendsButton").click( function() {
		checkIfInTimeline();
	});
	
	$("#addFriendsTextfield").keydown(function(event) {
  		if ( event.which == 13 ) {
  			checkIfInTimeline();
  		}
 	});
 	
 	$("#addFriendsTextfield").focusin(function(event) {
 		if($("#addFriendsTextfieldId").val() == "Freunde hinzufügen"){
 			resetFriendTxtField();
 		}
 	});
 	
 	$("#addFriendsTextfield").click(function(event) {
 		if($("#addFriendsTextfieldId").val() == "Freunde hinzufügen"){
 			resetFriendTxtField();
 		}
 	});

  
	$(function () {
		var cache = {},
			lastXhr;
		$( "#addFriendsTextfieldId" ).autocomplete({
			minLength: 2,
			select: function(event, ui) { 
				loadFriendToTimeline();
			},
			
			source: function( request, response ) {
				
				var term = request.term;
				if ( term in cache ) {
					response( cache[ term ] );
					return;
				}

				lastXhr = $.getJSON( "/User/autocomplete-friends", request, function( data, status, xhr ) {
					cache[ term ] = data;
					if ( xhr === lastXhr ) {
						response( data );
					}
				});
			}
		});
	});	
}

function resetFriendTxtField(){
		$("#addFriendsTextfieldId").css("background-color", "#FFF");
		$("#addFriendsTextfieldId").val("");
}
function resetFriendTxtFieldToStart(){
		$("#addFriendsTextfieldId").css("background-color", "#FFF");
		$("#addFriendsTextfieldId").val("Freunde hinzufügen");
}

function checkIfInTimeline(){
	if( $("#addFriendsTextfieldId").val() != "" && $("#addFriendsTextfieldId").val() != "Freunde hinzufügen"){
		console.log(myFriends);
		var tauchtAuf = 0;
		for(var k = 0; k <= myFriends.length; k++){
			if($("#addFriendsTextfieldId").val() == myFriends[k]){
				tauchtAuf = 1;
				return;
			}
		}
		if(tauchtAuf == 0){
			loadFriendToTimeline();
		}
	}	
}

function loadFriendToTimeline(){	
	$("#bilderInhalte").append($('<div id="bilderInhalt'+ numberOfFriends +'"/>'));	
	$('#bilderInhalt'+ numberOfFriends).load('map/get-timeline/username/' + $("#addFriendsTextfieldId").val(), checkFriendStatus);
}

function checkFriendStatus(){
	if(isFriend == 1){
		areFriends();
	}else if(isFriend == 0){
		noFriends();
	}
}

function areFriends (){
	$("#bilderInhalt"+numberOfFriends).css({
						"background-color" : "#FFF", 
						"width" : "auto", 
						"height" : "60px", 
						"border" : "1px solid #999",
						"margin" : "5px 0px 19px 12px",
						"white-space" : "nowrap",
						"overflow" : "hidden"});
	numberOfFriends ++;
	initializeTimelineHeight();
	myFriends.push($("#addFriendsTextfieldId").val());	 
}

function noFriends(){
	$("#bilderInhalt" + numberOfFriends).remove();
	$("#addFriendsTextfieldId").css("background-color", "#F00")
	$("#addFriendsTextfieldId").val("Sie können nur Freunde hinzufügen");
	setTimeout("resetFriendTxtFieldToStart()", 4000);
}
