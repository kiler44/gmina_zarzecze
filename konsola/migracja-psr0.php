<?php

//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
//require_once 'cli-cms.inc.php';

/*
 * Parametry uruchomieniowe:
 *
 * strukturaPlikow - generuje strukturę plików
 * mapowanieKlas - modyfikuje tresc plikow do standardu psr0
 *
 */

$mapowanieNazwModel = array(
	'Aktualnosci' => 'Aktualnosc',
	'ArtykulyUzytkownikow' => 'ArtykulUzytkownika',
	'Bloki' => 'Blok',
	'BlokiMenu' => 'BlokMenu',
	'BlokiOpisowe' => 'BlokOpisowe',
	'Dokumenty' => 'Dokument',
	'DokumentySzablony' => 'DokumentSzablon',
	'DostepneModuly' => 'DostepnyModul',
	'EmaileFormatki' => 'EmailFormatka',
	'EmaileSzablony' => 'EmailSzablon',
	'EmaileWpisyKolejki' => 'EmailWpisKolejki',
	'FirmyPozyskane' => 'FirmaPozyskana',
	'FormularzKontaktowyTematy' => 'FormularzKontaktowyTemat',
	'FormularzKontaktowyWiadomosci' => 'FormularzKontaktowyWiadomosc',
	'Galerie' => 'Galeria',
	'GalerieZdjecia' => 'GaleriaZdjecia',
	'JezykiProjektu' => 'JezykProjektu',
	'KanalyRss' => 'KanalRss',
	'Kategorie' => 'Kategoria',
	'KategorieMapperCache' => 'KategoriaMapperCache',
	'KategorieOgloszen' => 'KategoriaOgloszen',
	'KategorieOgloszenNowe' => 'KategoriaOgloszenNowa',
	'KategorieOgloszenPowiazania' => 'KategoriaOgloszenPowiazanie',
	'KategorieOgloszenPowiazaniaNowe' => 'KategoriaOgloszenPowiazanieNowe',
	'KategorieStareNowe' => 'KategoriaStaraNowa',
	'Klienci' => 'Klient',
	'KontaBankowe' => 'KontoBankowe',
	'Logi' => 'Log',
	'Notatki' => 'Notatka',
	'Obserwatory' => 'Obserwator',
	'OfertySphinx' => 'OfertaSphinx',
	'Ogloszenia' => 'Ogloszenie',
	'OgloszeniaPromowane' => 'OgloszeniePromowane',
	'OgloszeniaPrzypisywanie' => 'OgloszeniePrzypisywanie',
	'Ogloszenia' => 'Ogloszenie',
	'OgloszeniaSphinx' => 'OgloszenieSphinx',
	'OgloszeniaUzupelnienia' => 'OgloszenieUzupelnienie',
	'PlatnosciHistoria' => 'PlatnoscHistoria',
	'Platnosci' => 'Platnosc',
	'PlikiPrywatne' => 'PlikPrywatny',
	'PlikiPrywatneRolePowiazania' => 'PlikPrywatnyRolaPowiazanie',
	'PlikiPrywatneUzytkownicyPowiazania' => 'PlikPrywatnyUzytkownikPowiazanie',
	'Powiazania' => 'Powiazanie',
	'PowiazaniaTypy' => 'PowiazanieTypy',
	'Produkty' => 'Produkt',
	'ProduktyZakupione' => 'ProduktZakupiony',
	'Projekty' => 'Projekt',
	'RaportyEdytowalne' => 'RaportEdytowalny',
	'RegulyRoutingu' => 'RegulaRoutingu',
	'Role' => 'Rola',
	'RoleUprawnieniaAdministracyjne' => 'RolaUprawnienieAdministracyjne',
	'RoleUprawnienia' => 'RolaUprawnienie',
	'StronyOpisowe' => 'StronaOpisowa',
	'Tlumaczenia' => 'Tlumaczenie',
	'UkladyStron' => 'UkladStrony',
	'UprawnieniaAdministracyjne' => 'UprawnienieAdministracyjne',
	'Uprawnienia' => 'Uprawnienie',
	'UrlopyPracownikow' => 'UrlopPracownika',
	'Urlopy' => 'UrlopPracownika',
	'Uzytkownicy' => 'Uzytkownik',
	'UzytkownicyRole' => 'UzytkownikRola',
	'UzytkownicySuperads' => 'UzytkownikSuperads',
	'UzytkownicySuperwebsite' => 'UzytkownikSuperwebsite',
	'WiadomosciBranzoweOdczytane' => 'WiadomoscBranzowaOdczytana',
	'Wiadomosci' => 'Wiadomosc',
	'Widoki' => 'Widok',
	'WizytowkiBranze' => 'WizytowkaBranza',
	'WizytowkiDoswiadczenie' => 'WizytowkaDoswiadczenie',
	'WizytowkiHistoria' => 'WizytowkaHistoria',
	'WizytowkiLokalizacje' => 'WizytowkaLokalizacja',
	'Wizytowki' => 'Wizytowka',
	'WizytowkiMaterialy' => 'WizytowkaMaterial',
	'WizytowkiObciazeniaPracownikow' => 'WizytowkaObciazeniePracownika',
	'WizytowkiPliki' => 'WizytowkaPlik',
	'WizytowkiPrzypisywanie' => 'WizytowkaPrzypisywanie',
	'WizytowkiSeo' => 'WizytowkaSeo',
	'WizytowkiSphinx' => 'WizytowkaSphinx',
	'WizytowkiStrony' => 'WizytowkaStrona',
	'WizytowkiUmiejetnosci' => 'WizytowkaUmiejetnosc',
	'WizytowkiWyksztalcenie' => 'WizytowkaWyksztalcenie',
	'ZadaniaCykliczne' => 'ZadanieCykliczne',
);

