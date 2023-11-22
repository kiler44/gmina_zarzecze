<?php
namespace Generic\Biblioteka\Mapper\Baza;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\BazaWyjatek;


/**
 * Klasa odpowiedzialna za pobieranie i zapisywanie danych do bazy danych
 * Dodatkowo obsługuje wersjonowanie danych. Wersjonowanie odbywa się do tabeli
 * wersjonujacej (struktura pól identyczna jak podstawowej) znajdujacej się
 * w tej samej lub innej bazie danych.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Wersjonowana extends Biblioteka\Mapper\Baza implements Biblioteka\Mapper\Interfejs
{

	/**
	 * Przetrzymuje referencje do sterownika wersjonującej bazy danych
	 *
	 * @var Baza
	 */
	protected $bazaWersje;


	/**
	 * Nazwa tabeli wersjonującej w bazie do której będą zapisywane dane
	 *
	 * @var string
	 */
	protected $tabelaWersje;


	/**
	 * Identyfikator wersjonującej bazy danych z konfiguracji
	 *
	 * @var string
	 */
	protected $identyfikatorBazyWersje = null;


	/**
	 * Odwrotnosc tablicy $polaTabeliObiekt
	 *
	 * @var array
	 */
	private $obiektPolaTabeli = array();


	/**
	 * Pola, których zmiana powoduje zapis w tabeli wersji
	 *
	 * @var array
	 */
	protected $polaWersjonowane = array();



	/**
	 * Konstruktor ustawia typ zwracanego obiektu i ustawia bazę danych
	 *
	 * @param boolean $zwracaTablice Czy wynik ma byc zwracany w postaci tablicy czy standardowo w postaci obiektu
	 */
	public function __construct($zwracaTablice = false)
	{
		parent::__construct($zwracaTablice);
		$this->bazaWersje = Cms::inst()->Baza($this->identyfikatorBazyWersje);
		$this->obiektPolaTabeli = array_flip($this->polaTabeliObiekt);
	}



	/**
	 * Dodaje nowy obiekt do zrodla danych i zwraca identyfikator utworzonego rekordu
	 *
	 * @param ObiektDanych $obiekt zapisywany obiekt
	 *
	 * @return integer
	 */
	public function wstaw(ObiektDanych $obiekt, $id = 0)
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
			$this->zapiszWersje($dane, $obiekt);
			return $dane['id'];
		}
		catch (BazaWyjatek $wyjatek)
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class ($obiekt).' w bazie.');
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
			$daneWersje = array();
			$zmienne = $obiekt->daneDoZapisu();
			$pola = array_keys($zmienne);
			$polaZmodyfikowane = $obiekt->zmodyfikowanePola();
			$nalezyZapisacWersje = $this->czyZapisacWersje($polaZmodyfikowane);

			if ($nalezyZapisacWersje)
			{
				foreach ($pola as $zmienna)
				{
					$poleTabeli = $this->obiektPolaTabeli[$zmienna];

					if (in_array($zmienna, $polaZmodyfikowane))
					{
						if (in_array($poleTabeli, $this->polaTabeliKlucz)) continue;
						$dane[$poleTabeli] = $this->formatujWartosc($poleTabeli, $zmienne[$zmienna]);
					}

					$daneWersje[$poleTabeli] = $this->formatujWartosc($poleTabeli, $zmienne[$zmienna]);
				}
			}
			else
			{
				foreach ($polaZmodyfikowane as $zmienna)
				{
					$poleTabeli = $this->obiektPolaTabeli[$zmienna];
					if (in_array($poleTabeli, $this->polaTabeliKlucz)) continue;
					$dane[$poleTabeli] = $this->formatujWartosc($poleTabeli, $zmienne[$zmienna]);
				}
			}

			if (count($dane) > 0)
			{
				$polaKlucza = $this->piszKlucz($obiekt);
				$polaKlucza = (count($polaKlucza) > 0) ? array('AND' => $polaKlucza) : null;
				$this->baza->zapytanie($this->baza->sqlUpdate($this->tabela, $dane, $polaKlucza));

				if ($nalezyZapisacWersje)
				{
					$this->zapiszWersje($daneWersje, $obiekt);
				}
			}
		}
		catch (BazaWyjatek $wyjatek)
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($obiekt).' w bazie.');
		}
	}


	/**
	 * Sprawdza czy jakiekolwiek ze zmodyfikowanych pól występuje na liście pól wersjonowanych
	 *
	 * @param Array $polaZmodyfikowane - lista zmodyfikowanych pól
	 *
	 * @return boolean
	 */
	protected function czyZapisacWersje($polaZmodyfikowane)
	{
		if (count($this->polaWersjonowane) == 0)
		{
			return true;
		}

		foreach ($polaZmodyfikowane as $poleZmodyfikowane)
		{
			if (in_array($poleZmodyfikowane, $this->polaWersjonowane))
			{
				return true;
			}
		}

		return false;
	}


	/**
	 * Zapisuje rekord w tabeli wersji. Podczas uzywania celowo nie obsługuję
	 * zwracanych parametrów - zapis do tabeli wersji może nie nastąpic, jednak
	 * podtrzymujemy dzialanie reszty systemu.
	 *
	 * @param Array $daneWersje
	 *
	 * @return boolean
	 */
	protected function zapiszWersje(Array $daneWersje, ObiektDanych $obiekt)
	{
		try
		{
		$this->bazaWersje->zapytanie($this->bazaWersje->sqlInsert($this->tabelaWersje, $daneWersje));
		}
		catch (BazaWyjatek $wyjatek)
		{
			trigger_error('Nie mozna zapisac danych obiektu wersji '.get_class ($obiekt).' w bazie '. $this->identyfikatorBazyWersje .'.');
			return false;
		}
		return true;
	}

}
