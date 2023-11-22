<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca wielokrotne pole tekstowe(text) i listy rozwijanej(select).
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Atrybuty extends Input
{
	protected $katalogSzablonu = 'AttributesNew';
	protected $tpl = '
	<table id="{{$nazwa}}" class="input_array" border="0">
	{{BEGIN wartosci}}
		<tr class="para">
			<td><input type="text" name="{{$nazwa}}_klucz[]" value="{{$klucz}}" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/></td>
			<td>{{$etykieta_podzial}}</td>
			<td>
				<select name="{{$nazwa}}_wartosc[]" class="input_tablica_wartosc" {{$atrybuty}}>
				{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
				{{BEGIN lista}}
					<option value="{{$opcja}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
				{{END}}
				</select>
			</td>
		</tr>
	{{END}}
	</table>
	{{BEGIN dodawanie_wierszy}}
	<div class="input_array" id="{{$nazwa}}_control">
		<input type="button" value="{{$etykieta_dodaj_pole}}" class="dodaj_pole" />
		<input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole" />
	</div>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			if ($("#{{$nazwa}} .para").length >= {{$liczba_wierszy}}) { return; }

			if ($("#{{$nazwa}} .para:last").length == 0)
			{
				$("#{{$nazwa}}").prepend($("#{{$nazwa}} .para:first").clone());
			}
			else
			{
				$("#{{$nazwa}} .para:last").after($("#{{$nazwa}} .para:first").clone());
			}
			$("#{{$nazwa}} .para:last select").attr("selectedIndex", false);
			$("#{{$nazwa}} .para:last input").attr("value", "");
			$("#{{$nazwa}} .para:last").show("fast");
		});

		$("#{{$nazwa}}_control .usun_pole").click(function()
		{
			if ($("#{{$nazwa}} .para").length > 1)
			{
				$("#{{$nazwa}} .para:last").fadeOut("normal").remove();
			}
		});
	});
	-->
	</script>
	{{END}}
	';

	protected $parametry = array(
		'liczba_wierszy' => 1000, //ograniczenie ilosci wierszy
		'dodawanie_wierszy' => true, // czy mozna dodawac/usuwac wiersze
		'blokowanie_kluczy' => false, // blokowanie mozliwosci edycji kluczy
		'wybierz' => '',
	);


	/**
	 * Obecna wartosc inputa w formacie tablicowym
	 *
	 * @return array
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
		$return = array();
		$klucze = Zadanie::pobierz($this->pobierzNazwe().'_klucz');
		if (is_array($klucze) && count($klucze))
		{
			$wartosci = Zadanie::pobierz($this->pobierzNazwe().'_wartosc');
			$uprawnienia = Zadanie::pobierz($this->pobierzNazwe().'_uprawnienie');
			
			foreach($klucze as $i => $wartoscKlucz)
			{
				if($wartoscKlucz != '')
					$return[$wartoscKlucz] = array( 'uprawnienie' => $uprawnienia[$i],'wartosc' => $wartosci[$i]);
			}
			$this->wartosc = $return;
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		
		
		
		return $this->wartosc;
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param array $tablica Wartosc do filtrowania.
	 *
	 * @return array
	 */
	protected function filtrujWartosc($tablica)
	{
		$temp = $tablica;
		foreach($this->filtry as $filtr)
		{
			foreach ($temp as $klucz => $wartosc)
			{
				$nowyKlucz = $filtr($klucz);
				$nowaWartosc = $filtr($wartosc);
				unset($temp[$klucz]);
				$temp[$nowyKlucz] = $nowaWartosc;
			}
		}
		$this->filtrowany = true;
		return $temp;
	}




	function pobierzHtml()
	{
		$this->parametry['liczba_wierszy'] = ($this->parametry['liczba_wierszy'] > 0 && $this->parametry['liczba_wierszy'] <= 1000) ? (int)$this->parametry['liczba_wierszy'] : 1000;

		$wartosci = $this->pobierzWartosc();
		if (!is_array($wartosci) || count($wartosci) < 1)
		{
			$wartosci = array(''=> '');
		}

		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
		{
			$lista = $this->parametry['lista'];
		}
		else
		{
			trigger_error('Brak listy danych danych dla pola select', E_USER_WARNING);
		}

		$disabled = ($this->parametry['blokowanie_kluczy'] == true) ? true : false;

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'etykieta_podzial' => $this->tlumaczenia['input_atrybuty_etykieta_podzial'],
			'etykieta_podzial_uprawnienia' => $this->tlumaczenia['input_atrybuty_etykieta_podzial_uprawnienia'],
			'etykieta_dodaj_pole' => $this->tlumaczenia['input_atrybuty_etykieta_dodaj_pole'],
			'etykieta_usun_pole' => $this->tlumaczenia['input_multi_text_select_etykieta_usun_pole'],
		);

		$this->szablon->ustawGlobalne($dane);

		foreach($lista as $opcja => $etykieta)
		{
			$dane['listaTmp'][] = array(
				'opcja' => $opcja,
				'etykieta' => $etykieta,
			);
		}
			
		$licznik = 0;
		if(count(array_filter($wartosci)) > 0)
		{
			foreach ($wartosci as $klucz => $wartosc)
			{
				$dane['wartosci'][$licznik] = array(
					'klucz' => htmlspecialchars($klucz),
					'wartosc' => (isset($wartosc['wartosc'])) ?  htmlspecialchars($wartosc['wartosc']) : '',
					'wyswietlaj' => (isset($wartosc['wyswietlaj'])) ? 'block' : 'none',
					'wybierz' => $this->parametry['wybierz'],
				);

				$uprawnienie = isset($wartosc['uprawnienie']) ? htmlspecialchars($wartosc['uprawnienie']) : '';
				foreach($lista as $opcja => $etykieta)
				{
					$dane['wartosci'][$licznik]['lista'][] = array(
						'opcja' => $opcja,
						'etykieta' => $etykieta,
						'selected' => ($opcja == $uprawnienie) ? true : false,
					);
				}
				$licznik++;
				if ($licznik >= $this->parametry['liczba_wierszy']) break;
			}
		}
		else
		{
			$dane['wartosci'][$licznik] = array(
					'klucz' => '',
					'wartosc' => '',
					'wyswietlaj' => 'block',
					'wybierz' => $this->parametry['wybierz'],
				);
			foreach($lista as $opcja => $etykieta)
				{
					$dane['wartosci'][$licznik]['lista'][] = array(
						'opcja' => $opcja,
						'etykieta' => $etykieta,
						'selected' => false,
					);
				}
		}
		
		if ($this->parametry['dodawanie_wierszy'] == true)
		{
			$dane['dodawanie_wierszy'] = array(
				'liczba_wierszy' => $this->parametry['liczba_wierszy'],
			);
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}
}
