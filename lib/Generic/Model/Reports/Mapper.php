<?php
namespace Generic\Model\Reports;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_reports
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Reports\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_reports';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'obiekt' => 'obiekt',
		'id_obiektow' => 'idObiektow',
		'kategoria' => 'kategoria',
		'data_od' => 'dataOd',
		'data_do' => 'dataDo',
		'autor' => 'autor',
		'data_dodania' => 'dataDodania',
		'data_modyfikacji' => 'dataModyfikacji',
		'wyslany' => 'wyslany',
		'status' => 'status',
		'typ_zamowien' => 'typZamowien',
		'netto_price' => 'nettoPrice',
		'brutto_price' => 'bruttoPrice',
		'zafakturowano' => 'zafakturowano',
		'wyslany_do_fakturowania' => 'wyslanyDoFakturowania',
		'additional_data' => 'additionalData',
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
	* Zwraca ilość w tabeli modul_reports.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}


	
	/**
	* Zwraca dla podanego id w tabeli modul_reports.
	* @return \Generic\Model\Generic\Model\Reports\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;
		
		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_reports.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}

	/**
	* Zwraca dla podanego id w tabeli modul_zamowienia.
	* @return \Generic\Model\Generic\Model\Reports\Obiekt
	*/
	public function pobierzPoWieleId(array $ids)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id IN (' . implode(',' , $ids) .')'
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}

	public function pobierzNajnowszyZkategorii()
	{
		$sql = 'SELECT MAX(id) AS id FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND status = \'active\' '
			. ' GROUP BY kategoria';

		return $this->pobierzWiele($sql);
	}
	
	/**
	* Wyszukuje w tabeli modul_reports dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * '
			. ', (SELECT CONCAT(imie,\' \', nazwisko) FROM  cms_uzytkownicy cu WHERE cu.id = '.$this->tabela.'.autor ) as autor_nazwa'
			. ', (SELECT zdjecie FROM  cms_uzytkownicy cu WHERE cu.id = '.$this->tabela.'.autor ) as autor_zdjecie'
			. ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		 if(isset($kryteria['status']) && $kryteria['status'] != '')
		 {
			 $fraza = addslashes($kryteria['status']);
			 $sql.= ' AND status = \''.$fraza.'\' ';
		 }
		 if(isset($kryteria['kategoria']) && $kryteria['kategoria'] != '')
		 {
			 $fraza = addslashes($kryteria['kategoria']);
			 $sql.= ' AND kategoria = \''.$fraza.'\' ';
		 }
		 if(isset($kryteria['wyklucz_id']) && $kryteria['wyklucz_id'] !='' && $kryteria['wyklucz_id'] > 0)
		 {
			 $sql.= ' AND id <> '.$kryteria['wyklucz_id'];
		 }
		 
		 if(isset($kryteria['zafakturowano']))
		 {
			 if ($kryteria['zafakturowano'])
			 {
				 $sql.= ' AND zafakturowano = TRUE';
			 }
			 else
			 {
				 $sql.= ' AND zafakturowano = FALSE';
			 }
		 }
		 
		 if(isset($kryteria['wyslany_do_fakturowania']))
		 {
			 if ($kryteria['wyslany_do_fakturowania'])
			 {
				 $sql.= ' AND wyslany_do_fakturowania = TRUE';
			 }
			 else
			 {
				 $sql.= ' AND wyslany_do_fakturowania = FALSE';
			 }
		 }

		 return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_reports.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT COUNT(*) '
			. ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$fraza = addslashes($kryteria['status']);
			$sql.= ' AND status = \''.$fraza.'\' ';
		}
		if(isset($kryteria['kategoria']) && $kryteria['kategoria'] != '')
		{
			 $fraza = addslashes($kryteria['kategoria']);
			 $sql.= ' AND kategoria = \''.$fraza.'\' ';
		}
		if(isset($kryteria['wyklucz_id']) && $kryteria['wyklucz_id'] !='' && $kryteria['wyklucz_id'] > 0)
		{
			$sql.= ' AND id <> '.$kryteria['wyklucz_id'];
		}
		
		if(isset($kryteria['zafakturowano']))
		{
			if ($kryteria['zafakturowano'])
			{
				$sql.= ' AND zafakturowano = TRUE';
			}
			else
			{
				$sql.= ' AND zafakturowano = FALSE';
			}
		}
		 
		if(isset($kryteria['wyslany_do_fakturowania']))
		{
			if ($kryteria['wyslany_do_fakturowania'])
			{
				$sql.= ' AND wyslany_do_fakturowania = TRUE';
			}
			else
			{
				$sql.= ' AND wyslany_do_fakturowania = FALSE';
			}
		}
		return $this->pobierzWartosc($sql);
	}
	
	
	public function pobierzKwoteRaportow($kryteria)
	{
		$sql = 'SELECT SUM (netto_price) '
			. ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['status']) && $kryteria['status'] != '')
		 {
			 $fraza = addslashes($kryteria['status']);
			 $sql.= ' AND status = \''.$fraza.'\' ';
		 }
		 if(isset($kryteria['kategoria']) && $kryteria['kategoria'] != '')
		 {
			 $fraza = addslashes($kryteria['kategoria']);
			 $sql.= ' AND kategoria = \''.$fraza.'\' ';
		 }
		 if(isset($kryteria['wyklucz_id']) && $kryteria['wyklucz_id'] !='' && $kryteria['wyklucz_id'] > 0)
		 {
			 $sql.= ' AND id <> '.$kryteria['wyklucz_id'];
		 }
		 
		 if(isset($kryteria['zafakturowano']))
		 {
			 if ($kryteria['zafakturowano'])
			 {
				 $sql.= ' AND zafakturowano = TRUE';
			 }
			 else
			 {
				 $sql.= ' AND zafakturowano = FALSE';
			 }
		 }
		 
		 if(isset($kryteria['wyslany_do_fakturowania']))
		 {
			 if ($kryteria['wyslany_do_fakturowania'])
			 {
				 $sql.= ' AND wyslany_do_fakturowania = TRUE';
			 }
			 else
			 {
				 $sql.= ' AND wyslany_do_fakturowania = FALSE';
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