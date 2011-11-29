var windowWidth;
var imageWidthAll;
var numberOfImages;

var firstDate = Date.today().add(-1).days();
var firstDateString = firstDate.toString('d.M.yyyy');
var secondDate = Date.today();
var secondDateString = secondDate.toString('d.M.yyyy');
var minimalDate = Date.parse("01.01.1900");
var maximalDate = (Date.today().add((Date.today() - minimalDate) / (1000*60*60*24)).days());
var dateDifference = (secondDate - firstDate) / (1000*60*60*24);
var hourDifference = (secondDate - firstDate) / (1000*60*60);

var buttonPlusActiv = 1;
var buttonMinusActiv = 1;
var hourDate = 0;

$(window).resize(function() {
	sendImageRequest();
});

$(document).ready(function() {	
 						
	var dates = $( "#zeitraumStartEingabefeldId, #zeitraumEndeEingabefeldId" ).datepicker({
		showOn: "button",	
		buttonImage: "images/calendar.gif",
		buttonImageOnly: true,
		showButtonPanel: true,
		defaultDate: "+1w",
		changeMonth: true,
					
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

	
	$('#zeitraumPlus').click(function zoomIn() {
		if(buttonPlusActiv == 1){
			buttonMinusActiv = 1;
			firstDate = firstDate.addDays(dateDifference/4);
			secondDate = secondDate.addDays(-dateDifference/4);
			checkDateArea();
			setDatePicker();
			sendImageRequest();
		}
	});
	
	$('#zeitraumMinus').click(function zoomOut() {	
		if(buttonMinusActiv == 1){
			buttonPlusActiv = 1;
			firstDate = firstDate.addDays(-dateDifference/2);
			secondDate = secondDate.addDays(dateDifference/2);
			checkDateArea();
			setDatePicker();
			sendImageRequest();
		}
	});
	
	$('#zeitraumScrollMinus').click(function ScrollLeft() {
		firstDate = firstDate.addDays(-dateDifference);
		secondDate = secondDate.addDays(-dateDifference);
		setDatePicker();
		sendImageRequest();
	});
	
	$('#zeitraumScrollPlus').click(function ScrollRight () {
		firstDate = firstDate.addDays(dateDifference);
		secondDate = secondDate.addDays(dateDifference);
		setDatePicker();
		sendImageRequest();
	});	
	
	$("input[type='text']").change( function() {
		parseDate();
		sendImageRequest();
	});
});

function howMuchImages(){
	windowWidth =$(document).width(); 
	imageWidthAll = (windowWidth - 24 - $("#profilImage").width() - $("#profilInfo").width() - 11); 
	numberOfImages = Math.round(imageWidthAll / (48 + 3));
}

function parseDate(){
	firstDate =	Date.parse($(zeitraumStartEingabefeldId).val());
	secondDate = Date.parse($(zeitraumEndeEingabefeldId).val());	
}

function setDateDifference(){
	dateDifference = Math.round((secondDate - firstDate) / (1000*60*60*24));
	if (dateDifference >= 36500){
		dateDifference = 36500;
	} else if(dateDifference <= 0){
		buttonPlusActiv = 0;
		dateDifference = 2;
	} 	
} 

function checkDateArea(){	
	if (firstDate.compareTo(minimalDate) <= 0){
		firstDate = new Date(minimalDate);
		secondDate = new Date(maximalDate);
		buttonMinusActiv = 0;
	}
}

function setDatePicker(){
	if(hourDate == 0){
		$("#zeitraumStartEingabefeldId").datepicker('setDate', firstDate);
		$("#zeitraumEndeEingabefeldId").datepicker('setDate', secondDate);
		$("#zeitraumEndeEingabefeldId").datepicker("option", "minDate", firstDate.toString('d.M.yyyy'));
		$("#zeitraumStartEingabefeldId").datepicker("option", "maxDate", secondDate.toString('d.M.yyyy'));
	}
}

function sendImageRequest(){
	var firstDay = firstDate.getDate();
	var firstMonth = firstDate.getMonth() + 1;
	var firstYear = firstDate.getFullYear();
	var secondDay = secondDate.getDate();
	var secondMonth = secondDate.getMonth() + 1;
	var secondYear = secondDate.getFullYear();
	
	setDateDifference();
	howMuchImages();
	
	//hourDifference = Math.round((secondDate - firstDate) / (1000*60*60));
	console.log(firstDate.toShortTimeString());
	//console.log(hourDifference)
	
	$('#images').load('map/get-images-for-timeline/number-of-images/' + numberOfImages + "/first-day/" + firstDay + "/first-month/" + firstMonth + "/first-year/" + firstYear + "/second-day/" + secondDay + "/second-month/" + secondMonth + "/second-year/" + secondYear);
	//$('#images').load('map/get-images-for-timeline/' + 'id/' + 'minus/' + '/start/' + $(zeitraumStartEingabefeldId).val() + '/ende/' +$(zeitraumEndeEingabefeldId).val());
}