var myFriends = new Array();
var tg_actor = 0;
var tg;

$(document).ready(function() {
	initializeAddFriends();
	buildTimeline();
});
function buildTimeline(){
	$(function () { 
		
		if(tg_actor != 0){
			tg_actor.destroy()
		} 
		
		tg = $("#placement").timeline({
			"min_zoom":1, 
			"max_zoom":60, 
			"show_centerline":true,
			"data_source":"timeline/get-json/names/" + myFriends,
			"show_footer":false,
			"display_zoom_level":true,
			"event_overflow":"scroll"
		});
		
		$("#scrolldown").bind("click", function() {
			$(".timeglider-timeline-event").animate({top:"+=100"})
		})
		
		$("#scrollup").bind("click", function() {
			$(".timeglider-timeline-event").animate({top:"-=100"})
		})
		
		tg_actor = tg.data("timeline");
		
		$("#legende").load("timeline/get-json2/names/" + myFriends);
		tg_actor.resize();
    }); // end document-ready
}

function initializeAddFriends(){
		
 	
 	$("#addFriendsTextfield").focusin(function(event) {
 		if($("#addFriendsTextfieldId").val() == "Freunde hinzufügen"){
  			$("#addFriendsTextfieldId").css("background-color", "#FFF");
  			$("#addFriendsTextfieldId").val("");
  		}
 	});

	$(function () {
		var cache = {},
			lastXhr;
		$( "#addFriendsTextfieldId" ).autocomplete({
			minLength: 2,
			select: function(event, ui) { 
				buildFriendArray();
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

function buildFriendArray(){
	var friendName = $("#addFriendsTextfieldId").val();
	var inArray = false;
	for (var i=0; i < myFriends.length; i++) {
	  if (friendName == myFriends[i]) {
	  	inArray = true;
	  };
	};
	if(!inArray){
		myFriends.push(friendName);
	}
	loadFriendToTimeline();
}

function loadFriendToTimeline(){
	buildTimeline()
}



function areFriends (){
	numberOfBilder ++;
	var neuerFreund = myFriends.push($("#addFriendsTextfieldId").val());	 
}

function noFriends(){
	$("#addFriendsTextfieldId").css("background-color", "#F00")
	$("#addFriendsTextfieldId").val("Sie können nur Freunde hinzufügen");
}

