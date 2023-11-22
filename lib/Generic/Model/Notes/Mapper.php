<?php
namespace Generic\Model\Notes;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_notes
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Notes\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_notes';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'object' => 'object',
		'id_object' => 'idObject',
		'description' => 'description',
		'data_added' => 'dataAdded',
		'status' => 'status',
		'author' => 'author',
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
	* Zwraca ilość w tabeli modul_notes.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_notes.
	* @return \Generic\Model\Generic\Model\Notes\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	public function pobierzOstatioDodanaNotatka($idUzytkownik, $idZamowienie)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE author = ' . intval($idUzytkownik)
			. ' AND id_object = '. intval($idZamowienie)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' ORDER BY data_added DESC'
			. ' LIMIT 1';
		
		return $this->pobierzJeden($sql);
	}
	
	/**
	 * Zwraca wszystkie typy obiektów do których przypisane są notatki
	 * 
	 */
	public function pobierzObiektyNotatek()
	{
		$sql = 'SELECT id, object, id_object FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' GROUP BY id, object, id_object';
		
		return $this->pobierzWiele($sql);
	}
			  
	/**
	* Zwraca wszystko z tabeli modul_notes.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}


	/**
	* Wyszukuje w tabeli modul_notes dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * ,'
			. ' author as id_author, '
			. ' (SELECT CONCAT (imie, \' \', nazwisko) FROM cms_uzytkownicy WHERE author = cms_uzytkownicy.id ) AS author'
			. ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$fraza = addslashes($kryteria['status']);
			$sql.= ' AND status = \''.$fraza.'\' ';
		}
		if (isset($kryteria['author']) && $kryteria['author'] != '')
		{
			$fraza = intval($kryteria['author']);
			$sql.= ' AND author  = '.$fraza;
		}
		if (isset($kryteria['object']) && $kryteria['object'] != '')
		{
			$fraza = addslashes($kryteria['object']);
			$sql.= ' AND object ILIKE \'%'.$fraza.'%\'';
		}
		if (isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']) && count($kryteria['wiele_id']) > 0)
		{
			$sql.= ' AND id IN ('.implode(', ', $kryteria['wiele_id']).') ';
			if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
			{
				$fraza = addslashes($kryteria['fraza']);
				$sql.= ' OR (description ILIKE \'%'.$fraza.'%\''.
						  'OR object ILIKE \'%'.$fraza.'%\' )';
			}
		}
		else
		{
		  if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		  {
			  $fraza = addslashes($kryteria['fraza']);
			  $sql.= ' AND (description ILIKE \'%'.$fraza.'%\''.
						'OR object ILIKE \'%'.$fraza.'%\' )';
		  }
		}
		if (isset($kryteria['wiele_idObject']) && $kryteria['wiele_idObject'] != '')
		{
			$sql.= ' AND id_object IN(\''.implode('\',\'', $kryteria['wiele_idObject']).'\') ';
		}
		if (isset($kryteria['idObject']) && $kryteria['idObject'] != '')
		{
			$fraza = intval($kryteria['idObject']);
			$sql.= ' AND id_object = '.$fraza.' ';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql.= ' AND data_added::timestamp::date = \''.$kryteria['data_dodania'].'\' ';
		}
		if(isset($kryteria['data_dodania_od']) && $kryteria['data_dodania_od'] != "")
		{
			$sql .= ' AND data_added > \''.$kryteria['data_dodania_od'].'\'';
		}
		if(isset($kryteria['data_dodania_do']) && $kryteria['data_dodania_do'] != "")
		{
			$sql .= ' AND data_added < \''.$kryteria['data_dodania_do'].'\'';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
		
	}


	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_zalaczniki.
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
		 if (isset($kryteria['object']) && $kryteria['object'] != '')
       {
          $fraza = addslashes($kryteria['object']);
          $sql.= ' AND object ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']) && count($kryteria['wiele_id']) > 0)
       {
          $sql.= ' AND id IN ('.implode(', ', $kryteria['wiele_id']).') ';
			 if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
			 {
				 $fraza = addslashes($kryteria['fraza']);
				 $sql.= ' OR (description ILIKE \'%'.$fraza.'%\''.
							'OR object ILIKE \'%'.$fraza.'%\' )';
			 }
       }
		 else
		 {
			if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
			{
				$fraza = addslashes($kryteria['fraza']);
				$sql.= ' AND (description ILIKE \'%'.$fraza.'%\''.
						 'OR object ILIKE \'%'.$fraza.'%\' )';
			}
		 }
		 if (isset($kryteria['wiele_idObject']) && $kryteria['wiele_idObject'] != '')
       {
          $sql.= ' AND id_object IN(\''.implode('\',\'', $kryteria['wiele_idObject']).'\') ';
       }
		 if (isset($kryteria['idObject']) && $kryteria['idObject'] != '')
       {
          $fraza = intval($kryteria['idObject']);
          $sql.= ' AND id_object = '.$fraza.' ';
       }
        
		 
		 return $this->pobierzWartosc($sql);
	}

}