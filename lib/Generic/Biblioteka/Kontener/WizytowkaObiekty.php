<?php
namespace Generic\Biblioteka\Kontener;
use Generic\Biblioteka\Kontener;


/**
 * Kontener przetrzymujący i zwracający instancje obiektow.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class WizytowkaObiekty extends Kontener
{

	/**
	 * Przetrzymuje etykiety obiektow i odpowiadajace im klasy
	 * @var array
	 */
	protected $obslugiwaneObiekty = array(
		'Klient' => 'Generic\\Model\\Klient\\Obiekt',
		'KlientOsobaKontaktowa' => 'Generic\\Model\\Klient\\Obiekt',
		'Faktura' => 'Generic\\Model\\Faktura\\Obiekt',
		'Team' => 'Generic\\Model\\Team\\Obiekt',
		'Koordynator' => 'Generic\\Model\\Uzytkownik\\Obiekt',
		'Zamowienie' => 'Generic\\Model\\Zamowienie\\Obiekt',
		'ZamowienieTyp' => 'Generic\\Model\\ZamowienieTyp\\Obiekt',
		'NowyKoordynator' => 'Generic\\Model\\Uzytkownik\\Obiekt',
		'StaryKoordynator' => 'Generic\\Model\\Uzytkownik\\Obiekt',
		'StaryTeam' => 'Generic\\Model\\Team\\Obiekt',
		'NowyTeam' => 'Generic\\Model\\Team\\Obiekt',
		'Notes' => 'Generic\\Model\\Notes\\Obiekt',
		'Uzytkownik' => 'Generic\\Model\\Uzytkownik\\Obiekt',
		'Pracownik' => 'Generic\\Model\\Uzytkownik\\Obiekt',
		'OpiekunMagazynu' => 'Generic\\Model\\Uzytkownik\\Obiekt',
	);



	protected $powiazania = array(
		'Uzytkownik' => array('Wizytowka',),
		'Lokalizacja' => array('Wizytowka',),
		'Material' => array('Wizytowka',),
		'Wiadomosc' => array('Nadawca', 'Odbiorca', 'WizytowkaNadawcy', 'WizytowkaOdbiorcy'),
		'Koordynator' => array('Zamowienie'),
		'Team' => array('Zamowienie'),
	);



	public function pobierzObslugiwaneObiekty()
	{
		return $this->obslugiwaneObiekty;
	}



	public function czyObiektyObslugiwany($etykieta, $obiekt)
	{
		if ( ! is_object($obiekt)) return false;
		if ( ! isset($this->obslugiwaneObiekty[$etykieta])) return false;
		$klasa = $this->obslugiwaneObiekty[$etykieta];
		if ( ! $obiekt instanceof $klasa) return false;
		return true;
	}



	public function wczytajObiekty(Array $obiekty)
	{
		foreach ($obiekty as $etykieta => $obiekt)
		{
			if ($this->czyObiektyObslugiwany($etykieta, $obiekt))
			{
				$this->instancje[$etykieta] = $obiekt;
			}
		}
	}



	/**
	 * Dodaje instancję obiektu żądanej klasy do wewnętrznej tablicy obiektów.
	 *
	 * @param string $nazwaKlasy Nazwa klasy której instancją ma być tworzony obiekt.
	 */
	protected function ustaw($nazwaKlasy)
	{
		if ( ! isset($this->obslugiwaneObiekty[$nazwaKlasy]))
		{
			return;
		}

		$sciezkaPobierania = $this->wyznaczSciezkePobierania($nazwaKlasy);

		if (count($sciezkaPobierania) > 1)
		{
			$obiektZrodlo = $obiektPobierany = null;
			foreach ($sciezkaPobierania as $etykietaObiektu)
			{
				if ($obiektZrodlo === null)
				{
					$obiektZrodlo = $etykietaObiektu;
					continue;
				}
				$obiektPobierany = $etykietaObiektu;
				if ($obiektZrodlo !== null && $obiektPobierany !== null)
				{
					$this->pobierzObiekt($obiektZrodlo, $obiektPobierany);
				}
				$obiektZrodlo = $obiektPobierany;
			}
		}
	}



	protected function wyznaczSciezkePobierania($etykietaSzukany)
	{
		$mapa = array();
		$pola = array_keys($this->obslugiwaneObiekty);
		$polaOdwrocone = array_flip(array_keys($this->obslugiwaneObiekty));

		// budowanie mapy grafu dla wzoru Roy-Warshalla
		foreach ($pola as $id1 => $nazwa1)
		{
			foreach ($pola as $id2 => $nazwa2)
			{
				$mapa[$id1][$id2] = (isset($this->powiazania[$nazwa1]) && in_array($nazwa2, $this->powiazania[$nazwa1])) ? $id2 : 0;
			}
		}
		// algorytm Roy-Warshalla
		$n = count($mapa);
		for ($x = 0; $x < $n; $x++)
		{
			for ($y = 0; $y < $n; $y++)
			{
				if ($mapa[$y][$x] != 0)
				{
					for ($z = 0; $z < $n; $z++)
					{
						if ($mapa[$y][$z] == 0 && $mapa[$x][$z] != 0)
						{
							$mapa[$y][$z] = $mapa[$y][$x];
						}
					}
				}
			}
		}

		$sciezki = array();
		foreach ($this->instancje as $etykietaDostepny => $obiekt)
		{
			$x = $polaOdwrocone[$etykietaDostepny]; //skad zaczynamy
			$y = $polaOdwrocone[$etykietaSzukany]; // gdzie chcemy dojsc
			$k = 0; //zmienna pomocnicza

			// wyznaczanie sciezki do pobrania obiektu dla wzoru Roy-Warshalla
			if ($mapa[$x][$y] != 0)
			{
				$sciezka = array($pola[$x]);
				$k = $x;
				while ($k != $y)
				{
					$k = $mapa[$k][$y];
					$sciezka[] = $pola[$k];
				}
				$sciezki[] = $sciezka;
			}
		}
		$najkrotszaSsciezka = false;

		foreach ($sciezki as $sciezka)
		{
			if ($najkrotszaSsciezka === false)
				$najkrotszaSsciezka = $sciezka;
			elseif (count($najkrotszaSsciezka) > count($sciezka))
				$najkrotszaSsciezka = $sciezka;
		}
		return $najkrotszaSsciezka;
	}



	protected function pobierzObiekt($nazwaZrodla, $nazwaCelu)
	{
		$zrodlo = $this->instancje[$nazwaZrodla];
		$cel = $zrodlo->{lcfirst($nazwaCelu)};

		$spodziewanaKlasaCelu = $this->obslugiwaneObiekty[$nazwaCelu];
		if ($cel instanceof $spodziewanaKlasaCelu || $cel === null)
		{
			$this->instancje[$nazwaCelu] = $cel;
		}
		else
		{
			trigger_error("Nieprawidlowy obiekt celu $nazwaCelu, spodziewana klasa to $spodziewanaKlasaCelu", E_USER_WARNING);
		}
		//echo "Ze zrodla $nazwaZrodla (".get_class($zrodlo).") pobrano $nazwaCelu (".get_class($cel).") <br>";
	}

}

?>
