<?php
namespace Generic\Model\ZamowieniePdf;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_zamowienie_pdf
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\ZamowieniaPdf\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_zamowienie_pdf';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'data' => 'data',
		'godzina' => 'godzina',
		'id_pdf' => 'idPdf',
		'data_wygenerowania' => 'dataWygenerowania',
		'data_dostarczenia' => 'dataDostarczenia',
		'id_zamowienie_projekt' => 'idZamowienieProjekt',
		'druga_tura_apartament' => 'drugaTuraApartament',
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
	* Zwraca ilość w tabeli modul_zamowienie_pdf.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_zamowienie_pdf.
	* @return \Generic\Model\Generic\Model\ZamowieniePdf\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_zamowienie_pdf.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}

	/**
	 * 
	 * @param type $idPdf
	 * @param type $tura
	 * @return \Generic\Model\Generic\Model\ZamowieniePdf\Obiekt\Obiekt
	 */
	public function pobierzPoIdPdf($idPdf, $tura)
	{
			$sql = 'SELECT * FROM ' . $this->tabela
				. ' WHERE id_projektu = ' . ID_PROJEKTU
				. ' AND id_pdf = \''.trim(strval($idPdf)).'\' '
				. ' AND druga_tura_apartament = '.$tura;
			
			return $this->pobierzJeden($sql);
	}

	/**
	* Wyszukuje w tabeli modul_zamowienie_pdf dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * '
			. ' FROM '.$this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['druga_tura_apartament']) && $kryteria['druga_tura_apartament'] > 0)
		{
			$fraza = intval($kryteria['druga_tura_apartament']);
			$sql.= ' AND druga_tura_apartament = '.$fraza.' ';
		}
		if(isset($kryteria['id_zamowienie_projekt']) && $kryteria['id_zamowienie_projekt'] > 0)
		{
			$fraza = intval($kryteria['id_zamowienie_projekt']);
			$sql.= ' AND id_zamowienie_projekt = '.$fraza.' ';
		}
		if(isset($kryteria['id_pdf']) && $kryteria['id_pdf'] > 0)
		{
			$fraza = addslashes(strval($kryteria['id_pdf']));
			$sql.= ' AND id_pdf = \''.$fraza.'\' ';
		}
		if(isset($kryteria['druga_tura']) && $kryteria['druga_tura'] != "")
		{
			$sql.= ' AND druga_tura_apartament = '.intval($kryteria['druga_tura']);
		}
		if(isset($kryteria['dostarczone']))
		{
			if($kryteria['dostarczone'] == true)
			{
				$sql.= ' AND data_dostarczenia IS NOT NULL';
			}
			else
			{
				$sql.= ' AND data_dostarczenia IS NULL';
			}
			
		}
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_zamowienie_pdf.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT * '
			. ' FROM '.$this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['druga_tura_apartament']) && $kryteria['druga_tura_apartament'] > 0)
		{
			$fraza = intval($kryteria['druga_tura_apartament']);
			$sql.= ' AND druga_tura_apartament = '.$fraza.' ';
		}
		if(isset($kryteria['id_zamowienie_projekt']) && $kryteria['id_zamowienie_projekt'] > 0)
		{
			$fraza = intval($kryteria['id_zamowienie_projekt']);
			$sql.= ' AND id_zamowienie_projekt = '.$fraza.' ';
		}
		if(isset($kryteria['id_pdf']) && $kryteria['id_pdf'] > 0)
		{
			$fraza = addslashes(strval($kryteria['id_pdf']));
			$sql.= ' AND id_pdf = \''.$fraza.'\' ';
		}
		if(isset($kryteria['druga_tura']) && $kryteria['druga_tura'] != "")
		{
			$sql.= ' AND druga_tura_apartament = '.intval($kryteria['druga_tura']);
		}
		if(isset($kryteria['dostarczone']))
		{
			if($kryteria['dostarczone'] == true)
			{
				$sql.= ' AND data_dostarczenia IS NOT NULL';
			}
			else
			{
				$sql.= ' AND data_dostarczenia IS NULL';
			}
			
		}
		return $this->pobierzWartosc($zapytanie);
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