$listaKatalogow = array();
$plikiDoPrzeniesienia = array();
$namespacePlikowKlas = array();
$namespaceKlas = array();
$stareNoweKlasy = array();
$plikiKlasy = array();
$plikiExtends = array();

$podmianaKlasyNamespacy = array();



function Wykonaj($polecenie)
{
	exec($polecenie);
}


function przetworzDoPsr0($vendor, $katalogZrodlo, $katalogDocelowy, $czyModel = false)
{
	global $mapowanieNazwModel;
	global $listaKatalogow;
	global $plikiDoPrzeniesienia;
	global $namespacePlikowKlas;
	global $namespaceKlas;
	global $stareNoweKlasy;
	global $plikiKlasy;

	$plikiBiblioteki = glob_recur('*', 0, CMS_KATALOG.'/' . $katalogZrodlo . '/');

	foreach ($plikiBiblioteki as $plik)
	{
		$sciezkaOryginalna = str_replace(CMS_KATALOG.'/', '', $plik);
		$sciezkaNowa = 'lib/' . $vendor . '/' . str_replace(array('.class.php', $katalogZrodlo . '/'), array('.php', $katalogDocelowy . '/'), $sciezkaOryginalna);

		$nazwaKlasyOryginalna = str_replace(array('/', '.php', '.class', $katalogZrodlo . '_'), array('_', '', '', ''), $sciezkaOryginalna);
		$nazwaKlasyNowaPelna = explode('_', $vendor . '_' . $katalogDocelowy . '_' . $nazwaKlasyOryginalna);
		$nazwaKlasyNowa = $nazwaKlasyNowaPelna[count($nazwaKlasyNowaPelna) - 1];

		$nameSpaceNowyTablica = $nazwaKlasyNowaPelna;
		unset($nameSpaceNowyTablica[count($nameSpaceNowyTablica) - 1]);
		$namespaceNowy = implode('\\', $nameSpaceNowyTablica);

		//latka na moduly
		if ($katalogDocelowy == 'Modul')
		{
			$nazwaKlasyOryginalna = 'Modul_' . $nazwaKlasyOryginalna;
		}

		if ($czyModel)
		{
			$nazwaBazowa = str_replace(array( 'MapperCache', 'Mapper', 'Sorter'), '', $nazwaKlasyNowa);

			$nazwaKlasyNowa = str_replace($nazwaBazowa, '', $nazwaKlasyNowa);

			$nazwaBazowaNowa = isset($mapowanieNazwModel[$nazwaBazowa]) ? $mapowanieNazwModel[$nazwaBazowa] : $nazwaBazowa;

			if ($nazwaKlasyNowa == '')
			{
				$sciezkaNowa = str_replace($nazwaBazowa, $nazwaBazowaNowa . '/Obiekt', $sciezkaNowa);
				$nazwaKlasyNowa = 'Obiekt';
			}
			else
			{
				$sciezkaNowa = str_replace($nazwaBazowa, $nazwaBazowaNowa . '/', $sciezkaNowa);
			}

			$namespaceNowy .= '\\' . $nazwaBazowaNowa;

		}

		$listaKatalogow[] = str_replace('\\', '/', $namespaceNowy);
		if (is_file($plik))
		{
			$plikiDoPrzeniesienia[$plik] = CMS_KATALOG . '/' . $sciezkaNowa;
		}

	}
}

