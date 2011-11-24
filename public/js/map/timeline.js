/*var firstDate = new Date ();
var secondDate = new Date(); 

firstDay = firstDate.getDate();
firstMonth = firstDate.getMonth();
firstYear = firstDate.getFullYear();*/

var windowWidth;
var imageWidthAll;
var numberOfImages;

var firstDate = Date.today();
var secondDate = Date.today().add(10).days();
var dateDifference = (secondDate - firstDate) / (1000*60*60*24);

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
				date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
				dates.not( this ).datepicker( "option", option, date );
				parseDate();	
				}		
	});	
	
	
	
	$("#zeitraumStartEingabefeldId").datepicker('setDate', firstDate);
	$("#zeitraumEndeEingabefeldId").datepicker('setDate', secondDate);
	
	$('#zeitraumPlus').click(function() {
		$('#images').load('getImage.php/' + 'id/' + 'plus/' + '/start/' + $(zeitraumStartEingabefeldId).val() + '/ende/' +$(zeitraumEndeEingabefeldId).val());
	});
	
	$('#zeitraumMinus').click(function() {
		$('#images').load('getImage.php/' + 'id/' + 'minus/' + '/start/' + $(zeitraumStartEingabefeldId).val() + '/ende/' +$(zeitraumEndeEingabefeldId).val());
	});
	
	$('#zeitraumScrollMinus').click(function() {
		firstDate = firstDate.addDays(-dateDifference);
		secondDate = secondDate.addDays(-dateDifference);		
		$("#zeitraumStartEingabefeldId").datepicker('setDate', firstDate);
		$("#zeitraumEndeEingabefeldId").datepicker('setDate', secondDate);
	});
	
	$('#zeitraumScrollPlus').click(function() {
		
		firstDate = firstDate.addDays(dateDifference);
		secondDate = secondDate.addDays(dateDifference);	
		$("#zeitraumStartEingabefeldId").datepicker('setDate', firstDate);
		$("#zeitraumEndeEingabefeldId").datepicker('setDate', secondDate);
	});
	
	
	$("input[type='text']").change( function() {
		parseDate();
	});

});

function howMuchImages(){
	windowWidth =$(document).width(); 
	imageWidthAll = windowWidth - 24 - $("#profilImage").width() - $("#profilInfo").width() - 11  
	numberOfImages = (imageWidthAll / (48 + 3));
	console.log(imageWidthAll);
	console.log(numberOfImages);
	console.log(Math.round(numberOfImages));
}

function parseDate(){
	firstDate =	Date.parse($(zeitraumStartEingabefeldId).val());
	secondDate = Date.parse($(zeitraumEndeEingabefeldId).val());
	dateDifference = (secondDate - firstDate) / (1000*60*60*24);
	console.log(dateDifference);		
	$('#images').load('getImage.php/' + 'id/' + $(this).attr('id') + '/start/' + $(zeitraumStartEingabefeldId).val() + '/ende/' +$(zeitraumEndeEingabefeldId).val());		
} 




