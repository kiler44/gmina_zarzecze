<?php
namespace Generic\Model\RoleUprawnieniaEvents;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: cms_role_uprawnienia_events
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\RoleUprawnieniaEvents\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'cms_role_uprawnienia_events';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_roli' => 'idRoli',
		'szablon_eventu' => 'szablonEventu',
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
	* Zwraca ilość w tabeli cms_role_uprawnienia_events.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli cms_role_uprawnienia_events.
	* @return \Generic\Model\Generic\Model\RoleUprawnieniaEvents\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli cms_role_uprawnienia_events.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}

	public function pobierzDlaRoli($idRoli)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND id_roli = '.intval($idRoli);

		return $this->pobierzWiele($sql);
	}
	
	public function pobierzDlaUzytkownika($idUzytkownik)
	{
		$sql = 'SELECT * FROM ' . $this->tabela .' rue '
			. ' JOIN cms_uzytkownicy_role cur ON(rue.id_roli = cur.id_roli)'
			. ' WHERE rue.id_projektu = ' . ID_PROJEKTU
			. ' AND cur.id_uzytkownika = '.intval($idUzytkownik);
		
		return $this->pobierzWiele($sql);
	}
	
	public function pobierzPoRolaEvent($idRoli, $nazwaSzablonu)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND id_roli = '.intval($idRoli)
			. ' AND szablon_eventu = \''.addslashes($nazwaSzablonu).'\' ';
		
		return $this->pobierzJeden($sql);
	}

	/**
	* Wyszukuje w tabeli cms_role_uprawnienia_events dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli cms_role_uprawnienia_events.
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