<div id="map"> 
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDt-mNNI1fzAwteBIng_6Ub_BCjk9JacCQ"></script>
	<div id="mymap">
	</div>	
</div>


<script>	
jQuery(document).ready(function() {

			var locations = [
				//Loop
				['<div> <h6>Entidade</h6>' +
							'Rua...,<br> 4520-000 Localidade<br><br>' +
								'<a href="https://www.google.com/maps/place/data=" target="_blank" rel="noopener" title="Localização" aria-label="Localização">'+
									'Google Maps' +
								'</a>' +
				'</div>',
				40.974220684914705, -8.487660002142976 ],
				//Loop
			];
			var map_center = new google.maps.LatLng(40.974220684914705, -8.487660002142976);


			var map_icon = "../googlemaps/marker.png";
			
            // Map Options
			var map = new google.maps.Map(document.getElementById('mymap'), {
                zoom: 14,
                center: map_center,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
				draggable: true,	
				gestureHandling: 'cooperative',
				panControl: false,
				zoomControl: true,	
				mapTypeControl: false,				
				streetViewControl: false,
                scrollwheel: false,
                // Google Map Color Styles
				styles:
[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]				
 				});


			var infowindow = new google.maps.InfoWindow;
			
			var marker, i;
			
			for (i = 0; i < locations.length; i++) {  
				marker = new google.maps.Marker({
					 position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					 map: map,
					 icon: map_icon
				});

				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					 return function() {
						 infowindow.setContent(locations[i][0]);
						 infowindow.open(map, marker);
					 }
				})(marker, i));
			}
			

});	
	
</script>