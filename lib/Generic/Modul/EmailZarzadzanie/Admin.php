<?php
namespace Generic\Modul\EmailZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Model\EmailFormatka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Cms;
use Generic\Model\EmailSzablon;
use Generic\Biblioteka\Plik;
use Generic\Model\EmailWpisKolejki;
use Generic\Biblioteka\Pomocnik;


/**
 * Modul administracyjny odpowiedzialny za zarzadząnie wiadomosciami email w cms-ie.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\EmailZarzadzanie\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\EmailZarzadzanie\Admin
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajUsunZalacznik',
		'wykonajSzablony',
		'wykonajDodajSzablon',
		'wykonajEdytujSzablon',
		'wykonajUsunSzablon',
		'wykonajKolejka',
		'wykonajPodglad',
		'wykonajPodgladFormatki',
	);

	protected $zdarzenia = array();



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony']
		));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('tytul', $this->j->t['index.etykieta_tytul'], 0, Router::urlAdmin('EmailZarzadzanie','edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('kategoria', $this->j->t['index.etykieta_kategoria'], 300);
		$grid->dodajKolumne('typ_wysylania', $this->j->t['index.etykieta_typ_wysylania'], 150);
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_data_dodania'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin('EmailZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj','usun')
		);

		$kryteria = $this->formularzWyszukiwaniaFormatki($grid);

		$mapper = $this->dane()->EmailFormatka();

		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$sorter = new EmailFormatka\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('tytul', 'kategoria', 'data_dodania'), $kolumna, $kierunek,
				Router::urlAdmin('EmailZarzadzanie', '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
			$grid->pager($pager->html(Router::urlAdmin('EmailZarzadzanie', '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach ($mapper->zwracaTablice('id','tytul','opis','typ_wysylania','kategoria','data_dodania')->szukaj($kryteria, $pager, $sorter) as $formatka)
			{
				$formatka['tytul'] = '<em title="'.$formatka['opis'].'">'.$formatka['tytul'].'</em>';
				$formatka['kategoria'] = $this->j->t['formatka.kategorie'][$formatka['kategoria']];
				$formatka['typ_wysylania'] = $this->j->t['formatka.typy_wysylania'][$formatka['typ_wysylania']];
				$formatka['_ustaw_klase_'] = 'tooltip';
				$grid->dodajWiersz($formatka);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/index', array(
				'tabela_danych' => $grid->html(),
				'link_dodaj' => Router::urlAdmin('EmailZarzadzanie', 'dodaj'),
				'link_szablony' => Router::urlAdmin('EmailZarzadzanie', 'szablony'),
				'link_kolejka' => Router::urlAdmin('EmailZarzadzanie', 'kolejka'),
		));
	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['dodaj.tytul_strony']
		));

		$formatka = new EmailFormatka\Obiekt();
		$formatka->idProjektu = ID_PROJEKTU;
		$formatka->dataDodania = date("Y-m-d H:i:s");

		$this->tresc .= $this->szablon->parsujBlok('/dodaj', array(
			'form' => $this->formularzFormatka($formatka),
		));
	}



	public function wykonajEdytuj()
	{
		$mapper = $this->dane()->EmailFormatka();
		$formatka = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if ($formatka instanceof EmailFormatka\Obiekt)
		{
			$this->ustawGlobalne(array(
				'tytul_strony' => sprintf($this->j->t['edytuj.tytul_strony'], $formatka->tytul)
			));

			$this->tresc .= $this->szablon->parsujBlok('/edytuj', array(
				'form' => $this->formularzFormatka($formatka),
			));
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_formatki'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie'));
		}
	}



	public function wykonajUsun()
	{
		$mapper = $this->dane()->EmailFormatka();
		$formatka = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if ($formatka instanceof EmailFormatka\Obiekt)
		{
			$katalog = new Katalog(Cms::inst()->katalog('email_zalaczniki', $formatka->id));

			if (( ! $katalog->istnieje() || $katalog->usun()) && $formatka->usun($mapper))
			{
				$this->komunikat($this->j->t['usun.info_formatka_usunieta'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_formatki'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_brak_formatki'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie'));
	}



	public function wykonajPodgladFormatki()
	{
		$trescFormatki = Zadanie::pobierzGet('tresc', 'filtr_xss', 'trim');
		if ($trescFormatki == '')
		{
			return;
		}

		$szablon = EmailSzablon\Mapper::wywolaj()->pobierzPoId(Zadanie::pobierzGet('szablon', 'intval','abs'));
		if ($szablon instanceof EmailSzablon\Obiekt)
		{
			$trescFormatki = str_replace('{TRESC}', $trescFormatki, $szablon->trescHtml);
		}
		$this->tresc .= $trescFormatki;
	}



	public function wykonajUsunZalacznik()
	{
		$mapper = $this->dane()->EmailFormatka();
		$formatka = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));
		$plikNazwa = Zadanie::pobierzGet('plik', 'strval', 'trim', 'basename');

		if ($formatka instanceof EmailFormatka\Obiekt)
		{
			$zalaczniki = $formatka->emailZalaczniki;
			if (in_array($plikNazwa, $zalaczniki))
			{
				$plik = new Plik(Cms::inst()->katalog('email_zalaczniki', $formatka->id).$plikNazwa);
				if ( ! $plik->istnieje() || $plik->usun())
				{
					$this->komunikat($this->j->t['usunZalacznik.info_zalacznik_usuniety'], 'info', 'sesja');
					$formatka->emailZalaczniki = array_values(array_diff($zalaczniki, array($plikNazwa)));
					$formatka->zapisz($mapper);
				}
				else
				{
					$this->komunikat($this->j->t['usunZalacznik.blad_nie_mozna_usunac_zalacznika'], 'error', 'sesja');
				}
			}
			else
			{
				$this->komunikat($this->j->t['usunZalacznik.blad_brak_zalacznika'],'error', 'sesja');
			}
			Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'edytuj', array('id' => $formatka->id)));
		}
		else
		{
			$this->komunikat($this->j->t['usunZalacznik.blad_brak_formatki'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie'));
	}



	public function wykonajSzablony()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['szablony.tytul_strony']
		));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['szablony.etykieta_nazwa'], 0, Router::urlAdmin('EmailZarzadzanie','edytujSzablon', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('aktywny', $this->j->t['szablony.etykieta_aktywny'], 50);

		$grid->dodajPrzyciski(
			Router::urlAdmin('EmailZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array(
				'edytujSzablon' => array(
					'akcja' => Router::urlAdmin('EmailZarzadzanie', 'edytujSzablon', array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['szablony.etykieta_edytuj'],
					'ikona' => 'icon-pencil',
				),
				'usunSzablon' => array(
					'akcja' => Router::urlAdmin('EmailZarzadzanie', 'usunSzablon', array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['szablony.etykieta_usun'],
					'ikona' => 'icon-remove',
					'onclick' => 'return confirm(\''.$this->j->t['szablony.etykieta_potwierdz_usun'].'\')',
				),
			)
		);

		$mapper = EmailSzablon\Mapper::wywolaj();
		$kryteria = array();

		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['szablony.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['szablony.domyslne_sortowanie'], false, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$sorter = new EmailSzablon\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('nazwa','aktywny'), $kolumna, $kierunek,
				Router::urlAdmin('EmailZarzadzanie', 'szablony', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['szablony.pager_konfiguracja']);
			$grid->pager($pager->html(Router::urlAdmin('EmailZarzadzanie', 'szablony', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach ($mapper->zwracaTablice('id','nazwa','aktywny')->szukaj($kryteria, $pager, $sorter) as $szablon)
			{
				$szablon['aktywny'] = $this->j->t['szablon.aktywny_opcje'][$szablon['aktywny']];
				$grid->dodajWiersz($szablon);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/szablony', array(
				'tabela_danych' => $grid->html(),
				'link_dodaj' => Router::urlAdmin('EmailZarzadzanie', 'dodajSzablon'),
		));
	}



	public function wykonajDodajSzablon()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['dodajSzablon.tytul_strony']
		));

		$szablon = new EmailSzablon\Obiekt();

		$this->tresc .= $this->szablon->parsujBlok('/dodaj_szablon', array(
			'form' => $this->formularzSzablon($szablon),
		));
	}



	public function wykonajEdytujSzablon()
	{
		$mapper = EmailSzablon\Mapper::wywolaj();
		$szablon = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if ($szablon instanceof EmailSzablon\Obiekt)
		{
			$this->ustawGlobalne(array(
				'tytul_strony' => sprintf($this->j->t['edytujSzablon.tytul_strony'], $szablon->nazwa)
			));

			$this->tresc .= $this->szablon->parsujBlok('/edytuj_szablon', array(
				'form' => $this->formularzSzablon($szablon),
			));
		}
		else
		{
			$this->komunikat($this->j->t['edytujSzablon.blad_brak_szablonu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie','szablony'));
		}
	}



	public function wykonajUsunSzablon()
	{
		$mapper = EmailSzablon\Mapper::wywolaj();
		$szablon = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if ($szablon instanceof EmailSzablon\Obiekt)
		{
			$ileFormatekZawieraSzablon = $this->dane()->EmailFormatka()->iloscSzukaj(array('email_szablon_rowne_' => $szablon->id));
			if ($ileFormatekZawieraSzablon > 0)
			{
				$this->komunikat($this->j->t['usunSzablon.info_istnieja_powiazane_formatki'], 'info', 'sesja');
			}
			if ($ileFormatekZawieraSzablon < 1 && $szablon->usun($mapper))
			{
				$this->komunikat($this->j->t['usunSzablon.info_szablon_usuniety'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usunSzablon.blad_nie_mozna_usunac_szablonu'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usunSzablon.blad_brak_szablonu'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie','szablony'));
	}



	public function wykonajKolejka()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['kolejka.tytul_strony']
		));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('email_tytul', $this->j->t['kolejka.etykieta_email_tytul'], 0, Router::urlAdmin('EmailZarzadzanie','podglad', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('typ_wysylania', $this->j->t['kolejka.etykieta_typ_wysylania'], 150);
		$grid->dodajKolumne('data_dodania', $this->j->t['kolejka.etykieta_data_dodania'], 150);
		$grid->dodajKolumne('bledy', $this->j->t['kolejka.etykieta_bledy'], 70);

		$grid->dodajPrzyciski(
			Router::urlAdmin('EmailZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array('podglad')
		);

		$kryteria = $this->formularzWyszukiwaniaKolejka($grid);

		$mapper = $this->dane()->EmailWpisKolejki();

		$kryteria['nie_wysylaj'] = false;
		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['kolejka.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['kolejka.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

			$sorter = new EmailWpisKolejki\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('email_tytul', 'bledy', 'data_dodania'), $kolumna, $kierunek,
				Router::urlAdmin('EmailZarzadzanie', 'kolejka', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['kolejka.pager_konfiguracja']);
			$grid->pager($pager->html(Router::urlAdmin('EmailZarzadzanie', 'kolejka', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach ($mapper
					->zwracaTablice('id','email_tytul','bledy_licznik','data_dodania','typ_wysylania')
					->szukaj($kryteria, $pager, $sorter) as $wpis)
			{
				$wpis['typ_wysylania'] = $this->j->t['formatka.typy_wysylania'][$wpis['typ_wysylania']];
				$wpis['bledy'] = ($wpis['bledy_licznik'] > 0) ? sprintf($this->j->t['kolejka.bledy_wiersz'], $wpis['bledy_licznik']) : '&nbsp;';
				$grid->dodajWiersz($wpis);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/kolejka', array(
				'tabela_danych' => $grid->html(),
		));
	}



	public function wykonajPodglad()
	{
		$wpis = $this->dane()->EmailWpisKolejki()->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if ($wpis instanceof EmailWpisKolejki\Obiekt)
		{
			$this->ustawGlobalne(array(
				'tytul_strony' => $this->j->t['podglad.tytul_strony'],
			));

			$this->tresc .= $this->szablon->parsujBlok('/podglad', array(
				'form' => $this->formularzWpisKolejki($wpis),
			));
			$this->tresc .= $this->szablon->parsujBlok('/podglad_tresci');
		}
		else
		{
			$this->komunikat($this->j->t['podglad.blad_brak_wpisu_kolejki'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'kolejka'));
		}
	}



	protected function formularzFormatka(EmailFormatka\Obiekt $formatka)
	{
		$listaSzablonow = EmailSzablon\Mapper::wywolaj()
			->zwracaTablice('id','nazwa','tresc_html','tresc_txt')
			->szukaj(array('aktywny' => 1), null, new EmailSzablon\Sorter('nazwa', 'asc'));
		$listaSzablonow = listaZTablicy($listaSzablonow, 'id', 'nazwa');

		$formularzObiekt = new \Generic\Formularz\EmailFormatka\Edycja();
		$formularzObiekt->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawTlumaczenia(array(
				'formatka.kategorie' => $this->j->t['formatka.kategorie'],
				'formatka.typy_wysylania' => $this->j->t['formatka.typy_wysylania'],
				'formularzSzablon.podgladHtml.wartosc' => $this->j->t['formularzSzablon.podgladHtml.wartosc'],
			))
			->ustawUrlUsun(Router::urlAdmin('EmailZarzadzanie', 'usunZalacznik', array('id' => $formatka->id, 'plik' => '{PLIK}')))
			->ustawUrlZalaczniki(Cms::inst()->url('email_zalaczniki', $formatka->id))
			->ustawListaSzablonow($listaSzablonow)
			->ustawWymaganePola($this->k->k['formularz.wymagane_pola'])
			->ustawIloscZalacznikow($this->k->k['formularz.ilosc_zalacznikow'])
			->ustawOdbiorcy($this->pobierzOdbiorcowPredefiniowanych())
			->ustawObiekt($formatka);

		$this->tresc .= $this->szablon->parsujBlok('/podglad_formatki', array(
			'link_podglad' => Router::urlAjax('Admin', 'EmailZarzadzanie', 'podgladFormatki', array('tresc'=> '{TRESC}', 'szablon' => '{SZABLON}')),
			'pole_tresc' => 'emailTrescHtml',
			'pole_szablon' => 'emailSzablon',
		));

		if ($formularzObiekt->wypelniony())
		{
			if ($formularzObiekt->danePoprawne())
			{
				if ($this->zapiszFormatke($formatka, $formularzObiekt->pobierzZmienioneWartosci()))
				{
					Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'index'));
				}
			}
			else
			{
				$this->komunikat($this->j->t['formularz.info_zawiera_bledy'], 'warning');
			}
		}
		return $formularzObiekt->html();
	}



	protected function zapiszFormatke(EmailFormatka\Obiekt $formatka, $dane)
	{
		$cms = Cms::inst();

		if ($formatka->id > 0)
		{
			$info = $this->j->t['edytuj.info_formatka_zapisana'];
			$blad = $this->j->t['edytuj.blad_nie_mozna_zapisac_formatki'];
		}
		else
		{
			$info = $this->j->t['dodaj.info_formatka_zapisana'];
			$blad = $this->j->t['dodaj.blad_nie_mozna_zapisac_formatki'];
		}
		
		$mapper = $this->dane()->EmailFormatka();
		
		$zalaczniki = array();
		foreach ($dane as $nazwaPola => $wartosc)
		{
			if (strpos($nazwaPola, 'emailZalaczniki') !== false)
			{
				$zalaczniki[] = $wartosc;
				continue;
			}
			$formatka->$nazwaPola = $wartosc;
		}
		if ($formatka->zapisz($mapper))
		{
			$this->komunikat($info, 'info', 'sesja');
		}
		else
		{
			$this->komunikat($blad, 'error', 'sesja');
			return false;
		}

		$katalogDocelowy = new Katalog(Cms::inst()->katalog('email_zalaczniki', $formatka->id), true);
		$nowePliki = array();
		foreach ($zalaczniki as $zalacznik)
		{
			$nowePliki[] = Pomocnik\Upload::wgrajPlik($zalacznik, $katalogDocelowy);
		}

		$nowePliki = array_filter($nowePliki);
		if (count($nowePliki) > 0)
		{
			$formatka->emailZalaczniki = array_merge($formatka->emailZalaczniki, $nowePliki);
			$formatka->zapisz($mapper);
		}
		return true;
	}



	private function pobierzObiektyZdarzenia($zdarzenie)
	{
		/* @var $zdarzenie Zdarzenia\\Zdarzenie */
		$zdarzenie = 'Generic\\Zdarzenie\\'.$zdarzenie;
		$zdarzenie = new $zdarzenie;
		$dostepneObiektyEtykiety = array_keys($zdarzenie->pobierzDaneWymagane());

		$kontener = new Kontener\WizytowkaObiekty;
		$obiektyEtykiety = $kontener->jakieObiektyMoznaPobrac($dostepneObiektyEtykiety);
		$obiektyTypy = $kontener->pobierzObslugiwaneObiekty();
		$obiekty = array();
		foreach ($obiektyEtykiety as $etykieta)
		{
			$typ = $obiektyTypy[$etykieta];
			$obiekty[$typ]['etykiety'][] = $etykieta;

			if ( !isset($obiekty[$typ]['propercje']) || empty($obiekty[$typ]['propercje']))
			{
				$reflect = new \ReflectionClass(new $typ);
				preg_match_all('/\@property.*\$(\w+)/', $reflect->getDocComment(), $propercje);
				if (count($propercje) > 1) $obiekty[$typ]['propercje'] = $propercje[1];
			}
		}
		return $obiekty;
	}


	private function formularzSzablon(EmailSzablon\Obiekt $szablon)
	{
		$formularzObiekt = new \Generic\Formularz\EmailFormatka\Szablon();

		$ileFormatekZawieraSzablon = ($szablon->id > 0) ? $this->dane()->EmailFormatka()->iloscSzukaj(array('email_szablon_rowne_' => $szablon->id)) : 0;

		$formularzObiekt->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzSzablon'))
			->ustawUrlPowrotny(Router::urlAdmin('EmailZarzadzanie', 'szablony'))
			->ustawObiekt($szablon)
			->ustawIleFormatekZawieraSzablon($ileFormatekZawieraSzablon)
			->ustawKonfiguracje(array('wymagane_pola' => $this->k->k['formularzSzablon.wymagane_pola']));

		if ($formularzObiekt->wypelniony())
		{
			if ($formularzObiekt->danePoprawne())
			{
				$dane = $formularzObiekt->pobierzZmienioneWartosci();
				if ($ileFormatekZawieraSzablon > 0) $dane['aktywny'] = 1;
				if ($this->zapiszSzablon($szablon, $dane))
				{
					Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'szablony'));
				}
			}
			else
			{
				$this->komunikat($this->j->t['formularzSzablon.info_zawiera_bledy'], 'warning');
			}
		}
		return $formularzObiekt->html();
	}



	protected function zapiszSzablon(EmailSzablon\Obiekt $szablon, $dane)
	{
		$cms = Cms::inst();

		if ($szablon->id > 0)
		{
			$info = $this->j->t['edytujSzablon.info_zmieniono_szablon'];
			$blad = $this->j->t['edytujSzablon.blad_nie_mozna_zapisac_szablon'];
		}
		else
		{
			$info = $this->j->t['dodajSzablon.info_dodano_szablon'];
			$blad = $this->j->t['dodajSzablon.blad_nie_mozna_zapisac_szablonu'];
		}

		$mapper = EmailSzablon\Mapper::wywolaj();

		foreach ($dane as $nazwaPola => $wartosc)
		{
			$szablon->$nazwaPola = $wartosc;
		}
		if ($szablon->zapisz($mapper))
		{
			$this->komunikat($info, 'info', 'sesja');
			return true;
		}
		else
		{
			$this->komunikat($blad, 'error', 'sesja');
			return false;
		}
	}



	protected function formularzWpisKolejki(EmailWpisKolejki\Obiekt $wpis)
	{
		$obiektFormularza = new \Generic\Formularz\EmailFormatka\WpisKolejki();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formatka'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('podglad'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzSzablon'))
			->ustawKonfiguracje(array('nie_wysylaj' => $wpis->nieWysylaj))
			->ustawOdbiorcy($this->pobierzOdbiorcowPredefiniowanych(true))
			->ustawWymaganePola($this->k->k['formularz.wymagane_pola'])
			->ustawObiekt($wpis);

		if ($obiektFormularza->wypelniony())
		{
			if ($obiektFormularza->danePoprawne())
			{
				if (Zadanie::pobierzPost('wyslijPonownieWpis'))
				{
					foreach ($obiektFormularza->pobierzZmienioneWartosci() as $pole => $wartosc)
					{
						if (in_array($pole, array('bledyLicznik','bledyOpis','typWysylania','idFormatki'))) continue;
						$wpis->$pole = $wartosc;
					}
					if ($this->wyslijPonownie($wpis))
					{
						Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'kolejka'));
					}
					else
					{
						$obiektFormularza->zwrocFormularz()->input('bledyLicznik')->ustawWartosc($wpis->bledyLicznik);
						$obiektFormularza->zwrocFormularz()->input('bledyOpis')->ustawWartosc(nl2br($wpis->bledyOpis));
					}
				}
				elseif (Zadanie::pobierzPost('usunWpis') && $this->usunWpis($wpis))
				{
					Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'kolejka'));
				}
			}
			else
			{
				$this->komunikat($this->j->t['formularz.info_zawiera_bledy'], 'warning');
			}
		}
		return $obiektFormularza->html();
	}



	protected function wyslijPonownie(EmailWpisKolejki\Obiekt $wpis)
	{
		$cms = Cms::inst();
		$wpisyMapper = Cms::inst()->dane()->EmailWpisKolejki();

		$poczta = new Pomocnik\Poczta();
		$poczta->wczytajUstawienia(Pomocnik\Poczta::przygotujUstawieniaDlaWpisu($wpis));

		if ($poczta->wyslij())
		{
			$wpis->usun($wpisyMapper);

			$this->komunikat($this->j->t['wyslijPonownie.info_wiadomosc_wyslana'], 'info', 'sesja');
			return true;
		}
		else
		{
			$wpis->bledyLicznik++;
			$wpis->bledyOpis .= "\n".trim($cms->temp('smtp_debug'));
			$wpis->zapisz($wpisyMapper);

			$this->komunikat($this->j->t['wyslijPonownie.blad_nie_mozna_wyslac_wiadomosci'], 'error');
			return false;
		}
	}



	protected function usunWpis(EmailWpisKolejki\Obiekt $wpis)
	{
		$mapper = $this->dane()->EmailWpisKolejki();

		if ($wpis instanceof EmailWpisKolejki\Obiekt)
		{
			if ($wpis->usun($mapper))
			{
				$this->komunikat($this->j->t['usunWpis.info_wpis_usuniety'], 'info', 'sesja');
				return true;
			}
			else
			{
				$this->komunikat($this->j->t['usunWpis.blad_nie_mozna_usunac_wpisu'], 'error', 'sesja');
				return false;
			}
		}
		else
		{
			$this->komunikat($this->j->t['usunWpis.blad_brak_wpisu'],'error', 'sesja');
			return false;
		}
	}



	private function formularzWyszukiwaniaFormatki(TabelaDanych $grid)
	{
		$formularzObiekt = new \Generic\Formularz\EmailFormatka\Wyszukiwanie();

		$formularzObiekt->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formatka'));

		$kryteria = $formularzObiekt->pobierzWartosci();

		$grid->naglowek($formularzObiekt->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		return $kryteria;
	}



	private function formularzWyszukiwaniaKolejka(TabelaDanych $grid)
	{
		$obiektFormularza = new \Generic\Formularz\EmailFormatka\WyszukiwanieKolejka();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('kolejka'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formatka'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'));

		$kryteria = $obiektFormularza->pobierzWartosci();

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		return $kryteria;
	}



	protected function pobierzOdbiorcowPredefiniowanych($tylkoZawierajacyEmail = false)
	{
		$odbiorcy = array();

		$pracownicy = $this->dane()->Uzytkownik()
			->zwracaTablice('id', 'email', 'imie', 'nazwisko')
			->szukaj(array(
				'kody_rol' => $this->k->k['formularz.pracownicy_role'],
				'status' => 'aktywny',
			));
		foreach ($pracownicy as $pracownik)
		{
			$klucz = $tylkoZawierajacyEmail ? $pracownik['email'] : '{PRACOWNIK-'.$pracownik['id'].'}';
			$odbiorcy[$klucz] = $pracownik['imie'].' '.$pracownik['nazwisko'];
		}
		asort($odbiorcy);
		$odbiorcy = array_unique($odbiorcy);

		if ($tylkoZawierajacyEmail == false)
		{
			$odbiorcy = array_reverse($odbiorcy);
			foreach (array_reverse(array_keys(Pomocnik\Poczta::predefiniowaniOdbiorcy())) as $odbiorca)
			{
				$odbiorcy[$odbiorca] = $this->j->t['formatka.predefiniowani_odbiorcy'][$odbiorca];
			}
			$odbiorcy = array_reverse($odbiorcy);
		}
		return $odbiorcy;
	}



	public static function listaFormatek()
	{
		static $lista;
		if ( ! is_array($lista))
		{
			$dane = Cms::inst()->dane();
			$kategorie = $dane->WierszTlumaczen()->pobierzWartoscWierszaTlumaczen('formatka.kategorie', 'EmailZarzadzanie_Admin');
			$lista = array();
			$formatki = $dane->EmailFormatka()
				->zwracaTablice('id', 'tytul', 'kategoria')
				->szukaj(array(), null, new EmailFormatka\Sorter('tytul', 'ASC'));
			foreach ($formatki as $formatka)
			{
				$klucz = $kategorie[$formatka['kategoria']];
				$lista[$klucz][$formatka['id']] = $formatka['tytul'];
			}
		}
		return $lista;
	}

}