/**
 * Skrypt pobiera wszystkie nazwy plików i klas w nich zawartych i przedstawia
 * proponowane zmiany po wprowadzeniu PSR-0.
 */

function glob_recur($pattern='*', $flags = 0, $path = '')
{
	$paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
	$files = glob($path.$pattern, $flags);
	foreach ($paths as $path) {
		$files = array_merge($files, glob_recur($pattern, $flags, $path));
	}
	return $files;
}

$modyfikacjaNazwKatalogowGlownych = array(
	'biblioteki' => 'Biblioteka',
	'dane' => 'Model',
	'moduly' => 'Modul',
);


// ================ Zbudowanie mapowania polozenia plikow =================== //

$vendor = 'Generic';
$katalogBibliotek = '/lib';
przetworzDoPsr0($vendor, 'biblioteki', 'Biblioteka');
przetworzDoPsr0($vendor, 'moduly', 'Modul');
przetworzDoPsr0($vendor, 'dane', 'Model', true);

// ======================== STRUKTURA KATALOGOW ============================= //
if (in_array('strukturaPlikow', $argv))
{

	$listaKatalogow = array_unique($listaKatalogow);

	if ($katalogBibliotek != '')
	{
		Wykonaj('svn mkdir ' . CMS_KATALOG . $katalogBibliotek);
	}

	Wykonaj('svn mkdir ' . CMS_KATALOG . $katalogBibliotek . '/' . $vendor);
	//Wykonaj('svn mkdir ' . CMS_KATALOG . $katalogBibliotek . '/' . $vendor . '/Biblioteka');
	//Wykonaj('svn mkdir ' . CMS_KATALOG . $katalogBibliotek . '/' . $vendor . '/Modul');
	Wykonaj('svn mkdir ' . CMS_KATALOG . $katalogBibliotek . '/' . $vendor . '/Model');

	//Tworzę strykturę katalogow
	foreach ($listaKatalogow as $katalog)
	{
		Wykonaj('svn mkdir ' . CMS_KATALOG . $katalogBibliotek . '/' . $katalog);
	}

	//przenoszę pliki w svn do nowego drzewa
	foreach ($plikiDoPrzeniesienia as $zrodlo => $cel)
	{
		Wykonaj('svn copy ' . $zrodlo . ' ' . $cel);
	}
}
// ======================== STRUKTURA KATALOGOW ============================= //



$klasyZewnetrzne = array(
	'PDO', 'PDOException', 'Exception', 'SplObserver', 'IteratorAggregate',
	'ArrayIterator', 'ArrayAccess', 'Countable', 'Iterator', 'DateTime', 'Blitz',
	'DOMDocument', 'Memcached', 'Imagick', 'ImagickPixel', 'ImagickDraw',
	'SimpleXMLElement', 'SplSubject', 'DateTimeZone', 'ZipArchive',
	'RecursiveDirectoryIterator', 'Spreadsheet_Excel_Writer',
	'RecursiveIteratorIterator',

);



// =============================== MAPOWANIE KLAS =========================== //
$uzyteKlasyZewnetrzne = array();
if (in_array('mapowanieKlas', $argv))
{
	utworzMapeKlas();


}
// =============================== MAPOWANIE KLAS =========================== //

