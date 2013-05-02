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
    
    var latitude = "<?= $_GET['latitude'];?>";
    var longitude = "<?= $_GET['longitude'];?>";

	var s_address, s_latitude, s_longitude;

    function map_initialize() {
    	s_address = $("#s_address");
    	s_latitude = $("#s_latitude");
    	s_longitude = $("#s_longitude");

    	var latLng = new google.maps.LatLng(40.7143528, -74.0059731);
		if (latitude.length > 0 && longitude.length > 0) {
			latLng = new google.maps.LatLng(latitude, longitude);
		} else {
			s_address.html('Cannot determine address at this location.');
			
			return;	
		}

		geocoder = new google.maps.Geocoder();
		map = new google.maps.Map(document.getElementById('map_canvas'), {
			zoom: 8,
			center: latLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		marker = new google.maps.Marker({
			position: latLng,
			title: 'Point A',
			map: map
		});		

		geocodePosition(latLng);
   	}

	function geocodePosition(pos) {
		geocoder.geocode({
			latLng: pos
		}, 
		function(responses) {
			if (responses && responses.length > 0) {
				s_address.html(responses[0].formatted_address);
			} else {
				s_address.html('Cannot determine address at this location.');
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
		<td id="s_latitude"><?= $_GET['latitude'];?></td>
	</tr>
	<tr>
		<td>Longitude:</td>
		<td id="s_longitude"><?= $_GET['longitude'];?></td>
	</tr>
	<tr>
		<td width="75px">Address:</td>
		<td id="s_address"></td>
	</tr>
</table>
 

</body>