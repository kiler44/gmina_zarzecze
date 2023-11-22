<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca tablicę asocjacyjną przy użyciu pól tekstowych lub pól select.
 *
 * @author Krzysztof Żak
 * @package biblioteki
 */

class TablicaSelect extends Input
{
	protected $katalogSzablonu = 'ArraySelectNew';
	protected $tpl = '
	<table id="{{$nazwa}}" class="input_array" border="0">
	{{BEGIN wiersze}}
		<tr class="para">
			<td>{{$pobierz_select_1}}</td>
			<td>{{$etykieta_podzial}}</td>
			<td>{{$pobierz_select_2}}</td>
		{{IF $dodawanie_wierszy}}
			<td class="usun_pole1"><a href="javascript:void(0)">{{$etykieta_usun_pole_wybrane}}</a></td>
		{{END}}
		</tr>
	{{END}}
	</table>
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
	{{BEGIN obsluga_dodawania_wierszy}}
		<div class="input_array" id="{{$nazwa}}_control">
			<input type="button" value="{{$etykieta_dodaj_pole}}" class="dodaj_pole" />
			<input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole" />
		</div>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){
		var input = \'<tr class="para"><td>{{$pobierz_select_3}}</td><td>{{$etykieta_podzial}}</td><td>{{$pobierz_select_4}}</td><td class="usun_pole1"><a href="javascript:void(0)">{{$etykieta_usun_pole_wybrane}}</a></td></tr>\';

		$(".usun_pole1").live("click", function() {
			$(this).parent().remove();
			if ($("#{{$nazwa}} .para").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}
		});

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			if ($("#{{$nazwa}} .para:last").length == 0)
			{
				$("#{{$nazwa}}").prepend(input);
			}
			else
			{
				$("#{{$nazwa}} .para:last").after(input);
			}
			$("#{{$nazwa}} .para:last").show("fast");

			if ($("#{{$nazwa}} .para").length >= {{$liczba_wierszy}})
			{
				$(this).hide();
				return;
			}
		});

		$("#{{$nazwa}}_control .usun_pole").click(function(){
			if ($("#{{$nazwa}} .para").length > 0)
			{
				$("#{{$nazwa}} .para:last").fadeOut("normal").remove();
			}
			if ($("#{{$nazwa}} .para").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}
		});
	});
	-->
	</script>
	{{END}}

		{{BEGIN select_html}}{{BEGIN lista}}<select name="{{$nazwa}}_{{$typ}}[]" class="input_tablica_{{$typ}}">{{IF $etykieta_wybierz}}<option value="">{{$etykieta_wybierz}}</option>{{END}}{{BEGIN wiele_poziomow}}<optgroup label="{{$klucz}}">{{BEGIN opcje}}<option value="{{$element}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>{{END}}</optgroup>{{END}}{{BEGIN opcje}}<option value="{{$klucz}}" {{IF $selected}}selected="selected"{{END}}>{{$wartosc}}</option>{{END}}</select>{{END}}{{BEGIN tekst}}<input type="text" name="{{$nazwa}}_{{$typ}}[]" value="{{$wartosc_poczatkowna}}" class="input_tablica_{{$typ}}" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/>{{END}}{{END}}
	';

	protected $parametry = array(
		'liczba_wierszy' => 1000, //ograniczenie ilosci wierszy
		'dodawanie_wierszy' => false, // czy mozna dodawac/usuwac wiersze
		'blokowanie_kluczy' => false, // blokowanie mozliwosci edycji kluczy

		'lista_klucz' => array(),
		'wybierz_klucz' => '- wybierz -',
		'lista_wartosc' => array(),
		'wybierz_wartosc' => '- wybierz -',
	);




	function pobierzHtml()
	{
		$this->parametry['liczba_wierszy'] = ($this->parametry['liczba_wierszy'] > 0 && $this->parametry['liczba_wierszy'] <= 1000) ? (int)$this->parametry['liczba_wierszy'] : 1000;

		$wartosci = $this->pobierzWartosc();
		if (!is_array($wartosci) || count($wartosci) < 1)
		{
			$wartosci = array(''=> '');
		}

		$disabled = ($this->parametry['blokowanie_kluczy'] == true) ? 'readonly="readonly"' : '';

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_podzial' => $this->tlumaczenia['input_tablica_select_etykieta_podzial'],
			'etykieta_dodaj_pole' => $this->tlumaczenia['input_tablica_select_etykieta_dodaj_pole'],
			'etykieta_usun_pole' => $this->tlumaczenia['input_tablica_select_etykieta_usun_pole'],
			'etykieta_usun_pole_wybrane' => $this->tlumaczenia['input_tablica_select_etykieta_usun_pole_wybrane'],

			'dodawanie_wierszy' => $this->parametry['dodawanie_wierszy'],
			'liczba_wierszy' => $this->parametry['liczba_wierszy'],
		);
		$this->szablon->ustawGlobalne($dane);

		$licznik = 0;
		foreach ($wartosci as $klucz => $wartosc)
		{
			$dane['wiersze'][] = array(
				'pobierz_select_1' => $this->pobierzSelectHtml($this->parametry['lista_klucz'], 'klucz', $klucz),
				'pobierz_select_2' => $this->pobierzSelectHtml($this->parametry['lista_wartosc'], 'wartosc', $wartosc),
			);

			$licznik++;
			if ($licznik >= $this->parametry['liczba_wierszy']) break;
		}

		if ($this->parametry['dodawanie_wierszy'] == true)
		{
			$dane['obsluga_dodawania_wierszy'] = array(
				'pobierz_select_3' => $this->pobierzSelectHtml($this->parametry['lista_klucz'], 'klucz'),
				'pobierz_select_4' => $this->pobierzSelectHtml($this->parametry['lista_wartosc'], 'wartosc'),
			);
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}



	protected function pobierzSelectHtml($lista, $typ, $wartoscPoczatkowa = null)
	{
		$wybrane = $wartoscPoczatkowa;

		if (is_array($lista) && count($lista) > 0)
		{
			$dane['select_html']['lista'] = array(
				'nazwa' => $this->pobierzNazwe(),
				'atrybuty' => $this->pobierzAtrybuty(),
				'typ' => $typ,
				'etykieta_wybierz' => $this->parametry['wybierz_' . $typ],
			);
			$this->szablon->ustawGlobalne($dane);
			if (count($lista) > 0)
			{
				foreach($lista as $klucz => $wartosc)
				{
					if (is_array($wartosc))
					{
						$dane['select_html']['lista']['wiele_poziomow']['klucz'] = $klucz;

						foreach($wartosc as $element => $etykieta)
						{
							$dane['select_html']['lista']['wiele_poziomow']['opcje'][] = array(
								'selected' => ($wybrane !== null && in_array($element, (array)$wybrane)) ? true : false,
								'element' => htmlspecialchars($element),
								'etykieta' => $etykieta,
							);
						}
					}
					else
					{
						$dane['select_html']['lista']['opcje'][] = array(
							'selected' => ($wybrane !== null && in_array($klucz, (array)$wybrane)) ? true : false,
							'klucz' => htmlspecialchars($klucz),
							'wartosc' => $wartosc,
						);
					}
				}
			}
		}
		else
		{
			$dane['select_html']['tekst'] = array(
				'nazwa' => $this->pobierzNazwe(),
				'atrybuty' => $this->pobierzAtrybuty(),
				'wartosc_poczatkowa' => htmlspecialchars($wartoscPoczatkowa),
				'typ' => $typ,
				'disabled' => ($this->parametry['blokowanie_kluczy']) ? true : false,
			);
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsujBlok('/select_html', $dane);
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
		if (Zadanie::pobierz($this->pobierzNazwe().'_wyswietlony') !== null)
		{
			$this->wartosc = array();
			$temp = null;
			$klucze = Zadanie::pobierz($this->pobierzNazwe().'_klucz');
			if (is_array($klucze))
			{
				$temp = array_combine($klucze, Zadanie::pobierz($this->pobierzNazwe().'_wartosc'));
				if (isset($temp['']) && trim($temp['']) == '')
				{
					unset($temp['']);
				}
			}
			if ($temp !== null)
			{
				$this->wartosc = $this->filtrujWartosc($temp);
			}
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
	 * @return array Wartosc po zastosowaniu filtrow.
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




	/**
	 * Zwraca blad walidacji.
	 *
	 * @return string
	 */
	public function pobierzBladWalidacji()
	{
		if (!$this->sprawdzony)
		{
			$this->sprawdzony = true;
			$this->bladWalidacji = null;
			$wartosci = $this->pobierzWartosc();
			/*
			 * Jezeli input ma wartosc pusta i nie jest wymagany to pomijamy sprawdzanie
			 * poniewaz niektore walidatory nie akceptuja wartosci pustej wiec zwroca blad
			 * mimo iz wartosc pusta jest dozwolona.
			 */
			if ($wartosci == '' && (bool) $this->wymagany === false)
			{
				return $this->bladWalidacji;
			}
			foreach ($this->walidatory as $walidator)
			{
				foreach($wartosci as $wartosc)
				{
					// pierwszy walidator który zwróci blad przerywa sprawdzanie
					if (!$walidator->sprawdz($wartosc))
					{
						$this->bladWalidacji = $walidator->pobierzBlad();
						break;
					}
				}
			}
		}
		return $this->bladWalidacji;
	}
}
