<?php

namespace Generic\Biblioteka\Kreator;

use \Generic\Biblioteka;
use \Generic\Biblioteka\Kreator\Kreator;

/**
 * Zawiera wspólne metody używane przez generatory plików PHP na podstawie tabeli bazy danych.
 * Pozwal na połączenie się z bazą danych i operowanie na niej poprzez Aura.Sql.
 * @author Marek Bar
 */
abstract class KreatorBaza extends Kreator implements Interfejs
{

	/**
	 * Nazwa tabeli
	 * @var string
	 */
	public $nazwaTabeli = '';
   
   
   /**
	 * Nazwa obiektu modelu
	 * @var string
	 */
	public $nazwaObiektuModelu = '';
   

	/**
	 * Odpowiada za stworzenie obiektu do połączenia z bazą.
	 * @var type Aura\Sql\ConnectionFactory
	 */
	private $_aura;

	/**
	 * Zarządza połączeniem z bazą.
	 * @var Aura\Sql\Connection\AbstractConnection
	 */
	private $aura;

	/**
	 * Konfiguracja bazy danych.
	 * @var array
	 */
	private $konfiguracjaBazy;

	/**
	 * Używana baza danych
	 * @var string
	 */
	protected $nazwaBazy = 'st';

	/**
	 * Tablica dostępnych baz danych
	 * @var array
	 */
	private $dostepneBazy = array();

	/**
	 * Zawiera inputowe odpowiedniki typów danych php
	 * @var array
	 */
	private $odpowiednikiInputDlaTypu = array(
		'string' => 'Text',
		'boolean' => 'Checkbox',
		'integer' => 'Text',
		'float' => 'Text',
		'double' => 'Text',
		'enum' => 'Select',
		'datetime' => 'Data',
		'mixed' => 'Text',
	);

	/**
	 * Zawiera filtry odpowiadające typom danych php
	 * @var array
	 */
	private $filtryDlaTypuPola = array(
		'string' => array('strval', 'trim', 'filtr_xss'),
		'boolean' => array('intval', 'abs'),
		'integer' => array('intval'),
		'float' => array('floatval'),
		'double' => array('doubleval'),
		'enum' => array(),
		'datetime' => array('strval', 'trim', 'filtr_xss'),
		'mixed' => array(),
	);

	/**
	 * Zawiera tłumaczenia fragmentów nazwy pola na odpowiedni walidator.
	 * @var array
	 */
	private $tlumaczeniaNaWalidator = array(
		'rok' => 'DataIso',
		'plec' => 'DopuszczalneWartosci',
		'telefon' => 'Telefon',
		'fax' => 'Telefon',
		'komorka' => 'Telefon',
		'www' => 'Url',
		'miasto' => 'KodPocztowy',
	);

	/**
	 * Zawiera tłumaczenia fragmentów nazwy pola na odpowiedni input.
	 * @var array
	 */
	private $odpowiednikiDlaFragmentuTekstu = array(
		'czy' => 'Checkbox',
		'haslo' => 'Password',
		'mapa_' => 'Text',
		'mapa' => 'MapaGoogle',
		'rok' => 'Data',
		'cena' => 'Cena',
		'html' => 'Html',
		'kod_jezyk' => 'Text',
		'kod' => 'KodPocztowy',
		'lista' => 'Lista',
		'jezyk' => 'Select',
		'zgoda' => 'Checkbox',
		'status' => 'Select',
	);

	/**
	 * Zawiera tłumaczenia fragmentów nazwy pola naodpowiedni walidator.
	 * @var array
	 */
	private $fragmentTekstuWalidatory = array(
		'nip' => 'Nip',
		'iban' => 'NrKontaIban',
		'nrb' => 'NrKontaNrb',
		'pesel' => 'Pesel',
		'telefon' => 'Telefon',
		'url' => 'Url',
		'domena' => 'Domena',
		'email' => 'Email',
		'datapl' => 'DataPl',
		'dataiso' => 'DataIso',
		'dataczasiso' => 'DataCzasIso',
		'adresip' => 'AdresIp',
		'captcha' => 'CaptchaText',
		'html' => 'Html',
		'kod_jezyk' => 'NiePuste',
		'kod' => 'KodPocztowy',
		'regon' => 'Regon',
	);

