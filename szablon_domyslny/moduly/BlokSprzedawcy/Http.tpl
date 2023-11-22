{{BEGIN index}}
<div class="vcard">
	<ul class="pBoxList cName">
		<li>
			<a href="{{$url}}">
			{{BEGIN zdjecie}}
				<div class="photoShell small seller">
					<span class="cell"><img alt="{{escape($sprzedawca)}}" src="{{$url_zdjecia}}"/></span>
				</div>
			{{END}}
			</a>
			<div class="textBox sellerNameDiv{{BEGIN zdjecie}} sellerNameDivNarrow{{END}}">
				<a href="{{$url}}" class="org">{{ $sprzedawca }}</a>
				<span class="sellerNameType"><strong>{{$nazwa_produktu}}</strong></span>
			</div>
		</li>
	</ul>

	<ul class="cData adr">
		<li class="country-name region"><img class="flaga" src="/_szablon/grafika/flagi/{{ $kod_kraju }}.gif" alt="{{ escape($kraj) }}"/> {{$kraj}} {{if($region,'/')}} {{$region}}</li>

	{{ BEGIN lokalizacje}}
		<li class="street-address">{{$ulica}}</li>
		<li class="postal-code locality">{{$kod_pocztowy}} {{$miasto}}</li>
		<li class="tel">{{$telefony}}</li>
	{{ END }}
	</ul>

	<ul class="cData">
		{{if $ilosc_produktow}}<li>{{$opublikowane_produkty}} <a href="{{$url_produkty}}"><strong class="blue">{{$ilosc_produktow}}</strong></a></li>{{end}}
		{{if $ilosc_uslug}}<li>{{$opublikowane_uslugi}} <a href="{{$url_uslugi}}"><strong class="blue">{{$ilosc_uslug}}</strong></a></li>{{end}}
	</ul>
	<ul class="cData">
		<li><a href="{{$url}}"><var class="ico icoWWW"></var>{{$strona_firmowa}}</a></li>
		{{BEGIN formularz_onclick}}
		<li><span onclick="formularz('{{$dane_formularz_kontaktowy}}','{{$dane_formularz_ga}}')"><var class="ico icoMail"></var>{{$wyslij_wiadomosc}}</span></li>
		{{END}}
		<li><a href="javascript:void(0)" id="link_mapka" title="{{ escape($etykieta_link_kontakt) }}"><var class="ico icoMap"></var>{{ $etykieta_link_kontakt }}</a></li>
	</ul>
</div>
{{BEGIN mapa}}
	{{BEGIN marker_info}}<div class="info_mapa"><strong>{{$nazwa}}</strong><p>{{$adres}}</p></div>{{END}}
	{{BEGIN marker_info_trasa}}<div class="info_trasa"><strong>{{$nazwa}}</strong><p>{{$adres}}<br/><strong>{{$etykieta_gps}}</strong> <var>{{$lat}}</var><sup>°</sup>, <var>{{$lng}}</var><sup>°</sup></p><label for="trasa_start">{{$etykieta_pokaz_trase}}</label><input type="text" id="trasa_start" name="trasa_start" value="{{ escape($etykieta_podaj_lokalizacje) }}" class="trasa_box"/><input type="hidden" name="lat" id="lat" value="{{ escape($lat) }}"/><input type="hidden" name="lng" id="lng" value="{{ escape($lng) }}"/><input type="submit" value="{{ escape($etykieta_button_pokaz_trase) }}" class="trasa_button"/></div>{{END}}

<div id="lokalizacja_sprzedawcy" title="{{ escape($sprzedawca) }}" style="display: none;">
	<div class="map_canvas" id="map_canvas"  style="width: 775px; height: 600px;">

	</div>
</div>

<script type="text/javascript">
<!--
function ladujMapy()
{
    var script = document.createElement("script");
    script.src = "http://maps.google.com/maps/api/js?sensor=false&language=pl&callback=poZaladowaniuMap";
    script.type = "text/javascript";
    document.getElementsByTagName("head")[0].appendChild(script);
}

