<?php
namespace Generic\Model\UprawnienieObiektu;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: UprawnienieObiektu
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\UprawnienieObiektu\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'cms_uprawnienia_obiektow';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_obiektu' => 'kodObiektu',
		'pole' => 'pole',
		'hash' => 'hash',
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
	* Zwraca ilość w tabeli UprawnienieObiektu.
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli UprawnienieObiektu.
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli UprawnienieObiektu.
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli UprawnienieObiektu dla podanych kryteriów.
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli UprawnienieObiektu.
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

	public function pobierzDlaRoli($idRoli)
	{
		$sql = 'SELECT ua.* FROM cms_role AS r'
			. ' JOIN cms_role_uprawnienia_obiektow AS rua'
			. ' ON (r.id = ' . intval($idRoli)
			. ' AND r.id_projektu = ' . ID_PROJEKTU
			. ' AND r.id = rua.id_roli '
			. ' AND r.id_projektu = rua.id_projektu)'
			. ' JOIN ' . $this->tabela . ' AS ua'
			. ' ON (ua.id_projektu = ' . ID_PROJEKTU
			. ' AND ua.id = rua.id_uprawnienia_obiektu'
			. ' AND ua.id_projektu = rua.id_projektu)';

		return $this->pobierzWiele($sql);
	}

	public function pobierzPoKodzie($kod)
	{
		$kod = explode('_', $kod);

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod_obiektu = \'' . $kod[0] .'\''
			. ' AND pole = \'' . $kod[1] .'\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzPoHashu($kod)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE hash = \'' . $kod .'\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzDlaUzytkownika($idUzytkownika)
	{
		$sql = 'SELECT ua.* FROM cms_uzytkownicy_role AS ur'
			. ' JOIN cms_role_uprawnienia_obiektow AS rua'
			. ' ON (ur.id_uzytkownika = ' . intval($idUzytkownika)
			. ' AND ur.id_projektu = ' . ID_PROJEKTU
			. ' AND ur.id_roli = rua.id_roli'
			. ' AND ur.id_projektu = rua.id_projektu)'
			. ' JOIN ' . $this->tabela . ' AS ua'
			. ' ON (ua.id_projektu = ' . ID_PROJEKTU
			. ' AND ua.id = rua.id_uprawnienia_obiektu'
			. ' AND ua.id_projektu = rua.id_projektu)';

		return $this->pobierzWiele($sql);
	}



}