var myFriends = new Array();
var tg_actor;

$(document).ready(function() {
	initializeAddFriends();
});

	$(function () { 
		
		var tg1 = $("#placement").timeline({
			"min_zoom":1, 
			"max_zoom":60, 
			"show_centerline":true,
			"data_source":"timeline/get-json",
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
		
		tg_actor = tg1.data("timeline");
		
    }); // end document-ready


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
	tg_actor.load("timeline/get-json/names/" + myFriends);
}



function areFriends (){
	numberOfBilder ++;
	var neuerFreund = myFriends.push($("#addFriendsTextfieldId").val());	 
}

function noFriends(){
	$("#addFriendsTextfieldId").css("background-color", "#F00")
	$("#addFriendsTextfieldId").val("Sie können nur Freunde hinzufügen");
}