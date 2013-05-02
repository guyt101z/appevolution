<html>
<head>
	<title>Find location in google map</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
</head>
<body>

<script type="text/javascript">
	var map;
    var geocoder;
    var marker;
    
    var store_location = $(window.parent.document).find("#store_location");
    var store_latitude = $(window.parent.document).find("#store_latitude");
	var store_longitude = $(window.parent.document).find("#store_longitude");

	var s_location, s_latitude, s_longitude;

    function map_initialize() {
    	s_location = $("#s_location");
    	s_latitude = $("#s_latitude");
    	s_longitude = $("#s_longitude");

    	s_latitude.html(store_latitude.val());
    	s_longitude.html(store_longitude.val());
    	s_location.val(store_location.val());

    	geocoder = new google.maps.Geocoder();
    	
    	var latLng = new google.maps.LatLng(40.7143528, -74.0059731);
		if (store_latitude.val().length > 0 && store_longitude.val().length > 0) {
			latLng = new google.maps.LatLng(store_latitude.val(), store_longitude.val());
		} else {
			s_latitude.html(latLng.lat());
	    	s_longitude.html(latLng.lng());	    	
		}
		
		map = new google.maps.Map(document.getElementById('map_canvas'), {
			zoom: 8,
			center: latLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		marker = new google.maps.Marker({
			position: latLng,
			title: 'Point A',
			map: map,
			draggable: true
		});
		
		google.maps.event.addListener(map, 'click', function(e) {
			geocoder.geocode({
				'latLng': e.latLng,
				'partialmatch': true
			}, 
			function(results, status) {
				if (status == 'OK' && results.length > 0) {
			    	map.setCenter(results[0].geometry.location);

			    	marker.setPosition(e.latLng);

			    	updateMarkerPosition(marker.getPosition());
			    	s_location.val(results[0].formatted_address);
			    } else {
			    	alert("Geocode was not successful for the following reason: " + status);
			    }
	    	});
		});

		google.maps.event.addListener(marker, 'drag', function() {
			updateMarkerPosition(marker.getPosition());
		});
		
		google.maps.event.addListener(marker, 'dragend', function() {
			geocodePosition(marker.getPosition());
		});

		if (s_location.val().length > 0) {
			find_location();
		} else {
			geocodePosition(latLng);
		}
   	}

    function updateMarkerPosition(latLng) {
    	s_latitude.html(latLng.lat());
    	s_longitude.html(latLng.lng());
	}
    
	function geocodePosition(pos) {
		geocoder.geocode({
			latLng: pos
		}, 
		function(responses) {
			if (responses && responses.length > 0) {
				s_location.val(responses[0].formatted_address);
			} else {
				s_location.val('Cannot determine address at this location.');
			}
		});
	}

	function set_location() {
		store_location.val(s_location.val());
		store_latitude.val(s_latitude.html());
		store_longitude.val(s_longitude.html());
	}

   	function find_location() {
   		geocoder.geocode({
			'address': s_location.val(),
			'partialmatch': true
		}, 
		function(results, status) {
			if (status == 'OK' && results.length > 0) {
		    	map.setCenter(results[0].geometry.location);

		    	marker.setPosition(results[0].geometry.location);

		    	updateMarkerPosition(marker.getPosition());
		    	s_location.val(results[0].formatted_address);
		    } else {
		    	alert("Geocode was not successful for the following reason: " + status);
		    }
    	});
   	}
 
	google.maps.event.addDomListener(window, 'load', map_initialize);
</script>

<div id="map_canvas" style="width:700px; height:350px;"></div>
<br /><br />
<table border="0">
	<tr>
		<td>Latitude:</td>
		<td id="s_latitude"></td>
	</tr>
	<tr>
		<td>Longitude:</td>
		<td id="s_longitude"></td>
	</tr>
	<tr>
		<td width="75px">Address:</td>
		<td><input type="text" id="s_location" style="width: 600px;"/></td>
	</tr>
	<tr>
		<td />
		<td>
			<input type="button" value="find location" onclick="find_location()"/>&nbsp;
			<input type="button" value="set location" onclick="set_location()" />
		</td>
	</tr>
</table>
 

</body>