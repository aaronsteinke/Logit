var howManyUsers = 1;
var footerActiv = 0;
var footerHeightMin = "45px";
var footerHeightMax = "125px";
var footerDifference = "80px";

function initializeTimeline(){
	setTimelineAndMapBottom();
	setFooterHeight();
	setFooterBottom();
}

function setTimelineAndMapBottom(){
	setTimelineBottom();
	setMapBottom();
	setFooterBottom();
}

function setFooterHeight() {
	$("#footer").click(function(){
	if(footerActiv == 0){
		$("#footer").animate({height:footerHeightMax}, 1500 );
		$("#timeline").animate({bottom:"+=" + footerDifference}, 1500 );
		$("#map").animate({bottom:"+=" + footerDifference}, 1500 );
		footerActiv = 1;
	} else if(footerActiv ==1){
		$("#footer").animate({height:footerHeightMin}, 1500 );
		$("#timeline").animate({bottom:"-=" + footerDifference}, 1500 );
		$("#map").animate({bottom:"-=" + footerDifference}, 1500 );	
		footerActiv = 0;
	}	
});

/*
$("#footerButton").click(function(){
	if(active == 0){$("#block").animate({height:'500px'}, 1500 );
		active = 1;
	} else if( active ==1){
		$("#block").animate({height:'10px'}, 1500 );	
		active = 0;
	}*/
}

function setFooterBottom(){
	$("#footer").css("bottom", function(bottomPx) {
  		return bottomPx = 0;
	});
}

function setTimelineBottom() {
	$("#timeline").css("bottom", function(bottomPx) {
  		return bottomPx = $("#footer").css("height");
	});
}

function setMapBottom() {
	$("#map").css("bottom", function(bottomPx) {
  			return bottomPx = parseInt($("#footer").css("height")) + parseInt($("#timeline").css("height"));
		});	
}
