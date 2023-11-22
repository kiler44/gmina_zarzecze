<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Walidator;


/**
 * Klasa obsługująca wielokrotne pole wyboru(checkbox).
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class MultiCheckbox extends Input
{
	protected $katalogSzablonu = 'MultiCheckboxNew';
	protected $tpl = '
	{{BEGIN lista}}<label for="{{$nazwa}}_{{$klucz}}"><input type="checkbox" id="{{$nazwa}}_{{$klucz}}" name="{{$nazwa}}[]" value="{{$klucz}}" {{IF $selected}}checked="checked"{{END}} {{$atrybuty}}/> {{$etykieta}}</label><br />{{END}}
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony"/>
	';

	protected $parametry = array(
		'lista' => array(),
	);



	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return mixed Obecna wartosc inputa.
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
			$this->wartosc = Zadanie::pobierz($this->pobierzNazwe());
			if($this->wartosc == null) { $this->wartosc = array(); }
			$this->wartosc = $this->filtrujWartosc($this->wartosc);
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
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return boolean
	 */
	function zmieniony()
	{
		if (count($this->pobierzWartosc()) != count($this->pobierzWartoscPoczatkowa()))
		{
			return true;
	}

		$poczatkowe = $this->pobierzWartoscPoczatkowa();
		foreach ($this->pobierzWartosc() as $klucz => $wartosc)
		{
			if ($poczatkowe[$klucz] != $wartosc)
			{
				return true;
			}
		}
		return false;
	}



	function pobierzHtml()
	{
		$lista = array();
		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
		{
			$lista = $this->parametry['lista'];
		}
		else
		{
			trigger_error('Brak listy danych dla pola select', E_USER_WARNING);
		}

		$wybrane = $this->pobierzWartosc();
		$wybrane = (is_array($wybrane)) ? $wybrane : array($wybrane);

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
		);

		$this->szablon->ustawGlobalne($dane);

		if (count($lista) > 0)
		{
			foreach($lista as $klucz => $etykieta)
			{
				$selected = (in_array($klucz, $wybrane)) ? true : false;
				$dane['lista'][] = array(
					'klucz' => htmlspecialchars($klucz),
					'etykieta' => $etykieta,
					'selected' => $selected,
					'atrybuty' => $this->pobierzAtrybuty(),
				);
			}
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
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

}
