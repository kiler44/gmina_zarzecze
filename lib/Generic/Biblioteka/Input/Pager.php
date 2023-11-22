<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca konfigurację stronnicowania.
 *
 * @author Dariusz Poltorak, Krzysztof Lesiczka
 * @package biblioteki
 */

class Pager extends Input
{
	protected $katalogSzablonu = 'PagerNew';
	protected $parametry = array(
		'liczba_wierszy' => 10, //ograniczenie ilosci skokow
	);


	protected $tpl = '
	<table>
		<tr>
			<td>{{$etykieta_wyborZakresu}}</td>
			<td>
				<select name="{{$nazwa}}_pager_wyborZakresu" id="{{$nazwa}}_pager_wyborZakresu">
					<option value="" {{IF $wyborZakresu == \'\'}}selected="selected"{{END}}>{{$wybor_brak}}</option>
					<option value="linki" {{IF $wyborZakresu == \'linki\'}}selected="selected"{{END}}>{{$wybor_linki}}</option>
					<option value="select" {{IF $wyborZakresu == \'select\'}}selected="selected"{{END}}>{{$wybor_select}}</option>
				</select>
			</td>
		</tr>
		<tr id="{{$nazwa}}_pr1">
			<td>{{$etykieta_dostepneZakresy}}</td>
			<td><input type="text" name="{{$nazwa}}_pager_dostepneZakresy" value="{{$dostepneZakresy}}"></td>
		</tr>
		<tr>
			<td>{{$etykieta_skoczDo}}</td>
			<td>
				<input type="checkbox" name="{{$nazwa}}_pager_skoczDo" value="form" {{IF $skoczDo}}checked="checked"{{END}}/>
			</td>
		</tr>
		<tr>
			<td>{{$etykieta_wyborStrony}}</td>
			<td>
				<select name="{{$nazwa}}_pager_wyborStrony" id="{{$nazwa}}_pager_wyborStrony">
					<option value="" {{IF $wyborStrony == \'\'}}selected="selected"{{END}}>{{$wybor_brak}}</option>
					<option value="linki" {{IF $wyborStrony == \'linki\'}}selected="selected"{{END}}>{{$wybor_linki}}</option>
					<option value="select" {{IF $wyborStrony == \'select\'}}selected="selected"{{END}}>{{$wybor_select}}</option>
				</select>
			</td>
		</tr>
		<tr id="{{$nazwa}}_pr2">
			<td>{{$etykieta_poprzedniaNastepna}}</td>
			<td><input type="checkbox" name="{{$nazwa}}_pager_poprzedniaNastepna" value="1" {{IF $poprzedniaNastepna}}checked="checked"{{END}}/></td>
		</tr>
		<tr id="{{$nazwa}}_pr3">
			<td>{{$etykieta_pierwszaOstatnia}}</td>
			<td><input type="checkbox" name="{{$nazwa}}_pager_pierwszaOstatnia" value="1" {{IF $pierwszaOstatnia}}checked="checked"{{END}}/></td>
		</tr>
		<tr id="{{$nazwa}}_pr4">
			<td>{{$etykieta_zakres}}</td>
			<td><input size="2" maxlength="2" type="text" name="{{$nazwa}}_pager_zakres" value="{{$zakres}}"/></td>
		</tr>
		<tr id="{{$nazwa}}_pr5">
			<td>{{$etykieta_skoki}}</td>
			<td>
				<input type="button" value="{{$etykieta_skoki_dodaj}}" class="dodaj_pole" />
				<input type="button" value="{{$etykieta_skoki_usun}}" class="usun_pole" />
			</td>
		</tr>
	</table>
	<table id="{{$nazwa}}_pr6" class="input_pager">
	{{BEGIN wiersze}}
		<tr class="para">
			<td><input type="text" size="3" maxlength="3" name="{{$nazwa}}_pager_skok[]" value="{{$klucz}}" class="input_pager_klucz"/></td>
			<td>{{$etykieta_podzial}}</td>
			<td><input type="text" size="10" name="{{$nazwa}}_pager_skok_etykieta[]" value="{{$wartosc}}" class="input_pager_wartosc"/></td>
		</tr>
	{{END}}
	</table>

	<script type="text/javascript">
	<!--
	$(document).ready(function(){
		function {{$nazwa}}CheckPager()
		{
			if ($("#{{$nazwa}}_pager_wyborZakresu").val() == "")
			{
				$("#{{$nazwa}}_pr1").hide();
			}
			else
			{
				$("#{{$nazwa}}_pr1").show();
			}

			$("#{{$nazwa}}_pr2, #{{$nazwa}}_pr3, #{{$nazwa}}_pr4, #{{$nazwa}}_pr5, #{{$nazwa}}_pr6").hide();

			wybor = $("#{{$nazwa}}_pager_wyborStrony").val();
			if (wybor == \'select\')
			{
				$("#{{$nazwa}}_pr2").show();
			}
			else if (wybor == \'linki\')
			{
				$("#{{$nazwa}}_pr2, #{{$nazwa}}_pr3, #{{$nazwa}}_pr4, #{{$nazwa}}_pr5, #{{$nazwa}}_pr6").show();
			}
		}

		$("#{{$nazwa}}_pager_wyborZakresu, #{{$nazwa}}_pager_wyborStrony").change(function() { {{$nazwa}}CheckPager(); });

		{{$nazwa}}CheckPager();

		$("#{{$nazwa}}_pr5 .dodaj_pole").click(function()
		{
			var input = \'<tr class="para"><td><input type="text" size="3" maxlength="3"  name="{{$nazwa}}_pager_skok[]" value="" class="input_pager_klucz"/></td><td>{{$etykieta_podzial}}</td><td><input type="text" size="10" name="{{$nazwa}}_pager_skok_etykieta[]" value="" class="input_pager_wartosc"/></td></tr>\';

			if ($("#{{$nazwa}}_pr6 .para").length >= {{$liczba_wierszy}})
			{
				return;
			}
			if ($("#{{$nazwa}}_pr6 .para:last").length == 0)
			{
				$("#{{$nazwa}}_pr6").prepend(input);
			}
			else
			{
				$("#{{$nazwa}}_pr6 .para:last").after(input);
			}
			$("#{{$nazwa}}_pr6 .para:last").show("fast");
		});

		$("#{{$nazwa}}_pr5 .usun_pole").click(function(){
			if ($("#{{$nazwa}}_pr6 .para").length > 1)
			{
				$("#{{$nazwa}}_pr6 .para:last").fadeOut("normal").remove();
			}
		});
	});
	-->
	</script>
	';



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

		// najpierw pobieramy wartosci stałe
		$temp = array();
		$temp['zakres'] = Zadanie::pobierz($this->pobierzNazwe().'_pager_zakres');
		$temp['wyborStrony'] = Zadanie::pobierz($this->pobierzNazwe().'_pager_wyborStrony');
		$temp['wyborZakresu'] = Zadanie::pobierz($this->pobierzNazwe().'_pager_wyborZakresu');
		$temp['pierwszaOstatnia'] = Zadanie::pobierz($this->pobierzNazwe().'_pager_pierwszaOstatnia');
		$temp['poprzedniaNastepna'] = Zadanie::pobierz($this->pobierzNazwe().'_pager_poprzedniaNastepna');
		$temp['dostepneZakresy'] = Zadanie::pobierz($this->pobierzNazwe().'_pager_dostepneZakresy');
		$temp['skoczDo'] = Zadanie::pobierz($this->pobierzNazwe().'_pager_skoczDo');
		if ($temp['skoczDo'] != null)
		{
			$temp['skoczDo'] = 'form';
		}
		// usuwamy zbedne puste pola
		foreach($temp as $k => $w)
		{
			if ($w === null)
			{
				unset($temp[$k]);
			}
		}
		// uzupelniamy tablice skokami do dalszych stron jezeli takie istnieja i sa prawidlowe
		$skoki = Zadanie::pobierz($this->pobierzNazwe().'_pager_skok');
		if (is_array($skoki) && count($skoki) > 0)
		{
			$etykiety = Zadanie::pobierz($this->pobierzNazwe().'_pager_skok_etykieta');
			foreach ($skoki as $nr => $skok)
			{
				if ((int)$skok != 0) $temp[$skok] = $etykiety[$nr];
			}
		}

		if (count($temp) > 0)
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
		$this->parametry['liczba_wierszy'] = ($this->parametry['liczba_wierszy'] > 0 && $this->parametry['liczba_wierszy'] <= 100) ? (int)$this->parametry['liczba_wierszy'] : 100;

		$dane = $this->pobierzWartosc();

		$pola = array(
			'zakres',
			'dostepneZakresy',
			'wyborStrony',
			'wyborZakresu',
			'skoczDo',
			'pierwszaOstatnia',
			'poprzedniaNastepna',
		);

		foreach ($pola as $pole)
		{
			if (isset($dane[$pole]))
			{
				$$pole = $dane[$pole];
				unset($dane[$pole]);
			}
			else
			{
				$$pole = '';
			}
		}
		if (count($dane) < 1) $dane = array('' => '');

		$dane_szablonu = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_zakres' => $this->tlumaczenia['input_pager_etykieta_zakres'],
			'etykieta_dostepneZakresy' => $this->tlumaczenia['input_pager_etykieta_dostepneZakresy'],
			'etykieta_wyborStrony' => $this->tlumaczenia['input_pager_etykieta_wyborStrony'],
			'etykieta_wyborZakresu' => $this->tlumaczenia['input_pager_etykieta_wyborZakresu'],
			'etykieta_skoczDo' => $this->tlumaczenia['input_pager_etykieta_skoczDo'],
			'etykieta_pierwszaOstatnia' => $this->tlumaczenia['input_pager_etykieta_pierwszaOstatnia'],
			'etykieta_poprzedniaNastepna' => $this->tlumaczenia['input_pager_etykieta_poprzedniaNastepna'],
			'etykieta_skoki' => $this->tlumaczenia['input_pager_etykieta_skoki'],
			'etykieta_skoki_dodaj' => $this->tlumaczenia['input_pager_etykieta_skoki_dodaj'],
			'etykieta_skoki_usun' => $this->tlumaczenia['input_pager_etykieta_skoki_usun'],
			'etykieta_podzial' => $this->tlumaczenia['input_pager_etykieta_podzial'],

			'wybor_brak' => $this->tlumaczenia['input_pager_wybor_brak'],
			'wybor_linki' => $this->tlumaczenia['input_pager_wybor_linki'],
			'wybor_select' => $this->tlumaczenia['input_pager_wybor_select'],
			'wyborZakresu' => $wyborZakresu,
			'dostepneZakresy' => $dostepneZakresy,
			'skoczDo' => $skoczDo,
			'wyborStrony' => $wyborStrony,
			'poprzedniaNastepna' => $poprzedniaNastepna,
			'pierwszaOstatnia' => $pierwszaOstatnia,
			'zakres' => intval($zakres),
			'liczba_wierszy' => $this->parametry['liczba_wierszy'],
		);

		$this->szablon->ustawGlobalne($dane_szablonu);

		$licznik = 0;
		foreach ($dane as $klucz => $wartosc)
		{
			$dane['wiersze'][] = array(
				'klucz' => htmlspecialchars($klucz),
				'wartosc' => htmlspecialchars($wartosc),
			);

			$licznik++;
			if ($licznik >= $this->parametry['liczba_wierszy']) break;
		}

		$this->szablon->ustaw($dane_szablonu);

		return $this->szablon->parsuj();
	}
}