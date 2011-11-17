////////Others //////////
	function clusterDivVisible (){
		document.getElementById('clusterPopUp').style.visibility = 'visible';
	}
	function clusterDivInvisible (){
		document.getElementById('clusterPopUp').style.visibility = 'hidden';
	}
	
////// MAP /////////////
	function initialize() {
    	var latlng = new google.maps.LatLng(48.049915, 8.205328);
    	var myOptions = {
      		zoom: 5,
 			minZoom: 3,
      		center: latlng,
      		mapTypeId: google.maps.MapTypeId.ROADMAP
    	};

		var markerOptions = {
			gridSize: 50
		};

    	var map = new google.maps.Map(document.getElementById("map"), myOptions);	
		var markers = new Array();
		
		for (var i = 0; i < data.ID.length; i++) {	
			
			var dataID = data.ID[i];		
			var kord = new google.maps.LatLng(dataID.latitude, dataID.longitude);
			var marker = new google.maps.Marker({
				position: kord
			//	icon: dataID.image
		 	});	
			markers.push(marker);
		}	
		var markerCluster = new MarkerClusterer(map, markers, markerOptions);
		
		google.maps.event.addListener(markerCluster, "click", function (c) {
			console.log("click");
		});
		google.maps.event.addListener(markerCluster, "mouseover", function (c) {
			if(document.getElementById('PopUp').checked){
				clusterDivVisible();
			}
			console.log("mouseover");	
		});
		google.maps.event.addListener(markerCluster, "mouseout", function (c) {
			console.log("mouseout");	
		});
	}		
//	google.maps.event.addDomListener(window, 'load', initialize);
