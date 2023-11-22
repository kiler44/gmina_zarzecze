<?php
namespace Generic\Model\{{NAZWA}};

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: {{NAZWA_TABELI_W_BAZIE}}
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = '{{ZWRACANY_OBIEKT}}';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = '{{NAZWA_TABELI_W_BAZIE}}';{{KOMENTARZ_TABELI}}



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
{{BEGIN POLA_TABELI_OBIEKT}}
		'{{TABELA_KOLUMNA}}' => '{{OBIEKT_POLE}}',
{{END}}
	);



	/**
	* Pola tabeli bazy danych tworzące klucz główny.
	* @var array
	*/
	protected $polaTabeliKlucz = array(
{{BEGIN POLA_TABELI_KLUCZ}}
		{{KOMENTARZ1}}'{{POLE_BEDACE_CZESCIA_KLUCZA}}',{{KOMENTARZ2}}
{{END}}
	);



	/**
	* Zwraca ilość w tabeli {{NAZWA_TABELI_W_BAZIE}}.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli {{NAZWA_TABELI_W_BAZIE}}.
	* @return \Generic\Model\{{ZWRACANY_OBIEKT}}\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli {{NAZWA_TABELI_W_BAZIE}}.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli {{NAZWA_TABELI_W_BAZIE}} dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli {{NAZWA_TABELI_W_BAZIE}}.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWartosc($zapytanie);
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