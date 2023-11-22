<?php
namespace Generic\Model\Aktualnosc;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących aktualności.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Aktualnosc\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_aktualnosci';



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
		'zajawka' => 'zajawka',
		'zdjecie_glowne' => 'zdjecieGlowne',
		'tresc' => 'tresc',
		'id_uzytkownika' => 'idUzytkownika',
		'autor' => 'autor',
		'data_dodania' => 'dataDodania',
		'data_waznosci' => 'dataWaznosci',
		'priorytetowa' => 'priorytetowa',
		'publikuj' => 'publikuj',
		'id_galerii' => 'idGalerii',
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



	public function pobierzDlaKategorii($id, $opublikowane = true)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_kategorii = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND publikuj = ' . ($opublikowane ? 'true' : 'false');

		return $this->pobierzWiele($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] != '')
		{
			$sql .= ' AND id_kategorii = '.intval($kryteria['id_kategorii']);
		}
		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ' AND id_uzytkownika = '.intval($kryteria['id_uzytkownika']);
		}
		if (isset($kryteria['publikuj']) && $kryteria['publikuj'] != '')
		{
			$sql .= ' AND publikuj = '.((intval($kryteria['publikuj']) > 0) ? 'true' : 'false');
		}
		if (isset($kryteria['priorytetowa']) && intval($kryteria['priorytetowa']) > 0)
		{
			$sql .= ' AND priorytetowa = '.intval($kryteria['priorytetowa']);
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tytul LIKE \'%'.$fraza.'%\''
				. ' OR zajawka LIKE \'%'.$fraza.'%\''
				. ' OR tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) > 0)
		{
			$sql .= ' AND (data_waznosci > NOW() OR data_waznosci IS NULL)';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

			if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] != '')
		{
			$sql .= ' AND id_kategorii = '.intval($kryteria['id_kategorii']);
		}
		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ' AND id_uzytkownika = '.intval($kryteria['id_uzytkownika']);
		}
		if (isset($kryteria['publikuj']) && $kryteria['publikuj'] != '')
		{
			$sql .= ' AND publikuj = '.((intval($kryteria['publikuj']) > 0) ? 'true' : 'false');
		}
		if (isset($kryteria['priorytetowa']) && intval($kryteria['priorytetowa']) > 0)
		{
			$sql .= ' AND priorytetowa = '.intval($kryteria['priorytetowa']);
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tytul LIKE \'%'.$fraza.'%\''
				. ' OR zajawka LIKE \'%'.$fraza.'%\''
				. ' OR tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) > 0)
		{
			$sql .= ' AND (data_waznosci > NOW() OR data_waznosci IS NULL)';
		}

		return $this->pobierzWartosc($sql);
	}

}
