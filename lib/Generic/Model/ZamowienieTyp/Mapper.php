<?php
namespace Generic\Model\ZamowienieTyp;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_zamowienia_typy
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\ZamowienieTyp\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_zamowienia_typy';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_config_template' => 'idConfigTemplate',
		'main_type' => 'mainType',
		'active' => 'active',
		'child_orders' => 'childOrders',
		'date_added' => 'dateAdded',
      'name' => 'name',
		'possible_charge_types' => 'possibleChargeTypes',
		'parent_types' => 'parentTypes',
		'required_skills' => 'requiredSkills',
		'preview_template' => 'previewTemplate',
		'order_group' => 'orderGroup',
		'is_reclamation' => 'isReclamation',
		'kolejnosc' => 'kolejnosc',
		'direct_assignment' => 'directAssignment',
		'require_appointment' =>'requireAppointment',
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
	* Zwraca ilość w tabeli modul_zamowienia_typy.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_zamowienia_typy.
	* @return \Generic\Model\ZamowieniaTypy\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;
		
		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_zamowienia_typy.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_zamowienia_typy dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .=	' AND (name ILIKE \'%'.$fraza.'%\''
					  .' OR possible_charge_types ILIKE \'%'.$fraza.'%\''
					  .' OR parent_types ILIKE \'%'.$fraza.'%\')';
		}
      if (isset($kryteria['active']))
		{
			$sql .= ' AND active = '.$this->warunekBool($kryteria['active']);
		}
      if (isset($kryteria['child_orders']))
		{
			$sql .= ' AND child_orders = '.$this->warunekBool($kryteria['child_orders']);
		}
      if (isset($kryteria['main_type']))
		{
			$sql .= ' AND main_type = '.$this->warunekBool($kryteria['main_type']);
		}
      if (isset($kryteria['possible_charge_types']) && is_array($kryteria['possible_charge_types']))
		{
			$sql .= ' AND possible_charge_types ILIKE \'%|' . implode('|', $kryteria['possible_charge_types']) . '|%\'';
		}
      if (isset($kryteria['parent_types']) && is_array($kryteria['parent_types']))
		{
			$sql .= ' AND parent_types ILIKE \'%|' . implode('|', $kryteria['parent_types']) . '|%\'';
		}
		if (isset($kryteria['wiele_id']) && $kryteria['wiele_id']!='')
		{
			$sql .= ' AND  id IN ('.$kryteria['wiele_id'].')';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_zamowienia_typy.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .=	' AND (name ILIKE \'%'.$fraza.'%\''
					  .' OR possible_charge_types ILIKE \'%'.$fraza.'%\''
					  .' OR parent_types ILIKE \'%'.$fraza.'%\')';
		}
      if (isset($kryteria['active']))
		{
			$sql .= ' AND active = '.$this->warunekBool($kryteria['active']);
		}
      if (isset($kryteria['child_orders']))
		{
			$sql .= ' AND child_orders = '.$this->warunekBool($kryteria['child_orders']);
		}
      if (isset($kryteria['main_type']))
		{
			$sql .= ' AND main_type = '.$this->warunekBool($kryteria['main_type']);
		}
      if (isset($kryteria['possible_charge_types']) && is_array($kryteria['possible_charge_types']))
		{
			$sql .= ' AND possible_charge_types ILIKE \'%|' . implode('|', $kryteria['possible_charge_types']) . '|%\'';
		}
      if (isset($kryteria['parent_types']) && is_array($kryteria['parent_types']))
		{
			$sql .= ' AND parent_types ILIKE \'%|' . implode('|', $kryteria['parent_types']) . '|%\'';
		}
		if (isset($kryteria['wiele_id']) && $kryteria['wiele_id']!='')
		{
			$sql .= ' AND  id IN ('.$kryteria['wiele_id'].')';
		}
      
		return $this->pobierzWartosc($sql);
	}
	
	
	public function pobierzDzieciDlaTypu($id, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM '. $this->tabela .' WHERE'
				.' id_projektu = '. ID_PROJEKTU
				.' AND active = true'
			   .' AND parent_types ILIKE \'%|'.$id.'|%\'';
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	 
	public function pobierzPoGrupie($grupa, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM '. $this->tabela .' WHERE'
				.' id_projektu = '. ID_PROJEKTU
				.' AND active = true';
		if (is_array($grupa) && count($grupa) > 0)
		{
			$sql .=' AND order_group IN (\''.  implode('\',\'', $grupa).'\')';
		}
		else if ($grupa != '')
		{
			$sql .=' AND order_group = \''.strval($grupa).'\'';
		}
		else
			return false;
			   
		return $this->pobierzWiele($sql, $pager, $sorter);
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