function utworzMapeKlas()
{
	global $plikiDoPrzeniesienia;

	$plikiBiblioteki = glob_recur('*.php', 0, CMS_KATALOG.'/biblioteki/');
	$plikiBiblioteki = array_merge(glob_recur('*.php', 0, CMS_KATALOG.'/moduly/'), $plikiBiblioteki);
	$plikiBiblioteki = array_merge(glob_recur('*.php', 0, CMS_KATALOG.'/dane/'), $plikiBiblioteki);

	foreach ($plikiBiblioteki as $plik)
	{
		$plikKlasy = new Plik($plik);
		$zawartoscNowa = podmienKlasyWPliku($plikKlasy->pobierzZawartosc());

		if (isset($plikiDoPrzeniesienia[$plik]))
		{
			$plikZapisu = new Plik($plikiDoPrzeniesienia[$plik]);
			if ( ! $plikZapisu->ustawZawartosc($zawartoscNowa))
			{
				trigger_error('Blad zapisu pliku: ' . $plikiDoPrzeniesienia[$plik]);
			}
		}
		else
		{
			trigger_error('Nie wiem gdzie zapisac plik: ' . $plik);
		}
	}

}


function symulujAutoloader($nazwaKlasy)
{
	$plik = str_replace('_', '/', $nazwaKlasy);
	$sciezka = false;

	// inaczej traktujemy moduly a inaczej pozostale biblioteki
	if (strpos($nazwaKlasy, 'Modul_') === false || in_array($nazwaKlasy, array('Modul_Admin', 'Modul_Http', 'Modul_Rss', 'Modul_Cron', 'Modul_System')))
	{
		//katalogi do przeszukiwania plikow bibliotek
		foreach (array('/biblioteki/', '/dane/') as $katalog)
		{
			$sciezka = CMS_KATALOG.$katalog.$plik.'.class.php';
			if ( ! is_file($sciezka)) $sciezka = false; else break;
		}
	}
	else
	{
		$sciezka = CMS_KATALOG.'/moduly/'.str_replace('Modul/', '', $plik).'.php';
		if (!is_file($sciezka)) $sciezka = false;
	}

	if ($sciezka)
	{
		listaPlikow($nazwaKlasy, $sciezka);
		return $sciezka;
	}
}