function poZaladowaniuMap()
{
    if (typeof google === 'object' && typeof google.maps === 'object')
    {
	// KOD PO ZALADOWANIU

		var lokalizacje = [];

		{{BEGIN lokalizacja}}
		lokalizacje[{{$id}}] = [];
		lokalizacje[{{$id}}]['lat'] = '{{$lat}}';
		lokalizacje[{{$id}}]['lng'] = '{{$lng}}';
		lokalizacje[{{$id}}]['nazwa'] = '{{$nazwa}}';
		lokalizacje[{{$id}}]['info'] = '{{$info}}';
		lokalizacje[{{$id}}]['info_trasa'] = '{{$info_trasa}}';
		{{END}}

		var max_loc = 0;
		for (var i =0; i<lokalizacje.length; ++i)
		{
			if (lokalizacje[i] != undefined)
			{
				++max_loc;
			}
		}

		var min_lat = '{{$min_lat}}';
		var min_lng = '{{$min_lng}}';
		var max_lat = '{{$max_lat}}';
		var max_lng = '{{$max_lng}}';

		var map;
		var markersArray = [];
		var directionDisplay;
		var directionsService = new google.maps.DirectionsService();
		var infoOpened = false;
		var bounds;
		var maxBoundsZoom = 14;

		function wszystkieLokalizacje() {

			var options = {
				zoom: 8,
				panControl: true,
				mapTypeControl: false,
				zoomControl: true,
				zoomControlOptions: { style: google.maps.ZoomControlStyle.DEFAULT },
				scaleControl: true,
				streetViewControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var SW = new google.maps.LatLng(min_lat,min_lng);
			var NE = new google.maps.LatLng(max_lat,max_lng);
			bounds = new google.maps.LatLngBounds(SW, NE);
			var cnt = bounds.getCenter();

			map = new google.maps.Map(document.getElementById('map_canvas'), options);

			var zoomChangeBoundsListener =
				google.maps.event.addListener(map, 'bounds_changed', function(event) {
					google.maps.event.removeListener(zoomChangeBoundsListener);
					map.setZoom( Math.min( maxBoundsZoom, map.getZoom() ) );
			});

			for (i in lokalizacje)
			{
				var l = lokalizacje[i];
				var latlng = new google.maps.LatLng(l['lat'],l['lng']);

				var marker = new google.maps.Marker({
					position: latlng,
					map: map
				});
				marker.setTitle(l['nazwa']);
				dodajInfo(marker, l['info']);

				bounds.extend(latlng);
			}
			map.fitBounds(bounds);
		}


		function dodajInfo(marker, info, open) {
			var infowindow = new google.maps.InfoWindow({
				content: info,
				size: new google.maps.Size(200,200)
			});
			google.maps.event.addListener(infowindow, 'closeclick', function(){
				infoOpened = false;
			});
			google.maps.event.addListener(marker, 'mouseover', function() {
				if (! infoOpened)
				{
					infowindow.open(map,marker);
					infoOpened = true;
				}
			});
			if (open == true)
			{
				infowindow.open(map,marker);
			}
		}

		wszystkieLokalizacje();

		$( "#lokalizacja_sprzedawcy" ).dialog({
			autoOpen: false,
			show: "blind",
			width: 800,
			modal: true
		});

		$("#lokalizacja_sprzedawcy" ).show().dialog( "open" );
    }
}


$(document).ready(function(){

	$( "#link_mapka" ).click(function() {
		if (typeof google === 'object' && typeof google.maps === 'object') {
			$("#lokalizacja_sprzedawcy" ).show().dialog( "open" );
		} else {
			ladujMapy();
		}
		return false;
	});

});
-->
</script>

{{END}}



{{END}}
{{BEGIN telefony}}
	<strong>{{$opis}}:</strong> {{ $telefon }}<br/>
{{END}}

