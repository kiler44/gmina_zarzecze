<?php
namespace Generic\Model\RaportEdytowalny;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_raporty_edytowalne
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\RaportyEdytowalne\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_raporty_edytowalne';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'nazwa' => 'nazwa',
		'opis' => 'opis',
		'grupa' => 'grupa',
		'kod_sql' => 'kodSql',
		'nazwy_pol' => 'nazwyPol',
		'uprawnieni_uzytkownicy' => 'uprawnieniUzytkownicy',
		'filtry' => 'filtry',
		'data_dodania' => 'dataDodania',
		'data_modyfikacji' => 'dataModyfikacji',
		'cache' => 'cache',
		'zezwol_zaawansowany' => 'zezwolZaawansowany',
		'typ_wykresu' => 'typWykresu',
		'kolumny_wykresu' => 'kolumnyWykresu',
		'typy_kolumn_tabeli' => 'typyKolumnTabeli',
		'kolumna_wykresu_daty' => 'kolumnaWykresuDaty',
		'typ_wykresu_modyfikowalny' => 'typWykresuModyfikowalny',
		'sub_zapytania' => 'subZapytania',
		'filtry_poczatkowe' => 'filtryPoczatkowe',
		'filtry_poczatkowe_wartosci' => 'filtryPoczatkoweWartosci',
		'filtry_poczatkowe_etykiety' => 'filtryPoczatkoweEtykiety',
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
	* Zwraca ilość w tabeli modul_raporty_edytowalne.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_raporty_edytowalne.
	* @return \Generic\Model\Generic\Model\RaportyEdytowalne\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}


	public function pobierzPoIdUzytkownika($idUzytkownika)
	{
		if (intval($idUzytkownika) < 1)
		{
			return null;
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND uprawnieni_uzytkownicy LIKE \'%,' . intval($idUzytkownika) . ',%\'';

		return $this->pobierzWiele($sql);
	}

	/**
	* Zwraca wszystko z tabeli modul_raporty_edytowalne.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_raporty_edytowalne dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_raporty_edytowalne.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);
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