<?php
namespace Generic\Model\ProduktyMagazyn;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_produkty_magazyn
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\ProduktyMagazyn\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_produkty_magazyn';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kategoria' => 'kategoria',
		'kod' => 'kod',
		'nazwa_produktu' => 'nazwaProduktu',
		'ilosc' => 'ilosc',
		'ilosc_wydanych' => 'iloscWydanych',
		'wyswietlaj' => 'wyswietlaj',
		'status' => 'status',
		'zdjecie' => 'zdjecie',
		'grupa' => 'grupa',
		'produkty_grupy' => 'produktyGrupy',
		'atrybuty' => 'atrybuty',
		'id_osoby_dodajacej' => 'idOsobyDodajacej',
		'opis' => 'opis',
		'cena' => 'cena',
	);



	/**
	* Pola tabeli bazy danych tworzące klucz główny.
	* @var array
	*/
	protected $polaTabeliKlucz = array(
		'id', 'id_projektu'
	);



	/**
	* Zwraca ilość w tabeli modul_produkty_magazyn.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_produkty_magazyn.
	* @return \Generic\Model\Generic\Model\ProduktyMagazyn\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	
	/**
	* Zwraca dla podanego id w tabeli modul_produkty_magazyn.
	* @return \Generic\Model\Generic\Model\ProduktyMagazyn\Obiekt\Obiekt
	*/
	public function pobierzPoKodzie($kod)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod = \'' . addslashes(strval($kod)) . '\' '
			. ' AND id_projektu = ' . ID_PROJEKTU;
		

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_produkty_magazyn.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_produkty_magazyn dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * ,'
			. ' (SELECT nazwa FROM modul_kategorie_magazyn km WHERE km.id = kategoria ) AS kategoria_nazwa'
			. ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$fraza = addslashes($kryteria['status']);
			$sql.= ' AND status = \''.$fraza.'\' ';
		}
		if(isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql.= ' AND ( nazwa_produktu ILIKE \'%'.$fraza.'%\'';
			$sql.= ' OR kod ILIKE \'%'.$fraza.'%\' )';
		}
		if(isset($kryteria['ids']) && is_array($kryteria['ids']))
		{
			if(count($kryteria['ids']) > 1)
			{
				$sql.= ' AND id IN ('.implode(',',$kryteria['ids']).')';
			}
			else 
			{
				$sql.= ' AND id = '.$kryteria['ids'][0].' ';
			}
			
		}
		if(isset($kryteria['kategorie']))
		{
			if(is_array($kryteria['kategorie']) && count($kryteria['kategorie']))
			{
				$sql.= ' AND kategoria IN ('.implode($kryteria['kategorie'], ',').') ';
			}
			else
			{
				$sql.= ' AND kategoria = '.$kryteria['kategorie'].' ';
			}
		}
		if(isset($kryteria['!kategorie']))
		{
			$sql.= ' AND kategoria NOT IN ('.implode($kryteria['!kategorie'], ',').') ';
		}
		if(isset($kryteria['wyswietlaj']))
		{
			if($kryteria['wyswietlaj'])
			{
				$sql.= ' AND wyswietlaj = true ';
			}
			else
			{
				$sql.= ' AND wyswietlaj = false ';
			}
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_produkty_magazyn.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$fraza = addslashes($kryteria['status']);
			$sql.= ' AND status = \''.$fraza.'\' ';
		}
		if(isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql.= ' AND ( nazwa_produktu ILIKE \'%'.$fraza.'%\'';
			$sql.= ' OR kod ILIKE \'%'.$fraza.'%\' )';
		}
		if(isset($kryteria['ids']) && is_array($kryteria['ids']))
		{
			if(count($kryteria['ids']) > 1)
			{
				$sql.= ' AND id IN ('.implode(',',$kryteria['ids']).')';
			}
			else 
			{
				$sql.= ' AND id = '.$kryteria['ids'][0].' ';
			}
			
		}
		if(isset($kryteria['kategorie']))
		{
			if(is_array($kryteria['kategorie']) && count($kryteria['kategorie']))
			{
				$sql.= ' AND kategoria IN ('.implode($kryteria['kategorie'], ',').') ';
			}
			else
			{
				$sql.= ' AND kategoria = '.$kryteria['kategorie'].' ';
			}
		}
		if(isset($kryteria['!kategorie']))
		{
			$sql.= ' AND kategoria NOT IN ('.implode($kryteria['!kategorie'], ',').') ';
		}
		if(isset($kryteria['wyswietlaj']))
		{
			if($kryteria['wyswietlaj'])
			{
				$sql.= ' AND wyswietlaj = true ';
			}
			else
			{
				$sql.= ' AND wyswietlaj = false ';
			}
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