function podmienKlasyWPliku($zawartosc)
{
	global $klasyZewnetrzne;
	global $mapowanieNazwModel;

	$uzyteKlasy = array();
	$klasyWPliku = array();
	$dziedziczenieWPliku = array();
	$thisDane = array();
	$obiektWMapperze = array();

	$tokeny = token_get_all($zawartosc);

	$pomijajDoKlucza = -1;

	foreach ($tokeny as $klucz => $token)
	{
		if ($pomijajDoKlucza > $klucz)
		{
			continue;
		}

		if (is_array($token) && $token[0] == 307)
		{
			if (($token[1] == ucfirst($token[1]) && $token[1] != strtoupper($token[1]) && str_cut($token[1], 1, false) != '_') || in_array($token[1], $klasyZewnetrzne, true))
			{
				if ($klucz > 1 && is_array($tokeny[$klucz - 1]) && (
						$tokeny[$klucz - 1][1] == '->' || $tokeny[$klucz - 1][1] == '::' || (is_array($tokeny[$klucz - 2]) && $tokeny[$klucz - 2][1] == 'function')
						))
				{
					continue;
				}

				$zapiszKlase = true;

				if ($klucz > 1 && is_array($tokeny[$klucz - 2]))
				{
					if ($tokeny[$klucz - 2][1] == 'class')
					{
						$klasyWPliku[$klucz] = $token[1];
						$zapiszKlase = false;
					}
					if ($tokeny[$klucz - 2][1] == 'interface')
					{
						$klasyWPliku[$klucz] = $token[1];
						$zapiszKlase = false;
					}

					if ($tokeny[$klucz - 2][1] == 'extends')
					{
						$dziedziczenieWPliku[$klucz] = $token[1];
						$zapiszKlase = false;
					}
				}

				if ($zapiszKlase)
				{
					$uzyteKlasy[$klucz] = $token[1];
				}

			}

			if ($klucz > 2 && is_array($token) && $token[1] == 'dane' && $tokeny[$klucz + 1] == '(' && $tokeny[$klucz + 2] == ')' && is_array($tokeny[$klucz - 1]) && $tokeny[$klucz - 1][1] == '->' && is_array($tokeny[$klucz + 4]) )
			{
				if (substr($tokeny[$klucz + 4][1], 0, 1) != '$')
				{
					$thisDane[$klucz + 4] = $tokeny[$klucz + 4][1];
				}
			}
		}


		if (is_array($token) && $token[0] == 309 && $token[1] == '$zwracanyObiekt' && is_array($tokeny[$klucz + 4]) && substr($tokeny[$klucz + 4][1], 0, 1) == '\'' && $tokeny[$klucz + 4][0] = 315)
		{
			$obiektWMapperze[$klucz + 4] = str_replace('\'', '', $tokeny[$klucz + 4][1]);
		}


		if (is_array($token) && $token[1] == 'implements')
		{
			while($tokeny[$klucz] != '{')
			{
				++$klucz;
				if (is_array($tokeny[$klucz]) && $tokeny[$klucz][0] == 307)
				{
					$dziedziczenieWPliku[$klucz] = $tokeny[$klucz][1];
					if (isset($uzyteKlasy[$klucz]))
					{
						unset($uzyteKlasy[$klucz]);
					}
				}
			}
			$pomijajDoKlucza = $klucz;
		}
	}

	$namespace = '';
	$use = array();

	// Poleciec po tablicy klasyWPliku i zmienic nazwy klas. Przygotowac Namespace.

	foreach ($klasyWPliku as $klucz => $wartosc)
	{
		$klasaInfo = okreslInfoKlasy($wartosc);
		$namespace = $klasaInfo['namespace'];
		$tokeny[$klucz][1] = $klasaInfo['nowaNazwa'];
	}

	// Poleciec po tablicy dziedziczenieWPliku i zmienic nazwy klas. Przygotowac Use.

	foreach ($dziedziczenieWPliku as $klucz => $wartosc)
	{
		$klasaInfo = okreslInfoKlasy($wartosc);
		$use[] = $klasaInfo['use'];
		$tokeny[$klucz] = $klasaInfo['nowaNazwaUzycie'];
	}

	// Poleciec po tablicy uzyteKlasy i zmienic nazwy klas. Przygotowac Use.

	foreach ($uzyteKlasy as $klucz => $wartosc)
	{
		$klasaInfo = okreslInfoKlasy($wartosc);
		if ($klasaInfo['use'] != '')
		{
			$use[] = $klasaInfo['use'];
		}
		$tokeny[$klucz] = $klasaInfo['nowaNazwaUzycie'];
	}

	//Poprawic $this->dane()->...
	foreach ($thisDane as $klucz => $wartosc)
	{
		if (isset($mapowanieNazwModel[$wartosc]))
		{
			$tokeny[$klucz][1] = $mapowanieNazwModel[$wartosc];
		}
	}

	//Zamienic $zwracanyObiekt w mapperach
	foreach ($obiektWMapperze as $klucz => $wartosc)
	{
		if ($wartosc != '')
		{
			$tokeny[$klucz][1] = '\'Generic\\Model\\' . $wartosc . '\\Obiekt\'';
		}
	}

	// Porownac Use i Namespace. Przygotowac unikalna listę i dopisac do pliku.

	$use = array_unique($use);

	$doWstawienia = 'namespace ' . $namespace . ";\n";

	foreach($use as $klucz => $wartosc)
	{
		if ($wartosc == '') continue;

		$doWstawienia .= 'use ' . $wartosc . ";\n";
	}

	//zwrocic zawartosc.

	$nowaZawartosc = '';
	foreach ($tokeny as $token)
	{
		if (is_array($token))
		{
			$nowaZawartosc .= $token[1];
		}
		else
		{
			$nowaZawartosc .= $token;
		}
	}

	$nowaZawartosc = str_replace('<?php', "<?php\n" . $doWstawienia, $nowaZawartosc);

	return $nowaZawartosc;

}

/**
 * Zwraca tablicę zawierającą nową nazwę klasy oraz wartosci namespace oraz use
 */
