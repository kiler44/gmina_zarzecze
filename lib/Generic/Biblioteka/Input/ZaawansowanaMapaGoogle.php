<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Input Zaawansowana Mapa Google.
 *
 * @author Łukasz Wrucha
 */

class ZaawansowanaMapaGoogle extends Input
{
	protected $katalogSzablonu = 'GoogleMapsAdvanceNew';
	protected $tpl = '
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">

	var tlumaczenia = [];
	tlumaczenia["problem"] = "{{$input_problem}}";
	tlumaczenia["ZERO_RESULTS"] = "{{$ZERO_RESULTS}}";
	tlumaczenia["OVER_QUERY_LIMIT"] = "{{$OVER_QUERY_LIMIT}}";
	tlumaczenia["REQUEST_DENIED"] = "{{$REQUEST_DENIED}}";
	tlumaczenia["INVALID_REQUEST"] = "{{$INVALID_REQUEST}}";

	var markersArray = [];

	$(document).ready(function(){
		initialize();
		poprawWygladMapy();

		$("#{{$nazwa}}_szukaj").click(function(){
			if ($("#{{$nazwa}}_adres").val() != \'\') codeAddress();
		});
		$("#{{$nazwa}}_adres").keypress(function(event){
			if(event.keyCode == \'13\')
			{
				event.preventDefault();
				if ($(this).val() != \'\')
				{
					setTimeout(function(){
						$("#{{$nazwa}}_szukaj").click()
					}, 50);
				}
			}
		});
	});
	var geocoder;
	var map;
	function initialize() {
		geocoder = new google.maps.Geocoder();
		{{IF $poprawne_wspolrzedne}}
		var latlng = new google.maps.LatLng({{$wartosc_szerokosc}}, {{$wartosc_dlugosc}});
		{{ELSE}}
		var latlng = new google.maps.LatLng(52.173931692568, 18.8525390625);
		{{END}}

		var options = {
			zoom: {{$zoom}},
			center: latlng,
			panControl: true,
			mapTypeControl: false,
			zoomControl: true,
			zoomControlOptions: { style: google.maps.ZoomControlStyle.DEFAULT },
			scaleControl: true,
			streetViewControl: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById("map_canvas"), options);
		google.maps.event.addListener(map, \'click\', function(event){
			point = event.latLng;
			deleteOverlays();
			addMarker(event.latLng);
		});

		{{IF $poprawne_wspolrzedne}}
		addMarker(latlng);
		{{END}}

		{{IF $poprawny_zoom}}
		map.setZoom({{$wartosc_zoom}});
		{{END}}
	}

	function codeAddress()
	{
		deleteOverlays();
		var adres = $("#{{$nazwa}}_adres").val();
		geocoder.geocode({ \'address\': adres}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK)
			{
				map.setCenter(results[0].geometry.location);
				map.fitBounds(results[0].geometry.viewport);
				addMarker(results[0].geometry.location);
			}
			else
			{
				confirmLightbox(null, "", tlumaczenia["problem"] + tlumaczenia[status], "eWarning", "info");
			}
		});
	}

	function addMarker(point)
	{
		var marker = new google.maps.Marker({
			position: point,
			map: map
		});
		markersArray.push(marker);
		$("#{{$nazwa}}_szerokosc").val("" + point.lat() + "");
		$("#{{$nazwa}}_dlugosc").val("" + point.lng() + "");
		$("#{{$nazwa}}_zoom").val(map.getZoom());
	}

	function deleteOverlays()
	{
		if (markersArray) {
			for (i in markersArray)
			{
				markersArray[i].setMap(null);
			}
			markersArray.length = 0;
		}
	}

	function poprawWygladMapy()
	{
		if($("#{{$nazwa}}ContainerBox").next().next().next().next().text() != "")
		{
			$("#{{$nazwa}}ContainerBox").css("border", "1px solid #e00");
		}
	}
	</script>
	{{IF $wersja_mini}}
		<div id="{{$nazwa}}ContainerBox" style="margin-left:415px; position:absolute; float:right; width:300px; height:420px; padding:15px; background-color:#F2F3F5;" class="gray-bg">
			<h2 style="font-size:14px; margin-bottom: 0px;">{{$input_tytul}}</h2>
			<div style="margin-top:5px; margin-bottom:5px;">
				<p><input id="{{$nazwa}}_adres" type="text" value="" class="medium" />
				<span class="btn mid map"><input type="button" value="{{$etykieta_geolokalizacja}}" id="{{$nazwa}}_szukaj" class="buttonSet buttonLight" /></span></p>
			</div>
			<div id="map_canvas" style="width: 300px; height: 342px;"></div>
		</div>
	{{ELSE}}
		<div style="height:40px;">
			<input id="{{$nazwa}}_adres" type="text" value="" style="width: 370px; height: 19px"/>
			<span class="btn mid map"><input class="buttonSet buttonLight" type="button" value="{{$etykieta_geolokalizacja}}" id="{{$nazwa}}_szukaj"/></span>
		</div>
		<div id="map_canvas" style="width: 500px; height: 500px"></div>
	{{END}}
	<input type="hidden" id="{{$nazwa}}_szerokosc" name="{{$nazwa}}_szerokosc" value="{{$wartosc_szerokosc}}" {{$atrybuty}}/>
	<input type="hidden" id="{{$nazwa}}_dlugosc" name="{{$nazwa}}_dlugosc" value="{{$wartosc_dlugosc}}" {{$atrybuty}}/>
	<input type="hidden" id="{{$nazwa}}_zoom" name="{{$nazwa}}_zoom" value="{{$wartosc_zoom}}" {{$atrybuty}}/>
	';

	protected $parametry = array(
		'url_google_api' => '', // url do api google (ze strony http://code.google.com/intl/pl/apis/maps/signup.html)
		'pokaz_wspolrzedne' => true,
		'geolokalizacja' => true,
		'wyznacz_trase' => true,
		'wersja' => null,
	);


	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();

		if (!isset($wartosc['szerokosc']) || !isset($wartosc['dlugosc'])) $wartosc = array('szerokosc' => '', 'dlugosc' => '');
		if (!isset($wartosc['zoom'])) $wartosc['zoom'] = '';

		$poprawne_wspolrzedne = false;
		if ((isset($wartosc['szerokosc']) && isset($wartosc['dlugosc'])) &&
			(is_numeric($wartosc['szerokosc']) && is_numeric($wartosc['dlugosc'])) &&
			($wartosc['szerokosc'] > -90 && $wartosc['szerokosc'] < 90) &&
			($wartosc['dlugosc'] > -180 && $wartosc['dlugosc'] < 180))
		{
			$poprawne_wspolrzedne = true;
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'poprawne_wspolrzedne' => $poprawne_wspolrzedne,
			'wartosc_szerokosc' => $wartosc['szerokosc'],
			'wartosc_dlugosc' => $wartosc['dlugosc'],
			'wartosc_zoom' => $wartosc['zoom'],
			'zoom' => ($wartosc['zoom'] > 0) ? $wartosc['zoom'] : 6,
			'wersja_mini' => ($this->parametry['wersja'] == 'mini') ? true : false,

			'etykieta_x' => $this->tlumaczenia['input_zaawansowana_mapa_googla_etykieta_x'],
			'etykieta_y' => $this->tlumaczenia['input_zaawansowana_mapa_googla_etykieta_y'],
			'etykieta_uzyj_mapy' => $this->tlumaczenia['input_zaawansowana_mapa_googla_etykieta_uzyj_mapy'],
			'etykieta_ukryj_mape' => $this->tlumaczenia['input_zaawansowana_mapa_googla_etykieta_ukryj_mape'],
			'etykieta_geolokalizacja' => $this->tlumaczenia['input_zaawansowana_mapa_googla_etykieta_geolokalizacja'],
			'input_problem' => $this->tlumaczenia['input_zaawansowana_mapa_googla_problem'],
			'input_tytul' => $this->tlumaczenia['input_zaawansowana_mapa_googla_tytul'],
			'ZERO_RESULTS' => $this->tlumaczenia['input_zaawansowana_mapa_googla_kody_bledow']['ZERO_RESULTS'],
			'OVER_QUERY_LIMIT' => $this->tlumaczenia['input_zaawansowana_mapa_googla_kody_bledow']['OVER_QUERY_LIMIT'],
			'REQUEST_DENIED' => $this->tlumaczenia['input_zaawansowana_mapa_googla_kody_bledow']['REQUEST_DENIED'],
			'INVALID_REQUEST' => $this->tlumaczenia['input_zaawansowana_mapa_googla_kody_bledow']['INVALID_REQUEST'],
		);

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}



	/**
	 * Obecna wartosc inputa w formacie tablicowym
	 *
	 * @return Obecna wartosc inputa.
	 */
	function pobierzWartosc()
	{
		if ($this->wymusPoczatkowa)
		{
			return $this->pobierzWartoscPoczatkowa();
		}
		if ($this->filtrowany)
		{
			return $this->wartosc;
		}
		$temp = array();
		$temp['szerokosc'] = Zadanie::pobierz($this->pobierzNazwe().'_szerokosc');
		$temp['dlugosc'] = Zadanie::pobierz($this->pobierzNazwe().'_dlugosc');
		$temp['zoom'] = Zadanie::pobierz($this->pobierzNazwe().'_zoom');
		if ($temp['szerokosc'] != '' && $temp['dlugosc'] != '')
		{
			$this->wartosc = $this->filtrujWartosc($temp);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}

}