	/**
	 * Odczytany opis danej tabeli.
	 * <b>autoinc</b> - bool - czy pole jest automatycznie zwiększane,<br/>
	 * <b>nazwa</b> - string - nazwa pola kolumny,<br/>
	 * <b>domyslna</b> - string - domyślna wartość,<br/>
	 * <b>typ</b> - string - typ danych w kolumnie,<br/>
	 * <b>liczba_miejsc</b> - int - liczba miejsc dziesiętnych dla typów nietekstowych,<br/>
	 * <b>rozmiar</b> - int,<br/>
	 * <b>czy_klucz</b> - bool - czy kolumna jest częścią klucza,<br/>
	 * <b>czy_nie_puste</b> - bool - czy może być puste<br/>
	 * @var array
	 */
	protected $opisKolumnTabeli;

	/**
	 * Określa czy jest połączenia z bazą danych.
	 * @var bool
	 */
	protected $czyJestPolaczenie = false;

	/**
	 * Tłumaczenia
	 * @var array
	 */
	protected $t = array(
		'brak_konf_bazy' => 'Nie wczytano konfiguracji bazy: ',
		'tytul' => " Podsumowanie:",
		'brak_polaczenia' => 'AuraSql nie może połączyć się z bazą: ',
		'brak_polaczenia2' => 'Brak połączenia z bazą danych ',
		'nie_wczytano_szablonu' => 'Nie wczytano szablonu generowanego pliku.',
		'nie_odczytano_opisu_tabeli' => 'Nie odczytano opisu tabeli: ',
		'szablon_nie_istneje' => 'Szablon nie istnieje: ',
	);

	/**
	 * Nawiązuje połączenia z bazą danych określoną w pliku baza.ini.
	 */
	protected function polacz()
	{
		$this->_aura = new \Aura\Sql\ConnectionFactory();
		$this->inicjujKatalogi();
		if (!$this->wczytajPlikIni())
		{
			$this->log($this->t['brak_konf_bazy'] . $this->nazwaBazy);
			return false;
		}

		$sterownik = $this->konfiguracjaBazy['db_driver'];
		$host = $this->konfiguracjaBazy['db_host'];
		$uzytkownik = $this->konfiguracjaBazy['db_user'];
		$haslo = $this->konfiguracjaBazy['db_password'];
		$nazwaBazy = $this->konfiguracjaBazy['db_name'];
		$port = isset($this->konfiguracjaBazy['db_port']) ? $this->konfiguracjaBazy['db_port'] : '';
		$dsn = 'dbname=' . $nazwaBazy . ';host=' . $host . ';port=' . $port;

		try
		{
			$this->aura = $this->_aura->newInstance(
					$sterownik, $dsn, $uzytkownik, $haslo);
			$this->czyJestPolaczenie = $this->aura != null ? true : false;
		}
		catch (Exception $e)
		{
			$this->log($this->t['brak_polaczenia'] . $this->nazwaBazy);
			$this->log($e->getMessage());
			$this->czyJestPolaczenie = false;
		}
	}



