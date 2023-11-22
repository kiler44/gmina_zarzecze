<?php
namespace Generic\Model\CennikMiejscowosci;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;


/**
 * Klasa obsługująca zapis i odczyt z bazy elementów menu aplikacji.
 * @author Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\CennikMiejscowosci\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_zamowienia_miejscowosci_ceny';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_pocztowy' => 'kodPocztowy',
		'miejscowosc' => 'miejscowosc',
		'cena' => 'cena',
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

	/**
	* Zwraca wszystko z tabeli modul_zamowienia_miejscowosci_ceny.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	/**
	* Wyszukuje w tabeli modul_zamowienia_miejscowosci_ceny dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * ';
		$sql .= ' FROM ' . $this->tabela;
		$sql .= ' WHERE '.$this->tabela.'.id_projektu = ' . ID_PROJEKTU ; 
		if(isset($kryteria['kod_pocztowy']) && $kryteria['kod_pocztowy'] != '')
		{
			if (is_array($kryteria['kod_pocztowy']) && count($kryteria['kod_pocztowy']) > 0)
			{
				$sql .= ' AND kod_pocztowy IN ('.implode(', ', $kryteria['kod_pocztowy']).')';
			}
			else
			{
				$sql .= ' AND kod_pocztowy = \''.$kryteria['kod_pocztowy'].'\'';
			}
		}
		if(isset($kryteria['miejscowosc']) && $kryteria['miejscowosc'] != '')
		{
			$sql .= ' AND miejscowosc = \''.$kryteria['miejscowosc'].'\'';
		}
		if(isset($kryteria['cena']) && $kryteria['cena'] != '')
		{
			$sql .= ' AND cena = \''.$kryteria['cena'].'\'';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	
	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_zamowienia_miejscowosci_ceny.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) ';
		$sql .= ' FROM ' . $this->tabela;
		$sql .= ' WHERE '.$this->tabela.'.id_projektu = ' . ID_PROJEKTU ; 
		if(isset($kryteria['kod_pocztowy']) && $kryteria['kod_pocztowy'] != '')
		{
			if (is_array($kryteria['kod_pocztowy']) && count($kryteria['kod_pocztowy']) > 0)
			{
				$sql .= ' AND kod_pocztowy IN ('.implode(', ', $kryteria['kod_pocztowy']).')';
			}
			else
			{
				$sql .= ' AND kod_pocztowy = \''.$kryteria['kod_pocztowy'].'\'';
			}
		}
		if(isset($kryteria['miejscowosc']) && $kryteria['miejscowosc'] != '')
		{
			$sql .= ' AND miejscowosc = \''.$kryteria['miejscowosc'].'\'';
		}
		if(isset($kryteria['cena']) && $kryteria['cena'] != '')
		{
			$sql .= ' AND cena = \''.$kryteria['cena'].'\'';
		}
		
		return $this->pobierzWartosc($sql);
	}
	
	
	public function pobierzPoKodziePocztowym($kod_pocztowy)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		. ' WHERE kod_pocztowy = \'' . strval($kod_pocztowy).'\''
		. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
}

