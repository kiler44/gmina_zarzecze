<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\CmsWyjatek;
use Generic\Biblioteka\Bledy;
use Generic\Biblioteka\Baza;
use Generic\Biblioteka\Sesja;
use Generic\Biblioteka\Kontener;
use Generic\Model\Uzytkownik;


/**
 * Implementacja wzorca Rejestr
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

final class Cms
{

	/**
	 * Przechowuje instancję klasy Singleton
	 *
	 * @var Cms
	 */
	private static $_instancja = false;



	/**
	 * Tlmaczy nazwy blokow w adresie na nazwy klas uslug
	 *
	 * @var array
	 */
	private $_uslugi = array(
		'admin' => 'Admin',
		'ajax' => 'Ajax',
		'http' => 'Http',
		'_private' => 'Download',
		'_public' => 'DownloadPublic',
		'rss' => 'Rss',
		'api' => 'Api',
		'cron' => 'Cron',
		'popup' => 'Popup',
	);



	/**
	 * Przetrzymuje dane ulotne w ramach biezacego zadania
	 *
	 * @var array
	 */
	private $_temp = array();



	/**
	 * Przetrzumuje instancję kontenera przechowujacego mappery
	 *
	 * @var Kontener_Mappery
	 */
	private $dane = null;


	/**
	 * Przetrzymuje obiekt obsługujący błędy
	 *
	 * @var Bledy
	 */
	public $bledy = null;

	/**
	 * Przetrzymuje obiekt obsługujący połączenia z bazami danych
	 *
	 * @var Kontener_PolaczeniaBazDanych
	 */
	public $polaczeniaBazDanych = null;


	/**
	 * Przetrzymuje obiekt obsługujący połączenie z bazą danych
	 *
	 * @var Baza
	 */
	public $baza = null;


	/**
	 * Przetrzymuje obiekt zapewniający obsługę sesji
	 *
	 * @var Sesja
	 */
	public $sesja = null;


	/**
	 * Usługa obsługiwana w bieżącym żądaniu przez cms
	 *
	 * @var Usluga
	 */
	public $usluga = null;


	/**
	 * Przetrzymuje obiekt projektu (strony www)
	 *
	 * @var Projekt
	 */
	public $projekt = null;


	/**
	 * Przetrzymuje tablicę tłumaczeń systemowych
	 *
	 * @var array
	 */
	public $lang = null;


	/**
	 * Przetrzymuje tablicę z konfiguracją systemu
	 *
	 * @var array
	 */
	public $config = null;


	/**
	 * Przetrzymuje identyfikator domyślnej bazy danych
	 *
	 * @var string
	 */
	private $identyfikatorDomyslnejBazy = null;



	private function __construct()
	{
		Cms::$_instancja = $this;
	}



	/**
	 * Zwraca instancje Cms-a
	 *
	 * @return Cms
	 */
	static public function inst()
	{
		if (self::$_instancja === false)
		{
			self::$_instancja = new Cms();
		}
		return self::$_instancja;
	}



	/**
	 * Tą metodą należy domyślnie uruchamiać cms
	 */
	static public function start()
	{
		$cms = Cms::inst();
		$cms->konfiguracjaPlik();
		$cms->tlumaczeniaPlik();
		$cms->wlaczObslugeBledow();
		$cms->ladujUsluge();
		$cms->usluga->start();
	}


	/**
	 * Zwraca konfigurację domyślną cms-a
	 */
	public function konfiguracjaDomyslna()
	{
		return array(
			'sesja' => array
			(
				'nazwaSesji' => 'bkt_login',
				'czasZyciaSesji' => '1800',
				'czasZyciaCiasteczka' => 0,
			),
			'blokady' => array
			(
				'serwis_zabezpieczony_haslem' => 0,
				'tryb_serwisowy' => 0,
				'blokowanie_logowania' => 0,
				'blokowanie_rejestracji' => 0,
				'blokowanie_aktywacji' => 0,
			),
			'bledy' => array
			(
				'logowanie_ekran' => 0,
				'logowanie_plik' => E_ALL,
				'logowanie_email' => 0,
				'logowanie_email_adres' => '',
			),
			'baza' => array
			(
				'nagrywanie_zapytan' => 0,
			),
			'cache' => array(
				'php' => 0,
				'tpl' => 0,
				'baza' => 0,
				'znacznik' => array(
					'html_tresc' => '',
					'data_format' => '',
				),
			),
			'email' => array
			(
				'smtp_host' => '',
				'smtp_port' => '',
				'smtp_user' => '',
				'smtp_pass' => '',
				'smtp_secur' => '', // opcje: '', 'ssl', 'tls'
				'smtp_debug' => 0,
				'from' => '',
				'from_name' => '',
				'img_include' => false, //wysylka obrazkow w mailu jako zalaczniki
				'email_dev' => '',
			),
			'router' => array(
				'blokady' => 0,
				'przekierowania' => 1,
				'wlacz_filtr_url' => 1,
				'caly_serwis_https' => 0,
                'parametry_slownik' => [],
                'parametry_url' => [],
			),
			'superuzytkownik' => array(
				'id' => 0,
				'login' => 'superadmin',
				'imie' => 'Full',
				'nazwisko' => 'Root',
				'jezyk' => 'pl',
				'telKomorkaFirmowa' => '26114123454805',
			),
			'katalogi' => array(
				'aktualnosci' => '/public/aktualnosci/',
				'private_temp' => '/private/temp/',
				'pliki_uzytkownika' => '/private/temp/user_files/',
				'public_temp' => '/public/temp/',
				'public' => '/public/',
				'zdjecia_pracownikow' => '/public/zdjecia/',
				'galeria' => '/public/galeria/',
				'zdjecia_produktow' => '/public/zdjecia_produktow/',
				'miniatury' => '/public/menedzer_plikow/min/',
				'udostepniane_pliki' => '/private/udostepnianepliki/',
				'edytor_graficzny' => '/public/edytor_graficzny/',
				'email_zalaczniki' => '/public/email_zalaczniki/',
				'assign_team' => '/public/assign_team/',
				'get_api_token' => '/public/get_api_token/',
				'orders_import' => '/public/orders_import/',
				'orders_import_grave' => '/public/orders_import/GraveBefaring/',
				'orders_import_homenetvilla' => '/public/orders_import/HomeNetVilla/',
				'orders_import_b2b_befaring' => '/public/orders_import/B2BBefaring/',
				'tidsbanken_metody' => '/private/tidsbanken/',
				'zalaczniki_produkty_magazyn' => '/public/zalaczniki_produkty_magazyn/',
				'produktymagazyn' => '/public/zalaczniki_produkty_magazyn/',
				'orders' => '/public/orders/',
                'zamowieniabm' => '/public/zamowienia/',
				'timelist' => '/public/timelist/',
				'reports' => '/public/reports/',
				'faktura' => '/public/faktura/',
				'trash' => '/public/trash/',
				'raporty_b2b' => '/public/raporty_b2b/',
				'apartamenty_przydzielone' => '/public/apartamenty_przydzielone/',
			),
			'url' => array(
				'aktualnosci' => '/_public/aktualnosci/',
				'private_temp' => '/_private/temp/',
				'pliki_uzytkownika' => '/_private/temp/user_files/',
				'pliki_uzytkownika_baza' => 'temp/user_files/',
				'public_temp' => '/_public/temp/',
				'public' => '/_public/',
				'zdjecia_pracownikow' => '/_public/zdjecia/',
				'galeria' => '/_public/galeria/',
				'zdjecia_produktow' => '/_public/zdjecia_produktow/',
				'miniatury' => '/_public/menedzer_plikow/min/',
				'udostepniane_pliki' => '/_private/udostepnianepliki/',
				'edytor_graficzny' => '/_public/edytor_graficzny/',
				'email_zalaczniki' => '/_public/email_zalaczniki/',
				'orders_import' => '/_public/orders_import/',
				'orders_import_grave' => '/_public/orders_import/GraveBefaring/',
				
				'orders_import_homenetvilla' => '/_public/orders_import/HomeNetVilla/',
				
				'orders_import_b2b_befaring' => '_/public/orders_import/B2BBefaring/',
				'assign_team' => '/_public/assign_team/',
				'tidsbanken_metody' => '/_private/tidsbanken/',
				'zalaczniki_produkty_magazyn' => '/_public/zalaczniki_produkty_magazyn/',
				'produktymagazyn' => '/_public/zalaczniki_produkty_magazyn/',
				'orders' => '/_public/orders/',
                'zamowieniabm' => '/_public/zamowienia/',
				'reports' => '/_public/reports/',
				'raporty_b2b' => '/_public/raporty_b2b/',
				'faktura' => '/_public/faktura/',
				'apartamenty_przydzielone' => '/_public/apartamenty_przydzielone/',
				'trash' => '/_public/trash/',
			),
			'rozdzielanie_wizytowek' => array(
				'automat_wlaczony' => true,
				'okres_wyliczania_statystyk' => '-3 month',
				'godzin_roboczych_dziennie' => 8,
				'uwzgledniaj_weekendy' => true,
				'uwzgledniaj_urlopy' => true,
				'tryb_pracy' => 'czasowy',
				'kody_rol' => array ('otrzymujezad'),
			),
			'cropper' => array(
				'klucz_szyfrowania' => '$up3rtajny t3k$tCr0ppera'
			),
			'bkt_crm' => array(
				'kod_podstawowej_roli' => 'uzytkownik',
			),
			'sms' => array(
                'token' => 'mYe90O9Ei3RF6Wmoct4q5PDciwpaPqug7og4IBmC',
                'tryb_nie_wysylaj_sms' => false,
                'tryb_testowy' => true,
                'numer_testowy_do' => '792820918',
                'nazwa_nadawcy' => 'WEB FLY'
            ),
			'sms_norwegia' => array(
				'tryb_testowy' => '1',
				'tryb_nie_wysylaj_sms' => '0',
				'PSK_numer_testowy_do' => '26114123454805',
				'numer_testowy_do' => '004792419665',
				'PSK_GET' => '26114123450049',
				'PSK_BKT' => '26114123454805',
				'serviceId' => '4805',
				'fromId' => '26114123454805',
				'fromIdPremium' => 'BKT AS',
				'psk_password' => 'r262XU53e2L63y6Paq5A9AMPk38Q78',
			),
			'bkt_cena_za_godzine' => array(
				'ogolna' => 450,
				'budget' => 450,
				'praktykant' => 0,
				'mnoznik_nadgodziny' => '1.4',
			),
			'api' => array(
				'haslo_dostepu' => 'TajneHaslo!@#',
			),
			'bkt_bazy' => array(
				'domyslna' => 'default',
				'bkt_bazy' => array(
					'default' => 'Micheletveien 37B, 1053 OSLO, Norge',
					'ostfold' => 'Høydaveien 17, 1523 Moss, Norge',
				),
			),
            'idp' => array(
                'wlacz_logowanie' => true,
                'host' => 'idp.bktas.no',
                'cert' => '/www/norway/trunk/certs/ldap.crt',
            ),
		);
	}



	/**
	 * Wczytuje konfigurację systemową z pliku (w celu nadpisania podstawowej)
	 */
	public function konfiguracjaPlik()
	{
		$this->config = $this->konfiguracjaDomyslna();
		$konfiguracjaPlik = konfiguracjaCzytajPlik();
		if (isset($konfiguracjaPlik['superuzytkownik'])) unset($konfiguracjaPlik['superuzytkownik']);
		$konfiguracjaTemp = $this->config;
		$this->config = array_replace_recursive($konfiguracjaTemp, $konfiguracjaPlik);
		unset($konfiguracjaTemp);
	}



	/**
	 * Wczytuje konfigurację systemową z bazy danych (w celu nadpisania podstawowej)
	 */
	public function konfiguracjaBaza()
	{
		$config = array();
		if ($this->polaczeniaBazDanych->czyPusty())
		{
			throw new CmsWyjatek('Nie mozna zaladowac konfiguracji z baza danych.');
		}
		$mapper = $this->dane()->WierszKonfiguracji();
		foreach ($mapper->pobierzDlaSystemu() as $wiersz)
		{
			$indeks = explode('.', $wiersz->nazwa);
			$sekcja = array_shift($indeks);
			$klucz = implode('.', $indeks);
			$wartosc = $wiersz->wartosc;
			if ($wiersz->typ == 'array')
				$wartosc = unserialize($wartosc);
			else
				settype($wartosc, $wiersz->typ);
			$config[$sekcja][$klucz] = $wartosc;
		}
		$this->config = array_merge_recursive_distinct($this->config, $config);
	}



	/**
	 * Wczytuje tłumaczenia systemowe z pliku (w celu nadpisania podstawowej)
	 */
	public function tlumaczeniaPlik()
	{
		$this->lang = require_once(CMS_KATALOG.'/lang.inc.php');
	}



	/**
	 * Wczytuje tłumaczenia systemowe z bazy danych (w celu nadpisania podstawowych)
	 */
	public function tlumaczeniaBaza()
	{
		$lang = array();
		if ($this->polaczeniaBazDanych->czyPusty())
		{
			throw new CmsWyjatek('Nie mozna zaladowac konfiguracji z baza danych.');
		}
		$mapper = $this->dane()->WierszTlumaczen();
		
		foreach ($mapper->pobierzDlaSystemu(KOD_JEZYKA_ITERFEJSU) as $wiersz)
		{
			$indeks = explode('.', $wiersz->nazwa);
			$sekcja = array_shift($indeks);
			$klucz = implode('.', $indeks);
			$wartosc = $wiersz->wartosc;
			settype($wartosc, $wiersz->typ);
			$lang[$sekcja][$klucz] = $wartosc;
		}
		$this->lang = array_merge_recursive_distinct($this->lang, $lang);
	}



	/**
	 * Ładuje usługę na podstawie danych z żądania
	 */
	public function ladujUsluge()
	{
		if (PHP_SAPI != 'cli') unset($this->_uslugi['cron']);

		$sciezka = explode('/', strtolower(trim($_SERVER['ST_URL'], "/")));
		if (array_key_exists($sciezka[0], $this->_uslugi))
		{
			$klasaUslugi = 'Generic\\Biblioteka\\Usluga\\'.$this->_uslugi[$sciezka[0]];
		}
		else
		{
			$klasaUslugi = 'Generic\\Biblioteka\\Usluga\\Http';
		}

		//$klasaUslugi = 'Generic\\Biblioteka\\Usluga\\Admin';
		$this->usluga = new $klasaUslugi;
	}



	/**
	 * Zwraca tablicę z kodami i nazwami usług
	 *
	 * @return array
	 */
	public function pobierzUslugi()
	{
		return $this->_uslugi;
	}



	/**
	 * Zwraca kod uslugi do url na podstawie jej nazwy
	 *
	 * @param string $usluga Nazwa uslugi.
	 *
	 * @return string
	 */
	public function pobierzKodUslugi($usluga)
	{
		foreach ($this->_uslugi as $kod => $nazwa)
		{
			if ($usluga == $nazwa) return $kod;
		}
		return false;
	}



	/**
	 * Inicjowanie mechanizmów odpowiedzialnych za obsługę błędów
	 */
	public function wlaczObslugeBledow()
	{
		// Ustawienia mechanizmow przechwytywania bledow i wlaczenie obslugi bledow
		$bledy = new Bledy();
		if ($this->config['bledy']['logowanie_ekran'] > 0)
		{
			$bledy->dodajMechanizm(new Bledy\Logowanie\Ekran($this->config['bledy']['logowanie_ekran']));
		}
		if ($this->config['bledy']['logowanie_plik'] > 0)
		{
			$bledy->dodajMechanizm(new Bledy\Logowanie\Plik($this->config['bledy']['logowanie_plik'], LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-php-error.log'));
		}
		if ($this->config['bledy']['logowanie_email'] > 0)
		{
			$bledy->dodajMechanizm(new Bledy\Logowanie\Email($this->config['bledy']['logowanie_email'], $this->config['bledy']['logowanie_email_adres']));
		}
		$bledy->rejestruj();
		$this->bledy = $bledy;
	}



	/**
	 * Inicjowanie połaczenia z bazą danych
	 */
	public function ladujBazeDanych()
	{
		$cfg = parse_ini_file(CMS_KATALOG.'/baza.ini', true);

		if (isset($cfg['default']))
		{
			$this->identyfikatorDomyslnejBazy = $cfg['default'];
			unset($cfg['default']);
		}
		else
		{
			throw new CmsWyjatek('brak zdefiniowanego domyślnego identyfikatora bazy danych');
		}

		if ($this->polaczeniaBazDanych == null)
		{
			$this->polaczeniaBazDanych = new Kontener\PolaczeniaBazDanych();
		}

		foreach ($cfg as $identyfikatorBazy => $konfiguracjaBazy)
		{
			if ($konfiguracjaBazy['db_driver'] == 'mongodb')
			{
				$this->ladujBazeNoSql($identyfikatorBazy, $konfiguracjaBazy);
			}
			else
			{
				$this->ladujBazeSql($identyfikatorBazy, $konfiguracjaBazy);
			}
		}
	}

	protected function ladujBazeSql($identyfikatorBazy, $konfiguracjaBazy)
	{
		$konfiguracjaBazy['identyfikator_bazy'] = $identyfikatorBazy;
		$baza = new Baza($konfiguracjaBazy, $identyfikatorBazy == $this->identyfikatorDomyslnejBazy);
		if (empty($baza))
		{
			throw new CmsWyjatek('Nie mozna nawiazac polaczenia z baza danych');
		}
		if ($konfiguracjaBazy['db_debug'] == 1)
		{
			$baza = new Baza\Dekorator\LogowanieZapytan($baza, LOGI_KATALOG.'/'.date("Y-m-d").'-sql.log');
		}
		if ($this->config['baza']['nagrywanie_zapytan'] > 0)
		{
			$baza = new Baza\Dekorator\NagrywanieZapytan($baza, LOGI_KATALOG.'/'.date("Y-m-d").'-sql-record.log');
		}

			$baza = new Baza\Dekorator\ObslugaTransakcji($baza, $this->polaczeniaBazDanych);

			$this->polaczeniaBazDanych->wstaw($identyfikatorBazy, $baza);
	}

	protected function ladujBazeNoSql($identyfikatorBazy, $konfiguracjaBazy)
	{
		$konfiguracjaBazy['identyfikator_bazy'] = $identyfikatorBazy;

		$cache = null;
		$logger = null;

		if ($this->config['cache']['baza'])
		{
			$cache = new Mandango\Cache(CACHE_KATALOG . '/bazaNosql');
		}
		if ($konfiguracjaBazy['db_debug'] == 1)
		{
			$logger = Mandango\LogowanieZapytan::pobierz(LOGI_KATALOG.'/'.date("Y-m-d").'-nosql.log', $logger);
		}
		if ($this->config['baza']['nagrywanie_zapytan'] > 0)
		{
			$logger = Mandango\NagrywanieZapytan::pobierz(LOGI_KATALOG.'/'.date("Y-m-d").'-nosql-record.log', $logger);
		}

		$baza = new BazaMongo($konfiguracjaBazy, true, $cache, $logger);
		if (empty($baza))
		{
			throw new CmsWyjatek('Nie mozna nawiazac polaczenia z baza danych');
		}

		$this->polaczeniaBazDanych->wstawNoSql($identyfikatorBazy, $baza);
	}


	/**
	 * Pobranie bazy danych - domyślnie pierwszej
	 * @return Baza
	 */
	public function Baza($identyfikatorBazy = null)
	{
		$identyfikatorBazy = $identyfikatorBazy == null ? $this->identyfikatorDomyslnejBazy : $identyfikatorBazy;

		if ($this->polaczeniaBazDanych->czyIstnieje($identyfikatorBazy))
		{
			return $this->polaczeniaBazDanych->pobierz($identyfikatorBazy);
		}
		else
		{
			throw new CmsWyjatek('Połaczenie z bazą o podanej nazwie nie istnieje');
		}
	}


	/**
	 * Inicjowanie sesji
	 */
	public function rozpocznijSesje()
	{
		$this->sesja = new Sesja($this->config['sesja']);
	}



	/**
	 * Rozpoczyna transakcję systemową obejmujacą wiele baz danych
	 */
	public function transakcjaSystemowaStart()
	{
		$this->polaczeniaBazDanych->transakcjaStart();
	}



	/**
	 * Cofa transakcję systemową obejmujacą wiele baz danych
	 */
	public function transakcjaSystemowaCofnij()
	{
		$this->polaczeniaBazDanych->transakcjaCofnij();
	}



	/**
	 * Potwierdza transakcję systemową obejmujacą wiele baz danych
	 */
	public function transakcjaSystemowaPotwierdz()
	{
		$this->polaczeniaBazDanych->transakcjaPotwierdz();
	}



	/**
	 * Zwraca lub ustawia klucz w wewnetrznej tabeli $_temp
	 *
	 * @param string $klucz Nazwa klucza w cache
	 * @param mixed $wartosc Nowa wartosc dla klucza.
	 *
	 * @return mixed
	 */
	public function temp($klucz, $wartosc = null)
	{
		if ($klucz == '')
			trigger_error('Klucz musi byc niepustym ciagiem tekstowym', E_USER_ERROR);
		if ($wartosc != null) $this->_temp[$klucz] = $wartosc;
		return isset($this->_temp[$klucz]) ? $this->_temp[$klucz] : null;
	}



	/**
	 * Zwraca sciezke na dysku odpowiadajaca podanemu kluczowi
	 *
	 * @param string $klucz Nazwa klucza przyporzadkowanego do katalogu
	 *
	 * @return string
	 */
	public function katalog($klucz)
	{
		$parametry = func_get_args();
		array_shift($parametry);
		if (array_key_exists($klucz, $this->config['katalogi']))
		{
			foreach ($parametry as $parametr)
			{
				if (trim($parametr) == '') throw new CmsWyjatek('Podano pusty parametr przy budowie sciezki dla klucza "'.$klucz.'"');
			}
			if ($klucz == 'wizytowki_zdjecia' || $klucz == 'wizytowki_pliki')
			{
				if (count($parametry) < 1) throw new CmsWyjatek('Brak wymaganego parametru identyfikatora katalogu dla klucza "'.$klucz.'"');
				return TEMP_KATALOG.sprintf($this->config['katalogi'][$klucz], $parametry[0]);
			}
			elseif ($klucz == 'wizytowki_materialy')
			{
				if (count($parametry) < 2) throw new CmsWyjatek('Brak wymaganego paramertu identyfikatora dla klucza "'.$klucz.'"');
				return TEMP_KATALOG.sprintf($this->config['url'][$klucz], $parametry[0], $parametry[1]);
			}
			//nowy format: ../0/578/zdjecie1.jpg, ../2/2231/zdjecie1.jpg
			elseif ($klucz == 'ogloszenia' && isset($parametry[0]))
			{
				$prefix = floor((int)$parametry[0] / 1000);
				return TEMP_KATALOG.$this->config['katalogi'][$klucz].$prefix.'/'.$parametry[0].'/';
			}
			$katalog = TEMP_KATALOG.$this->config['katalogi'][$klucz];
			if (count($parametry) > 0) $katalog .= implode('/',$parametry).'/';
			return $katalog;
		}
		else
		{
			throw new CmsWyjatek('Katalog dla klucza "'.$klucz.'" nie jest dopisany w konfiguracji');
		}
	}



	/**
	 * Zwraca url w serwisie odpowiadajacy podanemu kluczowi
	 *
	 * @param string $klucz Nazwa klucza przyporzadkowanego do adresu url
	 *
	 * @return string
	 */
	public function url($klucz)
	{
		$parametry = func_get_args();
		array_shift($parametry);
		if (array_key_exists($klucz, $this->config['url']))
		{
			if ($klucz == 'wizytowki_zdjecia' || $klucz == 'wizytowki_pliki')
			{
				if (count($parametry) < 1) throw new CmsWyjatek('Brak wymaganego paramertu identyfikatora dla klucza "'.$klucz.'"');
				return sprintf($this->config['url'][$klucz], $parametry[0]);
			}
			elseif ($klucz == 'wizytowki_materialy')
			{
				if (count($parametry) < 2) throw new CmsWyjatek('Brak wymaganego paramertu identyfikatora dla klucza "'.$klucz.'"');
				return sprintf($this->config['url'][$klucz], $parametry[0], $parametry[1]);
			}
			//nowy format: ../0/578/zdjecie1.jpg, ../2/2231/zdjecie1.jpg
			elseif ($klucz == 'ogloszenia')
			{
				$prefix = floor((int)$parametry[0] / 1000);
				return $this->config['url'][$klucz].$prefix.'/'.$parametry[0].'/';
			}
			elseif ($klucz == 'orders')
			{
				if (count($parametry) < 1) throw new CmsWyjatek('Brak wymaganego paramertu identyfikatora dla klucza "'.$klucz.'"');
				$url = $this->config['url'][$klucz];
				if (count($parametry) > 0) $url .= implode('/',$parametry).'';
				return $url;
			}
			
			$url = $this->config['url'][$klucz];
			if (count($parametry) > 0) $url .= implode('/',$parametry);//.'/';
			return $url;
		}
		else
		{
			throw new CmsWyjatek('Url dla klucza "'.$klucz.'" nie jest dopisany w konfiguracji');
		}
	}



	/**
	 * Zwraca instancje kontenera przechowującego mappery
	 *
	 * @return \Generic\Biblioteka\Kontener\Mappery
	 */
	public function dane()
	{
		if ($this->dane == null)
		{
			$this->dane = new Kontener\Mappery();
		}
		return $this->dane;
	}



	/**
	 * Zwraca profil zalogowanego uzytkownika
	 *
	 * @param string $nazwa Nazwa profilu, standardowo domyslny
	 *
	 * @return \Generic\Model\Uzytkownik\Obiekt
	 */
	public function profil($nazwa = 'domyslny')
	{
		switch ($nazwa)
		{
			case 'domyslny':
				return (isset($this->sesja->uzytkownik)) ? $this->sesja->uzytkownik : null;
			break;

			case 'pracownikBok':
				return (isset($this->sesja->pracownikBok)) ? $this->sesja->pracownikBok : null;
			break;

			default:
				return ($this->sesja->uzytkownik instanceof Uzytkownik\Obiekt && $this->sesja->uzytkownik->maRole(array($nazwa))) ? $this->sesja->uzytkownik : null;
			break;
		}
		return null;
	}

}

class CmsWyjatek extends \Exception {}
