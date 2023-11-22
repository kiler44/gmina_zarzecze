<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Walidator;


/**
 * Klasa obsługująca tablicę asocjacyjną przy użyciu pól tekstowych.
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Tablica extends Input
{
	protected $katalogSzablonu = 'ArrayNew';
	protected $tpl = '
	<div class="section inputs-inline" id="{{$nazwa}}">
	{{BEGIN elementy}}
		<fieldset class="para">
		<p>
			<label>{{IF $napis_przed}}{{$napis_przed}}{{END}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="{{$klucz}}" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/>
			<label>{{$podzial}}</label>
			<input type="text" name="{{$nazwa}}_wartosc[]" value="{{$wartosc}}" class="input_tablica_wartosc listaPoleZPrzyciskiem" {{$atrybuty}}/>
			{{IF $boolen}}<label style="margin:3px;" > {{$boolenLabel}} </label><input style="margin:3px;" type="checkbox" class="noWidth" name="serial_numbers_out_boolen[]" />{{END}}
			{{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon icon-remove"></i></a>{{END}}
		</p>
		</fieldset>
	{{END}}
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
	{{BEGIN obsluga_dodawania_wierszy}}
		<div class="input_array" id="{{$nazwa}}_control">
			<input type="button" value="{{$etykieta_dodaj_pole}}" {{IF $start_limit}}style="display: none;"{{END}} class="dodaj_pole buttonSet btn btn-success" /><input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole buttonSet btn btn-danger" />
		</div>
		<script type="text/javascript">
		<!--
		$(document).ready(function(){

			var input = \'<fieldset class="para"><p><label>{{$napis_przed}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/> <label>{{$podzial}}</label> <input type="text" name="{{$nazwa}}_wartosc[]" value="" class="input_tablica_wartosc listaPoleZPrzyciskiem" {{$strybuty}}/> {{IF $boolen}}<label style="margin:3px;" > {{$boolenLabel}} </label><input style="margin:3px;" type="checkbox" class="noWidth" name="serial_numbers_out_boolen[]" />{{END}}{{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon icon-remove"></i></a>{{END}}</p></fieldset>\';

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
		'boolen' => false,
		'boolenLabel' => 'Required photo',
		'blokowanie_kluczy' => false, // blokowanie mozliwosci edycji kluczy
		'podzial' => false,
		'napis_przed' => false,
		'sortowanie' => false, // czy umożliwić sortowanie listy
	);


	/**
	 *
	 * Walidatory nalozone na input, ale dla klucza
	 * @var array
	 */
	protected $walidatory_klucza = array();


	function pobierzHtml()
	{
		$this->parametry['liczba_wierszy'] = ($this->parametry['liczba_wierszy'] > 0 && $this->parametry['liczba_wierszy'] <= 1000) ? (int)$this->parametry['liczba_wierszy'] : 1000;

		$wartosc = $this->pobierzWartosc();
		if (!is_array($wartosc) || count($wartosc) < 1)
		{
			$wartosc = array(''=> '');
		}

		$html = '<div class="section inputs-inline" id="'.$this->pobierzNazwe().'">';


		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_podzial' => $this->tlumaczenia['input_tablica_etykieta_podzial'],
			'etykieta_dodaj_pole' => $this->tlumaczenia['input_tablica_etykieta_dodaj_pole'],
			'etykieta_usun_pole' => $this->tlumaczenia['input_tablica_etykieta_usun_pole'],
			'etykieta_usun_pole_wybrane' => $this->tlumaczenia['input_tablica_etykieta_usun_pole_wybrane'],
			'boolen' => $this->parametry['boolen'],
			'boolenLabel' => $this->parametry['boolenLabel'],
			'napis_przed' => $this->parametry['napis_przed'],
			'podzial' => ($this->parametry['podzial'] === false) ? $this->tlumaczenia['input_tablica_etykieta_podzial'] : $this->parametry['podzial'],
			'dodawanie_wierszy' => $this->parametry['dodawanie_wierszy'],

			'disabled' => ($this->parametry['blokowanie_kluczy'] == true) ? true : false,
		);

		$this->szablon->ustawGlobalne($dane);

		$licznik = 0;
		foreach ($wartosc as $klucz => $wartosc)
		{
			$dane['elementy'][] = array(
				'klucz' => htmlspecialchars($klucz),
				'wartosc' => htmlspecialchars($wartosc),
			);

			$licznik++;
			if ($licznik >= $this->parametry['liczba_wierszy']) break;
		}

		if ($this->parametry['dodawanie_wierszy'] == true)
		{
			$dane['obsluga_dodawania_wierszy'] = array(
				'liczba_wierszy' => $this->parametry['liczba_wierszy'],
				'start_limit' => ( ! ($this->parametry['liczba_wierszy'] > $licznik || $this->parametry['liczba_wierszy'] == 0)) ? true : false,
				'sortowanie' => ($this->parametry['sortowanie']) ? true : false,
			);
		}

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
