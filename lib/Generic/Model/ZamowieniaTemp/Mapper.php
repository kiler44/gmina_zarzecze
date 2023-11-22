<?php
namespace Generic\Model\ZamowieniaTemp;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_zamowienia_temp
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\ZamowieniaTemp\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_zamowienia_temp';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'number_order_get' => 'numberOrderGet',
		'note' => 'note',
		'time_spent' => 'timeSpent',
		'time_lopendetimer' => 'timeLopendetimer',
		'products' => 'products',
		'problem' => 'problem',
		'bkt_id' => 'bktId',
		'id_projektu' => 'idProjektu',
		'products_ids' => 'productsIds',
		'netto_price' => 'nettoPrice',
		'netto_price_without_lopendetimer' => 'nettoPriceWithoutLopendetimer',
		'from_address' => 'fromAddress',
		'to_address' => 'toAddress',
		'km' => 'km',
		'czas' => 'czas',
		'czas_trafic' => 'czasTrafic',
		'bez_lopende' => 'bezLopende',
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
	* Zwraca ilość w tabeli modul_zamowienia_temp.
	* @return int
	*/
	public function iloscWszystko($lopende, $idProdukt = null)
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU . ' AND from_address IS NOT NULL';
		if($lopende)
		{
			$sql .= ' AND ( bez_lopende IS NULL OR bez_lopende = FALSE )';
		}
		if($idProdukt != null && $idProdukt > 0)
		{
			$sql .= ' AND products_ids ILIKE \'%'.$idProdukt.'%\'' ;
		}

		return $this->pobierzWartosc($sql);
	}


	public function pobierzPoBktId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE bkt_id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	/**
	* Zwraca dla podanego id w tabeli modul_zamowienia_temp.
	* @return \Generic\Model\Generic\Model\ZamowieniaTemp\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_zamowienia_temp.
	* @return Array
	*/
	public function pobierzWszystko($lopende, Pager $pager = null, Sorter $sorter = null, $bezAdresu = true, $idProdukt = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela;
		if($bezAdresu)
		{
			$sql .= ' WHERE id > 0 AND from_address IS NOT NULL ';
		}
		if($lopende)
		{
			$sql .= ' AND ( bez_lopende IS NULL OR bez_lopende = FALSE )';
		}
		if($idProdukt != null && $idProdukt > 0)
		{
			$sql .= ' AND products_ids ILIKE \'%'.$idProdukt.'%\'' ;
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_zamowienia_temp dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_zamowienia_temp.
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