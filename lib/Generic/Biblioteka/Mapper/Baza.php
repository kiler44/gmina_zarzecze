<?php
namespace Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\BazaWyjatek;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\DefinicjaObiektu;


/**
 * Klasa odpowiedzialna za pobieranie i zapisywanie danych do bazy danych
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Baza extends Mapper implements Biblioteka\Mapper\Interfejs
{
	/**
	 * Przetrzymuje referencje do sterownika bazy danych
	 *
	 * @var Baza
	 */
	protected $baza;


	/**
	 * Nazwa tabeli w bazie do której będą zapisywane dane
	 *
	 * @var string
	 */
	protected $tabela;


	/**
	 * Identyfikator bazy danych z konfiguracji
	 *
	 * @var string
	 */
	protected $identyfikatorBazy = null;


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
	protected $obiektPolaTabeli = array();


	/**
	 * Pola tabeli tworzące klucz główny
	 *
	 * @var array
	 */
	protected $polaTabeliKlucz = array();


	/**
	 * Czy klucz główny posiada auto increment
	 *
	 * @var bool
	 */
	protected $polaTabeliKluczAutoIncrement = false;


	/**
	 * Przetrzymuje typy kolumn tabeli w bazie
	 *
	 * @var array
	 */
	protected $polaTabeliTypy = array();



	/**
	 * Konstruktor ustawia typ zwracanego obiektu i ustawia bazę danych
	 *
	 * @param boolean $zwracaTablice Czy wynik ma byc zwracany w postaci tablicy czy standardowo w postaci obiektu
	 */
	public function __construct(bool $zwracaTablice = false)
	{
		parent::__construct($zwracaTablice);

		$def = $this->definicjaObiektu;
		$ilosc_mapper = count($this->polaTabeliObiekt);
		$ilosc_def = count($def->polaObiektuTypy);
		if ($ilosc_def == $ilosc_mapper)
		{
			$this->polaTabeliTypy = array_combine(array_keys($this->polaTabeliObiekt), array_values($def->polaObiektuTypy));
		}
		else
			throw new \Exception('Ilość pol w Definicji('.$ilosc_def.') nie zgadza się z ilością w Mapperze('.$ilosc_mapper.') dla obiektu: "'.get_class($this).'"', E_USER_ERROR);


		$this->baza = Cms::inst()->Baza($this->identyfikatorBazy);
		$this->obiektPolaTabeli = array_flip($this->polaTabeliObiekt);
	}



	/**
	 * Formatuje wartosc na podstwie parametru i jego typu okreslonego
	 * w tabeli 'polaObiektuTypy' w pliku Definicja dla danego OD na potrzeby zapisu do bazy danych
	 *
	 * @param string $parametr nazwa formatowanego pola
	 * @param mixed $wartosc wartosc formatowanego pola
	 * @return mixed sformatowana wartosc
	 */
	protected function formatujWartosc(string $parametr, $wartosc)
	{
		$defObiektu = $this->definicjaObiektu;

		switch ($defObiektu->polaObiektuTypy[$this->polaTabeliObiekt[$parametr]])
		{
			case $defObiektu::_STRING:
				//$wartosc = ($wartosc === null || $wartosc === false) ? 'NULL' : '\''.str_replace ("'", "''", $wartosc).'\'';
				$wartosc = ($wartosc === null || $wartosc === false) ? 'NULL' : $this->baza->formatujTekst($wartosc);
				break;

			case $defObiektu::_INTEGER:
				$wartosc = ($wartosc == '' && $wartosc != 0) ? 'NULL' : intval($wartosc);
				break;

			case $defObiektu::_FLOAT:
				$wartosc = ($wartosc === null) ? 'NULL' : floatval($wartosc);
				break;
			case $defObiektu::_DOUBLE:
				$wartosc = ($wartosc === null) ? 'NULL' : doubleval($wartosc);
				break;
			case $defObiektu::_BOOLEAN:
				$wartosc = ($wartosc === null || $wartosc === false || $wartosc === 0 || trim($wartosc) == '') ? 'false' : 'true';
				break;
			case $defObiektu::_LIST:
				if (is_array($wartosc))
				{
					$wartosc = (count($wartosc) > 0) ? implode('|', $wartosc) : implode('|', array());
				}
				$wartosc = $this->baza->formatujTekst(strval($wartosc));

				break;
			case $defObiektu::_JSON:
				
				if (is_array($wartosc))
				{
					$wartosc = (count($wartosc) > 0) ? json_encode($wartosc) : json_encode(array());
				}
				$wartosc = $this->baza->formatujTekst(strval($wartosc));

				break;
			case $defObiektu::_ARRAY:
				if (is_array($wartosc))
				{
					$wartosc = (count($wartosc) > 0) ? serialize($wartosc) : serialize(array());
				}
				$wartosc = $this->baza->formatujTekst(strval($wartosc));

				break;
			case $defObiektu::_DATETIME:
				if ($wartosc instanceof \DateTime)
				{
					$wartosc = $wartosc->format('Y-m-d H:i:s');
				}
				$wartosc = $this->baza->formatujTekst(strval($wartosc));
				break;
			case $defObiektu::_ENUM:
				$wartosc = $this->baza->formatujTekst(strval($wartosc));
				break;
		}
		return $wartosc;
	}



	/**
	 * Pisze zapytanie na podstawie pol klucza glownego i pobiera nowe id z bazy
	 *
	 * @return integer
	 */
	protected function pobierzId(ObiektDanych $obiekt): int
	{
		$polaKlucza = $this->piszKlucz($obiekt);
		unset($polaKlucza['id']);
		$polaKlucza = (count($polaKlucza) > 0) ? array('AND' => $polaKlucza) : null;
		$this->baza->zapytanie($this->baza->sqlId($this->tabela, $polaKlucza));
		$dane = $this->baza->pobierzWynik();
		return $dane['id'];
	}



	/**
	 * Zwraca wartosc warunku WHERE zapytania na podstawie danych obiektu
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
		return $klucz;
	}



	/**
	 * Zamienia tablice z kryteriami wyszukiwania na tablice z ich odpowiednikami w zapisie sql
	 *
	 * @param array $kryteria Tablica zawierajaca kryteria
	 *
	 * @return array
	 */
	protected function piszKryteria(Array &$kryteria) : array
	{
		return $this->baza->piszKryteria($kryteria, $this->polaTabeliTypy);
	}



	/**
	 * Dodaje nowy obiekt do zrodla danych i zwraca identyfikator utworzonego rekordu
	 *
	 * @param ObiektDanych $obiekt zapisywany obiekt
	 *
	 * @return integer
	 */
	public function wstaw(ObiektDanych $obiekt, $id = 0) :int
	{
		if ( ! $this->obiektObslugiwany($obiekt))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w bazie.');
		}
		try
		{
			if ($id == 0 && ! $this->polaTabeliKluczAutoIncrement)
				$dane['id'] = $this->pobierzId($obiekt);
			else
				$dane['id'] = $id;

			$zmienne = $obiekt->daneDoZapisu();
			foreach ($obiekt->zmodyfikowanePola() as $zmienna)
			{
				$poleTabeli = $this->obiektPolaTabeli[$zmienna];
				$dane[$poleTabeli] = $this->formatujWartosc($poleTabeli, $zmienne[$zmienna]);
			}
			$this->baza->zapytanie($this->baza->sqlInsert($this->tabela, $dane));
			return $dane['id'];
		}
		catch (BazaWyjatek $wyjatek)
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class ($obiekt).' w bazie.');
		}
	}



	/**
	 * Dodaje nowy obiekt do zrodla danych wraz z identyfikatorem wpisanym na sztywno
	 * Uwaga!!!
	 * Metode nalezy uzywac bardzo ostroznie i przemyslanie
	 *
	 * @param ObiektDanych $obiekt zapisywany obiekt
	 * @param int $id identyfikator obiektu
	 *
	 * @return integer
	 */
	public function wstawZId(ObiektDanych $obiekt, $id) :int
	{
		if ( ! $this->obiektObslugiwany($obiekt))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w bazie.');
		}
		try
		{
			foreach ($obiekt->daneDoZapisu() as $zmienna => $wartosc)
			{
				$poleTabeli = $this->obiektPolaTabeli[$zmienna];
				$dane[$poleTabeli] = $this->formatujWartosc($poleTabeli, $wartosc);
			}
			$dane['id'] = $id;
			$this->baza->zapytanie($this->baza->sqlInsert($this->tabela, $dane));
			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			return false;
		}
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
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w bazie.');
		}
		try
		{
			$dane = array();
			$zmienne = $obiekt->daneDoZapisu();

			foreach ($obiekt->zmodyfikowanePola() as $zmienna)
			{
				$poleTabeli = $this->obiektPolaTabeli[$zmienna];
				if (in_array($poleTabeli, $this->polaTabeliKlucz)) continue;
				$dane[$poleTabeli] = $this->formatujWartosc($poleTabeli, $zmienne[$zmienna]);
			}
			if (count($dane) > 0)
			{
				$polaKlucza = $this->piszKlucz($obiekt);
				$polaKlucza = (count($polaKlucza) > 0) ? array('AND' => $polaKlucza) : null;
				$this->baza->zapytanie($this->baza->sqlUpdate($this->tabela, $dane, $polaKlucza));
			}
		}
		catch (BazaWyjatek $wyjatek)
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w bazie.');
		}
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
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w bazie.');
		}
		try
		{
			$polaKlucza = $this->piszKlucz($obiekt);
			$polaKlucza = (count($polaKlucza) > 0) ? array('AND' => $polaKlucza) : null;
			$this->baza->zapytanie($this->baza->sqlDelete($this->tabela, $polaKlucza));
		}
		catch (BazaWyjatek $wyjatek)
		{
			throw new MapperWyjatek('Nie mozna usunac danych obiektu '.get_class($obiekt).' w bazie.');
		}
	}



	/**
	 * Zwraca obiekt(o typie podanym w zmiennej self::klasaObiektu) lub tablice, na na podstawie danych ze zrodla
	 *
	 * @param array $dane Tablica z danymi potrzebnymi do utworzenia obiektu
	 *
	 * @return ObiektDanych|array
	 */
	protected function przetworzWynik(array $dane)
	{
		if ($this->zwracaTablice == self::ZWRACA_TABLICE)
		{
			return $dane;
		}
		else
		{
			$polaObiektu = array();
			foreach ($this->polaTabeliObiekt as $poleTabeli => $zmienna)
			{
				if (array_key_exists($poleTabeli, $dane)) $polaObiektu[$zmienna] = $dane[$poleTabeli];
			}
			return parent::przetworzWynik($polaObiektu);
		}
	}



	/**
	 * Pobiera pojedynczy wiersz z tabeli bazy danych
	 *
	 * @param string $zapytanie zapytanie sql
	 *
	 * @return ObiektDanych|array
	 */
	protected function pobierzJeden($zapytanie)
	{
		try
		{
			if (is_array($zapytanie))
			{
				if ( ! array_key_exists('kolumny', $zapytanie))
				{
					$zapytanie['kolumny'] = '*';
				}
				if (!array_key_exists('tabela', $zapytanie))
				{
					$zapytanie['tabela'] = $this->tabela;
				}
				if (array_key_exists('kryteria', $zapytanie))
				{
					$zapytanie['warunek'] = array('AND' => $zapytanie['kryteria']);
				}
				$zapytanie = $this->baza->sqlSelect($zapytanie);
			}
			$this->baza->zapytanie($zapytanie);
			$dane = array();
			$dane = $this->baza->pobierzWynik();

			$zwracanaWartosc = (is_array($dane)) ? $this->przetworzWynik($dane) : false;

			if ($this->zwracaTablice)
			{
				$this->zwracaObiekt();
			}

			return $zwracanaWartosc;
		}
		catch (BazaWyjatek $wyjatek)
		{
			//throw new MapperWyjatek ('Nie mozna pobrac danych z bazy');
			return false;
		}
	}



	/**
	 * Pobiera dane z bazy danych i zwraca w postaci tablicy
	 *
	 * @param string $zapytanie zapytanie sql
	 * @param Pager $pager Obiekt pager-a
	 * @param Sorter $sorter Obiekt sorter-a
	 *
	 * @return array
	 */
	protected function pobierzWiele($zapytanie, Pager $pager = null, Biblioteka\Sorter $sorter = null) :array
	{
		try
		{
			if (is_array($zapytanie))
			{
				if ( ! array_key_exists('kolumny', $zapytanie))
				{
					if (count($this->zwracaneKolumnyTablicy) > 0)
						$zapytanie['kolumny'] = implode(',', $this->zwracaneKolumnyTablicy);
					else
						$zapytanie['kolumny'] = '*';
				}
				if ( ! array_key_exists('tabela', $zapytanie))
				{
					$zapytanie['tabela'] = $this->tabela;
				}
				if (array_key_exists('kryteria', $zapytanie))
				{
					$zapytanie['warunek'] = array('AND' => $zapytanie['kryteria']);
				}
			}

			$zapytanie = $this->baza->sqlSelect($zapytanie, $pager, $sorter);

			if ($this->zwracaTablice == self::ZWRACA_TABLICE
				&& count($this->zwracaneKolumnyTablicy) > 0
				&& substr($zapytanie, 7, 1) == '*')
			{
				$zapytanie = substr_replace($zapytanie, implode(',', $this->zwracaneKolumnyTablicy), 7, 1);
			}

			$this->baza->zapytanie($zapytanie);

			$lista = array();
			while ($dane = $this->baza->pobierzWynik())
			{
				$lista[] = $this->przetworzWynik($dane);
			}
			if ($this->zwracaTablice)
			{
				$this->zwracaObiekt();
			}

			return $lista;
		}
		catch (BazaWyjatek $wyjatek)
		{
			//throw new MapperWyjatek ('Nie mozna pobrac danych z bazy');
			return array();
		}
	}



	/**
	 * Zwraca wartosc pobrana z bazy
	 *
	 * @param string $zapytanie zapytanie sql
	 *
	 * @return mixed
	 */
	protected function pobierzWartosc($zapytanie)
	{
		try
		{
			if (is_array($zapytanie))
			{
				if (!array_key_exists('kolumny', $zapytanie))
				{
					$zapytanie['kolumny'] = 'COUNT(*)';
				}
				if (!array_key_exists('tabela', $zapytanie))
				{
					$zapytanie['tabela'] = $this->tabela;
				}
				if (array_key_exists('kryteria', $zapytanie) && ! empty($zapytanie['kryteria']))
				{
					$zapytanie['warunek'] = array('AND' => $zapytanie['kryteria']);
				}
				$zapytanie = $this->baza->sqlSelect($zapytanie);
			}
			$this->baza->zapytanie($zapytanie);
			$wynik = $this->baza->pobierzWynik();
			if(is_array($wynik))
			{
				return array_shift($wynik);
			}
			else
			{
				return $wynik;
			}
		}
		catch (BazaWyjatek $wyjatek)
		{
			//throw new MapperWyjatek ('Nie mozna pobrac wartosci z bazy');
			return false;
		}
	}




	/**
	 * Przygotowuje zapytanie w formie tablicy
	 * @return array
	 */
	protected function przygotujZapytanieWyszukujace() : array
	{
		$zapytanie = array();
		$zapytanie['tabela'] = $this->tabela;
		$zapytanie['kryteria'] = array();
		if (in_array('id_projektu', $this->polaTabeliKlucz))
		{
			$zapytanie['kryteria']['id_projektu_rowne_'] = ID_PROJEKTU;
		}
		if (in_array('kod_jezyka', $this->polaTabeliKlucz))
		{
			$zapytanie['kryteria']['kod_jezyka_rowne_'] = KOD_JEZYKA;
		}
		$zapytanie['kryteria'] = $this->piszKryteria($zapytanie['kryteria']);

		return $zapytanie;
	}



	/**
	 * Zwraca tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	 *
	 * @return array
	 */
	public function pobierzPolaTabeliObiekt() :array
	{
		return $this->polaTabeliObiekt;
	}



	/**
	 * formatuje tekst dla zapytania sql
	 *
	 * @return array
	 */
	public function q($tekst)
	{
		return $this->baza->formatujTekst($tekst);
	}



	/**
	 * Wykonuje kod SQL.
	 *
	 * @param string $sql - kod SQL do wykonania
	 *
	 * @return bool
	 */
	public function wykonajSql($sql) :bool
	{
		try
		{
			$this->baza->transakcjaStart();
			$this->baza->zapytanie($sql);
			$this->baza->transakcjaPotwierdz();
			return true;
}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}


	public function warunekBool($wartosc)
	{
		if ($wartosc)
			return 'true';
		return 'false';
	}

}
