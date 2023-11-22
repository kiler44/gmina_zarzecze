<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole do ustalania wielkosci miniatur.
 *
 * @author Dariusz Poltorak, Krzysztof Lesiczka
 * @package biblioteki
 */

class Miniatury extends Input
{
	protected $katalogSzablonu = 'ThumbnailsNew';
	protected $tpl = '
	<table id="{{$nazwa}}" class="input_miniatury" border="0">
	{{BEGIN wiersz}}
		<tr class="wiersz_minatury">
			<td>{{$etykieta_kod}}<input type="text" size="10" name="{{$nazwa}}_min_kod[]" value="{{$kod}}"></td>
			<td>{{$etykieta_szerokosc}} <input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_szerokosc[]" value="{{$szerokosc}}"></td>
			<td>{{$etykieta_wysokosc}} <input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_wysokosc[]" value="{{$wysokosc}}"></td>
			<td>{{$etykieta_metoda}}
			<select name="{{$nazwa}}_min_metoda[]">
				<option value="scale" {{IF $metoda == \'scale\'}}selected="selected"{{END}}>{{$metoda_scale}}</option>
				<option value="crop" {{IF $metoda == \'crop\'}}selected="selected"{{END}}>{{$metoda_crop}}</option>
				<option value="scaleCrop" {{IF $metoda == \'scaleCrop\'}}selected="selected"{{END}}>{{$metoda_scaleCrop}}</option>
				<option value="resize" {{IF $metoda == \'resize\'}}selected="selected"{{END}}>{{$metoda_resize}}</option>
			</select></td>
		</tr>
	{{END}}
	</table>
	<div class="input_miniatury" id="{{$nazwa}}_control">
		<input type="button" value="{{$etykieta_dodaj_pole}}" class="dodaj_pole" />
		<input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole" />
	</div>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			var input = \'<tr class="wiersz_minatury"><td>{{$etykieta_kod}}<input type="text" size="10" name="{{$nazwa}}_min_kod[]" value=""></td><td>{{$etykieta_wysokosc}}<input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_wysokosc[]" value=""></td><td>{{$etykieta_szerokosc}}<input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_szerokosc[]" value=""></td><td>{{$etykieta_metoda}}<select name="{{$nazwa}}_min_metoda[]"><option value="scale">{{$metoda_scale}}</option><option value="crop">{{$metoda_crop}}</option><option value="resize">{{$metoda_resize}}</option></select></td></tr>\';

			if ($("#{{$nazwa}} .wiersz_minatury").length >= {{$liczba_wierszy}})
			{
				return;
			}
			if ($("#{{$nazwa}} .wiersz_minatury:last").length == 0)
			{
				$("#{{$nazwa}}").prepend(input);
			}
			else
			{
				$("#{{$nazwa}} .wiersz_minatury:last").after(input);
			}
			$("#{{$nazwa}} .wiersz_minatury:last").show("fast");
		});

		$("#{{$nazwa}}_control .usun_pole").click(function()
		{
			if ($("#{{$nazwa}} .wiersz_minatury").length > 1)
			{
				$("#{{$nazwa}} .wiersz_minatury:last").fadeOut("normal").remove();
			}
		});
	});
	-->
	</script>
	';

	protected $parametry = array(
		'liczba_wierszy' => 1000, //ograniczenie ilosci wierszy
	);


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
		$temp = null;
		$klucze = Zadanie::pobierz($this->pobierzNazwe().'_min_kod');
		if (is_array($klucze))
		{
			$wysokosc = Zadanie::pobierz($this->pobierzNazwe().'_min_wysokosc');
			$szerokosc = Zadanie::pobierz($this->pobierzNazwe().'_min_szerokosc');
			$metoda = Zadanie::pobierz($this->pobierzNazwe().'_min_metoda');
			$temp = array();
			foreach ($klucze as $nr => $klucz)
			{
				if (isset($szerokosc[$nr]) && isset($wysokosc[$nr]) && isset($metoda[$nr]))
				{
					$temp[$klucz] = (int)$szerokosc[$nr].'.'.(int)$wysokosc[$nr].'.'.$metoda[$nr];
				}
			}
		}
		if (is_array($temp) && count($temp) > 0)
		{
			$this->wartosc = $temp;
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	function pobierzHtml()
	{
		$this->parametry['liczba_wierszy'] = ($this->parametry['liczba_wierszy'] > 0 && $this->parametry['liczba_wierszy'] <= 1000) ? (int)$this->parametry['liczba_wierszy'] : 1000;

		$wartosc = $this->pobierzWartosc();

		$wiersze = array();
		if (is_array($wartosc) || count($wartosc) > 0)
		{
			foreach ($wartosc as $kod => $parametry)
			{
				$parametry = explode('.', $parametry);
				if (count($parametry) != 3)
				{
					trigger_error("Nieprawidlowe parametry miniatury $kod => ".implode('.', $parametry).', wiersz pominiety', E_USER_NOTICE);
				}
				$wiersze[] = array(
					'kod' => $kod,
					'szerokosc' => $parametry[0],
					'wysokosc' => $parametry[1],
					'metoda' => $parametry[2],
				);
			}
		}
		else
		{
			$wiersze[] = array(
				'kod' => '',
				'wysokosc' => '',
				'szerokosc' => '',
				'metoda' => '',
			);
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_kod' => $this->tlumaczenia['input_miniatury_etykieta_kod'],
			'etykieta_wysokosc' => $this->tlumaczenia['input_miniatury_etykieta_wysokosc'],
			'etykieta_szerokosc' => $this->tlumaczenia['input_miniatury_etykieta_szerokosc'],
			'etykieta_metoda' => $this->tlumaczenia['input_miniatury_etykieta_metoda'],

			'metoda_scale' => $this->tlumaczenia['input_miniatury_metoda_scale'],
			'metoda_crop' => $this->tlumaczenia['input_miniatury_metoda_crop'],
			'metoda_scaleCrop' => $this->tlumaczenia['input_miniatury_metoda_scaleCrop'],
			'metoda_resize' => $this->tlumaczenia['input_miniatury_metoda_resize'],

			'etykieta_dodaj_pole' => $this->tlumaczenia['input_miniatury_etykieta_dodaj_pole'],
			'etykieta_usun_pole' => $this->tlumaczenia['input_miniatury_etykieta_usun_pole'],

			'liczba_wierszy' => $this->parametry['liczba_wierszy'],
		);

		$this->szablon->ustawGlobalne($dane);

		$html = '<table id="'.$this->pobierzNazwe().'" class="input_miniatury" border="0">';
		$licznik = 0;
		foreach ($wiersze as $wiersz)
		{
			$dane['wiersz'][] = array(
				'metoda' => $wiersz['metoda'],
				'kod' => $wiersz['kod'],
				'wysokosc' => $wiersz['wysokosc'],
				'szerokosc' => $wiersz['szerokosc'],
			);

			$licznik++;
			if ($licznik >= $this->parametry['liczba_wierszy']) break;
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}
