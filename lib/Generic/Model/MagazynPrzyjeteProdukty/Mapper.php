<?php
namespace Generic\Model\MagazynPrzyjeteProdukty;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_magazyn_przyjete_produkty
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\MagazynPrzyjeteProdukty\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_magazyn_przyjete_produkty';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_magazyn_przyja' => 'idMagazynPrzyja',
		'id_produktu' => 'idProduktu',
		'ilosc' => 'ilosc',
		'stan' => 'stan',
		'opis' => 'opis',
		'id_magazyn_wydane_produkty' => 'idMagazynWydaneProdukty',
		'produkty_grupy' => 'produktyGrupy',
		'produkt_z_grupy' => 'produktZGrupy',
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
	* Zwraca ilość w tabeli modul_magazyn_przyjete_produkty.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_magazyn_przyjete_produkty.
	* @return \Generic\Model\Generic\Model\MagazynPrzyjeteProdukty\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_magazyn_przyjete_produkty.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_magazyn_przyjete_produkty dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT mp.*, mpm.*, mp.ilosc as ilosc, mpm.ilosc as iloscMagazyn, mpm.id AS idWmagazynie, mp.id AS idWydane, mp.produkty_grupy AS produktyGrupyZamowienie, mpm.produkty_grupy as produkty_grupy '
		  . 'FROM ' . $this->tabela.' mp'
		  . ' JOIN modul_produkty_magazyn mpm ON (mp.id_produktu = mpm.id)'
		  . ' WHERE mp.id_projektu = ' . ID_PROJEKTU;
		  
		if(isset($kryteria['id_magazyn_przyja']) && $kryteria['id_magazyn_przyja'] > 0)
		{
		  $sql .= ' AND mp.id_magazyn_przyja = '. $kryteria['id_magazyn_przyja'] .'  ';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_magazyn_przyjete_produkty.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
		  . ' WHERE id_projektu = ' . ID_PROJEKTU;
		  
		if(isset($kryteria['id_magazyn_przyja']) && $kryteria['id_magazyn_przyja'] > 0)
		{
		  $sql .= ' AND id_magazyn_przyja = '. $kryteria['id_magazyn_przyja'] .'  ';
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