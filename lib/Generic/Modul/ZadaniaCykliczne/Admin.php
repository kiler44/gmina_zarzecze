<?php
namespace Generic\Modul\ZadaniaCykliczne;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\ZadanieCykliczne;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Excel;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Sterownik;


/**
 * Modul administracyjny odpowiadajacy za zarzadząnie zadaniami cyklicznymi.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\ZadaniaCykliczne\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\ZadaniaCykliczne\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajRaport',
		'wykonajSprawdz',
		'ustawWielokrotne',
		'wykonajUruchom',
	);



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony'],
			'tytul_modulu' => $this->j->t['index.tytul_modulu'],	  
		));

		if (count(Cms::inst()->projekt->powiazaneModulyCron) < 1)
		{
			$this->komunikat($this->j->t['index.info_brak_modulow_cron'], 'info');
			return;
		}

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('kod_modulu', $this->j->t['index.etykieta_kod_modulu'], 200, Router::urlAdmin('ZadaniaCykliczne','edytuj',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('akcja', $this->j->t['index.etykieta_akcja'], 200, Router::urlAdmin('ZadaniaCykliczne','edytuj',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('id_kategorii', $this->j->t['index.etykieta_id_kategorii'], 0, Router::urlAdmin('ZadaniaCykliczne','edytuj',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('schemat', $this->j->t['index.etykieta_schemat'], 150);
		$grid->dodajKolumne('data_rozpoczecia', $this->j->t['index.etykieta_data_rozpoczecia'], 130);
		$grid->dodajKolumne('data_zakonczenia', $this->j->t['index.etykieta_data_zakonczenia'], 130);
		$grid->dodajKolumne('aktywne', $this->j->t['index.etykieta_aktywne'], 80);
		$grid->dodajKolumne('dodawane_wielokrotnie', $this->j->t['index.etykieta_dodawane_wielokrotnie'], 80);

		if ($this->moznaWykonacAkcje('wykonajUruchom'))
		{
			$grid->dodajPrzyciski(
			Router::urlAdmin('ZadaniaCykliczne','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array(
				array(
					'akcja' => Router::urlAdmin('ZadaniaCykliczne','uruchom',array('{KLUCZ}' => '{WARTOSC}')),
					'ikona' => 'icon-play',
					'etykieta' => $this->j->t['index.etykieta_button_uruchom'],
					'target' => '_self',
				))
		);
		}

		$grid->dodajPrzyciski(
			Router::urlAdmin('ZadaniaCykliczne','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj','usun')
		);

		$mapper = $this->dane()->ZadanieCykliczne();
		$ilosc = $mapper->iloscWszystko();


		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);
			$sorter = new ZadanieCykliczne\Sorter($kolumna, $kierunek);

			$grid->ustawSortownie(array('kod_modulu', 'id_kategorii', 'data_rozpoczecia', 'data_zakonczenia', 'aktywne', 'dodawane_wielokrotnie'), $kolumna, $kierunek,
				Router::urlAdmin('ZadaniaCykliczne', 'index', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$grid->pager($pager->wyborStrony(Router::urlAdmin('ZadaniaCykliczne', 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$mapperKategorie = $this->dane()->Kategoria();
			foreach($mapper->ZwracaTablice()->pobierzWszystko($pager, $sorter) as $zadanie)
			{
				$tlumaczenia = 'Generic\\Modul\\'.$zadanie['kod_modulu'].'\\Cron';
				$tlumaczenia = new $tlumaczenia;
				$tlumaczenia = $tlumaczenia->pobierzTlumaczenia();
				$tlumaczenia = (isset($tlumaczenia['_akcje_etykiety_'])) ? $tlumaczenia['_akcje_etykiety_'] : array();

				$zadanie['schemat'] = $zadanie['minuty'].' '.$zadanie['godziny'].' '.$zadanie['dni'].' '.$zadanie['miesiace'].' '.$zadanie['dni_tygodnia'];
				$zadanie['akcja'] = (isset($tlumaczenia[$zadanie['akcja']])) ? $tlumaczenia[$zadanie['akcja']] : $zadanie['akcja'];
				$kategoria = $mapperKategorie->pobierzPoId($zadanie['id_kategorii']);
				$zadanie['id_kategorii'] = ($kategoria instanceof Kategoria\Obiekt) ? $kategoria->nazwa : $zadanie['id_kategorii'];
				$zadanie['aktywne'] = $this->j->t['zadanie.aktywne'][$zadanie['aktywne']];
				$zadanie['dodawane_wielokrotnie'] = $this->j->t['zadanie.aktywne'][$zadanie['dodawane_wielokrotnie']];
				$grid->dodajWiersz($zadanie);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
				'tabela_danych' => $grid->html(),
				'link_dodaj' => Router::urlAdmin('ZadaniaCykliczne', 'dodaj'),
				'link_raport' => Router::urlAdmin('ZadaniaCykliczne', 'raport'),
				'link_sprawdz' => Router::urlAdmin('ZadaniaCykliczne', 'sprawdz'),
		));
	}

	public function wykonajRaport()
	{
		$xls = Excel::UtworzSzablon();
		$xls->setVersion(8);

		$format_naglowek =& $xls->addFormat();
		$format_naglowek->setTextWrap();
		$format_naglowek->setBold();
		$format_naglowek->setAlign('top');

		$xls->setCustomColor(12, 0xDA, 0xE1, 0xE8);
		$format_wiersz2 =& $xls->addFormat();
		$format_wiersz2->setFgColor(12);

		// Headers
		$xls->send($this->j->t['raport.nazwa_raportu_xls'] . '.xls');

		$arkusz =& $xls->addWorksheet();
		$arkusz->setInputEncoding('UTF-8');

		$arkusz->setColumn(0, 0, 60);
		$arkusz->setColumn(0, 1, 80);
		$arkusz->setColumn(0, 2, 30);
		$arkusz->setColumn(0, 3, 10);
		$arkusz->setColumn(0, 4, 60);

		$arkusz->write(0, 0, "Zadanie", $format_naglowek);
		$arkusz->write(0, 1, "Wykonywanie", $format_naglowek);
		$arkusz->write(0, 2, "Wpis Cron'a", $format_naglowek);
		$arkusz->write(0, 3, "Aktywne", $format_naglowek);
		$arkusz->write(0, 4, "Opis", $format_naglowek);

		$wiersz = 1;

		$mapper = $this->dane()->ZadanieCykliczne();
		foreach ($mapper->ZwracaTablice()->pobierzWszystko() as $zadanie)
		{
			$tlumaczenia = 'Generic\\Modul\\'.$zadanie['kod_modulu'].'\\Cron';
			$tlumaczenia = new $tlumaczenia;
			$tlumaczenia = $tlumaczenia->pobierzTlumaczenia();
			$tlumaczenia = isset($tlumaczenia['_akcje_etykiety_']) ? $tlumaczenia['_akcje_etykiety_'] : array();

			$zadanie['schemat'] = $zadanie['minuty'].' '.$zadanie['godziny'].' '.$zadanie['dni'].' '.$zadanie['miesiace'].' '.$zadanie['dni_tygodnia'];
			$zadanie['akcja'] = isset($tlumaczenia[$zadanie['akcja']]) ? $tlumaczenia[$zadanie['akcja']] : $zadanie['akcja'];
			$zadanie['aktywne'] = $this->j->t['zadanie.aktywne'][$zadanie['aktywne']];

			if ($wiersz % 2)
			{
				$arkusz->write($wiersz, 0, $zadanie['akcja'], $format_wiersz2);
				$arkusz->write($wiersz, 1, $this->schematCron2Tekst($zadanie['schemat'], $zadanie['data_rozpoczecia'], $zadanie['data_zakonczenia']), $format_wiersz2);
				$arkusz->write($wiersz, 2, $zadanie['schemat'], $format_wiersz2);
				$arkusz->write($wiersz, 3, $zadanie['aktywne'], $format_wiersz2);
				$arkusz->write($wiersz, 4, $zadanie['opis_zadania'], $format_wiersz2);
			}
			else
			{
				$arkusz->write($wiersz, 0, $zadanie['akcja']);
				$arkusz->write($wiersz, 1, $this->schematCron2Tekst($zadanie['schemat'], $zadanie['data_rozpoczecia'], $zadanie['data_zakonczenia']));
				$arkusz->write($wiersz, 2, $zadanie['schemat']);
				$arkusz->write($wiersz, 3, $zadanie['aktywne']);
				$arkusz->write($wiersz, 4, $zadanie['opis_zadania']);
			}
			++$wiersz;
		}

		$xls->close();
	}

	private function schematCron2Tekst ($schemat, $od, $do)
	{
		$tekst = '';

		$schemat = explode(' ', $schemat);

		$licznik = 0;
		$poprzedniaWartosc = 0;
		foreach ($schemat as $wartosc)
		{
			if ($wartosc == '*')
			{
				switch($licznik)
				{
					case 0: $tekst = $this->j->t['raport.kazda_min'].$tekst; break;
					case 1: $tekst = $this->j->t['raport.kazda_godz'].$tekst; break;
					case 2: $tekst = $this->j->t['raport.kazdy_dzien'].$tekst; break;
					case 3: $tekst = $this->j->t['raport.kazdy_miesiac'].$tekst; break;
				}
				++$licznik;
				continue;
			}
			//co N min, godz itd
			if (strpos($wartosc, '/') === 0)
			{
				$tekst = $this->j->t['raport.co'].intval(str_replace('/', '', $wartosc)).$this->j->t['raport.nazwy_wartosci_schematu'][$licznik].' '.$tekst;
			}
			//o okreslone min, godz
			else
			{
				switch ($licznik)
				{
					case 1:		if ($poprzedniaWartosc != '*')
								{
									$tekst = $this->j->t['raport.nazwy_wartosci_schematu'][$licznik].$wartosc . ':' . ($poprzedniaWartosc > 9 ? $poprzedniaWartosc : '0'.$poprzedniaWartosc);
								}
								else
								{
									$tekst = $wartosc.$this->j->t['raport.nazwy_wartosci_schematu'][$licznik].' '.$tekst;
								} break;
					case 3:		$tekst = $this->j->t['raport.miesiace'][$wartosc].' '.$tekst;		break;
					case 4:		$tekst = $tekst.', '.$this->j->t['raport.dni'][$wartosc];				break;
					default:	$tekst = $wartosc.$this->j->t['raport.nazwy_wartosci_schematu'][$licznik].' '.$tekst;	break;
				}
				$poprzedniaWartosc = $wartosc;
			}
			++$licznik;
		}

		if ($od != '')
		{
			$tekst .= $this->j->t['raport.od'] . $od;
		}
		if ($do != '')
		{
			$tekst .= $this->j->t['raport.do'] . $do;
		}

		return $tekst;
	}



	public function wykonajSprawdz()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['sprawdz.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('kod_modulu', $this->j->t['index.etykieta_kod_modulu'], 200, Router::urlAdmin('ZadaniaCykliczne','edytuj',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('akcja', $this->j->t['index.etykieta_akcja'], 200, Router::urlAdmin('ZadaniaCykliczne','edytuj',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('id_kategorii', $this->j->t['index.etykieta_id_kategorii'], 0, Router::urlAdmin('ZadaniaCykliczne','edytuj',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('schemat', $this->j->t['index.etykieta_schemat'], 200);
		$grid->dodajKolumne('data_rozpoczecia', $this->j->t['index.etykieta_data_rozpoczecia'], 130);
		$grid->dodajKolumne('data_zakonczenia', $this->j->t['index.etykieta_data_zakonczenia'], 130);

		$grid->dodajPrzyciski(
			Router::urlAdmin('ZadaniaCykliczne','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj')
		);

		$kryteria = $this->formularzWyszukiwania($grid);

		$mapper = $this->dane()->ZadanieCykliczne();

		$data = new \DateTime($kryteria['data_graniczna'], new \DateTimeZone('Europe/Warsaw'));
		$data->modify('-' . $this->k->k['sprawdz.zakres_godzin'] . ' hour');
		$czasOd = $data->format('Y-m-d H:i:s');
		$data->modify('+' . ($this->k->k['sprawdz.zakres_godzin'] * 2) . ' hour');
		$czasDo = $data->format('Y-m-d H:i:s');

		$mapperKategorie = $this->dane()->Kategoria();
		foreach ($mapper->ZwracaTablice()->pobierzPrzedzialCzasowy($czasOd, $czasDo) as $zadanie)
		{
			$tlumaczenia = 'Generic\\Modul\\'.$zadanie['kod_modulu'].'\\Cron';
			$tlumaczenia = new $tlumaczenia;
			$tlumaczenia = $tlumaczenia->pobierzTlumaczenia();
			$tlumaczenia = isset($tlumaczenia['_akcje_etykiety_']) ? $tlumaczenia['_akcje_etykiety_'] : array();

			$zadanie['schemat'] = $zadanie['minuty'] . ' ' . $zadanie['godziny'] . ' ' . $zadanie['dni'] . ' ' . $zadanie['miesiace'] . ' ' . $zadanie['dni_tygodnia'];
			$zadanie['akcja'] = isset($tlumaczenia[$zadanie['akcja']]) ? $tlumaczenia[$zadanie['akcja']] : $zadanie['akcja'];
			$kategoria = $mapperKategorie->pobierzPoId($zadanie['id_kategorii']);
			$zadanie['id_kategorii'] = ($kategoria instanceof Kategoria\Obiekt) ? $kategoria->nazwa : $zadanie['id_kategorii'];
			$zadanie['aktywne'] = $this->j->t['zadanie.aktywne'][$zadanie['aktywne']];
			$grid->dodajWiersz($zadanie);
		}

		$this->tresc .= $this->szablon->parsujBlok('sprawdz', array(
			'tabela_danych' => $grid->html(),
		));
	}



	private function formularzWyszukiwania(TabelaDanych $grid)
	{
		$obiektFormularza = new \Generic\Formularz\ZadanieCykliczne\Wyszukiwanie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('sprawdz'));

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$kryteria = $obiektFormularza->pobierzWartosci();

		return $kryteria;
	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
			'formularz' => $this->formularz(new ZadanieCykliczne\Obiekt())
		));
	}



	public function wykonajEdytuj()
	{
		$cms = Cms::inst();

		$mapper = $this->dane()->ZadanieCykliczne();
		$zadanie = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));
		if ($zadanie instanceof ZadanieCykliczne\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

			$this->tresc .= $this->szablon->parsujBlok('edytuj', array(
				'formularz' => $this->formularz($zadanie)
			));
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_zadania'], 'error');
		}
	}



	public function wykonajUsun()
	{
		$mapper = $this->dane()->ZadanieCykliczne();
		$zadanie = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));
		if ($zadanie instanceof ZadanieCykliczne\Obiekt)
		{
			if ($zadanie->usun($mapper))
			{
				$this->komunikat($this->j->t['usun.info_zadanie_usuniete'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_zadania'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_brak_zadania'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('ZadaniaCykliczne','index'));
	}



	private function formularz(ZadanieCykliczne\Obiekt $zadanie)
	{

		$cms = Cms::inst();

		$mapper = $this->dane()->ZadanieCykliczne();
		$zadania = array();
		$wielokrotne = array();
		foreach ($mapper->szukaj(array('dodawane_wielokrotnie' => 0)) as $z)
		{
			$zadania[] = $z->kodZadania;
		}

		foreach ($mapper->szukaj(array('dodawane_wielokrotnie' => 1)) as $z)
		{
			if (isset($wielokrotne[$z->kodZadania]))
			{
				$wielokrotne[$z->kodZadania]++;
			}
			else
			{
				$wielokrotne[$z->kodZadania] = 1;
			}
		}

		$modulyCron = $cms->projekt->powiazaneModulyCron;
		$kategorie = $this->dane()->Kategoria();

		$lp = 1;
		$lista = array();
		$nazwaZadania = '';
		$kategorie = $kategorie->zwracaTablice()->pobierzWszystko();

		// obsługa specjalnego zdarzenia dla wysyłki maili
		$wysylanieMaili = array(
			'id' => 1, //root
			'kod_modulu' => 'EmailZarzadzanie',
			'nazwa' => 'Email',
		);
		array_unshift($kategorie, $wysylanieMaili);
		$modulyCron[] = 'EmailZarzadzanie';

		foreach ($kategorie as $kategoria)
		{
			if (in_array($kategoria['kod_modulu'], $modulyCron))
			{
				$klasa = 'Generic\\Modul\\'.$kategoria['kod_modulu'].'\\Cron';
				$instancja = new $klasa;
				$tlumaczenia = $instancja->pobierzTlumaczenia();
				$tlumaczenia = (isset($tlumaczenia['_akcje_etykiety_'])) ? $tlumaczenia['_akcje_etykiety_'] : array();
				$metody = get_class_methods($klasa);

				$nazwaKategorii = $lp.' '.$kategoria['nazwa'];
				foreach ($metody as $metoda)
				{
					if (strpos($metoda, 'wykonaj') !== false && $metoda != 'wykonajAkcje' && $metoda != 'wykonajIndex')
					{
						$kod = $kategoria['kod_modulu'].'_'.$kategoria['id'].'_'.$metoda;
						if ($zadanie->kodZadania == $kod)
							$nazwaZadania = $kategoria['nazwa'].' (id:'.$kategoria['id'].', mod:'.$kategoria['kod_modulu'].') -> '.((isset($tlumaczenia[$metoda])) ? $tlumaczenia[$metoda] : $metoda);
						if (in_array($kod, $zadania))
							continue;
						$lista[$nazwaKategorii][$kod] = ((isset($tlumaczenia[$metoda])) ? $tlumaczenia[$metoda] : $metoda);

						if (isset($wielokrotne[$kod]))
						{
							 $lista[$nazwaKategorii][$kod] = '[' . sprintf($this->j->t['formularz.dodanoRazy'], $wielokrotne[$kod]).'] ' . $lista[$nazwaKategorii][$kod];
						}
					}
				}
				$lp++;
			}
		}

		if ($zadanie->id < 1 && count($lista) < 1)
		{
			$this->komunikat($this->j->t['formularz.etykieta_zadanie_brak_zadan'], 'info');
			return;
		}

		$obiektFormularza = new \Generic\Formularz\ZadanieCykliczne\Edycja();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawKonfiguracje(array('wymagane_pola' => $this->k->k['formularz.wymagane_pola']))
			->ustawObiekt($zadanie)
			->ustawUrlPowrotny(Router::urlAdmin('ZadaniaCykliczne'))
			->ustawNazwaZadania($nazwaZadania)
			->ustawListaZadan($lista);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();
			if ($zadanie->id < 1)
			{
				$zadanie->idProjektu = ID_PROJEKTU;
				$zadanie->kodJezyka = KOD_JEZYKA;

				$dane['zadanie'] = explode('_', $dane['zadanie']);
				$zadanie->kodModulu = $dane['zadanie'][0];
				$zadanie->idKategorii = $dane['zadanie'][1];
				$zadanie->akcja = $dane['zadanie'][2];
			}
			$zadanie->minuty = $dane['zapisCron']['minuty'];
			$zadanie->godziny = $dane['zapisCron']['godziny'];
			$zadanie->dni = $dane['zapisCron']['dni'];
			$zadanie->miesiace = $dane['zapisCron']['miesiace'];
			$zadanie->dniTygodnia = $dane['zapisCron']['dni_tygodnia'];
			$zadanie->dataRozpoczecia = ($dane['dataRozpoczecia'] != '') ? $dane['dataRozpoczecia'] : null;
			$zadanie->dataZakonczenia = ($dane['dataZakonczenia'] != '') ? $dane['dataZakonczenia'] : null;
			$zadanie->aktywne = $dane['aktywne'];
			$zadanie->opisZadania = $dane['opisZadania'];
			if (isset($dane['dodawaneWielokrotnie']) && $cms->profil()->maUprawnieniaDo('ZadaniaCykliczne_ustawWielokrotne'))
			{
				$zadanie->dodawaneWielokrotnie = $dane['dodawaneWielokrotnie'];
			}

			if ($zadanie->zapisz($mapper))
			{
				$this->komunikat($this->j->t['formularz.info_zapisano_dane_zadania'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin('ZadaniaCykliczne'));
				return;
			}
			else
			{
				$this->komunikat($this->j->t['formularz.blad_nie_mozna_zapisac_zadania'], 'error', 'modul');
			}
		}
		return $obiektFormularza->html();
	}

	public function wykonajUruchom()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['uruchom.tytul_strony']));

		$mapper = $this->dane()->ZadanieCykliczne();
		$zadanie = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));
		if ($zadanie instanceof ZadanieCykliczne\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

			$this->tresc .= $this->szablon->parsujBlok('edytuj', array(
				'formularz' => $this->formularzUruchom($zadanie)
			));
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_zadania'], 'error');
		}

	}

	protected function formularzUruchom(ZadanieCykliczne\Obiekt $zadanie)
	{
		$obiektFormularza = new \Generic\Formularz\ZadanieCykliczne\Uruchom();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzUruchom'))
			->ustawUrlPowrotny(Router::urlAdmin('ZadaniaCykliczne'));

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();
			$dataDanych = new \DateTime($dane['dataDanych']);
			$dataTresci = new \DateTime($dane['dataTresci']);

			$this->uruchomZadanie($zadanie, $dataDanych, $dataTresci);

			$this->komunikat($this->j->t['formularzUruchom.info_uruchomiono_zadanie'], 'info', 'sesja');
			Router::przekierujDo(Router::urlAdmin('ZadaniaCykliczne'));
			return;
		}

		return $obiektFormularza->html();
	}


	protected function uruchomZadanie(ZadanieCykliczne\Obiekt $zadanie, \DateTime $dataDanych, \DateTime $dataTresci)
	{
		$kategorie = Cms::inst()->dane()->Kategoria();

		$logWykonywania = new Plik(LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-cron.log', true);

		$logWiersz = date('Y-m-d H:i:s').' Rozpoczęto testowanie zadania '.$zadanie->kodZadania.' (ID: '.$zadanie->id.")\n";
		$logWykonywania->ustawZawartosc($logWiersz, true);

		$sterownik = new Sterownik('Cron');
		$kategoria = ($zadanie->idKategorii > 1) ? $kategorie->pobierzPoId($zadanie->idKategorii) : null;

		$nazwaModulu = 'Generic\\Modul\\' . $zadanie->kodModulu . '\\Cron';
		$nazwaAkcji = $zadanie->akcja;
		$modul = new $nazwaModulu();
		$modul->inicjuj($sterownik, $kategoria);
		$modul->ladujKonfiguracje();
		$modul->ladujTlumaczenia();

		$modul->ustawDateDanych($dataDanych);
		$modul->ustawDateTresci($dataTresci);

		$modul->$nazwaAkcji();

		$logWiersz = date('Y-m-d H:i:s').' Zakończono testowanie zadania '.$zadanie->kodZadania.' (ID: '.$zadanie->id.")\n";
		$logWykonywania->ustawZawartosc($logWiersz, true);

	}

}
