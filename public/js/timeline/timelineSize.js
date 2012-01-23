var howManyUsers = 1;
var footerActiv = 0;
var footerHeightMin = "45px";
var footerHeightMax = "175px";
var footerDifference = "130px";
var footerSpeed = 500;

var dragActiv = 0;
var timelineDragMax = 300;
var timelineDragNormal = 138
var timelineDragMin = 44;
var timelineDragMapMin = 44-138;
var timelineDragMapMax = 300-138;
var timelineStatus = 1;
var timelineSpeed = 500;
var animateMapToTimeline;

function initializeTimeline(){
	setFooterHeight();
	setFooterBottom();
	setTimelineAndMapBottom();
	setContentTimeline();
 }

function setTimelineAndMapBottom(){
	setTimelineBottom();
	setFooterBottom();
}

$(window).resize(function() {
	setContentTimeline(); 
});

function setFooterHeight() {
	$("#footer").dblclick(function(){
	if(footerActiv == 0){
		footerActiv = 2;
		$("#footer").animate({height:footerHeightMax}, footerSpeed, footerAcitv);
		$("#timeline").animate({bottom:"+=" + footerDifference}, footerSpeed);
	} else if(footerActiv ==1){
		footerActiv = 3;
		$("#footer").animate({height:footerHeightMin}, footerSpeed, footerAcitv);
		$("#timeline").animate({bottom:"-=" + footerDifference}, footerSpeed);
		}	
	});
}

function footerAcitv(){
	if(footerActiv == 2 ){
		footerActiv = 1;
	}else if(footerActiv ==3){
		footerActiv = 0;
	}
}

function setContentTimeline() {
	$("#content1").css("height", function(height) {
  		return height = $("#timeline").height() - $("#navi").height() - 30
	});
}

function setFooterBottom(){
	$("#footer").css("bottom", function(bottomPx) {
  		return bottomPx = 0;
	});
}

function setTimelineBottom(){
	$("#timeline").css("bottom", function(bottomPx) {
  		return bottomPx = $("#footer").css("height");
	});
}
