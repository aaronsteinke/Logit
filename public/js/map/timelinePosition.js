var howManyUsers = 1;

function setTimelineAndMapBottom(){
	setTimelineBottom();
	setMapBottom();
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
