<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Walidator;


/**
 * Klasa obsługująca listę elementów w postaci pól tekstowych.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Lista extends Input
{
	protected $katalogSzablonu = 'ListNew';
	protected $tpl = '
	<div class="option-list"><ul id="{{$nazwa}}_ul">
	{{BEGIN element}}
		{{IF $numerowanie}}
		<li class="numerowane"><label>{{$_num}}</label>{{ELSE}}<li>{{END}}
			<input type="text" title="" name="{{$nazwa}}[{{$licznik}}]" value="{{$wartosc}}" {{$atrybuty}} class="listaPoleZPrzyciskiem" style="margin-bottom:0px;" />
			{{IF $dodawanie_wierszy}}<a href="javascript:void(0)" title="{{$etykieta_usun_pole_wybrane}}" class="usuniecie remove btn btn-danger"><i class="icon icon-remove"></i></a>{{END}}
		</li>
	{{END}}
	</ul></div>
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" {{$atrybuty}} />

	{{BEGIN dodawanie_wierszy}}
	<div class="input_array_control" id="{{$nazwa}}_control">
		<a class="dodaj_pole buttonSet btn btn-success" {{IF $niemozliwe_dodawanie}}style="display: none;"{{END}}>{{$etykieta_dodaj_pole}}</a>
		<a class="usun_pole buttonSet btn btn-danger">{{$etykieta_usun_pole}}</a>
	</div>

	<script type="text/javascript">
	<!--
	var liczba_pol = $(\'#{{$nazwa}}_ul li\').length;
	$(document).ready(function(){
		$(".usuniecie").live("click", function() {
			$(this).parent().remove();
			if ($("#{{$nazwa}}_ul li").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}
			if ($("#{{$nazwa}}_ul li").length < 1)
			{
				$("#{{$nazwa}}_control .usun_pole").fadeOut("normal");
			}

			liczba_pol = 0;

			$("li.numerowane label").each(function () {
				++liczba_pol;
				$(this).html(liczba_pol + ".");
			})
		});

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			var ilosc_pol = $("#{{$nazwa}}_ul li").length;
			var input = \'{{IF $numerowanie}}<li class="numerowane"><label>\' + (++liczba_pol) + \'.</label>{{ELSE}}<li>{{END}}<input type="text" title="" name="{{$nazwa}}[\'+ilosc_pol+\']" value="" style="margin-bottom:0px;"  {{$atrybuty}}> <a href="javascript:void(0)" title="{{$etykieta_usun_pole_wybrane}}" class="usuniecie remove btn btn-danger"><i class="icon icon-remove"></i></a></li>\';

			if ($("#{{$nazwa}}_ul li:last").length == 0)
			{
				$("#{{$nazwa}}_ul").prepend(input);
					$("#{{$nazwa}}_control .usun_pole").fadeIn("normal");
			}
			else
			{
				$("#{{$nazwa}}_ul li:last").after(input);
			}
			$("#{{$nazwa}}_ul li:last").show("fast");
			if ($("#{{$nazwa}}_ul li").length >= {{$liczba_wierszy}})
			{
				$(this).hide();
				return;
			}
		});

		$("#{{$nazwa}}_control .usun_pole").click(function(){
			if ($("#{{$nazwa}}_ul li").length > 0)
			{
				$("#{{$nazwa}}_ul li:last").fadeOut("normal").remove();
				--liczba_pol;
			}
			if ($("#{{$nazwa}}_ul li").length < 1)
			{
				$("#{{$nazwa}}_control .usun_pole").fadeOut("normal");
				liczba_pol = 0;
			}
			if ($("#{{$nazwa}}_ul li").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}
		});

		{{IF $sortowanie}}
		$("#{{$nazwa}}_ul").sortable({
			placeholder: "sortable-placeholder",
			opacity: 0.6,
			helper: "original"
		});
		{{END}}
	});
	-->
	</script>
	{{END}}
	';

	protected $parametry = array(
		'liczba_wierszy' => 1000, //ograniczenie ilosci wierszy
		'dodawanie_wierszy' => false, // czy mozna dodawac/usuwac wiersze
		'sortowanie' => false, // czy umożliwić sortowanie listy
		'numerowanie' => false, //czy włączyć numerowanie wierszy
	);



	/**
	 * Obecna wartosc inputa w formacie listy
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
			$temp = Zadanie::pobierz($this->pobierzNazwe());
			if (is_array($temp))
			{
				$czyPustePole = function($v) { return ! (is_string($v) && $v === ''); };
				$this->wartosc = $this->filtrujWartosc(array_filter(array_values($temp), $czyPustePole));
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
		foreach($this->filtry as $filtr)
		{
			foreach ($tablica as $klucz => $wartosc)
			{
				$tablica[$klucz] = $filtr($wartosc);
			}
		}
		$this->filtrowany = true;
		return $tablica;
	}



	/**
	 * Zwraca blad walidacji.
	 *
	 * @return string|null Tresc bledu lub null.
	 */
	public function pobierzBladWalidacji()
	{
		if (!$this->sprawdzony)
		{
			$this->sprawdzony = true;
			$this->bladWalidacji = null;
			$wartosc = $this->pobierzWartosc();
			/*
			 * Jezeli input ma wartosc pusta i nie jest wymagany to pomijamy sprawdzanie
			 * poniewaz niektore walidatory nie akceptuja wartosci pustej wiec zwroca blad
			 * mimo iz wartosc pusta jest dozwolona.
			 */
			if ($wartosc === null && (bool)$this->wymagany === false)
			{
				return $this->bladWalidacji;
			}
			foreach($this->walidatory as $walidator)
			{
				if (is_array($wartosc))
				{
					foreach ($wartosc as $element)
					{
						// pierwszy walidator który zwróci blad przerywa sprawdzanie
						if (!$walidator->sprawdz($element))
						{
							$this->bladWalidacji = $walidator->pobierzBlad();
							break;
						}
					}

					/*
					 * Jeśli nałożony jest walidator_NiePuste i brak elementów
					 * w tablicy musimy zwrócić błąd walidacji dla tego walidatora.
					 */
					if ($walidator instanceof Walidator\NiePuste && count($wartosc) == 0)
					{
						$walidator->sprawdz('');
						$this->bladWalidacji = $walidator->pobierzBlad();
						break;
					}
				}
			}
		}
		return $this->bladWalidacji;
	}



	function pobierzHtml()
	{
		$this->parametry['liczba_wierszy'] = ($this->parametry['liczba_wierszy'] > 0 && $this->parametry['liczba_wierszy'] <= 1000) ? (int)$this->parametry['liczba_wierszy'] : 1000;

		$temp = $this->pobierzWartosc();

		if (empty($temp))
		{
			$temp = array(''=> '');
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'numerowanie' => $this->parametry['numerowanie'],
			'liczba_wierszy' => $this->parametry['liczba_wierszy'],
			'niemozliwe_dodawanie' => false,
			'etykieta_dodaj_pole' => $this->tlumaczenia['input_lista_etykieta_dodaj_pole'],
			'etykieta_usun_pole' => $this->tlumaczenia['input_lista_etykieta_usun_pole'],
			'etykieta_usun_pole_wybrane' => $this->tlumaczenia['input_lista_etykieta_usun_pole_wybrane'],
		);

		if ($this->parametry['dodawanie_wierszy'])
		{
			$dane['dodawanie_wierszy'] = $dane;
		}

		$licznik = 0;
		foreach($temp as $klucz => $wartosc)
		{
			$dane['element'][] = array_merge($dane, array(
				'licznik' => $licznik,
				'wartosc' => htmlspecialchars($wartosc),
			));

			$licznik++;
			if ($licznik >= $this->parametry['liczba_wierszy']) break;
		}


		if ( ! ($this->parametry['liczba_wierszy'] > $licznik || $this->parametry['liczba_wierszy'] == 0))
		{
			$dane['niemozliwe_dodawanie'] = true;
		}

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}
}