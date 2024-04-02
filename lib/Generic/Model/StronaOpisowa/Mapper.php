<?php
namespace Generic\Model\StronaOpisowa;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących strony opisowe.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\StronaOpisowa\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_strona_opisowa';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'id_kategorii' => 'idKategorii',
		'tytul' => 'tytul',
		'tresc' => 'tresc',
		'id_galerii' => 'idGalerii',
		'id_uzytkownika' => 'idAutora',
		'data_dodania' => 'dataDodania',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu', 'kod_jezyka');



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzJeden($sql);
	}



	public function pobierzDlaKategorii($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_kategorii = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzJeden($sql);
	}

	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tytul ILIKE \'%'.$fraza.'%\''
				. ' OR tresc ILIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tytul ILIKE \'%'.$fraza.'%\''
				. ' OR tresc ILIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		return $this->pobierzWartosc($sql);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		. ' WHERE id_projektu = ' . ID_PROJEKTU
		. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWartosc($sql);
	}

}

