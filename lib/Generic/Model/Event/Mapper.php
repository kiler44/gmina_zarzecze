<?php
namespace Generic\Model\Event;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_event
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Event\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_event';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'nazwa_szablonu' => 'nazwaSzablonu',
		'konfiguracja_szablon' => 'konfiguracjaSzablon',
		'nazwa' => 'nazwa',
		'id_obiekt' => 'idObiekt',
		'obiekt' => 'obiekt',
		'wykonany' => 'wykonany'
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
	* Zwraca ilość w tabeli modul_event.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_event.
	* @return \Generic\Model\Generic\Model\Event\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_event.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
			

		return $this->pobierzWiele($sql, $pager, $sorter);
	}

	public function pobierzTypyEventow()
	{
		$sql = 'SELECT szablon FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' GROUP BY szablon';
		
		return $this->pobierzWiele($sql, null, null);
	}
	
	public function pobierzBiezaceZadania(Array $kryteria)
	{
		$sql = 'SELECT em.id_event FROM ' . $this->tabela.' e '
			. ' LEFT JOIN modul_event_metody em ON (e.id = em.id_event)'
			. ' JOIN modul_kalendarz k ON (e.id = k.id_event)'
			. ' WHERE e.id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['data_wykonania_do']) && $kryteria['data_wykonania_do'] != '')
		{
			$sql.=' AND ( em.data_wykonania IS NOT NULL AND em.data_wykonania <= \''.$kryteria['data_wykonania_do'].'\' ) ';
		}
		if(isset($kryteria['wykonane']))
		{
			if($kryteria['wykonane'])
			{
				$sql.=' AND em.wykonany = true ';
			}
			else
			{
				$sql.=' AND em.wykonany = false ';
			}
		}
		if(isset($kryteria['id_autora']) && $kryteria['id_autora'] > 0)
		{
			if(is_array($kryteria['id_autora']) && count($kryteria['id_autora']))
			{
				$sql.=' AND k.id_autora IN ('.implode(',', $kryteria['id_autora']).')';
			}
			else
			{
				$sql.=' AND k.id_autora = '.intval($kryteria['id_autora']);
			}
		}
		$sql .= ' GROUP BY em.id_event';

		return $this->pobierzWiele($sql);
	}

	/**
	* Wyszukuje w tabeli modul_event dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * '
			. ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		if (isset($kryteria['ids']) && count($kryteria['ids']) )
		{
			$sql.= ' AND id IN('.implode(',', $kryteria['ids']).') ';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_event.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT * '
			. ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		if (isset($kryteria['ids']) && count($kryteria['ids']) )
		{
			$sql.= ' AND id IN('.implode(',', $kryteria['ids']).') ';
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