	/**
	 * Wczytuje konfigurację podanej bazy
	 * @return boolean
	 */
	public function wczytajPlikIni()
	{
		$ini = parse_ini_file(CMS_KATALOG . '/baza.ini', true);
		$this->nazwaBazy = $this->nazwaBazy == '' ? 'crm' : $this->nazwaBazy;

		if (!isset($ini['default']))
		{
			$this->czyJestPolaczenie = false;
			return false;
		}
		foreach ($ini as $nazwa => $konfiguracjaBazy)
		{
			if ($nazwa == 'default')
			{
				continue;
			}
			$this->dostepneBazy[] = $nazwa;
		}

		if (!in_array($this->nazwaBazy, $this->dostepneBazy))
		{
			$this->czyJestPolaczenie = false;
			return false;
		}

		$this->konfiguracjaBazy = $ini[$this->nazwaBazy];
		$wymaganePola = array('db_driver', 'db_host', 'db_user', 'db_password', 'db_name', 'db_port');
		foreach ($wymaganePola as $pole)
		{
			if (!isset($this->konfiguracjaBazy[$pole]))
			{
				$this->czyJestPolaczenie = false;
				$this->log('Brak wymaganych pól w pliku baza.ini: ' . $pole);
				return false;
			}
		}

		return true;
	}



	/**
	 * Sprawdza czy podana nazwa jest nazwą bazy.
	 * @param string $nazwaBazy
	 * @return boolean
	 */
	public static function czyBaza($nazwaBazy)
	{
		$ini = parse_ini_file(CMS_KATALOG . '/baza.ini', true);
		$sekcje = array_keys($ini);
		foreach ($sekcje as $sekcja)
		{
			if ($sekcja == 'default')
			{
				continue;
			}
			if ($sekcja == $nazwaBazy)
			{
				return true;
			}
		}
		return false;
	}



	/**
	 * Wyciąga nazwę bazy z podanych propozycji
	 * @param type $propozycje
	 * @return bool
	 */
	public static function zwrocNazweBazy($propozycje)
	{
		$nazwaBazy = 'crm';
		foreach ($propozycje as $propozycja)
		{
			if (strlen($propozycja) > 1)
			{
				if (KreatorBaza::czyBaza($propozycja) === true)
				{
					$nazwaBazy = $propozycja;
					break;
				}
			}
		}
		return $nazwaBazy;
	}



	/**
	 * Sprawdza czy baza istnieje
	 * @param string $nazwa
	 * @return bool
	 */
	public function czyBazaIstnieje($nazwa)
	{
		return in_array($nazwa, $this->dostepneBazy);
	}



	/**
	 * Konwertuje typ odczytany z bazy na typ PHP.
	 * @param string $typ
	 * @return string
	 */
	protected function poprawTypDlaPHPDoc($typ)
	{
		$typ = strtolower($this->parsujTyp(trim(strtolower($typ))));
		if ($typ == 'integer')
		{
			return 'int';
		}
		elseif ($typ == 'boolean')
		{
			return 'bool';
		}
		else
		{
			return $typ;
		}
	}



	/**
	 * Parsuje typ bazy danych na typ PHP<br/>
	 * Zwracany jeden zpodanych: STRING, BOOLEAN, INTEGER, FLOAT, DOUBLE, ENUM, DATETIME, MIXED
	 * @param string $typ
	 * @return string
	 */
	protected function parsujTyp($typ)
	{
		$typyBaza = array(
			'STRING' => array('char', 'character', 'text', 'date', 'timestamp', 'character varying'),
			'BOOLEAN' => array('boolean'),
			'INTEGER' => array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'integer', 'serial', 'bigserial'),
			'FLOAT' => array('decimal', 'float', 'real', 'numeric', 'money'),
			'DOUBLE' => array('double', 'double precision'),
			'ENUM' => array('enum'),
			'DATETIME' => array('datetime', 'timestamp'),
		);

