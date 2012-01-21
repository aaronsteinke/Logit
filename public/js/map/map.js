var map;
var maplatlng;
var markerOptions = {gridSize: 50,maxZoom:20,};
var LatLngMyBounds;
var dataID;		
var bigImage;
var kord;
var aktualisiereMarker;
var markerCluster;
var markers = new Array();
var markersWindow = new Array();


function initializeMap() {
	placeMap();
	placeMarker();
	initMapChanges();
}

function placeMap(){
   	maplatlng = new google.maps.LatLng(48.049915, 8.205328);
   	var myOptions = {
    	zoom: 5,
 		minZoom: 3,
      	center: maplatlng,
      	mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    map = new google.maps.Map(document.getElementById("map"), myOptions);	
	
}

function placeNewMarkers(){
	$('#mapJson').load('map/get-json/lat1/' + LatLngMyBounds1.lat() + '/lng1/' + LatLngMyBounds1.lng() + "/usernames/" + myFriends.join(","), function(){
		placeMarker();
	});
}

function placeMarker(){	
	
	markers = new Array();
	markersWindow = new Array();
	if(markerCluster){
		markerCluster.clearMarkers();
	}
	for (var i = 0; i < data.ID.length; i++) {	
		dataID = data.ID[i];		
		bigImage = dataID.bigPicture;
		kord = new google.maps.LatLng(dataID.latitude, dataID.longitude);
		var marker = new google.maps.Marker({
			position: kord,
			icon: dataID.image,
			idOfMarker: i, 
			imageId:dataID.id
		});
		markers.push(marker);
		var infoWindow = new google.maps.InfoWindow({
  			content:"<div id=mapInfoWindowContainer>" +"<img style='height:95%;' src='" + bigImage + "'> </img>" + "</div>",
		position: kord
		});
		markersWindow.push(infoWindow);
		
		google.maps.event.addListener(markers[i], 'click', function() {
			markersWindow[this.idOfMarker].open(map, this);
		});
	}		
	markerCluster = new MarkerClusterer(map, markers, markerOptions);
	console.log(markerCluster);
}	

	
function getImageOnTimeline(){
		var l=0;
	for(var k = markers[0].imageId; k >= 0; k--){
		l++;
		if(k == idOFImageShowInMap){
			aktualisiereMarker = markers[l];
			map.panTo(aktualisiereMarker.position);
			return;	
		}
	}
}	

function initMapChanges(){
	google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
    	getMyBounds();
	});
	getMyBoundsZoom();
  	centerChangeListener = google.maps.event.addListener(map,'center_changed', getCenterBounds);
}
  	
function getCenterBounds (event) {
	google.maps.event.removeListener(centerChangeListener);
	setTimeout(getMyBoundsCenter, 500); 
}
function getMyBoundsZoom(){
	zoomChangeListener = google.maps.event.addListener(map,'zoom_changed',function (event) {
		google.maps.event.removeListener(zoomChangeListener);
		setTimeout(getMyBoundsZoom, 500); 
  	});
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
	placeNewMarkers();
}