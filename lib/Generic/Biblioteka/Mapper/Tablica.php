<?php
namespace Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\Pager;


/**
 * Klasa odpowiedzialna za pobieranie i zapisywanie danych do plików
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Tablica extends Mapper\Singleton implements Biblioteka\Mapper\Interfejs
{

	/**
	 * Okresla czy zwracac wynik jako tablice czy jako obiekt
	 */
	const ZWRACA_TABLICE = true;


	/**
	 * Okresla typ wyniku(tablica lub obiekt)
	 *
	 * @var boolean
	 */
	protected $zwracaTablice = false;


	/**
	 * Okresla kolumny ktore maja byc zwracane jezeli $zwracaTablice = true
	 * Jezeli zmienna pusta to zwraca wszystkie kolumny
	 *
	 * @var array
	 */
	protected $zwracaneKolumnyTablicy = array();


	/**
	 * Okresla nazwe klasy tworzonego obiektu
	 *
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\ObiektDanych\Obiekt';


	/**
	 * Instancja klasy tworzonego obiektu
	 *
	 * @var ObiektDanych
	 */
	protected $_instancja;


	/**
	 * Okresla czy dane zostaly zaladowane
	 *
	 * @var boolean
	 */
	protected $daneZaladowane = false;


	/**
	 * Tablica przetrzymujaca dane
	 *
	 * @var array
	 */
	protected $dane = array();


	/**
	 * Tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 *
	 * @var array
	 */
	protected $polaTabeliObiekt = array();


	/**
	 * Odwrotnosc tablicy $polaTabeliObiekt
	 *
	 * @var array
	 */
	private $obiektPolaTabeli = array();


	/**
	 * Pola tabeli tworzące klucz główny
	 *
	 * @var array
	 */
	protected $polaTabeliKlucz = array();



	protected function inicjuj()
	{
		if ( ! $this->daneZaladowane)
		{
			$this->daneZaladowane = ($this->zaladujDane()) ? true : false;
		}
		$this->obiektPolaTabeli = array_flip($this->polaTabeliObiekt);
	}



	/**
	 * Zwraca instancje Singleton-a.
	 * Ustawia tez typ zwracanych danych.
	 */
	public static function wywolaj($zwracaTablice = false)
	{
		$obiekt = parent::wywolaj();
		($zwracaTablice) ? $obiekt->zwracaTablice() : $obiekt->zwracaObiekt();
		return $obiekt;
	}



	/**
	 * Wstawia dane tworzac klucz glowny
	 *
	 * @param array $dane Dane do przefiltrowania
	 */
	protected function przetworzDane($dane = array())
	{
		foreach ($dane as $wiersz)
		{
			$klucz = array();
			foreach ($this->polaTabeliKlucz as $pole) $klucz[] = $wiersz[$pole];
			$klucz = implode('-', $klucz);
			$this->dane[$klucz] = $wiersz;
		}
	}



	/**
	 * Laduje dane do mappera i zwraca True jezeli sukces False w przeciwym wypadku
	 *
	 * @return boolean
	 */
	public function zaladujDane() {}



	/**
	 * Laduje dane do mappera i zwraca True jezeli sukces False w przeciwym wypadku
	 *
	 * @return boolean
	 */
	public function zapiszDane() {}



	/**
	 * Czyści dane z mappera.
	 */
	public function czyscDane()
	{
		$this->dane = array();
		$this->daneZaladowane = false;
	}



	/**
	 * Sprawdza czy mapper jest zdolny do dzialania.
	 *
	 * @return boolean
	 */
	public function dostepny()
	{
		if ( ! $this->daneZaladowane)
		{
			$this->inicjuj();
		}
		return ($this->daneZaladowane) ? true : false;
	}



	/**
	 * Ustawia typ zwracanego obiektu na tablice i zwraca instancja obiektu z hierarchii Mapper
	 *
	 * @param array $kolumny Kolumny ktore powinny byc pobierane w trybie tablicowym
	 *
	 * @return Mapper
	 */
	public function zwracaTablice($kolumny = array())
	{
		$this->zwracaTablice = true;
		$this->zwracaneKolumnyTablicy = array();

		$kolumny = is_array($kolumny) ? $kolumny : func_get_args();

		if (count($kolumny) > 0)
		{
			foreach ($kolumny as $kolumna)
			{
				$kolumna = (string)$kolumna;
				if ($kolumna == '') continue;
				$this->zwracaneKolumnyTablicy[] = $kolumna;
			}
		}
		return $this;
	}



	/**
	 * Ustawia typ zwracanego obiektu na obiekt i zwraca instancja obiektu z hierarchii Mapper
	 *
	 * @return Mapper
	 */
	public function zwracaObiekt()
	{
		if ($this->zwracanyObiekt != '')
		{
			$this->zwracaTablice = false;
			$this->_instancja = new $this->zwracanyObiekt();
		}
		return $this;
	}



	/**
	 * Pisze klucz na podstawie danych obiektu
	 * i tabeli 'polaTabeliKlucz' z polami klucza glownego
	 *
	 * @param ObiektDanych $obiekt obiekt dziedziny
	 *
	 * @return string
	 */
	protected function piszKlucz(ObiektDanych $obiekt)
	{
		$klucz = array();
		foreach ($this->polaTabeliKlucz as $poleTabeli)
		{
			$zmienna = $this->polaTabeliObiekt[$poleTabeli];
			if ($zmienna != 'id' && $obiekt->$zmienna == '')
			{
				throw new MapperWyjatek('Nie ustawiono wymaganej wlasnosci \''.$zmienna.'\' (pole klucza glownego) obiektu klasy '.get_class ($obiekt));
			}
			$klucz[$poleTabeli] = $obiekt->$zmienna;
		}
		return implode('-', $klucz);
	}



	/**
	 * Pobiera najwieksze id z tablicy
	 *
	 * @param ObiektDanych $obiekt Zapisywany obiekt
	 *
	 * @return integer
	 */
	public function najwiekszeId()
	{
		$maxId = 0;

		foreach($this->dane as $klucz => $wartosc)
		{
			if($wartosc['id'] > $maxId)
				$maxId = $wartosc['id'];
		}
		return $maxId;
	}



	/**
	 * Sprawdza czy obiekt danych jest obslugiwany przez mapper
	 *
	 * @param ObiektDanych $obiekt Sprawdzany obiekt
	 *
	 * @return boolean
	 */
	protected function obiektObslugiwany(ObiektDanych $obiekt)
	{
		if ($obiekt instanceof $this->zwracanyObiekt)
		{
			return true;
		}
		else
		{
			trigger_error('Obiekt klasy '.get_class($obiekt).' nie moze byc zapisywany przez mapper '.get_class($this), E_USER_WARNING);
			return false;
		}
	}



	/**
	 * Dodaje nowy obiekt do zrodla danych i zwraca identyfikator utworzonego rekordu
	 *
	 * @param ObiektDanych $obiekt Zapisywany obiekt
	 *
	 * @return integer
	 */
	public function wstaw(ObiektDanych $obiekt)
	{
		if ( ! $this->obiektObslugiwany($obiekt))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w pliku.');
		}
		$id = $this->najwiekszeId() + 1;

		$this->dane[$id]['id'] = $id;

		foreach ($obiekt->zmodyfikowanePola() as $zmienna)
		{
			$poleTabeli = $this->obiektPolaTabeli[$zmienna];
			if (in_array($poleTabeli, $this->polaTabeliKlucz)) continue;

			$this->dane[$id][$poleTabeli] = $obiekt->$zmienna;
		}
		return $this->zapiszDane();
	}



	/**
	 * Uaktualnia rekord w zrodle danych
	 *
	 * @param ObiektDanych $obiekt Zapisywany obiekt
	 *
	 * @return boolean
	 */
	public function aktualizuj(ObiektDanych $obiekt)
	{
		if ( ! $this->obiektObslugiwany($obiekt))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w pliku.');
		}
		foreach ($obiekt->zmodyfikowanePola() as $zmienna)
		{
			$poleTabeli = $this->obiektPolaTabeli[$zmienna];
			if (in_array($poleTabeli, $this->polaTabeliKlucz)) continue;

			$this->dane[$this->piszKlucz($obiekt)][$poleTabeli] = $obiekt->$zmienna;
		}
		return $this->zapiszDane();
	}



	/**
	 * Usuwa obiekt z zrodla danych
	 *
	 * @param ObiektDanych $obiekt zapisywany obiekt
	 *
	 * @return boolean
	 */
	public function usun(ObiektDanych $obiekt)
	{
		if ( ! $this->obiektObslugiwany($obiekt))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w pliku.');
		}
		unset($this->dane[$this->piszKlucz($obiekt)]);
		return $this->zapiszDane();
	}



	/**
	 * Pobiera dane filtrujac je po zawartosci kolumny
	 *
	 * @param array $dane Dane do przefiltrowania
	 * @param string $kolumna Nazwa kolumny
	 * @param array $wartosci Porzadane wartosci kolumny
	 *
	 * @return array
	 */
	protected function kolumnaRowna($dane, $kolumna, Array $wartosci)
	{
		$temp = array();
		foreach ($dane as $klucz => $wiersz)
		{
			if (in_array($wiersz[$kolumna], $wartosci))
			{
				$temp[$klucz] = $wiersz;
			}
		}
		return $temp;
	}



	/**
	 * Pobiera dane filtrujac je po zawartosci kolumny
	 *
	 * @param array $dane Dane do przefiltrowania
	 * @param string $kolumna Nazwa kolumny
	 * @param string $wartosci Porzadane wartosci kolumny
	 *
	 * @return array
	 */
	protected function kolumnaZawiera($dane, $kolumna, $wartosc)
	{
		$temp = array();
		foreach ($dane as $klucz => $wiersz)
		{
			if (is_string($wiersz[$kolumna]) && stripos($wiersz[$kolumna], $wartosc) !== false)
			{
				$temp[$klucz] = $wiersz;
			}
			elseif (is_array($wiersz[$kolumna]) && in_array($wartosc, $wiersz[$kolumna]))
			{
				$temp[$klucz] = $wiersz;
			}
		}
		return $temp;
	}



	/**
	 * Sortuje przekazane dane wedlug kryteriow z obiektu sortera
	 *
	 * @param array $dane Dane do posortowania
	 * @param Sorter $sorter Obiekt sortera
	 *
	 * @return array
	 */
	protected function sorter(Array $dane, Biblioteka\Sorter $sorter)
	{
		$posortowane = array();
		// sortowanie losowe
		if ($sorter->wybraneSortowanie() == 'random')
		{
			$klucze = array_keys($dane);
			shuffle($klucze);
			foreach ($klucze as $klucz)
			{
				$posortowane[$klucz] = $dane[$klucz];
			}
			return $posortowane;
		}
		//sortowanie normalne
		else
		{
			//budujemy argumenty dla funkcji array_multisort()
			$sortowania = array();
			foreach ($sorter->wybraneKolumny() as $kolumna => $porzadek)
			{
				// kolumna ktora nie ma okreslonego porzadku dostanie wybrane przez uzytkownika
				if (is_numeric($kolumna))
				{
					$kolumna = $porzadek;
					$porzadek = '';
				}
				$porzadek = strtoupper($porzadek);
				$porzadek = ($porzadek == 'ASC' || $porzadek == 'DESC') ? $porzadek : $sorter->wybranyPorzadek();
				$tmp = array();
				foreach ($dane as $nrWiersza => $wiersz) $tmp[$nrWiersza] = $wiersz[$kolumna];
				$sortowania[] = $tmp;
				$sortowania[] = ($porzadek == 'DESC') ? SORT_DESC : SORT_ASC;
			}
			$sortowania[] = &$dane;
			call_user_func_array('array_multisort', $sortowania);
			return array_pop($sortowania);
		}
	}



	/**
	 * Obcina przekazane dane wedlug kryteriow z obiektu pager-a
	 *
	 * @param array $dane Dane do obciecia
	 * @param Pager $pager Obiekt pager-a
	 *
	 * @return array
	 */
	protected function pager(Array $dane, Pager $pager)
	{
		$licznik = 1;
		$poczatek = $pager->pierwszyNaStronie();
		$koniec = $pager->ostatniNaStronie();
		$bufor = array();
		foreach ($dane as $k => $v)
		{
			if ($licznik >= $poczatek && $licznik <= $koniec)
			{
				$bufor[$k] = $v;
			}
			$licznik++;
		}

		return $bufor;
	}



	/**
	 * Zwraca obiekt(o typie podanym w zmiennej self::klasaObiektu) lub tablice, na na podstawie danych ze zrodla
	 *
	 * @param array $dane Tablica z danymi potrzebnymi do utworzenia obiektu
	 *
	 * @return ObiektDanych|array
	 */
	protected function przetworzWynik(Array $dane)
	{
		if ($this->zwracaTablice == self::ZWRACA_TABLICE)
		{
			if (count($this->zwracaneKolumnyTablicy) > 0)
			{
				$temp = array();
				foreach ($dane as $kolumna => $wartosc)
				{
					if (in_array($kolumna, $this->zwracaneKolumnyTablicy)) $temp[$kolumna] = $wartosc;
				}
				$dane = $temp;
			}
			return $dane;
		}
		else
		{
			$polaObiektu = array();
			foreach ($this->polaTabeliObiekt as $poleTabeli => $zmienna)
			{
				if (array_key_exists($poleTabeli, $dane)) $polaObiektu[$zmienna] = $dane[$poleTabeli];
			}
			// Zastosowanie wzorca Prototype
			$obiekt = clone $this->_instancja;
			$obiekt->wypelnij($polaObiektu);
			return $obiekt;
		}
	}



	/**
	 * Pobiera pojedynczy wiersz ze źródła danych
	 *
	 * @param array $wiersz Wiersz danych
	 *
	 * @return ObiektDanych|array
	 */
	protected function pobierzJeden($wiersz)
	{
		$wiersz = (is_array($wiersz)) ? $this->przetworzWynik($wiersz) : false;
		if ($this->zwracaTablice)
		{
			$this->zwracaObiekt();
		}
		return $wiersz;
	}



	/**
	 * Pobiera dane z tablicy przekazanej jako parametr i zwraca w postaci tablicy
	 *
	 * @param array $tablica Tablica z danymi
	 * @param Pager $pager Obiekt pager-a
	 * @param Sorter $sorter Obiekt sorter-a
	 *
	 * @return array
	 */
	protected function pobierzWiele(Array $tablica, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		if ($sorter instanceof Biblioteka\Sorter)
		{
			$tablica = $this->sorter($tablica, $sorter);
		}
		if ($pager instanceof Pager)
		{
			$tablica = $this->pager($tablica, $pager);
		}
		$dane = array();
		
		if (count($tablica) > 0)
		{
			foreach ($tablica as $wiesz)
			{
				$dane[] = $this->przetworzWynik($wiesz);
			}
		}
		if ($this->zwracaTablice)
		{
			$this->zwracaObiekt();
		}
		return $dane;
	}

}
