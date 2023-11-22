<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca mapę Google.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class MapaGoogle extends Input
{
	
	protected $katalogSzablonu = 'GoogleMapsNew';
	protected $tpl = '
	{{IF $pokaz_wspolrzedne}}
	<div class="lokalizacja" id="{{$nazwa}}">
		{{$etykieta_x}}<input type="text" id="{{$nazwa}}_x" name="{{$nazwa}}_x" value="{{$wartosc_x}}" {{$atrybuty}}/>
		{{$etykieta_y}}<input type="text" id="{{$nazwa}}_y" name="{{$nazwa}}_y" value="{{$wartosc_y}}" {{$atrybuty}}/>
	</div>
	{{ELSE}}
	<div class="lokalizacja" id="{{$nazwa}}">
		<input type="hidden" id="{{$nazwa}}_x" name="{{$nazwa}}_x" value="{{$wartosc_x}}" {{$atrybuty}}/>
		<input type="hidden" id="{{$nazwa}}_y" name="{{$nazwa}}_y" value="{{$wartosc_y}}" {{$atrybuty}}/>
	</div>
	{{END}}
	{{IF $usluga_dostepna}}
	<div id="{{$nazwa}}_mapa"></div>
	<script src="{{$url_google_api}}" type="text/javascript"></script>
	<script type="text/javascript">
	<!--
	$(document).ready(function() {
		if (GBrowserIsCompatible()) {

			$("#{{$nazwa}}_mapa").attr("style", "width:500px; height:500px;margin: 2px;");

			$("#{{$nazwa}}").append(\'<input type="button" name="{{$nazwa}}_butt" id="{{$nazwa}}_uzyj" value="{{$etykieta_uzyj_mapy}}"/>\');

			$("#{{$nazwa}}_uzyj").click(function() {
				if ($("#{{$nazwa}}_mapa").is(":visible")) {
					$("#{{$nazwa}}_mapa").hide();
					$("#{{$nazwa}}_uzyj").val("{{$etykieta_uzyj_mapy}}");
				} else {
					$("#{{$nazwa}}_mapa").show();
					$("#{{$nazwa}}_uzyj").val("{{$etykieta_ukryj_mape}}");
				}
			});

			var mapa = new GMap2($("#{{$nazwa}}_mapa").get(0));
			mapa.addControl(new GSmallMapControl());
			//mapa.addControl(new GLargeMapControl());
			//mapa.addControl(new GOverviewMapControl());

			GEvent.addListener(mapa, "click", function(overlay, point) {
				var px = point.x;
				var py = point.y;
				mapa.clearOverlays();
				mapa.addOverlay(new GMarker(point));
				$("#{{$nazwa}}_x").val("" + point.x + "");
				$("#{{$nazwa}}_y").val("" + point.y + "");
			});
			{{IF sa_dane}}
			var x = \'{{$wartosc_x}}\';
			var zoom = (x.length > 15) ? 14 : 6;
			mapa.setCenter(new GLatLng({{$wartosc_y}},{{$wartosc_x}}), zoom);
			mapa.addOverlay(new GMarker(new GLatLng({{$wartosc_y}},{{$wartosc_x}})))
			{{ELSE}}
			mapa.setCenter(new GLatLng(52.173931692568, 18.8525390625), 6);
			$("#{{$nazwa}}_mapa").hide();
			{{END}}
		}
	});
	-->
	</script>
	{{END}}
	';

	protected $parametry = array(
		'url_google_api' => '', // url do api google (ze strony http://code.google.com/intl/pl/apis/maps/signup.html)
		'pokaz_wspolrzedne' => true,
	);


	/**
	 * Obecna wartosc inputa w formacie tablicowym
	 *
	 * @return Obecjna wartosc inputa.
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
		$temp['x'] = Zadanie::pobierz($this->pobierzNazwe().'_x');
		$temp['y'] = Zadanie::pobierz($this->pobierzNazwe().'_y');
		if ($temp['x'] !== null && $temp['y'] !== null)
		{
			$this->wartosc = $this->filtrujWartosc($temp);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();

		if (!isset($wartosc['x']) || !isset($wartosc['y'])) $wartosc = array('x' => '', 'y' => '');

		$uslugaDostepna = false;
		if ($this->parametry['url_google_api'] != '')
		{
			$url_google_api = parse_url($this->parametry['url_google_api']);
			$test = fsockopen($url_google_api['host'], 80, $errno, $errstr, 1);
			if ($test !== false)
			{
				fclose($test);
				$uslugaDostepna = true;
			}
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc_x' => $wartosc['x'],
			'wartosc_y' => $wartosc['y'],
			'atrybuty' => $this->pobierzAtrybuty(),
			'etykieta_x' => $this->tlumaczenia['input_mapa_google_etykieta_x'],
			'etykieta_y' => $this->tlumaczenia['input_mapa_google_etykieta_y'],
			'etykieta_uzyj_mapy' => $this->tlumaczenia['input_mapa_google_etykieta_uzyj_mapy'],
			'etykieta_ukryj_mape' => $this->tlumaczenia['input_mapa_google_etykieta_ukryj_mape'],
			'pokaz_wspolrzedne' => ($this->parametry['pokaz_wspolrzedne'] || ! $uslugaDostepna) ? true : false,
			'usluga_dostepna' => $uslugaDostepna,
			'url_google_api' => $this->parametry['url_google_api'],
			'sa_dane' => ($wartosc['x'] > 0 && $wartosc['y'] > 0) ? true : false,
		);

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}
}
