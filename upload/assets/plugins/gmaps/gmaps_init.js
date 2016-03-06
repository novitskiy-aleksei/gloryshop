/*!
 * GMaps init ifelement exist
 */
$(document).ready(function(){
		var elem_screen_last_width = elem_screen_width();
		$(window).resize(function() { 
			  elem_screen_last_width = elem_screen_width();
			  elem_google_map_with_text();
		});
		function elem_screen_width(){
			return document.documentElement.clientWidth || document.body.clientWidth || window.innerWidth;
		}
		
		//---------------------------------------------> Google map
		elem_google_map_with_text();
		function elem_google_map_with_text(){
			$(".col-md-4 .google_map, .col-md-6 .google_map, .col-md-3 .google_map, .col-md-9 .google_map").each(function(index, element) {
				  var widthy = $(this).innerWidth();
				  $(this).height(widthy/2);
			});
		}
		
		$(".google_map").each(function(index, element) {
			var main_lato = $(this).attr("data-lat");
			var main_longo = $(this).attr("data-long");
			var enable_main = $(this).attr("data-main");
			var main_texto = $(this).attr("data-text");
			
			var arr = []; var arr_con = []; var arr_text = [];
			
			var total = $(this).find(".location").length;
			$(this).find(".location").each(function(i) {
				var lato = $(this).attr("data-lat");
				var longo = $(this).attr("data-long");
				var texto = $(this).attr("data-text");
				arr_text.push( texto );
				arr = [lato,longo];
				arr_con.push( arr );
				//if (i === total - 1) {}
			});

			var map;
			if (typeof GMaps !== 'undefined') {
				map = new GMaps({
					el: element,
					scrollwheel: false,
					lat: main_lato,
					lng: main_longo,
				});
				if(total === 0 || enable_main == "yes" ){
					map.addMarker({
						lat: main_lato,
						lng: main_longo,
						icon: "http://localhost/0000_OpenCart/000_proteus_2031/assets/theme/images/map2.png",
						infoWindow: {
							content: main_texto
						}
					});
				}
				if (total > 0){
					map.getElevations({
						locations : arr_con,
						callback : function (result, status){
							if (status == google.maps.ElevationStatus.OK) {
								for (var i in result){
									if (result.hasOwnProperty(i)) {
										map.addMarker({
											lat: result[i].location.lat(),
											lng: result[i].location.lng(),
											icon: "http://localhost/0000_OpenCart/000_proteus_2031/assets/theme/images/map.png",
											//title: 'Marker with InfoWindow',
											infoWindow: {
												content: arr_text[i]
											}
										});
									}
								}
							}
						}
					});
				}
			}
		});
		$(".google_map").each(function(index) {
			var con_index = index + 1;
			var id_name = "map" + con_index;
			$(this).attr('id', id_name);
		});
});