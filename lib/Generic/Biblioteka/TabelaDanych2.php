<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TabelaDanych;

/**
 * Klasa generuje widok tabeli danych (data grid)
 *
 * @author Krzysztof Lesiczka, Konrad Rudowski
 * @package biblioteki
 */

class TabelaDanych2 implements Tlumaczenia\Interfejs
{

	/**
	 * Zmienne opisujące kolumny tabeli danych
	 */

	protected $kolumny = array();
	protected $kolumnyDeklaracje = array();
	protected $kolumnyNazwyZabronione = array(
		'_przyciski_usun_'
	);


	/**
	 * Przetrzymuje wiersze dodane do tabeli
	 *
	 * @var array
	 */
	protected $wiersze = array();


	protected $tlumaczenia = array(
		'etykieta_brak_wierszy' => 'Brak informacji do wyświetlenia',
	);



	/**
	 * Ustawia dane poczatkowe dla tabela danych.
	 */
	function __construct()
	{
		$this->ustawTlumaczenia(Cms::inst()->lang['tabela_danych']);
	}

	/**
	 * Dodaje kolumne do tabeli
	 *
	 * @param string $nazwa Nazwa kolumny.
	 * @param string $etykieta Widoczna nazwa kolumny.
	 */
	public function dodajKolumne($nazwa, $etykieta = '')
	{
		$this->wstawKolumne($nazwa, array(
				'nazwa' => $nazwa,
				'etykieta' => ($etykieta == '' && isset($this->tlumaczenia['etykieta_' . $nazwa])) ? $this->tlumaczenia['etykieta_' . $nazwa] : $etykieta
			));
	}


	/**
	 * Wstawia definicję kolumny tabeli
	 *
	 * @param string $nazwa Nazwa kolumny.
	 * @param Array $kolumna Definicja kolumny
	 */
	protected function wstawKolumne($nazwa, Array $kolumna)
	{
		if (in_array($nazwa, $this->kolumny))
		{
			throw new TabelaDanych\Wyjatek('Kolumna o nazwie '.$nazwa.' zostala juz zadeklarowana', E_USER_NOTICE);
		}
		if (in_array($nazwa, $this->kolumnyNazwyZabronione))
		{
			throw new TabelaDanych\Wyjatek('Nie mozna zdefiniowac kolumny o podanej nazwie.', E_USER_NOTICE);
		}
		else
		{
			$this->kolumny[] = $nazwa;
			$this->kolumnyDeklaracje[] = $kolumna;
		}
	}


	/**
	 * Dodaje wiersz z danymi do tablicy.
	 *
	 * @param array $dane Dane do wstawienia
	 */
	public function dodajWiersz(Array $dane)
	{
		$this->wstawWiersz($dane);
	}


	/**
	 * Wstawia wiersz z danymi do tablicy.
	 *
	 * @param array $dane Dane do wstawienia
	 */
	protected function wstawWiersz(Array $dane)
	{
		foreach ($this->kolumny as $kolumna)
		{
			if (!array_key_exists($kolumna, $dane))
			{
				throw new TabelaDanych\Wyjatek('Brak wartosci dla kolumny '.$kolumna.' w przekazanych danych', E_USER_NOTICE);
			}
		}

		$this->wiersze[] = $dane;
	}


	/**
	 * Pobiera tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->tlumaczenia;
	}



	/**
	 * Ustawia nowe tlumaczenia.
	 *
	 * @param array $tlumaczenia Tablica z nowymi tlumaczeniami.
	 *
	 * @return boolean
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		if (is_array($tlumaczenia) && $this->tlumaczenia = array_merge($this->tlumaczenia, $tlumaczenia))
		{
			return true;
		}
		return false;
	}


	/**
	 * Pobiera liczbę ustawionych kolumn.
	 *
	 * @return int
	 */
	public function pobierzIloscKolumn()
	{
		return count($this->kolumny);
	}
}
