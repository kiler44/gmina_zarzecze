<?php
namespace Generic\Model\MagazynWydane;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_magazyn_wydane
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\MagazynWydane\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_magazyn_wydane';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_odbiorcy' => 'idOdbiorcy',
		'obiekt_odbiorcy' => 'obiektOdbiorcy',
		'status' => 'status',
		'podpis' => 'podpis',
		'typ_podpisu' => 'typPodpisu',
		'id_osoby_akceptujacej' => 'idOsobyAkceptujacej',
		'id_osoby_wydajacej' => 'idOsobyWydajacej',
		'data_dodania' => 'dataDodania',
		'data_wydania' => 'dataWydania',
		'opis' => 'opis',
		'podpis_vector' => 'podpisVector',
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
	* Zwraca ilość w tabeli modul_magazyn_wydane.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_magazyn_wydane.
	* @return \Generic\Model\Generic\Model\MagazynWydane\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	public function pobierzPoIdUzytkownikaIIdProduktu()
	{
		$sql = 'SELECT pm.*, mwp.*, mw.*, mwp.ilosc as ilosc_uzytkownik FROM ' . $this->tabela . ' mw'
		  . ' JOIN modul_magazyn_wydane_produkty mwp ON (mw.id = mwp.id_zamowienia)'
		  . ' JOIN modul_produkty_magazyn pm ON (pm.id = mwp.id_produktu)'
		  . ' WHERE mw.id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['idProduktu']) && $kryteria['idProduktu'] > 0)
		{
			$sql .= ' AND mwp.id_produktu = '. $kryteria['idProduktu'];
		}
		if(isset($kryteria['odbiorcaUzytkownik']) && $kryteria['odbiorcaUzytkownik'] > 0)
		{
			$sql .= ' AND ( mw.obiekt_odbiorcy = \'Uzytkownik\' AND mw.id_odbiorcy = '.$kryteria['odbiorcaUzytkownik'].') ';
		}
		return $this->zwracaTablice()->pobierzWiele($sql);
	}

		/**
	* Zwraca wszystko z tabeli modul_magazyn_wydane.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}

	public function szukajZProduktami(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT pm.*, mwp.*, mw.*, mwp.ilosc as ilosc_uzytkownik, mwp.id as produkt_wydany_id FROM ' . $this->tabela . ' mw'
		  . ' JOIN modul_magazyn_wydane_produkty mwp ON (mw.id = mwp.id_zamowienia)'
		  . ' JOIN modul_produkty_magazyn pm ON (pm.id = mwp.id_produktu)'
		  . ' WHERE mw.id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['status']))
		{
			if(is_array($kryteria['status']) && count($kryteria['status']))
			{
				$sql .= ' AND mw.status IN (\''. implode('\',\'', $kryteria['typ']) .'\' )';
			}
			elseif($kryteria['status'] !='')
			{
				$fraza = addslashes($kryteria['status']);
				$sql .= ' AND mw.status = \''. $fraza .'\' ';
			}
		}
		if(isset($kryteria['idProduktu']) && $kryteria['idProduktu'] > 0)
		{
			$sql .= ' AND mwp.id_produktu = '. $kryteria['idProduktu'];
		}
		if(isset($kryteria['odbiorcaUzytkownik']) && $kryteria['odbiorcaUzytkownik'] > 0)
		{
			$sql .= ' AND ( mw.obiekt_odbiorcy = \'Uzytkownik\' AND mw.id_odbiorcy = '.$kryteria['odbiorcaUzytkownik'].') ';
		}
		if(isset($kryteria['odbiorcaTeam']) && $kryteria['odbiorcaTeam'] > 0)
		{
			$sql .= ' AND ( mw.obiekt_odbiorcy = \'Team\' AND mw.id_odbiorcy = '.$kryteria['odbiorcaTeam'].') ';
		}
		if(isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$sql .= ' AND mw.id = '. intval($kryteria['fraza']) .' ';
			$sql .= ' AND mw.opis = \''. addslashes($kryteria['fraza']) .'\' ';
		}
		if(isset($kryteria['grupa']))
		{
			if($kryteria['grupa'])
			{
				$sql .= ' AND mw.grupa = TRUE ';
			}
			else
			{
				$sql .= ' AND mw.grupa = FALSE ';
			}
		}
		if(isset($kryteria['zwrocone']))
		{
			if($kryteria['zwrocone'])
			{
				$sql .= ' AND mwp.ilosc = mwp.zwrot ';
			}
			else
			{
				$sql .= ' AND mwp.ilosc > mwp.zwrot  ';
			}
		}
		
		return $this->zwracaTablice()->pobierzWiele($sql, $pager, $sorter);
	}

	/**
	* Wyszukuje w tabeli modul_magazyn_wydane dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		  . ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['status']))
		{
			if(is_array($kryteria['status']) && count($kryteria['status']))
			{
				$sql .= ' AND status IN (\''. implode('\',\'', $kryteria['typ']) .'\' )';
			}
			elseif($kryteria['status'] !='')
			{
				$fraza = addslashes($kryteria['status']);
				$sql .= ' AND status = \''. $fraza .'\' ';
			}
		}
		if(isset($kryteria['odbiorcaUzytkownik']) && $kryteria['odbiorcaUzytkownik'] > 0)
		{
			$sql .= ' AND ( obiekt_odbiorcy = \'Uzytkownik\' AND id_odbiorcy = '.$kryteria['odbiorcaUzytkownik'].') ';
		}
		if(isset($kryteria['osobaAkceptujaca']) && $kryteria['osobaAkceptujaca'] > 0)
		{
			$sql .= ' AND  id_osoby_akceptujacej = '.$kryteria['osobaAkceptujaca'];
		}
		if(isset($kryteria['osobaWydajaca']) && $kryteria['osobaWydajaca'] > 0)
		{
			$sql .= ' AND  id_osoby_wydajacej = '.$kryteria['osobaWydajaca'];
		}
		if(isset($kryteria['odbiorcaTeam']) && $kryteria['odbiorcaTeam'] > 0)
		{
			$sql .= ' AND ( obiekt_odbiorcy = \'Team\' AND id_odbiorcy = '.$kryteria['odbiorcaTeam'].') ';
		}
		if(isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$sql .= ' AND id = '. intval($kryteria['fraza']) .' ';
			$sql .= ' AND opis = \''. addslashes($kryteria['fraza']) .'\' ';
		}
		if(isset($kryteria['grupa']))
		{
			if($kryteria['grupa'])
			{
				$sql .= ' AND grupa = TRUE ';
			}
			else
			{
				$sql .= ' AND grupa = FALSE ';
			}
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_magazyn_wydane.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
		  . ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['status']))
		{
			if(is_array($kryteria['status']) && count($kryteria['status']))
			{
				$sql .= ' AND status IN (\''. implode('\',\'', $kryteria['typ']) .'\' )';
			}
			elseif($kryteria['status'] !='')
			{
				$fraza = addslashes($kryteria['status']);
				$sql .= ' AND status = \''. $fraza .'\' ';
			}
		}
		if(isset($kryteria['odbiorcaUzytkownik']) && $kryteria['odbiorcaUzytkownik'] > 0)
		{
			$sql .= ' AND ( obiekt_odbiorcy = \'Uzytkownik\' AND id_odbiorcy = '.$kryteria['odbiorcaUzytkownik'].') ';
		}
		if(isset($kryteria['osobaAkceptujaca']) && $kryteria['osobaAkceptujaca'] > 0)
		{
			$sql .= ' AND  id_osoby_akceptujacej = '.$kryteria['osobaAkceptujaca'];
		}
		if(isset($kryteria['osobaWydajaca']) && $kryteria['osobaWydajaca'] > 0)
		{
			$sql .= ' AND  id_osoby_wydajacej = '.$kryteria['osobaWydajaca'];
		}
		if(isset($kryteria['odbiorcaTeam']) && $kryteria['odbiorcaTeam'] > 0)
		{
			$sql .= ' AND ( obiekt_odbiorcy = \'Team\' AND id_odbiorcy = '.$kryteria['odbiorcaTeam'].') ';
		}
		if(isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$sql .= ' AND id = '. intval($kryteria['fraza']) .' ';
			$sql .= ' AND opis = \''. addslashes($kryteria['fraza']) .'\' ';
		}
		if(isset($kryteria['grupa']))
		{
			if($kryteria['grupa'])
			{
				$sql .= ' AND grupa = TRUE ';
			}
			else
			{
				$sql .= ' AND grupa = FALSE ';
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