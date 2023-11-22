<?php
namespace Generic\Model\RaportyNadgodziny;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_raporty_nadgodziny
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\RaportyNadgodziny\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_raporty_nadgodziny';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_user' => 'idUser',
		'id_team' => 'idTeam',
		'data' => 'data',
		'godziny' => 'godziny',
		'nadgodziny' => 'nadgodziny',
		'pauza' => 'pauza',
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
	* Zwraca ilość w tabeli modul_raporty_nadgodziny.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_raporty_nadgodziny.
	* @return \Generic\Model\Generic\Model\RaportyNadgodziny\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_raporty_nadgodziny.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_raporty_nadgodziny dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM '.$this->tabela.' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['id']) && $kryteria['id'] != '' && !empty($kryteria['id']))
		{
			if (is_array($kryteria['id']))
			{
				$sql .= ' AND id IN (' . implode(',', $kryteria['id']) .')';
			}
			else
			{
				$sql .= ' AND id = '.intval($kryteria['pracownik']);
			}
		}
		if(isset($kryteria['id_user']) && $kryteria['id_user'] != '' && !empty($kryteria['id_user']))
		{
			if (is_array($kryteria['id_user']))
			{
				$sql .= ' AND id_user IN (' . implode(',', $kryteria['id_user']) .')';
			}
			else
			{
				$sql .= ' AND id_user = '.intval($kryteria['id_user']);
			}
		}
		if(isset($kryteria['data']) && $kryteria['data'] != '')
		{
			$sql .= ' AND data = \''.$kryteria['data'].'\'';
		}
		if(isset($kryteria['daty']) && is_array($kryteria['daty']))
		{
			if (!empty($kryteria['daty']))
			{
				$sql .= ' AND data IN(\''.implode('\',\'', $kryteria['daty']).'\')'; 
			}
		}
		if(isset($kryteria['data_od']) && $kryteria['data_od'] != '')
		{
			$sql .= ' AND data >= \''.$kryteria['data_od'].'\'';
		}
		if(isset($kryteria['data_do']) && $kryteria['data_do'] != '')
		{
			$sql .= ' AND data <= \''.$kryteria['data_do'].'\'';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_raporty_nadgodziny.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT * FROM '.$this->tabela.' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['id']) && $kryteria['id'] != '')
		{
			if (is_array($kryteria['id']))
			{
				$sql .= ' AND id IN (' . implode(',', $kryteria['id']) .')';
			}
			else
			{
				$sql .= ' AND id = '.intval($kryteria['pracownik']);
			}
		}
		if(isset($kryteria['id_user']) && $kryteria['id_user'] != '')
		{
			if (is_array($kryteria['id_user']))
			{
				$sql .= ' AND id_user IN (' . implode(',', $kryteria['id_user']) .')';
			}
			else
			{
				$sql .= ' AND id_user = '.intval($kryteria['id_user']);
			}
		}
		if(isset($kryteria['data']) && $kryteria['data'] != '')
		{
			$sql .= ' AND data = \''.$kryteria['data'].'\'';
		}
		if(isset($kryteria['daty']) && is_array($kryteria['daty']))
		{
			if (!empty($kryteria['daty']))
			{
				$sql .= ' AND data IN(\''.implode('\',\'', $kryteria['daty']).'\')'; 
			}
		}
		if(isset($kryteria['data_od']) && $kryteria['data_od'] != '')
		{
			$sql .= ' AND data >= \''.$kryteria['data_od'].'\'';
		}
		if(isset($kryteria['data_do']) && $kryteria['data_do'] != '')
		{
			$sql .= ' AND data <= \''.$kryteria['data_do'].'\'';
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