		foreach ($typyBaza as $nazwaTypu => $typySQL)
		{
			if (in_array($typ, $typySQL))
			{
				return $nazwaTypu;
			}
		}
		return 'MIXED';
	}



	/**
	 * Zamienia typ pola bazy danych na odpowiednik typu w PHP.
	 * @param type $typ
	 * @return type
	 */
	protected function poprawTypDlaTypuPolaBazy($typ)
	{
		$typ = trim(strtolower($typ));
		return $this->parsujTyp($typ);
	}



	/**
	 * Zwraca listę typów ENUM dostępnych w bazie danych. Uwaga! Dotyczy tylko PostgreSQL
	 * @return array
	 */
	private function pobierzListeEnumow()
	{
		if ($this->konfiguracjaBazy['db_driver'] == 'pgsql')
		{
			$sqlWyciagajacyEnumy = 'SELECT distinct(pg_type.typname)' .
					'FROM pg_type JOIN pg_enum ' .
					'ON pg_enum.enumtypid = pg_type.oid;';
		}
		return array_keys($this->aura->fetchAssoc($sqlWyciagajacyEnumy));
	}



	/**
	 * Zwraca wartości dla podanego typu ENUM w bazie danych
	 * @param string $array - opis kolumny
	 * @param string $nazwaTabeli - nazwa tabeli w bazie
	 * @return array
	 */
	protected function pobierzWartosciEnuma($opisKolumny, $nazwaTabeli)
	{
		$enum = $opisKolumny['typ'];
		if ($this->konfiguracjaBazy['db_driver'] == 'pgsql')
		{
			if (!in_array($enum, $this->pobierzListeEnumow()))
			{
				return array();
			}
			$sqlWyciagajacyWartosciEnuma = '
            SELECT pg_type.typname AS typ, ' .
					'pg_enum.enumlabel AS wartosc FROM pg_type ' .
					'JOIN pg_enum ON pg_enum.enumtypid = pg_type.oid;';
			$zapytanie = $this->aura->query($sqlWyciagajacyWartosciEnuma);
			if (!$zapytanie->execute())
			{
				return array();
			}
			$wynik = $zapytanie->fetchAll();
			$wartosciEnuma = array();
			foreach ($wynik as $kluczZewnetrzny => $tablicaZewnetrzna)
			{
				$typ = $tablicaZewnetrzna['typ'];
				$wartosc = $tablicaZewnetrzna['wartosc'];
				if ($enum == $typ && !in_array($wartosc, $wartosciEnuma))
				{
					$wartosciEnuma[] = $wartosc;
				}
			}
			$wartosci = array();
			foreach ($wartosciEnuma as $klucz => $wartosc)
			{
				$wartosci[] = $wartosc;
			}
			return $wartosci;
		}
		elseif ($this->konfiguracjaBazy['db_driver'] == 'mysql' && $enum == 'enum')
		{
			$sqlWyciagajacyWartosciEnuma = 'SELECT DISTINCT(COLUMN_TYPE)' .
					' FROM INFORMATION_SCHEMA.COLUMNS' .
					' WHERE TABLE_NAME = \'' . $nazwaTabeli . '\'' .
					' AND COLUMN_NAME = \'' . $opisKolumny['nazwa'] . '\'';

			$zapytanie = $this->aura->query($sqlWyciagajacyWartosciEnuma);

			if (!$zapytanie->execute())
			{
				return array();
			}
			$wynik = $zapytanie->fetchAll();
			$enum = '';
			foreach ($wynik as $kluczZewnetrzny => $tablicaZewnetrzna)
			{
				foreach ($tablicaZewnetrzna as $klucz => $wartosc)
				{
					$enum = $wartosc;
					break;
				}
				break;
			}
			$znakiDoUsuniecia = array('(', ')', 'enum', '\'');
			foreach ($znakiDoUsuniecia as $co)
			{
				$enum = str_replace($co, '', $enum);
			}
			return explode(',', $enum);
		}
		else
		{
			return array();
		}
	}



	/**
	 * Zapisuje wygenerowany kod do docelowego pliku
	 * @param string $nazwaUzytkownika
	 * @param string $nazwaKatalogu
	 * @param string $nazwaPliku
	 * @param string $zawartoscPliku
	 * @param string $czyNadpisac
	 * @return bool
	 */
    protected function zapiszKodDoPliku($nazwaUzytkownika, $nazwaKatalogu, $nazwaPliku, $zawartoscPliku, $czyNadpisac = true)
    {
        $nazwaTabeli = $this->konwertujNaWielblada($this->nazwaTabeli, true);
        $nazwaUzytkownika = $this->konwertujNaWielblada($nazwaUzytkownika, true);
        if ($nazwaUzytkownika != '' && $nazwaUzytkownika != $nazwaTabeli)
        {
            $nazwaTabeli = $nazwaUzytkownika;
        }
        if (empty($zawartoscPliku))
        {
            $this->log('Nie zapisano pliku, ponieważ podano pustą treść.');
            return false;
        }

        $podkatalog = $this->czyPlikMaNazweObiektu ? '' : '/' . $this->nazwaObiektuModelu;
        $katalog = new Biblioteka\Katalog($nazwaKatalogu . $podkatalog, true);
        $sciezkaDoPliku = $nazwaKatalogu . $podkatalog . '/' . $nazwaPliku;
        $plik = new Biblioteka\Plik($sciezkaDoPliku, true);

        if ($plik->istnieje() && $czyNadpisac)
        {
            return $plik->ustawZawartosc($zawartoscPliku);
        }
        else
        {
            $plik = new Biblioteka\Plik($sciezkaDoPliku, true);
            return $plik->ustawZawartosc($zawartoscPliku);
        }
    }



	/**
	 * Pobiera nazwy tabel w bazie danych.
	 * @return array
	 */
	public function pobierzNazwyTabel()
	{
		$wynik = $this->aura->fetchTableList();
		$tabele = array();
		foreach ($wynik as $wartosc)
		{
			$tabelki = explode(".", $wartosc);
			$tabele[] = $this->konfiguracjaBazy['db_driver'] == 'pgsql' ? $tabelki[1] : $tabelki[0];
		}
		return $tabele;
	}



	/**
	 *
	 * @param string $nazwaTabeli
	 * @return bool
	 */
	public function czyTabelaIstnieje($nazwaTabeli)
	{
		return in_array($nazwaTabeli, $this->pobierzNazwyTabel());
	}



	/**
	 * Pobiera opisy kolumn podanej tabeli, gdzie dana kolumna zawiera tablicę ją opisującą:<br/>
	 * <b>autoinc</b> - bool - czy pole jest automatycznie zwiększane,<br/>
	 * <b>nazwa</b> - string - nazwa pola kolumny,<br/>
	 * <b>domyslna</b> - string - domyślna wartość,<br/>
	 * <b>typ</b> - string - typ danych w kolumnie,<br/>
	 * <b>liczba_miejsc</b> - int - liczba miejsc dziesiętnych dla typów nietekstowych,<br/>
	 * <b>rozmiar</b> - int, rozmiar pola<br/>
	 * <b>czy_klucz</b> - bool - czy kolumna jest częścią klucza,<br/>
	 * <b>czy_nie_puste</b> - bool - czy może być puste<br/>
	 * Jeśli zwrócona tabela jest pusta to nie udało się odczytać opisu tabeli lub tabela o podanej nazwie nie istnieje.
	 * @param String $nazwaTabeli
	 * @return Array
	 */
	protected function pobierzOpisTabeli($nazwaTabeli)
	{
		if (!in_array($nazwaTabeli, $this->pobierzNazwyTabel()))
		{
			return array();
		}

		$kolumnyTabeli = $this->aura->fetchTableCols($nazwaTabeli);

		$opisTabeli = array();

		foreach ($kolumnyTabeli as $nazwaKolumny => $obiektKolumna)
		{
			$opisTabeli[$nazwaKolumny] = array(
				'autoinc' => $obiektKolumna->autoinc,
				'nazwa' => $obiektKolumna->name,
				'domyslna' => $obiektKolumna->default,
				'typ' => $obiektKolumna->type,
				'liczba_miejsc' => $obiektKolumna->scale,
				'rozmiar' => $obiektKolumna->size,
				'czy_klucz' => $obiektKolumna->primary,
				'czy_nie_puste' => $obiektKolumna->notnull,
			);
		}
		return $opisTabeli;
	}



	/**
	 * Ustawia plik szablonu potrzebny do wygenerowania pliku PHP.
	 * @param string $nazwaTabeli
	 * @return bool
	 */
	public function inicjuj($nazwaTabeli)
	{
		$this->nazwaTabeli = $nazwaTabeli;
      
      $elementy_nazwy = explode('_', $nazwaTabeli);
      unset($elementy_nazwy[0]);
      $this->nazwaObiektuModelu = $this->konwertujNaWielblada(implode('_', $elementy_nazwy), true);
      
		$this->inicjujKatalogi();
		if (!$this->czyJestPolaczenie)
		{
			$this->log($this->t['brak_polaczenia2'] . $this->nazwaBazy);
			return false;
		}
		if (!$this->inicjujSzablon())
		{
			$this->log($this->t['nie_wczytano_szablonu']);
			return false;
		}

		$this->opisKolumnTabeli = $this->pobierzOpisTabeli($nazwaTabeli);

		if (empty($this->opisKolumnTabeli) || !is_array($this->opisKolumnTabeli))
		{
			$this->log($this->t['nie_doczytano_opisu_tabeli'] . $this->nazwaTabeli);
			return false;
		}

		return true;
	}



	/**
	 * Zwraca obiekt połączenia z bazą
	 * @return Aura\Sql\Connection\AbstractConnection
	 */
	protected function pobierzAura()
	{
		return $this->aura;
	}



	/**
	 * Zwraca typ inputa dla podanego typu tabeli bazy danych
	 * @param array $typKolumny
	 * @return string
	 */
	protected function przetlumaczTypPolaNaInput($opisKolumny)
	{
		$this->utworzListeInputow();

		foreach (array_keys($this->odpowiednikiDlaFragmentuTekstu) as $klucz => $nazwa)
		{
			if ($this->czyKonczyLubZaczynaNa($nazwa, $opisKolumny['nazwa']))
			{
				return $this->odpowiednikiDlaFragmentuTekstu[$nazwa];
			}
			elseif (stripos(strtolower($opisKolumny['nazwa']), $nazwa) != false)
			{
				return $this->odpowiednikiDlaFragmentuTekstu[$nazwa];
			}
		}

		foreach ($this->dostepneInputy as $klucz => $nazwaInputa)
		{
			if (stripos(strtolower($nazwaInputa), strtolower($opisKolumny['nazwa']) != false))
			{
				return $nazwaInputa;
			}
		}

		$typ = strtolower($this->parsujTyp($opisKolumny['typ']));
		if (!in_array($typ, array_keys($this->odpowiednikiInputDlaTypu)))
		{
			return 'Text';
		}
		else
		{
			return $this->odpowiednikiInputDlaTypu[$typ];
		}
	}



	/**
	 * Zwraca tablicę proponowanych filtrów dla danego typu pola lub pustą tablicę
	 * @param string $typKolumny
	 * @return array
	 */
	protected function pobierzFiltryDla($typKolumny, $typInputa)
	{
		$typInputa = strtolower($typInputa);
		$typ = strtolower($this->parsujTyp($typKolumny));
		if (!in_array($typ, array_keys($this->filtryDlaTypuPola)))
		{
			$typ = '';
			switch ($typInputa)
			{
				case 'text':
					{
						$typ = 'string';
					}
					break;
			}
		}
		return $typ == '' ? array() : $this->filtryDlaTypuPola[$typ];
	}



	/**
	 * Zwraca proponowane walidatory dla podanej nazwy pola.
	 * @param array $nazwa
	 * @return array
	 */
	protected function pobierzWalidatoryDla($opisKolumny)
	{
		$nazwa = strtolower($opisKolumny['nazwa']);
		$this->utworzListeWalidatorow();
		$rozmiar = $opisKolumny['rozmiar'];
		$czyNiePuste = $opisKolumny['czy_nie_puste'];
		$proponowaneWalidatory = array();

		foreach ($this->fragmentTekstuWalidatory as $fragmentTekstu => $nazwaWalidatora)
		{
			if ($this->czyKonczyLubZaczynaNa($fragmentTekstu, $nazwa) && !in_array($nazwaWalidatora, $proponowaneWalidatory))
			{
				$proponowaneWalidatory[] = $nazwaWalidatora;
			}
		}
		$enumy = $this->pobierzWartosciEnuma($opisKolumny, $this->nazwaTabeli);
		if ($czyNiePuste && !empty($enumy))
		{
			$walidator = 'DozwoloneWartosci';
			if (!in_array($walidator, $proponowaneWalidatory))
			{
				$proponowaneWalidatory[] = $walidator;
			}
		}
		elseif ($czyNiePuste)
		{
			if (!in_array('NiePuste', $proponowaneWalidatory))
			{
				$proponowaneWalidatory[] = 'NiePuste';
			}
		}
		if ($rozmiar > 0)
		{
			if (!in_array('KrotszeOd', $proponowaneWalidatory))
			{
				$proponowaneWalidatory[] = 'KrotszeOd';
			}
		}

		if ($opisKolumny['czy_nie_puste'] === true)
		{
			$proponowanyWalidator = '';
			switch (strtolower($this->parsujTyp($opisKolumny['typ'])))
			{
				case 'string':
					{
						$proponowanyWalidator = 'NiePuste';
					}
					break;
				case 'integer':
					{
						$proponowanyWalidator = 'LiczbaCalkowita';
					}
					break;
				case 'float':
				case 'double':
					{
						$proponowanyWalidator = 'LiczbaZmiennoprzecinkowa';
					}
					break;
				case 'datetime':
					{
						$proponowanyWalidator = 'DataCzasIso';
					}
					break;
				case 'enum':
					{
						$walidator = 'DozwoloneWartosci';
						$proponowanyWalidator = $walidator;
					}break;
			}
			if (!in_array($proponowanyWalidator, $proponowaneWalidatory))
			{
				$proponowaneWalidatory[] = $proponowanyWalidator;
			}
		}

		foreach ($this->dostepneWalidatory as $klucz => $nazwaWalidatora)
		{
			if (stripos($nazwaWalidatora, $nazwa) != false && !in_array($nazwaWalidatora, $proponowaneWalidatory))
			{
				$proponowaneWalidatory[] = $nazwaWalidatora;
			}
		}

		return $proponowaneWalidatory;
	}



	/**
	 * Sprawdza czy kolumna ma być wymagana w formularzu.
	 * @param array $opisKolumny
	 * @return boolean
	 */
	protected function czyPoleMaBycWymagane($opisKolumny)
	{
		if ($opisKolumny['czy_nie_puste'])
		{
			return true;
		}

		$nazwaKolumny = strtolower($opisKolumny['nazwa']);
		$wymagane = array(
			'login', 'haslo', 'email', 'imie', 'nazwisko',
			'tytul', 'nip', 'nazwa', 'kod', 'typ',
		);

		if (in_array($nazwaKolumny, $wymagane))
		{
			return true;
		}
		else
		{
			foreach ($wymagane as $wartosc)
			{
				if ($nazwaKolumny == $wartosc || $this->czyKonczyLubZaczynaNa($wartosc, $nazwaKolumny))
				{
					return true;
				}
			}
			return false;
		}
	}



	abstract function generuj($nazwaTabeli, $nazwaUzytkownika);

	abstract function pokazPodsumowanie();
}