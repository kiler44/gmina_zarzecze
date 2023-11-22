<?php
namespace Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka;
use Generic\Biblioteka\BazaWyjatek;
use Generic\Model\Kategoria;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiersze konfiguracji.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\WierszKonfiguracji\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_konfiguracja';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_modulu' => 'kodModulu',
		'id_kategorii' => 'idKategorii',
		'id_bloku' => 'idBloku',
		'nazwa' => 'nazwa',
		'typ' => 'typ',
		'wartosc' => 'wartosc',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu');



	/**
	 * typy pol tabeli w bazie
	 * @var array
	 */
	protected $polaTabeliTypy = array(

	);




	function czyscDlaSystemu()
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND kod_modulu IS NULL
			AND id_kategorii IS NULL
			AND id_bloku IS NULL
		';

		return $this->wykonajSql($sql);
	}



	function czyscDlaBloku($id_bloku)
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND id_bloku = ' . intval($id_bloku);


		return $this->wykonajSql($sql);
	}



	function czyscDlaBlokow()
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND id_bloku IS NOT NULL';


		return $this->wykonajSql($sql);
	}



	function czyscDlaWszystkichKategorii()
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND id_kategorii IS NOT NULL';


		return $this->wykonajSql($sql);
	}



	function pobierzSystemowyNazwa($nazwa)
	{
		$sql = 'SELECT * FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND nazwa = \''.addslashes($nazwa).'\'
			AND kod_modulu IS NULL
			AND id_kategorii IS NULL
			AND id_bloku IS NULL
		';

		return $this->pobierzJeden($sql);
	}



	function pobierzPelna()
	{
		$sql = 'SELECT * FROM ' . $this->tabela . '
			WHERE id_projektu = '.ID_PROJEKTU;
		return $this->pobierzWiele($sql);
	}



	function pobierzPoKodzie($kod)
	{
		$cache = Kategoria\MapperCache::wywolaj($this->zwracaTablice);
		if ($cache->dostepny())
		{
			return $cache->pobierzPoKodzie($kod);
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod = \'' . addslashes($kod) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function usunZduplikowaneWpisy($kodJezyka = null)
	{
		$kodJezyka = empty($kodJezyka) ? KOD_JEZYKA : $kodJezyka;

		$sql = 'DELETE FROM ' . $this->tabela . '
			USING ' . $this->tabela . ', ' . $this->tabela . ' AS vtable
			WHERE ' . $this->tabela . '.id_projektu = '.ID_PROJEKTU.'
			AND (' . $this->tabela . '.id > vtable.id)
			AND CONCAT(
				IFNULL(' . $this->tabela . '.kod_modulu, \'\'),
				IFNULL(' . $this->tabela . '.nazwa, \'\'),
				IFNULL(' . $this->tabela . '.id_kategorii, \'\'),
				IFNULL(' . $this->tabela . '.id_bloku, \'\'),
				IFNULL(' . $this->tabela . '.wartosc, \'\')
					) = CONCAT(
				IFNULL(vtable.kod_modulu, \'\'),
				IFNULL(vtable.nazwa, \'\'),
				IFNULL(vtable.id_kategorii, \'\'),
				IFNULL(vtable.id_bloku, \'\'),
				IFNULL(vtable.wartosc, \'\'))';

		$this->baza->zapytanie($sql);
	}



	public function pobierzZduplikowaneWpisy($kodJezyka = null)
	{
		$kodJezyka = empty($kodJezyka) ? KOD_JEZYKA : $kodJezyka;

		$sql = 'SELECT *, COUNT(*) AS ile_wystapien
			FROM ' . $this->tabela . '
			WHERE id_projektu = '.ID_PROJEKTU.'
			GROUP BY id,id_projektu,kod_modulu,id_kategorii,id_bloku,nazwa,wartosc
			HAVING COUNT(*) > 1';

		return $this->pobierzWiele($sql);
	}



	function pobierzDlaSystemu()
	{
		$cache = WierszKonfiguracji\MapperCache::wywolaj($this->zwracaTablice);
		if ($cache->dostepny())
		{
			return $cache->pobierzDlaSystemu();
		}

		$sql = 'SELECT * FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND kod_modulu IS NULL
			AND id_kategorii IS NULL
			AND id_bloku IS NULL
		';

		return $this->pobierzWiele($sql);
	}



	function pobierzDlaBloku($idBloku)
	{
		$sql = 'SELECT * FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND id_bloku = ' . intval($idBloku) . '
		';

		return $this->pobierzWiele($sql);
	}



	function pobierzDlaModuluDomyslna($kodModulu)
	{
		$klasa = 'Generic\\Modul\\' . $kodModulu;
		$modul = new $klasa;
		return $modul->pobierzKonfiguracje();
	}


	function pobierzWierszDlaModuluDomyslna($wiersz, $kodModulu)
	{
		$klasa = 'Generic\\Modul\\' . str_replace('_', '\\', $kodModulu);
		$modul = new $klasa;
		$konfiguracja = $modul->pobierzKonfiguracje();
		return $konfiguracja[$wiersz];
	}



	function pobierzDlaModulu($kodModulu, $idKategorii = null, $idBloku = null)
	{
		$cache = WierszKonfiguracji\MapperCache::wywolaj($this->zwracaTablice);
		if ($cache->dostepny())
		{
			return $cache->pobierzDlaModulu($kodModulu, $idKategorii, $idBloku);
		}
		
		$sql = 'SELECT * FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND kod_modulu = \'' . addslashes($kodModulu) . '\'
		';
		if (!empty($idKategorii) && empty($idBloku))
		{
			$sql .= ' AND (id_kategorii = ' . intval($idKategorii) . ' OR id_kategorii IS NULL)'
			. ' AND id_bloku IS NULL ORDER BY id_kategorii ASC';
		}
		else if (empty($idKategorii) && !empty($idBloku))
		{
			$sql .= ' AND (id_bloku = ' . intval($idBloku) . ' OR id_bloku IS NULL)'
			. ' AND id_kategorii IS NULL ORDER BY id_bloku ASC';
		}
		else
		{
			$sql .= ' AND id_kategorii IS NULL AND id_bloku IS NULL';
		}

		return $this->pobierzWiele($sql);
	}

	function pobierzDlaModuluPelna($kodModulu, $idKategorii = null, $idBloku = null)
	{
		$konfiguracjaDomyslna = $this->pobierzDlaModuluDomyslna($kodModulu, $idKategorii, $idBloku);
		
		$kodModulu = str_replace('\\', '_', $kodModulu);
		$konfiguracjaBaza = $this->zwracaTablice()->pobierzDlaModulu($kodModulu, $idKategorii, $idBloku);
		
		$wierszeKonfiguracjiBaza = array();
		if (!empty($konfiguracjaBaza))
		{
			$wierszeKonfiguracjiBaza = $this->przetworzNaListe($konfiguracjaBaza);
		}
		
		$konfiguracja = array_merge($konfiguracjaDomyslna, $wierszeKonfiguracjiBaza);
		return $konfiguracja;
	}

	function pobierzWierszDlaModulu($wiersz, $kodModulu, $idKategorii = null, $idBloku = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND nazwa = \'' . addslashes($wiersz) . '\'
			AND kod_modulu = \'' . addslashes($kodModulu) . '\'
		';
		if (!empty($idKategorii) && empty($idBloku))
		{
			$sql .= ' AND (id_kategorii = ' . intval($idKategorii) . ' OR id_kategorii IS NULL)'
			. ' AND id_bloku IS NULL ORDER BY id_kategorii DESC';
		}
		else if (empty($idKategorii) && !empty($idBloku))
		{
			$sql .= ' AND (id_bloku = ' . intval($idBloku) . ' OR id_bloku IS NULL)'
			. ' AND id_kategorii IS NULL ORDER BY id_bloku DESC';
		}
		else
		{
			$sql .= ' AND id_kategorii IS NULL AND id_bloku IS NULL';
		}
		// nadpisanie ustawien ogolnych ustawieniami dla kategorii lub bloku
		return $this->pobierzJeden($sql);
	}


	function pobierzWartoscWierszaKonfiguracji($wiersz, $kodModulu, $idKategorii = null, $idBloku = null)
	{
		$domyslna_wartosc = $this->pobierzWierszDlaModuluDomyslna($wiersz, $kodModulu);

		$this->zwracaTablice = true;
		$sql = 'SELECT * FROM ' . $this->tabela . '
			 WHERE id_projektu = ' . ID_PROJEKTU . '
			AND nazwa = \'' . addslashes($wiersz) . '\'
			AND kod_modulu = \'' . addslashes($kodModulu) . '\'';
		//	AND kod_modulu = \'' . addslashes(str_replace('_', '\\', $kodModulu)) . '\'
		
		if (!empty($idKategorii) && empty($idBloku))
		{
			$sql .= ' AND (id_kategorii = ' . intval($idKategorii) . ' OR id_kategorii IS NULL)'
			. ' AND id_bloku IS NULL ORDER BY id_kategorii DESC';
		}
		else if (empty($idKategorii) && !empty($idBloku))
		{
			$sql .= ' AND (id_bloku = ' . intval($idBloku) . ' OR id_bloku IS NULL)'
			. ' AND id_kategorii IS NULL ORDER BY id_bloku DESC';
		}
		else
		{
			$sql .= ' AND id_kategorii IS NULL AND id_bloku IS NULL';
		}
		
		// nadpisanie ustawien ogolnych ustawieniami dla kategorii lub bloku
		$wiersz = $this->pobierzJeden($sql);

		if (is_array($wiersz) && !empty($wiersz))
		{
			if ($wiersz['typ'] == 'array')
			{
				$wiersz['wartosc'] = unserialize($wiersz['wartosc']);
			}
			else
			{
				settype($wiersz['wartosc'], $wiersz['typ']);
			}
			return $wiersz['wartosc'];
		}
		else
		{
			return $domyslna_wartosc;
		}
	}


	public function przetworzNaListe($wiersze)
	{
		$_cfg = array();
		foreach ($wiersze as $wiersz)
		{
			if ($wiersz['typ'] == 'array')
			{
				$wiersz['wartosc'] = unserialize($wiersz['wartosc']);
			}
			else
			{
				settype($wiersz['wartosc'], $wiersz['typ']);
			}
			$_cfg[$wiersz['nazwa']] = $wiersz['wartosc'];
		}
		return $_cfg;
	}



	public function przetworzNaDrzewo($wiersze)
	{
		foreach ($wiersze as $wiersz)
		{
			$kod_modulu = $wiersz['kod_modulu'];
			$id_kategorii = $wiersz['id_kategorii'];
			$id_bloku = $wiersz['id_bloku'];

			if ($wiersz['typ'] == 'array')
			{
				$wiersz['wartosc'] = unserialize($wiersz['wartosc']);
			}
			else
			{
				settype($wiersz['wartosc'], $wiersz['typ']);
			}

			if (!empty($kod_modulu) && empty($id_kategorii) && empty($id_bloku))
			{
				$_cfg['moduly'][$kod_modulu][$wiersz['nazwa']] = $wiersz['wartosc'];
			}
			else if (!empty($kod_modulu) && !empty($id_kategorii) && empty($id_bloku))
			{
				$_cfg['moduly'][$kod_modulu]['kategorie'][$id_kategorii][$wiersz['nazwa']] = $wiersz['wartosc'];
			}
			else if (!empty($kod_modulu) && empty($id_kategorii) && !empty($id_bloku))
			{
				$_cfg['moduly'][$kod_modulu]['bloki'][$id_bloku][$wiersz['nazwa']] = $wiersz['wartosc'];
			}
			else if (empty($kod_modulu) && empty($id_kategorii) && empty($id_bloku))
			{
				$_cfg[$wiersz['nazwa']] = $wiersz['wartosc'];
			}
		}
		return $_cfg;
	}



	public function wyszukajWiersz($wiersz, $kodModulu, $kodJezyka = null)
	{
		$kodJezyka = empty($kodJezyka) ? KOD_JEZYKA : $kodJezyka;

		$sql = 'SELECT * FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND ( nazwa LIKE \'%' . addslashes($wiersz) . '%\' OR wartosc LIKE \'%' . addslashes($wiersz) . '%\')
			AND kod_modulu = \'' . addslashes($kodModulu) . '\'
		';

		return $this->pobierzJeden($sql);
	}



	/*
	 * Usuwa rekord z tabeli
	 *
	 * @param ObiektDanych $obiekt zapisywany obiekt
	 */
	public function usun(ObiektDanych $obiekt)
	{
		parent::usun($obiekt);
		$cache = WierszKonfiguracji\MapperCache::wywolaj($this->zwracaTablice);
		$cache->usun($obiekt);
	}
	
	public function czyscDlaModulu($kodModulu, $idKategorii = null, $idBloku = null)
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND kod_modulu LIKE \'' . addslashes($kodModulu) . '\_%\'
		';
		if (!empty($idKategorii) && empty($idBloku))
		{
			$sql .= ' AND id_kategorii = ' . intval($idKategorii) . ' AND id_bloku IS NULL';
		}
		else if (empty($idKategorii) && !empty($idBloku))
		{
			$sql .= ' AND id_bloku = ' . intval($idBloku) . ' AND id_kategorii IS NULL';
		}
		try
		{
			$this->baza->transakcjaStart();
			$this->baza->zapytanie($sql);
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
