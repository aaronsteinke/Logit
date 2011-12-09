
////////Others //////////
	function clusterDivVisible (){
		document.getElementById('clusterPopUp').style.visibility = 'visible';
	}
	function clusterDivInvisible (){
		document.getElementById('clusterPopUp').style.visibility = 'hidden';
	}
	
////// MAP /////////////
var LatLngMyBounds

function initialize() {
   	var latlng = new google.maps.LatLng(48.049915, 8.205328);
   	var myOptions = {
    	zoom: 5,
 		minZoom: 3,
      	center: latlng,
      	mapTypeId: google.maps.MapTypeId.ROADMAP,
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
			/*icon: dataID.image*/
		});	
		markers.push(marker);
	}	
		
	//Get Bounds first time	
	google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
    	getMyBounds();
	});
	zoomChangeListener = google.maps.event.addListener(map,'zoom_changed',function (event) {
		setTimeout(getMyBounds, 500); 
  	});
  	centerChangeListener = google.maps.event.addListener(map,'center_changed', getCenterBounds);
  	function getCenterBounds (event) {
  		google.maps.event.removeListener(centerChangeListener);
		setTimeout(getMyBoundsCenter, 500); 
  	}
  	
	function getMyBounds(){
		getNewJson();
	}
	function getMyBoundsCenter(){
		getNewJson();
		centerChangeListener = google.maps.event.addListener(map,'center_changed', getCenterBounds);
	}
	
  	function getNewJson(){
  		LatLngMyBounds = map.getBounds();
  		LatLngMyBounds1 = LatLngMyBounds.getNorthEast();
  		LatLngMyBounds2 = LatLngMyBounds.getSouthWest();
		$('#mapJson').load('map/get-json/lat1/' + LatLngMyBounds1.lat() + '/lng1/' + LatLngMyBounds1.lng() + '/lat2/' + LatLngMyBounds2.lat() + '/lng2/' + LatLngMyBounds2.lng());
  	}
		
	
	//zoom_changed und center_changed	
	var markerCluster = new MarkerClusterer(map, markers, markerOptions);
		
			
		
		/*
		google.maps.event.addListener(markerCluster, "click", function (c) {
		});
		google.maps.event.addListener(markerCluster, "mouseover", function (c) {
			if(document.getElementById('PopUp').checked){
				clusterDivVisible();
			}
		});
		google.maps.event.addListener(markerCluster, "mouseout", function (c) {
		});*/
}		
//	google.maps.event.addDomListener(window, 'load', initialize);
