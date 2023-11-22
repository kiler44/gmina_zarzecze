<?php
namespace Generic\Model\MagazynWydaneProdukty;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_magazyn_wydane_produkty
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\MagazynWydaneProdukty\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_magazyn_wydane_produkty';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_zamowienia' => 'idZamowienia',
		'id_produktu' => 'idProduktu',
		'ilosc' => 'ilosc',
		'zwrot' => 'zwrot',
		'grupa' => 'grupa',
		'produkty_grupy' => 'produktyGrupy',
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
	* Zwraca ilość w tabeli modul_magazyn_wydane_produkty.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_magazyn_wydane_produkty.
	* @return \Generic\Model\Generic\Model\MagazynWydaneProdukty\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_magazyn_wydane_produkty.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}

	public function sprawdzCzyProduktWydany($idProduktu)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND id_produktu = '.intval($idProduktu)
			. ' AND ilosc > zwrot';
		

		return $this->pobierzWartosc($sql);
	}

	/**
	* Wyszukuje w tabeli modul_magazyn_wydane_produkty dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT mwp.*, mpm.*, mwp.ilosc as ilosc, mpm.ilosc as iloscMagazyn, mpm.id AS idWmagazynie, mwp.id AS idWydane, mwp.produkty_grupy AS produktyGrupyZamowienie '
		  . 'FROM ' . $this->tabela.' mwp'
		  . ' JOIN modul_produkty_magazyn mpm ON (mwp.id_produktu = mpm.id)'
		  . ' WHERE mwp.id_projektu = ' . ID_PROJEKTU;
		  
		if(isset($kryteria['id_zamowienia']) && $kryteria['id_zamowienia'] > 0)
		{
		  $sql .= ' AND mwp.id_zamowienia = '. $kryteria['id_zamowienia'] .'  ';
		}
		if(isset($kryteria['wiele_id']) && count($kryteria['wiele_id']) )
		{
			$sql .= ' AND mwp.id IN ('.implode(',', $kryteria['wiele_id']).')';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_magazyn_wydane_produkty.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		  . ' WHERE id_projektu = ' . ID_PROJEKTU;

		if(isset($kryteria['id_zamowienia']) && $kryteria['id_zamowienia'] > 0)
		{
		  $sql .= ' AND id_zamowienia = '. $kryteria['id_zamowienia'] .'  ';
		}
		if(isset($kryteria['wiele_id']) && count($kryteria['wiele_id']) )
		{
			$sql .= ' AND mwp.id IN ('.implode(',', $kryteria['wiele_id']).')';
		}
		
		return $this->pobierzWartosc($sql);
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