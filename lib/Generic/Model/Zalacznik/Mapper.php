<?php
namespace Generic\Model\Zalacznik;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_zalaczniki
*/
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Zalaczniki\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_zalaczniki';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'object' => 'object',
		'id_object' => 'idObject',
		'file' => 'file',
		'date_added' => 'dateAdded',
		'status' => 'status',
		'type' => 'type',
		'rozmiar' => 'rozmiar',
		'opis' => 'opis',
		'id_author' => 'idAuthor',
        'kod' => 'kod',
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
	* Zwraca ilość w tabeli modul_zalaczniki.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}

	public function dopasuj(string $kod, string $plik, int $idObiektu)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE kod = \'' . $kod. '\''
            . ' AND id_object ='.intval($idObiektu)
            . ' AND file = \''.$plik.'\''
            . ' AND id_projektu = ' . ID_PROJEKTU;

        return $this->pobierzJeden($sql);
    }

	/**
	* Zwraca dla podanego id w tabeli modul_zalaczniki.
	* @return \Generic\Model\Generic\Model\Zalaczniki\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	public function pobierzObiektyZalacznikow()
	{
		$sql = 'SELECT id, object, id_object FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' GROUP BY id, object, id_object';
		
		return $this->pobierzWiele($sql);
	}

	/**
	* Zwraca wszystko z tabeli modul_zalaczniki.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function pobierzDlaObjektu($objekt, $idObjektu, $status = 'active', $nazwaZalacznika = null, Array $kryteria = array())
	{
		$objekt = addslashes($objekt);
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND object = \''.$objekt.'\' '
			. ' AND status = \''.strval($status).'\' '
			. ' AND id_object = '.intval($idObjektu);
		if($nazwaZalacznika != null)
		{
			$sql .= ' AND file = \''.$nazwaZalacznika.'\' ';
		}
		if(isset($kryteria['type']) && $kryteria['type'] != '')
		{
			$fraza = addslashes(filtr_xss($kryteria['type']));
			$sql.= ' AND type = \''.$fraza.'\'';
		}
		if(isset($kryteria['id_author']) && $kryteria['id_author'] != '')
		{
			if (is_array($kryteria['id_author']))
			{
				$sql .= ' AND ( id_author IN (\''. implode('\',\'', $kryteria['id_author']) .'\' ))';
			}
			else
			{
				$sql .= ' AND ( id_author = \''. intval($kryteria['id_author']) .'\' )';
			}
		}

		return $this->pobierzWiele($sql);
		
	}

	public function liczIloscZalacznikowDlaObiektow(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) as ilosc, id_object FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		  if (isset($kryteria['wiele_id_object']) && $kryteria['wiele_id_object'] != '')
		 {
			$sql.= ' AND id_object IN (\''. implode('\',\'', $kryteria['wiele_id_object']) .'\' )';
		 }
		 if (isset($kryteria['object']) && $kryteria['object'] != '')
		 {
			$fraza = addslashes($kryteria['object']);
			$sql.= ' AND object = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['status']) && $kryteria['status'] != '')
		 {
			$fraza = addslashes($kryteria['status']);
			$sql.= ' AND status = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['type']) && $kryteria['type'] != '')
		 {
			 $fraza = addslashes(filtr_xss($kryteria['type']));
			 $sql.= ' AND type = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['id_author']) && $kryteria['id_author'] != '')
		 {
			 if (is_array($kryteria['id_author']))
			 {
				 $sql .= ' AND ( id_author IN (\''. implode('\',\'', $kryteria['id_author']) .'\' ))';
			 }
			 else
			 {
				 $sql .= ' AND ( id_author = \''. intval($kryteria['id_author']) .'\' )';
			 }
		 }
		 
		 $sql.= 'GROUP BY id_object';
		 return $this->pobierzWiele($sql);
	}
	
	/**
	* Wyszukuje w tabeli modul_zalaczniki dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		 if(isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']))
		 {
			  $sql.= ' AND id IN ('.implode(', ', $kryteria['wiele_id']).') ';
		 }
       if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
       {
          $fraza = addslashes($kryteria['fraza']);
			 (isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id'])) ? $sql.=' OR ' : $sql.=' AND ';
          $sql.= '( object ILIKE \'%'.$fraza.'%\''.
                 'OR file ILIKE \'%'.$fraza.'%\' )';
       }
		 if (isset($kryteria['object']) && $kryteria['object'] != '')
		 {
			 $fraza = addslashes($kryteria['object']);
			 $sql.= ' AND object = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['id_object']) && $kryteria['id_object'] != '')
		 {
			 $sql.= ' AND id_object = \''.intval($kryteria['id_object']).'\'';
		 }
		 if (isset($kryteria['wiele_id_object']) && $kryteria['wiele_id_object'] != '')
		 {
			$sql.= ' AND id_object IN (\''. implode('\',\'', $kryteria['wiele_id_object']) .'\' )';
		 }
		 if(isset($kryteria['status']) && $kryteria['status'] != '')
		 {
			 $fraza = addslashes($kryteria['status']);
			 $sql.= ' AND status = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['type']) && $kryteria['type'] != '')
		 {
			 $fraza = addslashes(filtr_xss($kryteria['type']));
			 $sql.= ' AND type = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['id_author']) && $kryteria['id_author'] != '')
		 {
			 if (is_array($kryteria['id_author']))
			 {
				 $sql .= ' AND ( id_author IN (\''. implode('\',\'', $kryteria['id_author']) .'\' ))';
			 }
			 else
			 {
				 $sql .= ' AND ( id_author = \''. intval($kryteria['id_author']) .'\' )';
			 }
		 }
		 if(isset($kryteria['id']) && $kryteria['id'] > 0)
       {
			 if (is_array($kryteria['id']))
			 {
				 $sql .= ' AND ( id IN (\''. implode('\',\'', $kryteria['id']) .'\' ))';
			 }
			 else
			 {
				 $sql .= ' AND ( id = \''. intval($kryteria['id']) .'\' )';
			 }
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
       if(isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']))
		 {
			  $sql.= ' AND id IN ('.implode(', ', $kryteria['wiele_id']).') ';
		 }
       if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
       {
          $fraza = addslashes($kryteria['fraza']);
			 (isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id'])) ? $sql.=' OR ' : $sql.=' AND ';
          $sql.= '( object ILIKE \'%'.$fraza.'%\''.
                 'OR file ILIKE \'%'.$fraza.'%\' )';
       }
		 if (isset($kryteria['object']) && $kryteria['object'] != '')
		 {
			 $fraza = addslashes($kryteria['object']);
			 $sql.= ' AND object = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['id_object']) && $kryteria['id_object'] != '')
		 {
			 $sql.= ' AND id_object = \''.intval($kryteria['id_object']).'\'';
		 }
		 if (isset($kryteria['wiele_id_object']) && $kryteria['wiele_id_object'] != '')
		 {
			$sql.= ' AND id_object IN (\''. implode('\',\'', $kryteria['wiele_id_object']) .'\' )';
		 }
		 if(isset($kryteria['status']) && $kryteria['status'] != '')
		 {
			 $fraza = addslashes($kryteria['status']);
			 $sql.= ' AND status = \''.$fraza.'\'';
		 }
		  if(isset($kryteria['type']) && $kryteria['type'] != '')
		 {
			 $fraza = addslashes(filtr_xss($kryteria['type']));
			 $sql.= ' AND type = \''.$fraza.'\'';
		 }
		 if(isset($kryteria['id_author']) && $kryteria['id_author'] != '')
		 {
			 if (is_array($kryteria['id_author']))
			 {
				 $sql .= ' AND ( id_author IN (\''. implode('\',\'', $kryteria['id_author']) .'\' ))';
			 }
			 else
			 {
				 $sql .= ' AND ( id_author = \''. intval($kryteria['id_author']) .'\' )';
			 }
		 }
		 if(isset($kryteria['id']) && $kryteria['id'] > 0)
       {
			 if (is_array($kryteria['id']))
			 {
				 $sql .= ' AND ( id IN (\''. implode('\',\'', $kryteria['id']) .'\' ))';
			 }
			 else
			 {
				 $sql .= ' AND ( id = \''. intval($kryteria['id']) .'\' )';
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