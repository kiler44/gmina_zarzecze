<?php
namespace Generic\Model\RaportyExcelDane;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_raporty_excel_dane
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\RaportyExcelDane\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_raporty_excel_dane';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_order' => 'idOrder',
		'id_team' => 'idTeam',
		'data' => 'data',
		'from_address' => 'fromAddress',
		'to_address' => 'toAddress',
		'kilometry' => 'kilometry',
		'minuty_jazdy' => 'minutyJazdy',
		'minuty_jazdy_traffik' => 'minutyJazdyTraffik',
		'day_of_simulation' => 'dayOfSimulation',
		'hour_of_simulation' => 'hourOfSimulation'
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
	* Zwraca ilość w tabeli modul_raporty_excel_dane.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_raporty_excel_dane.
	* @return \Generic\Model\Generic\Model\RaportyExcelDane\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	/**
	* Zwraca dla podanego id w tabeli modul_raporty_excel_dane.
	* @return \Generic\Model\Generic\Model\RaportyExcelDane\Obiekt\Obiekt
	*/
	public function pobierzPoIdOrder($bktId)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_order = ' . intval($bktId)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_raporty_excel_dane.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_raporty_excel_dane dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if (isset($kryteria['id_order']) && $kryteria['id_order'] != '')
		{
			if (is_array($kryteria['id_order']) && !empty($kryteria['id_order']))
				$sql .= ' AND id_order IN(\''.implode('\',\'', $kryteria['id_order']).'\')';
			else
				$sql .= ' AND id_order = \''.$kryteria['id_order'].'\'';
		}
		
		if(isset($kryteria['data_od']) && $kryteria['data_od'] != '')
		{
			$sql .= ' AND to_char(data, \'YYYY-MM-DD\')::timestamp <= \''.$kryteria['data_od'].'\'';
		}
		if(isset($kryteria['data_do']) && $kryteria['data_do'] != '')
		{
			$sql .= ' AND to_char(data, \'YYYY-MM-DD\')::timestamp <= \''.$kryteria['data_do'].'\'';
		}
		if(isset($kryteria['daty']) && !empty($kryteria['daty']))
		{
			if (is_array($kryteria['daty']))
			{
				$sql .= ' AND data IN(\''.implode('\',\'', $kryteria['daty']).'\')';
			}
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_raporty_excel_dane.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWartosc($zapytanie);
	}
	
	
	public function pobierzPracownikowDnia($data_od, $data_do)
	{
		$sql = 'SELECT mz.date_start, mte.id AS id_team, mte.team_number, (SELECT cu.id AS id_user FROM cms_uzytkownicy cu WHERE cu.id = mt.id_user),(SELECT CONCAT(  cu.imie, \' \' , cu.nazwisko) AS pracownik 
			FROM cms_uzytkownicy cu WHERE cu.id = mt.id_user )  FROM modul_timelist mt JOIN modul_zamowienia mz ON (mt.id_object = mz.id) JOIN modul_team mte ON (mt.id_team = mte.id) 
			WHERE mz.id_type = 1 AND mz.date_start >= \''.$data_od.'\' AND mz.date_start <= \''.$data_do.'\'
			GROUP BY mz.date_start, mte.team_number, mt.id_user, mte.id ORDER BY mz.date_start ASC
		';
		
		return $this->pobierzWiele($sql);
	}
	
	public function pobierzPracownikowDniaZakonczoneOrdery($data_od, $data_do)
	{
		$sql = 'SELECT mz.data_zakonczenia, mte.id AS id_team, mte.team_number, (SELECT cu.id AS id_user FROM cms_uzytkownicy cu WHERE cu.id = mt.id_user),(SELECT CONCAT(  cu.imie, \' \' , cu.nazwisko) AS pracownik 
			FROM cms_uzytkownicy cu WHERE cu.id = mt.id_user )  FROM modul_timelist mt JOIN modul_zamowienia mz ON (mt.id_object = mz.id) JOIN modul_team mte ON (mt.id_team = mte.id) 
			WHERE mz.id_type = 1 AND mz.data_zakonczenia >= \''.$data_od.'\' AND mz.data_zakonczenia <= \''.$data_do.'\'
			GROUP BY mz.data_zakonczenia, mte.team_number, mt.id_user, mte.id ORDER BY mz.data_zakonczenia ASC
		';
		
		return $this->pobierzWiele($sql);
	}
	
	public function pobierzPracownikowDniaDatyTablica(Array $daty)
	{
		$sql = 'SELECT mz.date_start, mte.id AS id_team, mte.team_number, (SELECT cu.id AS id_user FROM cms_uzytkownicy cu WHERE cu.id = mt.id_user),(SELECT CONCAT(  cu.imie, \' \' , cu.nazwisko) AS pracownik 
			FROM cms_uzytkownicy cu WHERE cu.id = mt.id_user )  FROM modul_timelist mt JOIN modul_zamowienia mz ON (mt.id_object = mz.id) JOIN modul_team mte ON (mt.id_team = mte.id) 
			WHERE mz.id_type = 1 AND mz.date_start IN(\''.implode('\',\'', $daty).'\')
			GROUP BY mz.date_start, mte.team_number, mt.id_user, mte.id ORDER BY mz.date_start ASC
		';
		
		return $this->pobierzWiele($sql);
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