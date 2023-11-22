<?php
namespace Generic\Model\UdostepnianyPlik;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących pliki udostępniane.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\UdostepnianyPlik\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_udostepnianie_plikow';



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
		'plik' => 'plik',
		'tresc' => 'tresc',
		'id_uzytkownika' => 'idUzytkownika',
		'autor' => 'autor',
		'data_dodania' => 'dataDodania',
		'data_waznosci' => 'dataWaznosci',
		'publikuj' => 'publikuj',
		'publiczny' => 'publiczny',
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



	public function pobierzDlaKategorii($id, $opublikowane = true)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_kategorii = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWiele($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT DISTINCT
		mup.id,
		mup.id_projektu,
		mup.kod_jezyka,
		mup.id_kategorii,
		mup.tytul,
		cp.url as plik,
		mup.tresc,
		mup.autor,
		mup.data_dodania,
		mup.data_waznosci
		 FROM ' . $this->tabela. ' as mup, cms_pliki as cp ';

		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ', cms_pliki_uzytkownicy_powiazania as cpup ';
		}

		$sql .= 'WHERE mup.id_projektu = ' . ID_PROJEKTU
			. ' AND mup.kod_jezyka = \'' . KOD_JEZYKA .'\'
			 AND mup.plik = cp.id';

		if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] != '')
		{
			$sql .= ' AND mup.id_kategorii = '.intval($kryteria['id_kategorii']);
		}
		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ' AND cpup.id_uzytkownika = '.intval($kryteria['id_uzytkownika']).
			' AND cpup.id_pliku = cp.id';
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					mup.tytul LIKE \'%'.$fraza.'%\''
				. ' OR mup.plik LIKE \'%'.$fraza.'%\''
				. ' OR mup.tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND mup.data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) > 0)
		{
			$sql .= ' AND (mup.data_waznosci > NOW() OR mup.data_waznosci IS NULL)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) < 0)
		{
			$sql .= ' AND (mup.data_waznosci < NOW() AND mup.data_waznosci IS NOT NULL)';
		}
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT DISTINCT
		COUNT(*)
		 FROM ' . $this->tabela. ' as mup, cms_pliki as cp ';

		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ', cms_pliki_uzytkownicy_powiazania as cpup ';
		}

		$sql .= 'WHERE mup.id_projektu = ' . ID_PROJEKTU
			. ' AND mup.kod_jezyka = \'' . KOD_JEZYKA .'\'
			 AND mup.plik = cp.id';

		if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] != '')
		{
			$sql .= ' AND mup.id_kategorii = '.intval($kryteria['id_kategorii']);
		}
		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ' AND cpup.id_uzytkownika = '.intval($kryteria['id_uzytkownika']).
			' AND cpup.id_pliku = cp.id';
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					mup.tytul LIKE \'%'.$fraza.'%\''
				. ' OR mup.plik LIKE \'%'.$fraza.'%\''
				. ' OR mup.tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND mup.data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) > 0)
		{
			$sql .= ' AND (mup.data_waznosci > NOW() OR mup.data_waznosci IS NULL)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) < 0)
		{
			$sql .= ' AND (mup.data_waznosci < NOW() AND mup.data_waznosci IS NOT NULL)';
		}
		return $this->pobierzWartosc($sql);
	}


	public function szukajIdPliku($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT DISTINCT
		mup.id,
		mup.id_projektu,
		mup.kod_jezyka,
		mup.id_kategorii,
		mup.tytul,
		cp.id as plik,
		mup.tresc,
		mup.autor,
		mup.data_dodania,
		mup.data_waznosci
		 FROM ' . $this->tabela. ' as mup, cms_pliki as cp ';

		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ', cms_pliki_uzytkownicy_powiazania as cpup ';
		}

		$sql .= 'WHERE mup.id_projektu = ' . ID_PROJEKTU
			. ' AND mup.kod_jezyka = \'' . KOD_JEZYKA .'\'
			 AND mup.plik = cp.id';

		if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] != '')
		{
			$sql .= ' AND mup.id_kategorii = '.intval($kryteria['id_kategorii']);
		}
		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ' AND cpup.id_uzytkownika = '.intval($kryteria['id_uzytkownika']).
			' AND cpup.id_pliku = cp.id';
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					mup.tytul LIKE \'%'.$fraza.'%\''
				. ' OR mup.plik LIKE \'%'.$fraza.'%\''
				. ' OR mup.tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND mup.data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) > 0)
		{
			$sql .= ' AND (mup.data_waznosci > NOW() OR mup.data_waznosci IS NULL)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) < 0)
		{
			$sql .= ' AND (mup.data_waznosci < NOW() AND mup.data_waznosci IS NOT NULL)';
		}
		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function szukajPowiazane($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = '
		SELECT DISTINCT
			mup.id,
			mup.id_projektu,
			mup.kod_jezyka,
			mup.id_kategorii,
			mup.tytul,
			cp.url as plik,
			mup.tresc,
			mup.autor,
			mup.data_dodania,
			mup.data_waznosci
		FROM
			'.$this->tabela.' as mup JOIN
			(cms_pliki as cp, cms_pliki_uzytkownicy_powiazania as cpup)
			ON
			(mup.plik = cpup.id_pliku AND cpup.id_pliku = cp.id)
		WHERE
			mup.id_projektu = '.ID_PROJEKTU.' AND
			mup.kod_jezyka = "'.KOD_JEZYKA.'"';

		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ' AND cpup.id_uzytkownika = '.$kryteria['id_uzytkownika'].' ';
		}

		if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] != '')
		{
			$sql .= ' AND mup.id_kategorii = '.intval($kryteria['id_kategorii']);
		}

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					mup.tytul LIKE \'%'.$fraza.'%\''
				. ' OR mup.plik LIKE \'%'.$fraza.'%\''
				. ' OR mup.tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}

		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND mup.data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) > 0)
		{
			$sql .= ' AND (mup.data_waznosci > NOW() OR mup.data_waznosci = NULL)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) < 0)
		{
			$sql .= ' AND (mup.data_waznosci < NOW() AND mup.data_waznosci != NULL)';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function policzPowiazane($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = '
		SELECT DISTINCT
			COUNT(*)
		FROM
			'.$this->tabela.' as mup JOIN
			(cms_pliki as cp, cms_pliki_uzytkownicy_powiazania as cpup)
			ON
			(mup.plik = cpup.id_pliku AND cpup.id_pliku = cp.id)
		WHERE
			mup.id_projektu = '.ID_PROJEKTU.' AND
			mup.kod_jezyka = "'.KOD_JEZYKA.'"';

		if (isset($kryteria['id_uzytkownika']) && $kryteria['id_uzytkownika'] != '')
		{
			$sql .= ' AND cpup.id_uzytkownika = '.$kryteria['id_uzytkownika'].' ';
		}

		if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] != '')
		{
			$sql .= ' AND mup.id_kategorii = '.intval($kryteria['id_kategorii']);
		}

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					mup.tytul LIKE \'%'.$fraza.'%\''
				. ' OR mup.plik LIKE \'%'.$fraza.'%\''
				. ' OR mup.tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}

		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND mup.data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) > 0)
		{
			$sql .= ' AND (mup.data_waznosci > NOW() OR mup.data_waznosci = NULL)';
		}
		if (isset($kryteria['data_waznosci']) && intval($kryteria['data_waznosci']) < 0)
		{
			$sql .= ' AND (mup.data_waznosci < NOW() AND mup.data_waznosci != NULL)';
		}
		return $this->pobierzWartosc($sql);
	}
}