function okreslInfoKlasy($nazwaKlasy)
{
	global $plikiDoPrzeniesienia;
	global $katalogBibliotek;
	global $klasyZewnetrzne;

	$klasySpecjalne = array(
		'UkladStronyWyjatek' => array(
			'nowaNazwa' => 'UkladStronyWyjatek',
			'namespace' => 'Generic\\Model\\UkladStrony',
		),
		'BazaWyjatek' => array(
			'nowaNazwa' => 'BazaWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'CmsWyjatek' => array(
			'nowaNazwa' => 'CmsWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'FacebookException' => array(
			'nowaNazwa' => 'FacebookException',
			'namespace' => 'Generic\\Biblioteka',
		),
		'FormularzWyjatek' => array(
			'nowaNazwa' => 'FormularzWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'Entry' => array(
			'nowaNazwa' => 'Entry',
			'namespace' => 'Generic\\Biblioteka',
		),
		'GoogleAuth' => array(
			'nowaNazwa' => 'GoogleAuth',
			'namespace' => 'Generic\\Biblioteka',
		),
		'GoogleWebmasterTool' => array(
			'nowaNazwa' => 'GoogleWebmasterTool',
			'namespace' => 'Generic\\Biblioteka',
		),
		'Keywords' => array(
			'nowaNazwa' => 'Keywords',
			'namespace' => 'Generic\\Biblioteka',
		),
		'ManagingSitemaps' => array(
			'nowaNazwa' => 'ManagingSitemaps',
			'namespace' => 'Generic\\Biblioteka',
		),
		'CrawlIssues' => array(
			'nowaNazwa' => 'CrawlIssues',
			'namespace' => 'Generic\\Biblioteka',
		),
		'ManagingSites' => array(
			'nowaNazwa' => 'ManagingSites',
			'namespace' => 'Generic\\Biblioteka',
		),
		'InputWyjatek' => array(
			'nowaNazwa' => 'InputWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'KatalogWyjatek' => array(
			'nowaNazwa' => 'KatalogWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'MapperWyjatek' => array(
			'nowaNazwa' => 'MapperWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'ModulWyjatek' => array(
			'nowaNazwa' => 'ModulWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'ObiektDanychWyjatek' => array(
			'nowaNazwa' => 'ObiektDanychWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'TablicaObiektWyjatek' => array(
			'nowaNazwa' => 'TablicaObiektWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'PlikWyjatek' => array(
			'nowaNazwa' => 'PlikWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'SterownikWyjatek' => array(
			'nowaNazwa' => 'SterownikWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'SzablonWyjatek' => array(
			'nowaNazwa' => 'SzablonWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'TabelaDanychWyjatek' => array(
			'nowaNazwa' => 'TabelaDanychWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'TabelaDanychWyjatek' => array(
			'nowaNazwa' => 'TabelaDanychWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'UslugaWyjatek' => array(
			'nowaNazwa' => 'UslugaWyjatek',
			'namespace' => 'Generic\\Biblioteka',
		),
		'Facebook_OpenGraphException' => array(
			'nowaNazwa' => 'OpenGraphException',
			'namespace' => 'Generic\\Biblioteka\\Facebook',
		),
		'Pomocnik_Poczta_Wyjatek' => array(
			'nowaNazwa' => 'PocztaWyjatek',
			'namespace' => 'Generic\\Biblioteka\\Poczta',
		),
		'Sorter' => array(
			'nowaNazwa' => 'Sorter',
			'namespace' => 'Generic\\Biblioteka',
			'use' => 'Generic\\Biblioteka',
			'nowaNazwaUzycie' => 'Biblioteka\\Sorter',
		),
		'Mapper_Baza' => array(
			'nowaNazwa' => 'Baza',
			'namespace' => 'Generic\\Biblioteka\\Mapper',
			'use' => 'Generic\\Biblioteka',
			'nowaNazwaUzycie' => 'Biblioteka\\Mapper\\Baza',
		),
		'Mapper_Tablica' => array(
			'nowaNazwa' => 'Tablica',
			'namespace' => 'Generic\\Biblioteka\\Mapper',
			'use' => 'Generic\\Biblioteka',
			'nowaNazwaUzycie' => 'Biblioteka\\Mapper\\Tablica',
		),
		'Mapper_Interfejs' => array(
			'nowaNazwa' => 'Interfejs',
			'namespace' => 'Generic\\Biblioteka\\Mapper',
			'use' => 'Generic\\Biblioteka',
			'nowaNazwaUzycie' => 'Biblioteka\\Mapper\\Interfejs',
		),
		'Platnosc_PlatnosciPl' => array(
			'nowaNazwa' => 'PlatnosciPl',
			'namespace' => 'Generic\\Biblioteka\\Platnosc',
			'use' => 'Generic\\Biblioteka\\Platnosc as Platnosci',
			'nowaNazwaUzycie' => 'Platnosci\\PlatnosciPl',
		),
		'Poczta_PHPMailer' => array(
			'nowaNazwa' => 'PHPMailer',
			'namespace' => 'Generic\\Biblioteka\\Poczta',
			'use' => 'Generic\\Biblioteka',
			'nowaNazwaUzycie' => 'Biblioteka\\Poczta\\PHPMailer',
		),
	);

	if (isset($klasySpecjalne[$nazwaKlasy]))
	{
		if ( !isset($klasySpecjalne[$nazwaKlasy]['use']))
		{
			$klasySpecjalne[$nazwaKlasy]['use'] = $klasySpecjalne[$nazwaKlasy]['namespace'] . '\\' . $klasySpecjalne[$nazwaKlasy]['nowaNazwa'];
		}

		if ( !isset($klasySpecjalne[$nazwaKlasy]['nowaNazwaUzycie']))
		{
			$klasySpecjalne[$nazwaKlasy]['nowaNazwaUzycie'] = $klasySpecjalne[$nazwaKlasy]['nowaNazwa'];
		}

		return $klasySpecjalne[$nazwaKlasy];
	}

	if (in_array($nazwaKlasy, $klasyZewnetrzne))
	{
		return array(
			'nowaNazwa' => $nazwaKlasy,
			'namespace' => '\\',
			'use' => '',
			'nowaNazwaUzycie' => '\\' . $nazwaKlasy,
		);
	}

	$oryginalnePolozenie = symulujAutoloader($nazwaKlasy);

	if ( !isset($plikiDoPrzeniesienia[$oryginalnePolozenie]))
	{
		trigger_error('Nie znalazłem mapowania klasy: ' . $nazwaKlasy);
	}
	else
	{
		$nowaSciezka = $plikiDoPrzeniesienia[$oryginalnePolozenie];
		$nowaSciezka = str_replace(CMS_KATALOG . $katalogBibliotek . '/', '', $nowaSciezka);
		$nowaSciezka = str_replace('.php', '', $nowaSciezka);
		$nowaSciezka = str_replace('/', '\\', $nowaSciezka);

		$nowaSciezkaTablica = explode('\\', $nowaSciezka);



		$nowaNazwa = $nowaSciezkaTablica[count($nowaSciezkaTablica) - 1];

		$namespaceTablica = $nowaSciezkaTablica;
		unset($namespaceTablica[count($namespaceTablica) - 1]);
		$namespace = implode('\\', $namespaceTablica);
		$use = '';
		$nowaNazwaUzycie = '';
		$nowaNazwaUzycieTablica = $nowaSciezkaTablica;

		//rozne zachowania zaleznie od tego czy to modul, model czy biblioteka
		switch($nowaSciezkaTablica[1])
		{
			case 'Model' : {
				$use = $nowaSciezkaTablica[0] . '\\' . $nowaSciezkaTablica[1] . '\\' . $nowaSciezkaTablica[2];
				unset($nowaNazwaUzycieTablica[0]);
				unset($nowaNazwaUzycieTablica[1]);
				$nowaNazwaUzycie = implode('\\', $nowaNazwaUzycieTablica);
			} break;
			case 'Biblioteka' : {
				$use = $nowaSciezkaTablica[0] . '\\' . $nowaSciezkaTablica[1] . '\\' . $nowaSciezkaTablica[2];
				unset($nowaNazwaUzycieTablica[0]);
				unset($nowaNazwaUzycieTablica[1]);
				$nowaNazwaUzycie = implode('\\', $nowaNazwaUzycieTablica);
			} break;
			case 'Modul' : {
				$use = $nowaSciezkaTablica[0] . '\\' . $nowaSciezkaTablica[1] . '\\' . $nowaSciezkaTablica[2];
				unset($nowaNazwaUzycieTablica[0]);
				unset($nowaNazwaUzycieTablica[1]);
				$nowaNazwaUzycie = implode('\\', $nowaNazwaUzycieTablica);
			} break;
		}

		return array(
			'nowaNazwa' => $nowaNazwa,
			'namespace' => $namespace,
			'use' => $use,
			'nowaNazwaUzycie' => $nowaNazwaUzycie,
		);
	}
}