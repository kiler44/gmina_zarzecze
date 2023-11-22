<?php
namespace Generic\Model\Produkt;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;

/**
* Maper tabeli w bazie: modul_produkty
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Produkt\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_produkty';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'code' => 'code',
		'name' => 'name',
		'status' => 'status',
		'measure_unit' => 'measureUnit',
		'visible_in_order' => 'visibleInOrder',
		'vat' => 'vat',
		'netto_price' => 'nettoPrice',
		'brutto_price' => 'bruttoPrice',
		'data_added' => 'dataAdded',
		'import' => 'import',
		'kombinacje' => 'kombinacje',
		'text_do_sms' => 'textDoSms',
		'main_product' => 'mainProduct',
		'multiplied' => 'multiplied',
		'note_required' => 'noteRequired',
		'serial' => 'serial',
		'pojedynczy' => 'pojedynczy',
		'kolejnosc' => 'kolejnosc',
		'not_done' => 'notDone',
		'ukryty' => 'ukryty',
		'id_polaczony' => 'idPolaczony',
		'technologia' => 'technologia',
		'photos_required' => 'photosRequired',
		'photos_explanation' => 'photosExplanation',
		'czas' => 'czas',
		'data_waznosci_od' => 'dataWaznosciOd',
		'data_waznosci_do' => 'dataWaznosciDo',
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
	* Zwraca ilość w tabeli modul_produkty.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_produkty.
	* @return \Generic\Model\Generic\Model\Produkty\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	/**
	* Zwraca dla podanego id w tabeli modul_produkty.
	* @return \Generic\Model\Generic\Model\Produkty\Obiekt\Obiekt
	*/
	public function pobierzPolaczony($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_polaczony = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	/**
	* Zwraca dla podanego id w tabeli modul_produkty.
	* @return \Generic\Model\Generic\Model\Produkty\Obiekt\Obiekt
	*/
	public function pobierzPoWieleId($ids)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id IN (' . implode(',' , $ids) .')'
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}
	
	/**
	* Zwraca obiekt dla podanego code w tabeli modul_produkty.
	* @param string $code kod produktu
	* @param bool $import ustawiony na 1 szuka w produktach zaimportowanych
	* @return \Generic\Model\Generic\Model\Produkty\Obiekt\Obiekt
	*/
	public function pobierzPoCode($code, $import = 0, $dataWaznosci = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE code = \'' . addslashes($code) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;
		if($dataWaznosci != null)
		{
			$sql.=' AND ( \''.$dataWaznosci.'\' > data_waznosci_od AND ( \''.$dataWaznosci.'\' < data_waznosci_do OR data_waznosci_do IS NULL ) )';
		}
		else
		{
			 $sql.=' AND status = \'active\' ';
		}
		if($import)
		{
			$sql.=' AND import = true';
		}

		return $this->pobierzJeden($sql);
	}

	public function pobierzPoCodes(Array $code, $import = 0, $dataWaznosci = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE  id_projektu = ' . ID_PROJEKTU;
		 
		$sql .= ' AND code IN (\''.implode('\' , \'' , $code ).'\')';
		if($dataWaznosci != null)
		{
			$sql.=' AND ( \''.$dataWaznosci.'\' > data_waznosci_od AND ( \''.$dataWaznosci.'\' < data_waznosci_do OR data_waznosci_do IS NULL ) )';
		}
		if($import)
		{
			$sql.=' AND import = true';
		}

		return $this->pobierzWiele($sql);
	}

	/**
	* Zwraca wszystko z tabeli modul_produkty.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_zalaczniki dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		 $sql = 'SELECT * FROM ' . $this->tabela .' AS p ';

		 if(isset($kryteria['idOrder']) && $kryteria['idOrder'] > 0)
		 {
			$sql.=' LEFT JOIN modul_produkty_zakupione ON (modul_produkty_zakupione.id_product = p.id) ';
			if(is_array($kryteria['idOrder']))
			{
				$sql.=' WHERE modul_produkty_zakupione.id_order IN ('.implode( ', ' ,$kryteria['idOrder']).')';
			}
			else
			{
				$sql.=' WHERE modul_produkty_zakupione.id_order = '.intval($kryteria['idOrder']).'';
			}
			$sql.=' AND p.id_projektu = ' . ID_PROJEKTU;
		 }
		 else
		 {
			$sql .= ' WHERE id_projektu = ' . ID_PROJEKTU;
		 }
		 
		 if(isset($kryteria['id']) && $kryteria['id'] > 0)
		 {
			if(is_array($kryteria['id']))
			{
				$sql.=' AND id IN ('.implode( ', ' ,$kryteria['id']).')';	
			}
			else
			{
				$sql.=' AND id = '.intval($kryteria['id']).'';
			}
		 }
		 if(isset($kryteria['nie_id']) && $kryteria['nie_id'] > 0)
		 {
			if(is_array($kryteria['nie_id']))
			{
				$sql.=' AND id NOT IN ('.implode( ', ' ,$kryteria['nie_id']).')';	
			}
			else
			{
				$sql.=' AND id <> '.intval($kryteria['nie_id']).'';
			}
		 }
		 if (isset($kryteria['status']) && $kryteria['status'] != '')
		 {
			 $fraza = addslashes($kryteria['status']);
			 $sql.= ' AND status = \''.$fraza.'\' ';
		 }
		 if (isset($kryteria['visible_in_order']) && $kryteria['visible_in_order'] != '' && $kryteria['visible_in_order'] > 0)
		 {
			if (!is_array($kryteria['visible_in_order']))
			{
				$kryteria['visible_in_order'] = array($kryteria['visible_in_order']);
			}
			$sql .= ' AND (';
			$i = 0;
			foreach ($kryteria['visible_in_order'] as $orderTypeId)
			{
				if ($i > 0)
				{
					$sql .= ' OR ';
				}
				$sql .= 'visible_in_order ILIKE \'%|' . $orderTypeId . '|%\'';
				$i++;
			}
			$sql .= ')';
		 }
		 
		 if (isset($kryteria['kombinacje']) && $kryteria['kombinacje'] != '' && $kryteria['kombinacje'] > 0)
		 {
			$sql .= ' AND kombinacje ILIKE \'%' . implode('|', $kryteria['kombinacje']) . '%\'';
		 }
		 if (isset($kryteria['text_do_sms']) && $kryteria['text_do_sms'] != '')
       {
          $fraza = addslashes($kryteria['text_do_sms']);
          $sql.= ' AND text_do_sms = \''.$fraza.'\'';
       }
		 if (isset($kryteria['main_product']))
		 {
			 $sql .= ' AND main_product = '.(($kryteria['main_product']) ? 'true' : 'false');
		 }
       if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
       {
          $fraza = addslashes($kryteria['fraza']);
          $sql.= ' AND (name ILIKE \'%'.$fraza.'%\''.
                 'OR measure_unit ILIKE \'%'.$fraza.'%\')';
       }
		 if (isset($kryteria['import']))
		 {
			if($kryteria['import'])
			{
				$sql.= ' AND import = true';
			}
			else
			{
				$sql.= ' AND import = false';
			}
		 }
		 if (isset($kryteria['pojedynczy']))
		 {
			if($kryteria['pojedynczy'])
			{
				$sql.= ' AND pojedynczy = true';
			}
			else
			{
				$sql.= ' AND pojedynczy = false';
			}
		 }
		 
		if (isset($kryteria['not_done']))
		{
			if($kryteria['not_done'])
			{
				 $sql.= ' AND not_done = true';
			}
			else
			{
				$sql.= ' AND not_done = false';
			}
		}
		if(isset($kryteria['zdjecia_wymagane']) && $kryteria['zdjecia_wymagane'])
		{
			$sql.= ' AND photos_required > 0';
		}
		if (isset($kryteria['ukryty']))
		{
			if ($kryteria['ukryty'])
			{
				//$sql.= ' AND ukryty = TRUE';
			}
		}
		else
		{
			$sql.= ' AND ukryty = FALSE';
		}
		if(isset($kryteria['dataWaznosci']) && $kryteria['dataWaznosci'] !='')
		{
			$sql.=' AND ( \''.$kryteria['dataWaznosci'].'\' > data_waznosci_od AND ( \''.$kryteria['dataWaznosci'].'\' < data_waznosci_do OR data_waznosci_do IS NULL ) )';
		}
		if(isset($kryteria['bezKombinacji']) && $kryteria['bezKombinacji'])
		{
			$sql.=' AND kombinacje IS NULL';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_zalaczniki.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela;
		
		 
		 if(isset($kryteria['idOrders']) && $kryteria['idOrders'] > 0)
		 {
			$sql.=' LEFT JOIN modul_produkty_zakupione ON (modul_produkty_zakupione.id_product = p.id) ';
			$sql.=' WHERE modul_produkty_zakupione.id_order = '.intval($kryteria['idOrders']).'';
			$sql.=' AND p.id_projektu = ' . ID_PROJEKTU;
		 }
		 else
		 {
			 $sql .= ' WHERE id_projektu = ' . ID_PROJEKTU;
		 }
		 
		  if(isset($kryteria['id']) && $kryteria['id'] > 0)
		 {
			if(is_array($kryteria['id']))
			{
				$sql.=' AND id IN ('.implode( ', ' ,$kryteria['id']).')';	
			}
			else
			{
				$sql.=' AND id = '.intval($kryteria['id']).'';
			}
		 }
		 if(isset($kryteria['nie_id']) && $kryteria['nie_id'] > 0)
		 {
			if(is_array($kryteria['nie_id']))
			{
				$sql.=' AND id NOT IN ('.implode( ', ' ,$kryteria['nie_id']).')';	
			}
			else
			{
				$sql.=' AND id <> '.intval($kryteria['nie_id']).'';
			}
		 }
		 if (isset($kryteria['status']) && $kryteria['status'] != '')
		 {
			 $fraza = addslashes($kryteria['status']);
			 $sql.= ' AND status = \''.$fraza.'\' ';
		 }
		if (isset($kryteria['visible_in_order']) && $kryteria['visible_in_order'] != '' && $kryteria['visible_in_order'] > 0)
		 {
			if (!is_array($kryteria['visible_in_order']))
			{
				$kryteria['visible_in_order'] = array($kryteria['visible_in_order']);
			}
			$sql .= ' AND visible_in_order ILIKE \'%|' . implode('|', $kryteria['visible_in_order']) . '|%\'';
		 }
		 
		 if (isset($kryteria['kombinacje']) && $kryteria['kombinacje'] != '' && $kryteria['kombinacje'] > 0)
		 {
			$sql .= ' AND kombinacje ILIKE \'%' . implode('|', $kryteria['kombinacje']) . '%\'';
		 }
		 if (isset($kryteria['main_product']))
		 {
			 $sql .= ' AND main_product = '.(($kryteria['main_product']) ? 'true' : 'false');
		 }
       if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
       {
          $fraza = addslashes($kryteria['fraza']);
          $sql.= ' AND (name ILIKE \'%'.$fraza.'%\''.
                 'OR measure_unit ILIKE \'%'.$fraza.'%\')';
       }
		 if (isset($kryteria['import']))
		 {
			if($kryteria['import'])
			{
				 $sql.= ' AND import = true';
			}
			else
			{
				$sql.= ' AND import = false';
			}
		 }
		 if (isset($kryteria['pojedynczy']))
		 {
			if($kryteria['pojedynczy'])
			{
				$sql.= ' AND pojedynczy = true';
			}
			else
			{
				$sql.= ' AND pojedynczy = false';
			}
		 }
		
		if (isset($kryteria['not_done']))
		{
			if($kryteria['not_done'])
			{
				 $sql.= ' AND not_done = true';
			}
			else
			{
				$sql.= ' AND not_done = false';
			}
		}
		 
		if (isset($kryteria['ukryty']))
		{
			if ($kryteria['ukryty'])
			{
				//$sql.= ' AND ukryty = TRUE';
			}
		}
		else
		{
		  $sql.= ' AND ukryty = FALSE'; 
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
	
	public function aktualizujKolejnosc($porzadek)
	{
		if (!is_array($porzadek) || empty($porzadek) || count($porzadek) == 0)
			return false;

		try
		{
			$this->baza->transakcjaStart();

			$warunek = array('id' => 0, 'id_projektu' => ID_PROJEKTU);

			$licznik = 1;
			foreach ($porzadek as $id)
			{
				$warunek['id'] = $id;
				$sql = $this->baza->sqlUpdate('modul_produkty', array('kolejnosc' => $licznik), array('AND' => $warunek));
				$this->baza->zapytanie($sql);
				$licznik++;
			}

			$this->baza->transakcjaPotwierdz();
			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}
}