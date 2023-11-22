<?php
namespace Generic\Biblioteka\Baza;
use Generic\Biblioteka\Baza;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka;


/**
 * Dekorator dla klasy bazy danych.
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Dekorator implements Baza\Interfejs
{

	/**
	 * Przetrzymuje obiekt obslugujacy baze danych.
	 *
	 * @var Baza
	 */
	protected $baza;



	/**
	 * Konstruktor, przekazuje obiekt obslugujacy baze danych do wewnetrznej zmiennej.
	 *
	 * @param Baza $baza obiekt obslugujacy baze.
	 */
	function __construct(Baza\Interfejs $baza)
	{
		$this->baza = $baza;
	}



	/**
	 * Wysyla zapytanie SQL do bazy danych i zachowuje rezultat w postaci obiektu klasy PDOStatement.
	 *
	 * @param string $sql zapytanie SQL.
	 */
	function zapytanie($sql)
	{
		$this->baza->zapytanie($sql);
	}



	/**
	 * Zwraca czas wykonywania ostatniego zapytania w sekundach i mikrosekuntach po przecinku
	 *
	 * @param integer $dokladnosc ile miejsc po przecinku wyswietlic.
	 *
	 * @return float
	 */
	function czasZapytania($dokladnosc = 0)
	{
		return $this->baza->czasZapytania($dokladnosc);
	}



	/**
	 * Pobiera wiersz w wyniku zapytania i zwraca w postaci tablicy asocjacyjnej.
	 *
	 * @return array
	 */
	function pobierzWynik()
	{
		return $this->baza->pobierzWynik();
	}



	/**
	 * Rozpoczyna transakcje w bazie
	 *
	 * @return boolean
	 */
	function transakcjaStart()
	{
		return $this->baza->transakcjaStart();
	}



	/**
	 * Potwierdza zapisanie zmian dokonanych w transakcji.
	 *
	 * @return boolean
	 */
	function transakcjaPotwierdz()
	{
		return $this->baza->transakcjaPotwierdz();
	}



	/**
	 * Anuluje zapisanie zmian dokonanych w transakcji.
	 *
	 * @return boolean
	 */
	function transakcjaCofnij()
	{
		return $this->baza->transakcjaCofnij();
	}



	/**
	 * Pisze zapytanie SQL SELECT i zwraca jego tresc
	 *
	 * @param string|array $zapytanie Zapytanie sql w formie tabeli lub tekstu
	 * @param Pager $pager Obiekt pager-a
	 * @param Sorter $sorter Obiekt sorter-a
	 *
	 * @return string
	 */
	public function sqlSelect($zapytanie, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		return $this->baza->sqlSelect($zapytanie, $pager, $sorter);
	}



	/**
	 * Pisze zapytanie SQL INSERT i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param array $dane Tablica zawierajaca dane w formacie array('nazwa_pola' => 'wartosc', itd.)
	 *
	 * @return string
	 */
	public function sqlInsert($tabela, $dane)
	{
		return $this->baza->sqlInsert($tabela, $dane);
	}



	/**
	 * Pisze zapytanie SQL UPDATE i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param array $dane Tablica zawierajaca dane w formacie array('nazwa_pola' => 'wartosc', itd.)
	 * @param string $warunek Tresc warunku where
	 *
	 * @return string
	 */
	public function sqlUpdate($tabela, $dane, $warunek)
	{
		return $this->baza->sqlUpdate($tabela, $dane, $warunek);
	}



	/**
	 * Pisze zapytanie SQL DELETE i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param string|array $warunek Tresc warunku where
	 *
	 * @return string
	 */
	public function sqlDelete($tabela, $warunek)
	{
		return $this->baza->sqlDelete($tabela, $warunek);
	}



	/**
	 * Pisze i zwraca kod sql operacji na podstawie podanych danych
	 *
	 * @param string $kolumna Kolumna ktorej dotyczy warunek
	 * @param string $operacja Operacja wykonywana na wartosci
	 * @param string $wartosc $wartosc
	 * @param mixed $typWartosci Typ pola do formatowania
	 * @return string
	 */
	public function sqlWarunek($kolumna, $operacja, $wartosc, $typWartosci)
	{
		return $this->baza->sqlWarunek($kolumna, $operacja, $wartosc, $typWartosci);
	}



	/**
	 * Zamienia tablice z warunkami na zapytanie SQL WHERE i zwraca jego tresc
	 * Struktura tablicy:
	 * array('and' => array('id' => 0, 'id2 >=' => 3), 'or' => array('sekcja' => 'www', 'sekcja2 <>' => 'cos')), itd.
	 * gdzie klucz tablicy - warunek (AND, OR, itd.), wartosc - tablica z polami i wartosciami.
	 *
	 * @param array $warunek Tablica zawierajaca warunek
	 * @param string $prefix Prefix dla pol
	 *
	 * @return string
	 */
	function sqlWhere($warunek, $prefix = '')
	{
		return $this->baza->sqlWhere($warunek, $prefix);
	}



	/**
	 * Pisze zapytanie SQL pobierajace nowe ID i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param string|array $warunek Warunek w postaci tablicy lub ciagu tekstowego
	 *
	 * @return string
	 */
	public function sqlId($tabela, $warunek)
	{
		return $this->baza->sqlId($tabela, $warunek);
	}



	/**
	 * Zamienia tablice z kryteriami wyszukiwania na tablice z ich odpowiednikami w zapisie sql
	 *
	 * @param array $kryteria Tablica zawierajaca kryteria
	 * @param array $polaTypy Tablica w formacie 'nazwa_pola' => 'typ_pola'
	 *
	 * @return array
	 */
	public function piszKryteria(Array &$kryteria, Array $polaTypy)
	{
		return $this->baza->piszKryteria($kryteria, $polaTypy);
	}


	/**
	 * Formatuje tekst tak aby nie powodowal problemow w zapytaniu
	 *
	 * @param string $tekst Tekst do przefiltrowania
	 *
	 * @return string
	 */
	public function formatujTekst($tekst)
	{
		return $this->baza->formatujTekst($tekst);
	}


	/**
	 * Zwraca identyfikator bazy danych
	 *
	 * @return string
	 */
	public function pobierzIdentyfikator()
	{
		return $this->baza->pobierzIdentyfikator();
}


	/**
	 * Sprawdza czy połaczenie jest aktywne
	 *
	 * @return bool
	 */
	public function czyPolaczenieAktywne()
	{
		return $this->baza->czyPolaczenieAktywne();
	}


	/**
	 * Łączy z bazą danych
	 *
	 */
	public function polaczZBaza()
	{
		$this->baza->polaczZBaza();
	}

}
