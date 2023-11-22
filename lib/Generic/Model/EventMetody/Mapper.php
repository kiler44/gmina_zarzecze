<?php
namespace Generic\Model\EventMetody;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_event_metody
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\EventMetody\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_event_metody';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_event' => 'idEvent',
		'akcja' => 'akcja',
		'opis' => 'opis',
		'data_wykonania' => 'dataWykonania',
		'dane_wejsciowe' => 'daneWejsciowe',
		'dane_wyjsciowe' => 'daneWyjsciowe',
		'id_wymagane' => 'idWymagane',
		'konfiguracja_szablon' => 'konfiguracjaSzablon',
		'konfiguracja' => 'konfiguracja',
		'kod' => 'kod',
		'szablon' => 'szablon',
		'wykonany' => 'wykonany',
		'errors' => 'errors',
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
	* Zwraca ilość w tabeli modul_event_metody.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_event_metody.
	* @return \Generic\Model\Generic\Model\EventMetody\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_event_metody.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function szukajPolaczZKalendarzem(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT DISTINCT(mk.id_event), mk.tytul, mem.data_wykonania, mem.opis, mk.opcje_dodatkowe FROM ' . $this->tabela . ' mem'
			. ' JOIN modul_kalendarz mk ON (mem.id_event = mk.id_event)'
			. ' WHERE mem.id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['data_wykonania_do']) && $kryteria['data_wykonania_do'] != '')
		{
			$sql.=' AND mem.data_wykonania <= \''.$kryteria['data_wykonania_do'].'\' ';
		}
		if(isset($kryteria['wykonane']))
		{
			if($kryteria['wykonane'])
			{
				$sql.=' AND mem.wykonany = true ';
			}
			else
			{
				$sql.=' AND mem.wykonany = false ';
			}
		}
		
		return $this->zwracaTablice()->pobierzWiele($sql, $pager, $sorter);
	}

	/**
	* Wyszukuje w tabeli modul_event_metody dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['data_wykonania']) && $kryteria['data_wykonania'] != '' )
		{
			$sql.=' AND data_wykonania = \''.$kryteria['data_wykonania'].'\'';
		}
		if(isset($kryteria['data_wykonania_do']) && $kryteria['data_wykonania_do'] != '')
		{
			$sql.=' AND data_wykonania <= \''.$kryteria['data_wykonania_do'].'\' ';
		}
		if(isset($kryteria['wykonane']))
		{
			if($kryteria['wykonane'])
			{
				$sql.=' AND wykonany = true ';
			}
			else
			{
				$sql.=' AND wykonany = false ';
			}
		}
		if(isset($kryteria['id_event']) && $kryteria['id_event'] > 0 )
		{
			$sql.=' AND id_event = '.$kryteria['id_event'];
		}
		if(isset($kryteria['akcja']) && $kryteria['akcja'] != '' )
		{
			$sql.=' AND akcja = \''.$kryteria['akcja'].'\'';
		}
		if(isset($kryteria['kod']) && $kryteria['kod'] != '')
		{
			$sql.=' AND kod = '.$kryteria['kod'];
		}
		if(isset($kryteria['id_wymagane']) && $kryteria['id_wymagane'] != '')
		{
			$sql.=' AND id_wymagane ILIKE \'%|'.$kryteria['id_wymagane'].'|%\' ';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_event_metody.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['data_wykonania']) && $kryteria['data_wykonania'] != '' )
		{
			$sql.=' AND data_wykonania = \''.$kryteria['data_wykonania'].'\'';
		}
		if(isset($kryteria['id_event']) && $kryteria['id_event'] > 0 )
		{
			$sql.=' AND id_event = '.$kryteria['id_event'];
		}
		if(isset($kryteria['akcja']) && $kryteria['akcja'] != '' )
		{
			$sql.=' AND akcja = \''.$kryteria['akcja'].'\'';
		}
		if(isset($kryteria['kod']) && $kryteria['kod'] > 0 )
		{
			$sql.=' AND kod = '.$kryteria['kod'];
		}
		if(isset($kryteria['id_wymagane']) && $kryteria['id_wymagane'] != '')
		{
			$sql.=' AND id_wymagane ILIKE \'%|'.$kryteria['id_wymagane'].'|%\' ';
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