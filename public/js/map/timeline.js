var windowWidth;
var imageWidthAll;
var numberOfImages;

var firstDate = Date.today();
var firstDateString = firstDate.toString('d.M.yyyy');
var secondDate = Date.today().add(1).days();
var secondDateString = secondDate.toString('d.M.yyyy');
var minimalDate = Date.parse("01.01.1900");
var maximalDate = (Date.today().add((Date.today() - minimalDate) / (1000*60*60*24)).days());
var dateDifference = (secondDate - firstDate) / (1000*60*60*24);

var buttonPlusActiv = 1;
var buttonMinusActiv = 1;

$(window).resize(function() {
	howMuchImages();
});

$(document).ready(function() {	
	howMuchImages();
 						
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
				setDateDifference();
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
			setDateDifference();
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
			setDateDifference();
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
		setDateDifference();
		sendImageRequest();
	});
});

function howMuchImages(){
	windowWidth =$(document).width(); 
	imageWidthAll = windowWidth - 24 - $("#profilImage").width() - $("#profilInfo").width() - 11  
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
	$("#zeitraumStartEingabefeldId").datepicker('setDate', firstDate);
	$("#zeitraumEndeEingabefeldId").datepicker('setDate', secondDate);
	$("#zeitraumEndeEingabefeldId").datepicker("option", "minDate", firstDate.toString('d.M.yyyy'));
	$("#zeitraumStartEingabefeldId").datepicker("option", "maxDate", secondDate.toString('d.M.yyyy'));
}

function sendImageRequest(){
	$('#images').load('map/get-images-for-timeline/number-of-images/' + numberOfImages);
	//$('#images').load('map/get-images-for-timeline/' + 'id/' + 'minus/' + '/start/' + $(zeitraumStartEingabefeldId).val() + '/ende/' +$(zeitraumEndeEingabefeldId).val());
}