<?php
namespace Generic\Model\Polaczenia;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_polaczenia
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Polaczenia\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_polaczenia';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_object_1' => 'idObject_1',
		'id_object_2' => 'idObject_2',
		'typ_object_1' => 'typObject_1',
		'typ_object_2' => 'typObject_2',
		'data_dodania' => 'dataDodania',
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
	* Zwraca ilość w tabeli modul_polaczenia.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_polaczenia.
	* @return \Generic\Model\Generic\Model\Polaczenia\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	public function pobierzPolaczone($idObject1, $idObject2, $typObject1, $typObject2)
	{
		
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_object_1 = ' . intval($idObject1)
			. ' AND id_object_2 = ' .  intval($idObject2)
			. ' AND typ_object_1 = ' . addslashes($typObject1)
			. ' AND typ_object_2 = ' . addslashes($typObject2)
			. ' AND id_projektu = ' . ID_PROJEKTU;
		
		return $this->pobierzWiele($sql);
		
	}


	/**
	* Zwraca wszystko z tabeli modul_polaczenia.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_polaczenia dla podanych kryteriów.
	* @return Array
	*/
	public function szukajZamowienia(Array $kryteria, Array $kryteriaZamowien, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela . ' as p'
			. ' JOIN modul_zamowienia mz ON id_object_1 = mz.id'
			. ' WHERE p.id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['obiekt_1']) && $kryteria['obiekt_1'] != '')
		{
			if (is_array($kryteria['obiekt_1']) && count($kryteria['obiekt_1']) > 0)
			{
				$sql .= ' AND id_object_1 IN (' . implode(',', $kryteria['obiekt_1']).')';
			}
			else
			{
				$sql .= ' AND id_object_1 = ' . intval($kryteria['obiekt_1']);
			}
		}
		if(isset($kryteria['obiekt_2']) && $kryteria['obiekt_2'] != '')
		{
			if (is_array($kryteria['obiekt_2']) && count($kryteria['obiekt_2']) > 0)
			{
				$sql .= ' AND id_object_2 IN (' . implode(',', $kryteria['obiekt_2']).')';
			}
			else
			{
				$sql .= ' AND id_object_2 = ' . intval($kryteria['obiekt_2']);
			}
		}
		if(isset($kryteria['typ_obiekt_1']) && $kryteria['typ_obiekt_1'] != '')
		{
			$sql .= ' AND typ_object_1 = \'' . addslashes($kryteria['typ_obiekt_1']).'\'';
		}
		if(isset($kryteria['typ_obiekt_2']) && $kryteria['typ_obiekt_2'] != '')
		{
			$sql .= ' AND typ_object_2 = \'' . addslashes($kryteria['typ_obiekt_2']).'\'';
		}
		if (isset($kryteriaZamowien['status']) && $kryteriaZamowien['status'] != '')
		{
			if (is_array($kryteriaZamowien['status']) && count($kryteriaZamowien['status']) > 0)
			{
				$sql .= ' AND mz.status IN(\''.implode('\',\'', $kryteriaZamowien['status']).'\') ';
			}
			else
			{
				$sql .= ' AND mz.status = \''.$kryteriaZamowien['status'].'\'';
			}
		}
		if (isset($kryteriaZamowien['status_work']) && $kryteriaZamowien['status_work'] != '')
		{
			if (is_array($kryteriaZamowien['status_work']))
			{
				$sql .= ' AND mz.status_work IN(\''.implode('\',\'', $kryteriaZamowien['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND mz.status_work = \''.$kryteriaZamowien['status_work'].'\'';
			}
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	/**
	* Wyszukuje w tabeli modul_polaczenia dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['obiekt_1']) && $kryteria['obiekt_1'] != '')
		{
			if (is_array($kryteria['obiekt_1']) && count($kryteria['obiekt_1']) > 0)
			{
				$sql .= ' AND id_object_1 IN (' . implode(',', $kryteria['obiekt_1']).')';
			}
			else
			{
				$sql .= ' AND id_object_1 = ' . intval($kryteria['obiekt_1']);
			}
		}
		if(isset($kryteria['obiekt_2']) && $kryteria['obiekt_2'] != '')
		{
			if (is_array($kryteria['obiekt_2']) && count($kryteria['obiekt_2']) > 0)
			{
				$sql .= ' AND id_object_2 IN (' . implode(',', $kryteria['obiekt_2']).')';
			}
			else
			{
				$sql .= ' AND id_object_2 = ' . intval($kryteria['obiekt_2']);
			}
		}
		if(isset($kryteria['typ_obiekt_1']) && $kryteria['typ_obiekt_1'] != '')
		{
			$sql .= ' AND typ_object_1 = \'' . addslashes($kryteria['typ_obiekt_1']).'\'';
		}
		if(isset($kryteria['typ_obiekt_2']) && $kryteria['typ_obiekt_2'] != '')
		{
			$sql .= ' AND typ_object_2 = \'' . addslashes($kryteria['typ_obiekt_2']).'\'';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_polaczenia.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['obiekt_1']) && $kryteria['obiekt_1'] != '')
		{
			$sql .= ' AND id_object_1 = ' . intval($kryteria['obiekt_1']);
		}
		if(isset($kryteria['obiekt_2']) && $kryteria['obiekt_2'] != '')
		{
			$sql .= ' AND id_object_2 = ' . intval($kryteria['obiekt_2']);
		}
		if(isset($kryteria['typ_obiekt_1']) && $kryteria['typ_obiekt_1'] != '')
		{
			$sql .= ' AND typ_object_1 = ' . addslashes($kryteria['typ_obiekt_1']);
		}
		if(isset($kryteria['typ_obiekt_2']) && $kryteria['typ_obiekt_2'] != '')
		{
			$sql .= ' AND typ_object_2 = ' . addslashes($kryteria['typ_obiekt_2']);
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