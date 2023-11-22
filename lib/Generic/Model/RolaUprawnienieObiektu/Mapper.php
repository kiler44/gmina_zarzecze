<?php
namespace Generic\Model\RolaUprawnienieObiektu;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: RolaUprawnienieObiektu
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\RolaUprawnienieObiektu\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'cms_role_uprawnienia_obiektow';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_roli' => 'idRoli',
		'id_uprawnienia_obiektu' => 'idUprawnieniaObiektu',
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
	* Zwraca ilość w tabeli RolaUprawnienieObiektu.
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli RolaUprawnienieObiektu.
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli RolaUprawnienieObiektu.
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli RolaUprawnienieObiektu dla podanych kryteriów.
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli RolaUprawnienieObiektu.
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWartosc($zapytanie);
	}



	/**
	* Wykonuje wyszukiwanie według podanych kryteriów.
	*/
	protected function zapytanieWyszukiwanie($kryteria)
	{
		$zapytanie = $this->przygotujZapytanieWyszukujace();
		return $zapytanie;
	}



	public function pobierzDlaUprawnienia($idUprawnienia)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_uprawnienia_obiektu = ' . intval($idUprawnienia)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaRoliUprawnienia($idRoli, $idUprawnienia)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_roli = ' . intval($idRoli)
			. ' AND id_uprawnienia_obiektu = ' . intval($idUprawnienia)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



}