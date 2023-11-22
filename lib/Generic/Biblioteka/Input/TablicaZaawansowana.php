<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Walidator;


/**
 * Klasa obsługująca tablicę asocjacyjną dla ktorej można zdefiniować pola
 * wartości, filtry i walidatory dla każdego z nich.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class TablicaZaawansowana extends Input
{
	protected $katalogSzablonu = 'AdvanceArrayNew';
	protected $tpl = '
	<div class="section inputs-inline" id="{{$nazwa}}">
	{{BEGIN elementy}}
		<fieldset class="para">
		<p>
			<label>{{IF $napis_przed}}{{$napis_przed}}{{END}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="{{$klucz}}" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/>
			<label>{{$podzial}}</label>
			<input type="text" name="{{$nazwa}}_wartosc[]" value="{{$wartosc}}" class="input_tablica_wartosc listaPoleZPrzyciskiem" {{$atrybuty}}/>
			{{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica" href="javascript:void(0)"><span></span></a>{{END}}
		</p>
		</fieldset>
	{{END}}
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
	{{BEGIN obsluga_dodawania_wierszy}}
		<div class="input_array" id="{{$nazwa}}_control">
			<input type="button" value="{{$etykieta_dodaj_pole}}" {{IF $start_limit}}style="display: none;"{{END}} class="dodaj_pole buttonSet buttonLight3" /><input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole buttonSet buttonLight3" />
		</div>
		<script type="text/javascript">
		<!--
		$(document).ready(function(){

			var input = \'<fieldset class="para"><p><label>{{$napis_przed}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/> <label>{{$podzial}}</label> <input type="text" name="{{$nazwa}}_wartosc[]" value="" class="input_tablica_wartosc listaPoleZPrzyciskiem" {{$strybuty}}/>{{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica" href="javascript:void(0)"><span></span></a>{{END}}</p></fieldset>\';

			$(".usun_pole1").live("click", function() {
				$(this).parent().parent().remove();
				if ($("#{{$nazwa}} fieldset").length < {{$liczba_wierszy}})
				{
					$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
				}

				if ($("#{{$nazwa}} .para").length < 1)
				{
					$("#{{$nazwa}} .usun_pole").fadeOut("fast")
				}
			});

			$("#{{$nazwa}}_control .dodaj_pole").click(function()
			{
				if ($("#{{$nazwa}} fieldset:last").length == 0)
				{
					$("#{{$nazwa}}").prepend(input);
				}
				else
				{
					$("#{{$nazwa}} fieldset:last").after(input);
				}
				$("#{{$nazwa}} .usun_pole").fadeIn("normal");
				$("#{{$nazwa}} .para:last").show("fast");
				if ($("#{{$nazwa}} .para").length >= {{$liczba_wierszy}})
				{
					$(this).fadeOut("fast")
					return;
				}
			});

			$("#{{$nazwa}}_control .usun_pole").click(function(){
				if ($("#{{$nazwa}} .para").length > 0)
				{
					$("#{{$nazwa}} .para:last").fadeOut("normal").remove();
				}
				if ($("#{{$nazwa}} .para").length < 1)
				{
					$("#{{$nazwa}} .usun_pole").fadeOut("fast");
				}
				if ($("#{{$nazwa}} .para").length < {{$liczba_wierszy}})
				{
					$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
				}
			});

			{{IF $sortowanie}}
			$("#{{$nazwa}}").sortable({
				items: "fieldset",
				placeholder: "sortable-placeholder",
				opacity: 0.6,
				helper: "original"
			});
			{{END}}
		});
		-->
		</script>
	{{END}}
	</div>
	';

	protected $parametry = array(
		'liczba_wierszy' => 1000, //ograniczenie ilosci wierszy
		'dodawanie_wierszy' => false, // czy mozna dodawac/usuwac wiersze
		'blokowanie_kluczy' => false, // blokowanie mozliwosci edycji kluczy
		'podzial' => false, //napis oddzielajacy pole klucza od pol wartości
		'napis_przed' => false, //napis przed polem klucza
		'sortowanie' => true,
		'konfiguracja_wiersza' => array('wartosc' => 'Text'), //tablica zawierajaca klucze pol wiersza oraz jego typ
		'listy_wartosci' => array(),
		'filtry_wiersza' => array('wartosc' => array('addslashes')), //tablica zawierajaca listy filtrow nakladanych na kazde z pol wiersza
		'walidatory_wiersza' => array(), //tablica zawierająca listę walidatorów nakladanych na każdez pol wiersza
		'ukryj_pola_klucza' => false, //jesli true to klucze oraz napisy przed i podzial nie bedą wyswietlane, klucze przyjma wartosci od 1 do n, gdzie n to liczba wierszy inputa
		'pionowy' => true, //jezeli true to kazde z pol wiersza znajdzie sie w osobnej linii, jesli false to pole inline
	);


	/**
	 *
	 * Walidatory nalozone na input, ale dla klucza
	 * @var array
	 */
	protected $walidatory_klucza = array();

	protected $pola = array();

	protected $polaWymagajaceListyWartosci = array(
		'Select',
		'SelectDrzewo',
		'SelectDrzewo2',
		'SelectDrzewo3',
		'SelectWiele',
	);


	function pobierzHtml()
	{
		$this->parametry['liczba_wierszy'] = ($this->parametry['liczba_wierszy'] > 0 && $this->parametry['liczba_wierszy'] <= 1000) ? (int)$this->parametry['liczba_wierszy'] : 1000;

		$wartosc = $this->pobierzWartosc();
		if (!is_array($wartosc) || count($wartosc) < 1)
		{
			if ($this->parametry['ukryj_pola_klucza'])
			{
				$wartosc = array(1 => array());
			}
			else
			{
				$wartosc = array('' => array());
			}
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_podzial' => $this->tlumaczenia['input_tablica_zaawansowana_etykieta_podzial'],
			'etykieta_dodaj_pole' => $this->tlumaczenia['input_tablica_zaawansowana_etykieta_dodaj_pole'],
			'etykieta_usun_pole' => $this->tlumaczenia['input_tablica_zaawansowana_etykieta_usun_pole'],
			'etykieta_usun_pole_wybrane' => $this->tlumaczenia['input_tablica_zaawansowana_etykieta_usun_pole_wybrane'],

			'napis_przed' => $this->parametry['napis_przed'],
			'podzial' => ($this->parametry['podzial'] === false) ? $this->tlumaczenia['input_tablica_zaawansowana_etykieta_podzial'] : $this->parametry['podzial'],
			'dodawanie_wierszy' => $this->parametry['dodawanie_wierszy'],

			'disabled' => ($this->parametry['blokowanie_kluczy'] == true) ? true : false,
			'ukryj_pola_klucza' => $this->parametry['ukryj_pola_klucza'],
		);

		$this->szablon->ustawGlobalne($dane);

		$licznik = 0;
		foreach ($wartosc as $klucz => $wartoscWiersza)
		{
			$dane['elementy'][] = $this->wygenerujPolaWiersza($klucz, $wartoscWiersza, $licznik);

			$licznik++;
			if ($licznik >= $this->parametry['liczba_wierszy']) break;
		}

		if ($this->parametry['dodawanie_wierszy'] == true)
		{
			$dane['obsluga_dodawania_wierszy'] = array(
				'liczba_wierszy' => $this->parametry['liczba_wierszy'],
				'start_limit' => ( ! ($this->parametry['liczba_wierszy'] > $licznik || $this->parametry['liczba_wierszy'] == 0)) ? true : false,
				'sortowanie' => ($this->parametry['sortowanie']) ? true : false,
				'htmlSzablonWiersza' => str_replace(array("\n", '\'', '<!--', '-->', '</script>'), array("\\\n", '\\\'', '&lt;--', '--&gt;', '&lt;/script&gt;'), $this->wygenerujPolaWiersza(null, null, 'IDWIERSZA')['htmlInputa']),
				'licznikPol' => $licznik,
			);
		}

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}


	protected function wygenerujPolaWiersza($klucz, $wartosc, $licznik)
	{
		$htmlWiersza = '';
		foreach ($this->parametry['konfiguracja_wiersza'] as $kluczPola => $typPola)
		{
			$namespacePola = 'Generic\\Biblioteka\\Input\\' . $typPola;

			$pole = new $namespacePola($this->nazwa . '_subpole_' . $licznik . '_' . $kluczPola);
			$pole->ustawSzablon('Admin.tpl');

			if (in_array($typPola, $this->polaWymagajaceListyWartosci))
			{
				$pole->ustawParametry(array_merge($pole->pobierzParametry(), array('lista' => $this->parametry['listy_wartosci'][$kluczPola])));
			}

			if (isset($this->tlumaczenia[$kluczPola . '.etykieta']))
			{
				$pole->dodajAtrybuty(array('placeholder' => $this->tlumaczenia[$kluczPola . '.etykieta']));
			}

			if (isset($this->parametry['filtry_wiersza'][$kluczPola]))
			{
				foreach ($this->parametry['filtry_wiersza'][$kluczPola] as $filtrWiersza)
				{
					$pole->dodajFiltr($filtrWiersza);
				}
			}

			if (isset($this->parametry['walidatory_wiersza'][$kluczPola]))
			{
				foreach ($this->parametry['walidatory_wiersza'][$kluczPola] as $kluczWalidatora => $walidatorWiersza)
				{

					if (is_numeric($kluczWalidatora))
					{
						$namespaceWalidatora = 'Generic\\Biblioteka\\Walidator\\' . $walidatorWiersza;
						$pole->dodajWalidator(new $namespaceWalidatora());
					}
					else
					{
						$namespaceWalidatora = 'Generic\\Biblioteka\\Walidator\\' . $kluczWalidatora;
						$pole->dodajWalidator(new $namespaceWalidatora($walidatorWiersza));
					}
				}
			}

			if ($wartosc !== null && is_array($wartosc) && isset($wartosc[$kluczPola]))
			{
				$pole->ustawWartosc($wartosc[$kluczPola]);
			}

			$this->pola[$licznik][$kluczPola] = $pole;

			if ($this->parametry['pionowy'])
			{
				$htmlWiersza .= $this->szablon->parsujBlok('inputPionowy', array('htmlInputa' => $pole->pobierzHtml()));
			}
			else
			{
				$htmlWiersza .= $this->szablon->parsujBlok('inputInline', array('htmlInputa' => $pole->pobierzHtml()));
			}

		}

		return array(
			'klucz' => htmlspecialchars($klucz),
			'htmlInputa' => $htmlWiersza,
			'licznikWierszy' => $licznik
		);
	}


	/**
	 * Obecna wartosc inputa w formacie tablicowym
	 *
	 * @return Obecna wartosc inputa.
	 */
	public function pobierzWartosc()
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
				foreach ($klucze as $idKlucza => $wartoscKlucza)
				{
					if ( ! isset($this->pola[$idKlucza]))
					{
						$this->wygenerujPolaWiersza($wartoscKlucza, null, $idKlucza);
					}
					$temp[$wartoscKlucza] = $this->pobierzWartoscWiersza($idKlucza);
				}

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

	protected function pobierzWartoscWiersza($licznikWiersza)
	{
		$wartoscWiersza = array();

		if (isset($this->pola[$licznikWiersza]))
		{
			foreach ($this->parametry['konfiguracja_wiersza'] as $kluczPola => $typPola)
			{
				$wartoscWiersza[$kluczPola] = $this->pola[$licznikWiersza][$kluczPola]->pobierzWartosc();
			}
		}
		else
		{
			trigger_error('Brak wartości dla klucza ' . intval($licznikWiersza));
		}

		return $wartoscWiersza;
	}


	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return boolean
	 */
	public function zmieniony()
	{
		return ($this->pobierzWartosc() !== $this->pobierzWartoscPoczatkowa());
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



	public function dodajWalidatorKlucza(Walidator $walidator)
	{
		$this->walidatory_klucza[] = $walidator;
		$this->sprawdzony = false;
		return $this;
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

			foreach ($this->pola as $wiersz)
			{
				foreach ($wiersz as $pole)
				{
					$bladWalidacjiPola = $pole->pobierzBladWalidacji();
					if ($bladWalidacjiPola != null)
					{
						$this->bladWalidacji = $bladWalidacjiPola;
						return $this->bladWalidacji;
					}
				}
			}

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
					foreach ($wartosc as $wartoscPola)
					{
						// pierwszy walidator który zwróci blad przerywa sprawdzanie
						if (!$walidator->sprawdz($wartoscPola))
						{
							$this->bladWalidacji = $walidator->pobierzBlad();
							break;
						}

						if ($this->bladWalidacji !== null)
						{
							break;
						}
					}
				}

				/*
				 * Jeśli nałożony jest walidator_NiePuste i brak elementów
				 * w tablicy musimy zwrócić błąd walidacji dla tego walidatora.
				 */
				if ($walidator instanceof Walidator\NiePuste && count($wartosci) == 0)
				{
					$walidator->sprawdz('');
					$this->bladWalidacji = $walidator->pobierzBlad();
					break;
				}
			}

			foreach ($this->walidatory_klucza as $walidator)
			{
				foreach ($wartosci as $klucz => $wartosc)
				{
					// pierwszy walidator który zwróci blad przerywa sprawdzanie
					if (!$walidator->sprawdz($klucz))
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
