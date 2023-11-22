<?php
namespace Generic\Model\MagazynPrzyja;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_magazyn_przyja
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\MagazynPrzyja\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_magazyn_przyja';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_oddajacego' => 'idOddajacego',
		'obiekt_oddajacy' => 'obiektOddajacy',
		'id_przyjmujacego' => 'idPrzyjmujacego',
		'id_osoby_akceptujacej' => 'idOsobyAkceptujacej',
		'data_dodania' => 'dataDodania',
		'podpis' => 'podpis',
		'podpis_vector' => 'podpisVector',
		'zwrot' => 'zwrot',
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
	* Zwraca ilość w tabeli modul_magazyn_przyja.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_magazyn_przyja.
	* @return \Generic\Model\Generic\Model\MagazynPrzyja\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_magazyn_przyja.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Wyszukuje w tabeli modul_magazyn_przyja dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['oddajacyUzytkownik']))
		{
			$sql .= ' AND obiekt_oddajacy = \'Uzytkownik\'  AND id_oddajacego = '.intval($kryteria['oddajacyUzytkownik']);
		}
		if(isset($kryteria['oddajacyTeam']))
		{
			$sql .= ' AND obiekt_oddajacy = \'Team\'  AND id_oddajacego = '.intval($kryteria['oddajacyTeam']);
		}
		if( isset($kryteria['przyjecie']) && $kryteria['przyjecie'] )
		{
			$sql .= ' AND obiekt_oddajacy IS NULL  AND id_oddajacego IS NULL';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_magazyn_przyja.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['oddajacyUzytkownik']))
		{
			$sql .= ' AND obiekt_oddajacy = \'Uzytkownik\'  AND id_oddajacego = '.intval($kryteria['oddajacyUzytkownik']);
		}
		if(isset($kryteria['oddajacyTeam']))
		{
			$sql .= ' AND obiekt_oddajacy = \'Team\'  AND id_oddajacego = '.intval($kryteria['oddajacyTeam']);
		}
		if( isset($kryteria['przyjecie']) && $kryteria['przyjecie'] )
		{
			$sql .= ' AND obiekt_oddajacy IS NULL  AND id_oddajacego IS NULL';
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