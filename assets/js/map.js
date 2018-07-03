
// Array for markers
var gMarkers = [];
var gName;

function initMap() {

	// The location of Manhattan(default)
	var coords = {lat: 40.7831, lng: -73.9712 };

	// The map, centered at Manhattan
	var map = new google.maps.Map(
		document.getElementById('map'), {zoom: 11, center: coords});


	// The marker, positioned at Manhattan
	addMarker({position: coords});

	// Listener to add marker
	google.maps.event.addListener(map, 'rightclick', function(event){
		removeMarkers();
		addMarker({
			position: event.latLng
		});
	})

	/*
	* addMarker function also calls the coordsToAddress function which store it in a global var.
	* Reasoning being that geocoding asychronously calls the function to get location address. 
	* From addMarker click to submit is enough time for the function to return and set the var gName. 
	*/

	function addMarker(props){
		var marker = new google.maps.Marker({
				position: props.position, 
				map: map
		});

		coordsToAddress(props.position, function(address){
			gName = address;
		});

		gMarkers.push(marker);
	}

	function removeMarkers(){
	    for(i = 0; i < gMarkers.length; i++){
	        gMarkers[i].setMap(null);
	    }
	}
}

function getCoords(){
	var position = {};
	
	var lat = gMarkers[gMarkers.length-1].getPosition().lat();
	var lng = gMarkers[gMarkers.length-1].getPosition().lng();
	
	position.name = gName;
	position.lat = lat;
	position.lng = lng;

	return position;
}

function coordsToAddress(latlng, callback){
	var geocoder = new google.maps.Geocoder();

	geocoder.geocode({
		'latLng': latlng
	}, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
	        	callback(results[0]['formatted_address']);
	        }	
	    });
}


function getTaskMediaMap(){

	var coords = {lat: 40.7831, lng: -73.9712 };

	var map = new google.maps.Map(
		document.getElementById('mediaMap'), {zoom: 14, center: coords});

	var marker = new google.maps.Marker({
		position: coords, 
		map: map
	});

}