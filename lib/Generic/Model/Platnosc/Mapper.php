<?php
namespace Generic\Model\Platnosc;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących płatności.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Platnosc\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_platnosci';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_uzytkownika' => 'idUzytkownika',
		'data_dodania' => 'dataDodania',
		'system_platnosci' => 'systemPlatnosci',
		'kod_modulu' => 'kodModulu',
		'id_kategorii_modulu' => 'idKategoriiModulu',
		'typ_obiektu' => 'typObiektu',
		'id_obiektu' => 'idObiektu',
		'kwota' => 'kwota',
		'waluta' => 'waluta',
		'opis' => 'opis',
		'typ_platnosci' => 'typPlatnosci',
		'status' => 'status',
		'imie' => 'imie',
		'nazwisko' => 'nazwisko',
		'ulica' => 'ulica',
		'nr_domu' => 'nrDomu',
		'nr_lokalu' => 'nrLokalu',
		'kod_pocztowy' => 'kodPocztowy',
		'miasto' => 'miasto',
		'wojewodztwo' => 'wojewodztwo',
		'kraj' => 'kraj',
		'email' => 'email',
		'telefon' => 'telefon',
		'dane_wyslane' => 'daneWyslane',
		'dane_odebrane' => 'daneOdebrane',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu');




	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					opis LIKE \'%'.$fraza.'%\''
				. ' OR imie LIKE \'%'.$fraza.'%\''
				. ' OR nazwisko LIKE \'%'.$fraza.'%\''
				. ' OR miasto LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['kod_modulu']) && $kryteria['kod_modulu'] != '')
		{
			$sql .= ' AND kod_modulu = \''.addslashes($kryteria['kod_modulu']).'\'';
		}
		if (isset($kryteria['id_kategorii_modulu']) && $kryteria['id_kategorii_modulu'] != '')
		{
			$sql .= ' AND id_kategorii_modulu = '.intval($kryteria['id_kategorii_modulu']);
		}
		if (isset($kryteria['typ_obiektu']) && $kryteria['typ_obiektu'] != '')
		{
			$sql .= ' AND typ_obiektu = \''.addslashes($kryteria['typ_obiektu']).'\'';
		}
		if (isset($kryteria['id_obiektu']) && $kryteria['id_obiektu'] != '')
		{
			$sql .= ' AND id_obiektu = '.intval($kryteria['id_obiektu']);
		}
		if (isset($kryteria['kwota']) && $kryteria['kwota'] != '')
		{
			$sql .= ' AND kwota = '.floatval($kryteria['kwota']);
		}
		if (isset($kryteria['kwota_max']) && $kryteria['kwota_max'] != '')
		{
			$sql .= ' AND kwota <= '.floatval($kryteria['kwota_max']);
		}
		if (isset($kryteria['kwota_min']) && $kryteria['kwota_min'] != '')
		{
			$sql .= ' AND kwota >= '.floatval($kryteria['kwota_min']);
		}
		if (isset($kryteria['waluta']) && $kryteria['waluta'] != '')
		{
			$sql .= ' AND waluta = \''.addslashes($kryteria['waluta']).'\'';
		}
		if (isset($kryteria['opis']) && $kryteria['opis'] != '')
		{
			$sql .= ' AND opis LIKE \'%'.addslashes($kryteria['opis']).'%\'';
		}
		if (isset($kryteria['status']))
		{
			if (is_array($kryteria['status']))
				$sql .= ' AND status IN (\''.implode('\',\'', array_map('addslashes',array_filter($kryteria['status']))).'\')';
			elseif ($kryteria['status'] != '')
				$sql .= ' AND status = \''.addslashes($kryteria['status']).'\'';
		}
		if (isset($kryteria['typ_platnosci']) && $kryteria['typ_platnosci'] != '')
		{
			$sql .= ' AND typ_platnosci = \''.addslashes($kryteria['typ_platnosci']).'\'';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania = \''.addslashes($kryteria['data_dodania']).'\'';
		}
		if (isset($kryteria['data_dodania_max']) && $kryteria['data_dodania_max'] != '')
		{
			$sql .= ' AND data_dodania <= \''.addslashes($kryteria['data_dodania_max']).'\'';
		}
		if (isset($kryteria['data_dodania_min']) && $kryteria['data_dodania_min'] != '')
		{
			$sql .= ' AND data_dodania >= \''.addslashes($kryteria['data_dodania_min']).'\'';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					opis LIKE \'%'.$fraza.'%\''
				. ' OR imie LIKE \'%'.$fraza.'%\''
				. ' OR nazwisko LIKE \'%'.$fraza.'%\''
				. ' OR miasto LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['kod_modulu']) && $kryteria['kod_modulu'] != '')
		{
			$sql .= ' AND kod_modulu = \''.addslashes($kryteria['kod_modulu']).'\'';
		}
		if (isset($kryteria['id_kategorii_modulu']) && $kryteria['id_kategorii_modulu'] != '')
		{
			$sql .= ' AND id_kategorii_modulu = '.intval($kryteria['id_kategorii_modulu']);
		}
		if (isset($kryteria['typ_obiektu']) && $kryteria['typ_obiektu'] != '')
		{
			$sql .= ' AND typ_obiektu = \''.addslashes($kryteria['typ_obiektu']).'\'';
		}
		if (isset($kryteria['id_obiektu']) && $kryteria['id_obiektu'] != '')
		{
			$sql .= ' AND id_obiektu = '.intval($kryteria['id_obiektu']);
		}
		if (isset($kryteria['kwota']) && $kryteria['kwota'] != '')
		{
			$sql .= ' AND kwota = '.floatval($kryteria['kwota']);
		}
		if (isset($kryteria['kwota_max']) && $kryteria['kwota_max'] != '')
		{
			$sql .= ' AND kwota <= '.floatval($kryteria['kwota_max']);
		}
		if (isset($kryteria['kwota_min']) && $kryteria['kwota_min'] != '')
		{
			$sql .= ' AND kwota >= '.floatval($kryteria['kwota_min']);
		}
		if (isset($kryteria['waluta']) && $kryteria['waluta'] != '')
		{
			$sql .= ' AND waluta = \''.addslashes($kryteria['waluta']).'\'';
		}
		if (isset($kryteria['opis']) && $kryteria['opis'] != '')
		{
			$sql .= ' AND opis LIKE \'%'.addslashes($kryteria['opis']).'%\'';
		}
		if (isset($kryteria['status']))
		{
			if (is_array($kryteria['status']))
				$sql .= ' AND status IN (\''.implode('\',\'', array_map('addslashes',array_filter($kryteria['status']))).'\')';
			elseif ($kryteria['status'] != '')
				$sql .= ' AND status = \''.addslashes($kryteria['status']).'\'';
		}
		if (isset($kryteria['typ_platnosci']) && $kryteria['typ_platnosci'] != '')
		{
			$sql .= ' AND typ_platnosci = \''.addslashes($kryteria['typ_platnosci']).'\'';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania = \''.addslashes($kryteria['data_dodania']).'\'';
		}
		if (isset($kryteria['data_dodania_max']) && $kryteria['data_dodania_max'] != '')
		{
			$sql .= ' AND data_dodania <= \''.addslashes($kryteria['data_dodania_max']).'\'';
		}
		if (isset($kryteria['data_dodania_min']) && $kryteria['data_dodania_min'] != '')
		{
			$sql .= ' AND data_dodania >= \''.addslashes($kryteria['data_dodania_min']).'\'';
		}

		return $this->pobierzWartosc($sql);
	}

}
