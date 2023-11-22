<?php
namespace Generic\Model\TabelaPodatkowa;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_tabela_podatkowa
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\TabelaPodatkowa\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_tabela_podatkowa';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'nr_tabeli' => 'nrTabeli',
		'rok' => 'rok',
		'kwota_od' => 'kwotaOd',
		'kwota_do' => 'kwotaDo',
		'podatek' => 'podatek',
		'rodzaj' => 'rodzaj',
	);



	/**
	* Pola tabeli bazy danych tworzące klucz główny.
	* @var array
	*/
	protected $polaTabeliKlucz = array(
		'id',
		'id_projektu',
	);



	/**
	* Zwraca ilość w tabeli modul_tabela_podatkowa.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_tabela_podatkowa.
	* @return \Generic\Model\Generic\Model\TabelaPodatkowa\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_tabela_podatkowa.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_tabela_podatkowa dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_tabela_podatkowa.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWartosc($zapytanie);
	}
	
	
	
	
	/**
	 * Zwraca wiersz podatku dla podanej kwoty przychodu brutto - jeśli $rok nie zostanie podany użyty zostanie bieżący
	 * @return int
	 */
	public function pobierzKwotePodatku($przychod, $nr_tabeli, $rok = '')
	{
		if ($rok == '')
			$rok = date('Y');
		
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' .ID_PROJEKTU. ' AND'
			. '	rok = ' . $rok . ' AND'
			. ' nr_tabeli = \'' .$nr_tabeli. '\' AND '
			. $przychod .' BETWEEN kwota_od AND (kwota_do - 1)';
		
		return $this->pobierzJeden($sql);
	}

	
	
	public function pobierzlisteTabel()
	{
		$sql = 'SELECT DISTINCT(nr_tabeli) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' .ID_PROJEKTU. ' AND'
			. '	rok = \'' . date('Y') . '\'';
		
		return $this->pobierzWiele($sql, null, null);
	}
	


	/**
	* Wykonuje wyszukiwanie według podanych kryteriów.
	* @return Array
	*/
	protected function zapytanieWyszukiwanie($kryteria)
	{
		$zapytanie = $this->przygotujZapytanieWyszukujace();

		$warunki = $this->piszKryteria($kryteria);

		$zapytanie['kryteria'] = array_merge($zapytanie['kryteria'], $warunki);

		return $zapytanie;
	}



}