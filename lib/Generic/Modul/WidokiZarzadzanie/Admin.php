<?php

namespace Generic\Modul\WidokiZarzadzanie;

use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;
use Generic\Model\Widok;
use Generic\Model\WidokPowiazania;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Blok;
use Generic\Model\DostepnyModul;
use Generic\Model\WierszKonfiguracji;
use Generic\Model\WierszTlumaczen;
use Generic\Model\BlokOpisowy;
use Generic\Model\Uprawnienie;
use Generic\Model\Uzytkownik;

/**
 * Modul administracyjny odpowiadajacy za zarzadzanie widokami z układem treści w cms-e.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */
class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\WidokiZarzadzanie\Admin
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\WidokiZarzadzanie\Admin
	 */
	protected $j;
	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajAktualizuj',
		'wykonajBloki',
		'wykonajDodajBlok',
		'wykonajEdytujBlok',
		'wykonajUsunBlok',
		'wykonajPobierzKonfiguracje',
		'wykonajWczytajKonfiguracje',
		'wykonajBudujUklad',
		'wykonajZapiszUklad',
	);

	/**
	 *
	 * @var array konfiguracja gridstera
	 */
	private $konfiguracjaGridstera = array(
		'podstawowaSzerokoscBloku' => 60,
		'podstawowaWysokoscBloku' => 60,
		'marginesWierszy' => 5,
		'marginesKolumn' => 5,
		'maxKolumn' => 12,
		'maxWierszy' => 50,
		'maxSzerokoscBloku' => 12,
		'maxWysokoscBloku' => 12,
		'autogenerate_stylesheet' => true,
		'avoid_overlapped_widgets' => true,
		'min_cols' => 12,
		'min_rows' => 15,
		'max_size_x' => 12,
		'max_size_y' => 12,
		'extra_cols' => 0,
		'extra_rows' => 0,
	);

	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval', 'abs'));
		$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
		$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
		$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

		$mapper = $this->dane()->Widok();
		$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);
		$sorter = new Widok\Sorter($kolumna, $kierunek);

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', null, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], null, Router::urlAdmin('WidokiZarzadzanie', 'edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('uklad_strony', $this->j->t['index.etykieta_ukladStrony'], 300);

		$grid->dodajPrzyciski(
				Router::urlAdmin('WidokiZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), array('edytuj', 'usun')
		);

		$grid->ustawSortownie(array('nazwa', 'uklad_strony'), $kolumna, $kierunek, Router::urlAdmin('WidokiZarzadzanie', '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
		);

		$grid->pager($pager->html(Router::urlAdmin('WidokiZarzadzanie', '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

		foreach ($mapper->zwracaTablice()->pobierzWszystko($pager, $sorter) as $widok)
		{
			$grid->dodajWiersz($widok);
		}

		$this->szablon->ustawBlok('/index', array(
			'grid' => $grid->html(),
			'link_dodaj' => Router::urlAdmin('WidokiZarzadzanie', 'dodaj'),
			'link_bloki' => Router::urlAdmin('WidokiZarzadzanie', 'bloki'),
			'link_budowanie_ukladu' => Router::urlAdmin('WidokiZarzadzanie', 'budujUklad'),
		));


		if ($this->k->k['wczytajKonfiguracje.pokaz_przyciski'])
		{
			$this->szablon->ustawBlok('/index/przyciski', array(
				'link_pobierz_konfiguracje' => Router::urlAdmin('WidokiZarzadzanie', 'pobierzKonfiguracje'),
				'link_wczytaj_konfiguracje' => Router::urlAdmin('WidokiZarzadzanie', 'wczytajKonfiguracje'),
			));
		}


		$this->tresc .= $this->szablon->parsujBlok('index');
	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$mapper = $this->dane()->Widok();
		$widok = new Widok\Obiekt;
		$widok->idProjektu = ID_PROJEKTU;
		$widok->kodJezyka = KOD_JEZYKA;

		$formularz = $this->budujFormularz($widok);

		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			$kopiowanyWidok = null;
			foreach ($formularz->pobierzZmienioneWartosci() as $klucz => $wartosc)
			{
				if ($klucz == 'kopiowanyWidok' && $wartosc != '')
				{
					$kopiowanyWidok = $mapper->pobierzPoId($wartosc);
					continue;
				}
				$widok->$klucz = $wartosc;
			}
			if ($kopiowanyWidok instanceof Widok\Obiekt)
			{
				$widok->ukladStrony = $kopiowanyWidok->ukladStrony;
				$widok->struktura = $kopiowanyWidok->struktura;
			}
			if ($widok->zapisz($mapper))
			{
				$this->komunikat($this->j->t['dodaj.info_zapisano_dane_widoku'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'edytuj', array('id' => $widok->id)));
			}
			else
			{
				$this->komunikat($this->j->t['dodaj.blad_nie_mozna_zapisac_widoku'], 'error');
			}
		}
		$this->tresc .= $this->szablon->parsujBlok('dodaj', array('form' => $formularz->html()));
	}



	/**
	 * Tworzy widok budowani układu
	 */
	public function wykonajBudujUklad()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['buduj.tytul_strony']));

		$gridster = $this->konfiguracjaGridstera;

		$mapperUzytkownicy = $this->dane()->Uzytkownik();
		$loginy = '';
		foreach ($mapperUzytkownicy->zwracaTablice()->szukaj(array()) as $uzytkownik)
		{
			$loginy .= '<li id="' . $uzytkownik['id'] . '"><a>' . $uzytkownik['imie'] . ' ' . $uzytkownik['nazwisko'] . '</a></li>' . PHP_EOL;
		}

		$mapperRole = $this->dane()->Rola();
		$role = '';

		foreach ($mapperRole->pobierzWszystko() as $rola)
		{
			$role .= '<li id="' . $rola->id . '"><a>' . $rola->nazwa . '</a></li>' . PHP_EOL;
		}

		$akcje = '';
		//TODO akcje - skąd brać i wpakować do dropdałna

		$widoki = '';
		$mapperWidoki = $this->dane()->Widok();
		foreach ($mapperWidoki->pobierzWszystko() as $widok)
		{
			$link = Router::urlAdmin('WidokiZarzadzanie', 'budujUklad', array('id' => $widok->id));
			$widoki .= '<li id="' . $widok->id . '"><a href="' . $link . '">' . $widok->nazwa . '</a></li>' . PHP_EOL;
		}

		$kodWczytaniaElementow = '';
		$nazwa_ukladu_strony = 'Nazwa widoku';
		$idWidoku = Zadanie::pobierz('id');
		if ($idWidoku != false)
		{
			$maperWidoku = $this->dane()->Widok();
			$widok = $maperWidoku->pobierzPoId($idWidoku);
			if ($widok->jsonUkladu != '')
			{
				$kodWczytaniaElementow = 'gridster.wczytajElementy(\'' . $widok->jsonUkladu . '\');';
			}
			$nazwa_ukladu_strony = $widok->nazwa;
		}

		$this->szablon->ustawBlok('/uklad', array(
			'a_wstecz_link' => Router::urlAdmin('WidokiZarzadzanie'),
			'a_zapisz_link' => Router::urlAdmin('WidokiZarzadzanie', 'zapiszUklad'),
			'maxKolumn' => $gridster['maxKolumn'],
			'maxWierszy' => $gridster['maxWierszy'],
			'max_szerokosc' => $gridster['maxSzerokoscBloku'],
			'max_wysokosc' => $gridster['maxWysokoscBloku'],
			'podstawowaSzerokosc' => $gridster['podstawowaSzerokoscBloku'],
			'podstawowaWysokosc' => $gridster['podstawowaWysokoscBloku'],
			'marginesKolumn' => $gridster['marginesKolumn'],
			'marginesWierszy' => $gridster['marginesWierszy'],
			'autogenerate_stylesheet' => $gridster['autogenerate_stylesheet'] ? 'true' : 'false',
			'avoid_overlapped_widgets' => $gridster['avoid_overlapped_widgets'] ? 'true' : 'false',
			'min_cols' => $gridster['min_cols'],
			'min_rows' => $gridster['min_rows'],
			'max_size_x' => $gridster['max_size_x'],
			'max_size_y' => $gridster['max_size_y'],
			'extra_cols' => $gridster['extra_cols'],
			'extra_rows' => $gridster['extra_rows'],
			'lista_wyboru_uzytkownikow' => $loginy,
			'lista_wyboru_grup' => $role,
			'lista_wyboru_akcji' => $akcje,
			'lista_istniejacych_widokow' => $widoki,
			'wczytanie_elementow_widoku' => $kodWczytaniaElementow,
			'nazwa_ukladu_strony' => $nazwa_ukladu_strony,
		));

		$this->tresc = $this->szablon->parsuj();
	}



	/**
	 * Zapisuje przesłany układ
	 * @return string json
	 */
	public function wykonajZapiszUklad()
	{
		$odpowiedz = array();
		$bloki = Zadanie::pobierzPost('bloki');
		if ($bloki == null || $bloki == '')
		{
			$odpowiedz['odpowiedzTekstowa'] = $this->j->t['gridster']['niezapisano_uklad'];
			die(json_encode($odpowiedz));
		}

		$blokiObiekty = json_decode($bloki);
		foreach ($blokiObiekty as $obiekt)
		{
			$obiekt->nazwa = str_replace("\t", '', str_replace("\n", '', $obiekt->nazwa));
		}
		$json = json_encode($blokiObiekty);
		$blokiTablica = array();
		foreach ($blokiObiekty as $obiektBloku)
		{
			$blokiTablica[$obiektBloku->wiersz][$obiektBloku->kolumna] = (array) $obiektBloku;
		}

		$html = $this->pobierzHtmlUkladu($blokiTablica);
		$nazwaUkladu = Zadanie::pobierzPost('nazwaUkladu');
		$nazwaUkladu = $nazwaUkladu == '' ? 'Nowy układ' : $nazwaUkladu;
		$uzytkownik = Zadanie::pobierzPost('uzytkownik', 'intval');
		if ($uzytkownik == false || $uzytkownik == '')
		{
			$uzytkownik = -1;
		}
		$grupa = Zadanie::pobierzPost('grupa', 'intval');
		if ($grupa == false || $grupa == '')
		{
			$grupa = -1;
		}
		$akcja = Zadanie::pobierzPost('jakaAkcja');

		if (!$this->zapiszUklad($blokiTablica, $json, $html, $nazwaUkladu, $uzytkownik, $grupa, $akcja))
		{
			$odpowiedz['odpowiedzTekstowa'] = $this->j->t['gridster']['niezapisano_uklad'] . " baza";
		}
		else
		{
			$odpowiedz['odpowiedzTekstowa'] = $this->j->t['gridster']['zapisano_uklad'] . ' jako: ' . $nazwaUkladu;
		}

		die(json_encode($odpowiedz));
	}



	/**
	 * Zapisuje do bazy układ html
	 * @param array $wiersze
	 * @param string $json
	 * @param string $html
	 * @return boolean
	 */
	private function zapiszUklad(Array $wiersze, $json, $html, $nazwaUkladu, $uzytkownik, $grupa, $akcja)
	{

		$cms = Cms::inst();
		$cms->Baza()->transakcjaStart();

		$widok = new Widok\Obiekt();
		$mapperWidoku = $this->dane()->Widok();

		$widok->idProjektu = ID_PROJEKTU;
		$widok->kodJezyka = KOD_JEZYKA;
		$widok->nazwa = $nazwaUkladu;
		$widok->struktura = 'uklad_podstawowy';
		$widok->ukladStrony = '';
		$widok->jsonUkladu = $json;
		$widok->htmlUkladu = $html;

		$statusy[] = $widok->zapisz($mapperWidoku);

		/**
		 * @var \Generic\Model\WidokPowiazania\Obiekt
		 */
		$powiazanie = new WidokPowiazania\Obiekt();
		$maperPowiazania = $this->dane()->WidokPowiazania();
		$powiazanie->idProjektu = ID_PROJEKTU;
		$powiazanie->kodJezyka = KOD_JEZYKA;
		$powiazanie->idWidoku = $widok->id;
		$powiazanie->akcja = '';//$akcja;
		$powiazanie->grupa = -1;//$grupa;
		$powiazanie->uzytkownik = -1;//$uzytkownik;
		$statusy[] = $powiazanie->zapisz($maperPowiazania);


		if (array_search(false, $statusy) === false)
		{
			$cms->Baza()->transakcjaPotwierdz();
			return true;
		}
		else
		{
			$cms->Baza()->transakcjaCofnij();
			return false;
		}
	}



	/**
	 * Generuje html zbudowanego układu
	 * @param string $bloki
	 */
	private function pobierzHtmlUkladu($bloki)
	{
		$sciezkaDoPlikuSzablonu = str_replace('domyslny', 'system', SZABLON_KATALOG) . '/'.SZABLON_UKLAD_HTML;
		$trescPliku = file_get_contents($sciezkaDoPlikuSzablonu);
		$szablon = new \Generic\Biblioteka\Szablon();
		$szablon->ladujTresc($trescPliku);
		foreach ($bloki as $numerWiersza => $wiersz)
		{
			$szablon->ustawBlok('/WIERSZ', array(
				'id' => $numerWiersza,
			));

			foreach ($wiersz as $numerKolumny => $blok)
			{
				extract($blok);
				$szablon->ustawBlok('/WIERSZ/BLOK', array(
					'wiersz' => $numerWiersza,
					'kolumna' => $numerKolumny,
					'nazwa' => $nazwa,
					'szerokosc' => $szerokosc,
					'min-height' => ($wysokosc * $this->konfiguracjaGridstera['podstawowaWysokoscBloku']),
				));
			}
		}
		return $szablon->parsuj();
	}



	public function wykonajEdytuj()
	{
		$mapper = $this->dane()->Widok();
		$id = Zadanie::pobierzGet('id', 'intval', 'abs');
		$widok = $mapper->pobierzPoId($id);
		$cms = Cms::inst();

		if ($widok instanceof Widok\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

			$this->ustawUrlPowrotny(Router::urlAdmin('WidokiZarzadzanie', 'edytuj', array('id' => $widok->id)), 'widok');
			$cms->sesja->idWidoku = $widok->id;
			if (Zadanie::pobierz('czysc', 'trim') && isset($cms->sesja->podglad_widokow) && isset($cms->sesja->podglad_widokow[$widok->id]))
			{
				$this->komunikat($this->j->t['edytuj.info_widok_domyslny'], 'info');
				unset($cms->sesja->podglad_widokow[$widok->id]);
			}
			if (isset($cms->sesja->podglad_widokow) && isset($cms->sesja->podglad_widokow[$widok->id]))
			{
				$this->komunikat($this->j->t['edytuj.info_widok_edytowany'], 'info');
				$widok->struktura = $cms->sesja->podglad_widokow[$widok->id];
			}
			$formularz = $this->budujFormularz($widok);

			if (Zadanie::pobierz('zapisz', 'trim') && $formularz->wypelniony() && $formularz->danePoprawne())
			{
				foreach ($formularz->pobierzZmienioneWartosci() as $klucz => $wartosc)
				{
					if ($klucz == 'podglad')
						continue;
					$widok->$klucz = $wartosc;
				}
				if ($widok->zapisz($mapper))
				{
					if (isset($cms->sesja->podglad_widokow) && isset($cms->sesja->podglad_widokow[$widok->id]))
					{
						unset($cms->sesja->podglad_widokow[$widok->id]);
					}
					$this->komunikat($this->j->t['edytuj.info_zapisano_dane_widoku'], 'info');
					Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'edytuj', array('id' => $id)));
				}
				else
				{
					$this->komunikat($this->j->t['edytuj.blad_nie_mozna_zapisac_widoku'], 'error');
				}
			}
			$dane['form'] = $formularz->html();
			$this->tresc .= $this->szablon->parsujBlok('edytuj', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_widoku'], 'error', 'sesja');
			Router::przekierujDo($this->pobierzUrlPowrotny('widoki'));
		}
	}



	public function wykonajUsun()
	{
		$mapper = $this->dane()->Widok();
		$widok = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval', 'abs'));
		if (!$widok instanceof Widok\Obiekt)
		{
			$this->komunikat($this->j->t['usun.blad_brak_widoku'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'index'));
		}

		$kategorie = $this->dane()->Kategoria();
		$przypisaneKategorie = array();
		foreach ($kategorie->pobierzWszystko() as $kategoria)
		{
			/* @var $kategoria Kategoria */
			if ($kategoria->idWidoku == $widok->id)
			{
				$przypisaneKategorie[] = $kategoria->nazwa . '(' . $kategoria->kodModulu . ')';
			}
		}
		if (count($przypisaneKategorie) > 0)
		{
			$this->komunikat(sprintf($this->j->t['usun.blad_przypisane_kategorie'], implode(', ', $przypisaneKategorie)), 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'index'));
		}

		if ($widok->usun($mapper))
		{
			$this->komunikat($this->j->t['usun.info_usunieto_widok'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_widoku'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'index'));
	}



	public function wykonajAktualizuj()
	{
		$widok = Zadanie::pobierzGet('widok', 'intval', 'abs');
		$stuktura = Zadanie::pobierz('struktura', 'strval', 'trim');
		if ($widok > 0 && $stuktura != '')
		{
			Cms::inst()->sesja->podglad_widokow[$widok] = $stuktura;
		}
	}



	public function wykonajBloki()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['bloki.tytul_strony']));

		$this->ustawUrlPowrotny(Router::urlAdmin('WidokiZarzadzanie', 'bloki'), 'widok');

		$naStronie = $this->pobierzParametr('blokiNaStronie', $this->k->k['bloki.wierszy_na_stronie'], true, array('intval', 'abs'));
		$nrStrony = $this->pobierzParametr('blokiNrStrony', 1, true, array('intval', 'abs'));
		$kolumna = $this->pobierzParametr('blokiKolumna', $this->k->k['bloki.domyslne_sortowanie'], true, array('strval'));
		$kierunek = $this->pobierzParametr('blokiKierunek', 'asc', true, array('strval'));

		$mapper = $this->dane()->Blok();
		$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);
		$sorter = new Blok\Sorter($kolumna, $kierunek);
		$urlTresc = Zadanie::protokol() . '://' . WWW_PREF . $cms->projekt->domena . '/admin/?blok={WARTOSC}&{KLUCZ}';

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', null, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['bloki.etykieta_nazwa'], null, $urlTresc);
		$grid->dodajKolumne('kod_modulu', $this->j->t['bloki.etykieta_kod_modulu'], 200);
		$grid->dodajKolumne('kontener', $this->j->t['bloki.etykieta_kontener'], 200);

		$grid->dodajPrzyciski(
				Router::urlAdmin('WidokiZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), array(
			'edytujTresc' => array(
				'akcja' => $urlTresc,
				'etykieta' => $this->j->t['bloki.etykieta_edytuj_tresc'],
				'ikona' => 'icon-file',
			),
			'edytujBlok' => array(
				'akcja' => Router::urlAdmin('WidokiZarzadzanie', 'edytujBlok', array('{KLUCZ}' => '{WARTOSC}')),
				'etykieta' => $this->j->t['bloki.etykieta_edytuj'],
				'ikona' => 'icon-pencil',
			),
			'usunBlok' => array(
				'akcja' => Router::urlAdmin('WidokiZarzadzanie', 'usunBlok', array('{KLUCZ}' => '{WARTOSC}')),
				'etykieta' => $this->j->t['bloki.etykieta_usun'],
				'ikona' => 'icon-remove',
				'onclick' => 'return potwierdzenieUsun(\'' . $this->j->t['bloki.etykieta_potwierdz_usun'] . '\', $(this));',
			),
				)
		);

		$grid->ustawSortownie(array('nazwa', 'kod_modulu', 'kontener'), $kolumna, $kierunek, Router::urlAdmin('WidokiZarzadzanie', 'bloki', array('blokiKolumna' => '{KOLUMNA}', 'blokiKierunek' => '{KIERUNEK}'))
		);

		$grid->pager($pager->html(Router::urlAdmin('WidokiZarzadzanie', 'bloki', array('blokiNrStrony' => '{NR_STRONY}', 'blokiNaStronie' => '{NA_STRONIE}'))));

		foreach ($mapper->zwracaTablice()->pobierzWszystko($pager, $sorter) as $widok)
		{
			$grid->dodajWiersz($widok);
		}

		$this->szablon->ustawBlok('/bloki', array(
			'grid' => $grid->html(),
			'link_dodaj' => Router::urlAdmin('WidokiZarzadzanie', 'dodajBlok'),
		));
		$this->tresc .= $this->szablon->parsujBlok('bloki');
	}



	public function wykonajDodajBlok()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodajBlok.tytul_strony']));

		$mapper = $this->dane()->Blok();
		$blok = new Blok\Obiekt;
		$blok->idProjektu = ID_PROJEKTU;
		$blok->kodJezyka = KOD_JEZYKA;

		$formularz = $this->budujFormularzBlok($blok);

		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			foreach ($formularz->pobierzZmienioneWartosci() as $klucz => $wartosc)
			{
				$blok->$klucz = $wartosc;
			}
			if ($blok->zapisz($mapper))
			{
				$this->tworzUprawnienia($blok);
				$this->komunikat($this->j->t['dodajBlok.info_zapisano_dane_bloku'], 'info', 'sesja');
				Router::przekierujDo($this->pobierzUrlPowrotny('widok'));
			}
			else
			{
				$this->komunikat($this->j->t['dodajBlok.blad_nie_mozna_zapisac_bloku'], 'error');
			}
		}
		$dane['form'] = $formularz->html();
		$this->tresc .= $this->szablon->parsujBlok('dodajBlok', $dane);
	}



	public function wykonajEdytujBlok()
	{
		$mapper = $this->dane()->Blok();
		$blok = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval', 'abs'));

		if ($blok instanceof Blok\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytujBlok.tytul_strony']));

			$formularz = $this->budujFormularzBlok($blok);
			if ($formularz->wypelniony() && $formularz->danePoprawne())
			{
				foreach ($formularz->pobierzZmienioneWartosci() as $klucz => $wartosc)
				{
					if ($blok->kodModulu != '' && in_array($klucz, array('kodModulu', 'widoki')))
						continue;
					$blok->$klucz = $wartosc;
				}
				if ($blok->zapisz($mapper))
				{
					$this->komunikat($this->j->t['edytujBlok.info_zapisano_dane_bloku'], 'info', 'sesja');
					Router::przekierujDo($this->pobierzUrlPowrotny('widok'));
				}
				else
				{
					$this->komunikat($this->j->t['edytujBlok.blad_nie_mozna_zapisac_bloku'], 'error');
				}
			}
			$this->tresc .= $this->szablon->parsujBlok('edytujBlok', array('form' => $formularz->html()));
		}
		else
		{
			$this->komunikat($this->j->t['edytujBlok.blad_brak_bloku'], 'error', 'sesja');
			Router::przekierujDo($this->pobierzUrlPowrotny('widok'));
		}
	}



	public function wykonajUsunBlok()
	{
		$idBloku = Zadanie::pobierzGet('id', 'intval', 'abs');
		$mapper = $this->dane()->Blok();
		$blok = $mapper->pobierzPoId($idBloku);
		if ($blok instanceof Blok\Obiekt)
		{
			$widoki = $this->dane()->Widok();
			$lista = $widoki->pobierzZawierajaceBlok($blok->id);
			if (count($lista) > 0)
			{
				$w = array();
				foreach ($lista as $widok)
					$w[] = $widok->nazwa;
				$this->komunikat(sprintf($this->j->t['usunBlok.blad_istnieja_widoki_zawierajace'], implode(', ', $w)), 'error', 'sesja');
				Router::przekierujDo($this->pobierzUrlPowrotny('widok'));
			}
			elseif ($blok->usun($mapper))
			{
				$uprawnieniaMapper = $this->dane()->Uprawnienie();
				$uprawnieniaMapper->usunDlaBloku($idBloku);
				$this->komunikat($this->j->t['usunBlok.info_usunieto_blok'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usunBlok.blad_nie_mozna_usunac_bloku'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usunBlok.blad_brak_bloku'], 'error', 'sesja');
		}
		Router::przekierujDo($this->pobierzUrlPowrotny('widok'));
	}



	public function wykonajPobierzKonfiguracje()
	{
		$tresc = '';
		$dane = array();
		$konfiguracjaBlokow = array();
		$tlumaczeniaBlokow = array();
		$opisyBlokow = array();
		$widoki = array();
		$bloki = array();

		$bloki = $this->dane()->Blok()->zwracaTablice()->pobierzWszystko();
		$konfiguracja = $this->dane()->WierszKonfiguracji()->zwracaTablice()->pobierzPelna();
		$tlumaczenia = $this->dane()->WierszTlumaczen()->zwracaTablice()->pobierzPelna();
		$opisy = $this->dane()->BlokOpisowy()->zwracaTablice()->pobierzWszystko();
		$widoki = $this->dane()->Widok()->zwracaTablice()->pobierzWszystko();

		foreach ($konfiguracja as $wiersz)
		{
			if (intval($wiersz['id_bloku']) > 0)
			{
				$konfiguracjaBlokow[$wiersz['id_bloku']][] = $wiersz;
			}
		}

		foreach ($tlumaczenia as $wiersz)
		{
			if (intval($wiersz['id_bloku']) > 0)
			{
				$tlumaczeniaBlokow[$wiersz['id_bloku']][] = $wiersz;
			}
		}

		foreach ($opisy as $wiersz)
		{
			if (intval($wiersz['id_bloku']) > 0)
			{
				$opisyBlokow[$wiersz['id_bloku']] = $wiersz;
			}
		}

		$dane = array(
			'bloki' => $bloki,
			'konfiguracja_blokow' => $konfiguracjaBlokow,
			'tlumaczenia_blokow' => $tlumaczeniaBlokow,
			'opisy_blokow' => $opisyBlokow,
			'widoki' => $widoki,
		);

		/**
		 * Tworzenie sumy kontrolnej dla konfiguracji widokow, zabezpieczenie przed majstronwanie przy pliku z konfiguracja
		 */
		$dane['suma_kontrolna'] = md5('SuperTraders jest the best!!!' . var_export($dane, true) . 'SuperTraders jest the best!!!');

		$tresc = "<?php
namespace Generic\Modul\WidokiZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;
use Generic\Model\Widok;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Blok;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Model\DostepnyModul;
use Generic\Model\WierszKonfiguracji;
use Generic\Model\WierszTlumaczen;
use Generic\Model\BlokOpisowy;
use Generic\Model\UkladStrony;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Szablon;
use Generic\Model\Uprawnienie;
 return " . var_export($dane, true) . ";";
		zwrocTrescDoPrzegladarki($tresc, 'widokiKonfiguracja.inc.php');
	}



	public function wykonajWczytajKonfiguracje()
	{
		$cms = Cms::inst();

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['wczytajKonfiguracje.tytul_strony']));

		$obiektFormularza = new \Generic\Formularz\Konfiguracja\Import();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('wczytajKonfiguracje'))
				->ustawUrlPowrotny(Router::urlAdmin('WidokiZarzadzanie'))
				->ustawKonfiguracje(array('dozwolone_formaty_plikow' => $this->k->k['wczytajKonfiguracje.dozwolone_formaty_plikow']));

		if ($obiektFormularza->wypelniony())
		{
			if ($obiektFormularza->danePoprawne())
			{
				$plik_konfiguracja = $obiektFormularza->zwrocFormularz()->plik->pobierzWartosc();

				if (is_file($plik_konfiguracja['tmp_name']))
				{
					$dane = @include($plik_konfiguracja['tmp_name']);

					/**
					 * Sprawdzanie czy wczytany plik jest tablica i czy ustawiona jest suma kontrolna
					 */
					if (is_array($dane) && isset($dane['suma_kontrolna']))
					{
						/**
						 * Sprawdzanie czy suma kontrolna pliku z konfiguracja jest poprawna
						 */
						$sumaKontrolna = $dane['suma_kontrolna'];
						unset($dane['suma_kontrolna']);

						$dane['suma_kontrolna'] = md5('SuperTraders jest the best!!!' . var_export($dane, true) . 'SuperTraders jest the best!!!');

						if ($sumaKontrolna == $dane['suma_kontrolna'])
						{
							$cms->Baza()->transakcjaStart();

							$statusy = array();
							$dostepneBloki = array();
							$bledy = array();

							$konfiguracjaMapper = $this->dane()->WierszKonfiguracji();
							$tlumaczeniaMapper = $this->dane()->WierszTlumaczen();
							$uprawnieniaMapper = $this->dane()->Uprawnienie();
							$opisyMapper = $this->dane()->BlokOpisowy();
							$blokiMapper = $this->dane()->Blok();
							$widokiMapper = $this->dane()->Widok();
							$modulyMapper = DostepnyModul\Mapper::wywolaj();

							if ($this->k->k['wczytajKonfiguracje.kasuj_stara_konfiguracje'])
							{
								$blokiMapper->usunWszystko();
								$widokiMapper->usunWszystko();
								$konfiguracjaMapper->czyscDlaBlokow();
								$tlumaczeniaMapper->czyscDlaBlokow();
								$uprawnieniaMapper->usunDlaBlokow();
							}

							$przypisaneModuly = listaZTablicy($modulyMapper->zwracaTablice()->pobierzPrzypisane(), null, 'kod');

							$stareBloki = listaZObiektow($blokiMapper->pobierzWszystko(), 'id');
							$stareWidoki = listaZObiektow($widokiMapper->pobierzWszystko(), 'id');

							/**
							 * Zapisanie do bazy danych zaimportowanych blokow
							 */
							foreach ($dane['bloki'] as $wiersz)
							{
								/**
								 * Jesli importowany blok jest utworzony z modulu ktory jest nie przypisany do projektu, omijamy go
								 */
								if (array_search($wiersz['kod_modulu'], $przypisaneModuly) === false)
								{
									$bledy['brak_modulu'][] = $wiersz;
									continue;
								}

								/**
								 * Sprawdzanie czy blok o podany id jest juz utworzony, jesli tak aktualizujemy go, w przeciwnym wypadku zapisujemy nowy blok do bazy z ustawionym na sztywno id
								 */
								if (isset($stareBloki[$wiersz['id']]))
								{
									$blok = $stareBloki[$wiersz['id']];
								}
								else
								{
									$blok = new Blok\Obiekt();
								}

								$polaBool = array('cache',);
								/**
								 * Zapisanie zaimportowanego bloku
								 */
								foreach ($wiersz as $pole => $wartosc)
								{
									if ($pole == 'id')
										continue;
									if (in_array($pole, $polaBool))
										$wartosc = (int) $wartosc;
									$pole = ucfirstWord($pole);
									$blok->$pole = $wartosc;
								}

								/**
								 * Sprawdzanie czy blok o podany id jest juz utworzony, jesli tak aktualizujemy go, w przeciwnym wypadku zapisujemy nowy blok do bazy z ustawionym na sztywno id
								 */
								if (isset($stareBloki[$wiersz['id']]))
								{
									$statusy[] = $blok->zapisz($blokiMapper);
									$idBloku = $blok->id;
								}
								else
								{
									$statusy[] = $blokiMapper->wstawZId($blok, $wiersz['id']);
									$idBloku = $wiersz['id'];
								}

								$konfiguracjaMapper->czyscDlaBloku($idBloku);
								$tlumaczeniaMapper->czyscDlaBloku($idBloku);
								$dostepneBloki[] = $idBloku;

								/**
								 * Jesli istnieje konfiguracja dla bloku, zapisujemy ja do bazy
								 */
								if (isset($dane['konfiguracja_blokow'][$wiersz['id']]))
								{
									foreach ($dane['konfiguracja_blokow'][$wiersz['id']] as $wierszKonfiguracji)
									{
										$wierszK = new WierszKonfiguracji\Obiekt();
										foreach ($wierszKonfiguracji as $pole => $wartosc)
										{
											if ($pole == 'id')
												continue;
											$pole = ucfirstWord($pole);
											$wierszK->$pole = $wartosc;
										}
										$statusy[] = $wierszK->zapisz($konfiguracjaMapper);
									}
								}

								/**
								 * Jesli istnieja tlumaczenia dla bloku, zapisujemy je do bazy
								 */
								if (isset($dane['tlumaczenia_blokow'][$wiersz['id']]))
								{
									foreach ($dane['tlumaczenia_blokow'][$wiersz['id']] as $wierszTlumaczen)
									{
										$wierszT = new WierszTlumaczen\Obiekt();
										foreach ($wierszTlumaczen as $pole => $wartosc)
										{
											if ($pole == 'id')
												continue;
											$pole = ucfirstWord($pole);
											$wierszT->$pole = $wartosc;
										}
										$statusy[] = $wierszT->zapisz($tlumaczeniaMapper);
									}
								}

								/**
								 * Jesli blok jest opisowy, nadpisujemy jego tresc
								 */
								if (isset($dane['opisy_blokow'][$wiersz['id']]))
								{
									$wierszO = $opisyMapper->pobierzDlaBloku($idBloku);

									if (!$wierszO instanceof BlokOpisowy\Obiekt)
									{
										$wierszO = new BlokOpisowy\Obiekt();
									}

									foreach ($dane['opisy_blokow'][$wiersz['id']] as $pole => $wartosc)
									{
										if ($pole == 'id' || $pole == 'id_uzytkownika')
											continue;
										$pole = ucfirstWord($pole);
										$wierszO->$pole = $wartosc;
									}

									$statusy[] = $wierszO->zapisz($opisyMapper);
								}
							}

							/**
							 * Zapisanie zaimportowanych widokow
							 */
							foreach ($dane['widoki'] as $wiersz)
							{
								/**
								 * Sprawdzanie czy widok o podany id jest juz utworzony, jesli tak aktualizujemy go, w przeciwnym wypadku zapisujemy nowy widok do bazy z ustawionym na sztywno id
								 */
								if (isset($stareWidoki[$wiersz['id']]))
								{
									$widok = $stareWidoki[$wiersz['id']];
								}
								else
								{
									$widok = new Widok\Obiekt();
								}

								/**
								 * Sprawdzanie czy bloki ktore przypisane sa do ukladu strony istnieja, jesli nie usuwamy je z ukladow strony
								 */
								foreach (explode(',', $wiersz['struktura']) as $wartosc)
								{
									$idBloku = intval(str_replace('blok_', '', $wartosc));

									if ($idBloku > 0 && array_search($idBloku, $dostepneBloki) === false)
									{
										$bledy['brak_bloku'][$wiersz['id']][] = array(
											'id_widoku' => $wiersz['id'],
											'id_bloku' => $idBloku,
										);
										$wiersz['struktura'] = str_replace($wartosc . ',', '', $wiersz['struktura']);
									}
								}

								/**
								 * Zapisanie zaimportowanego widoku
								 */
								foreach ($wiersz as $pole => $wartosc)
								{
									if ($pole == 'id')
										continue;
									$pole = ucfirstWord($pole);
									$widok->$pole = $wartosc;
								}

								/**
								 * Sprawdzanie czy widok o podany id jest juz utworzony, jesli tak aktualizujemy go, w przeciwnym wypadku zapisujemy nowy widok do bazy z ustawionym na sztywno id
								 */
								if (isset($stareWidoki[$wiersz['id']]))
								{
									$statusy[] = $widok->zapisz($widokiMapper);
								}
								else
								{
									$statusy[] = $widokiMapper->wstawZId($widok, $wiersz['id']);
								}
							}

							foreach ($bledy['brak_modulu'] as $blad)
							{
								$this->szablon->ustawBlok('bledy/blad_brak_modulu', $blad);
							}

							/**
							 * Sprawdzanie czy import zostal przeprowadzony prawidlowo
							 */
							if (array_search(false, $statusy) === false)
							{
								$trescKomunikatu = $this->j->t['wczytajKonfiguracje.wczytano_konfiguracje'];
								$trescKomunikatu .= $this->szablon->parsujBlok('bledy');

								$cms->Baza()->transakcjaPotwierdz();
								$this->komunikat($trescKomunikatu, 'info', 'sesja');
								Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'index'));
							}
							else
							{
								$cms->Baza()->transakcjaCofnij();
								$this->komunikat($this->j->t['wczytajKonfiguracje.blad_nie_wczytano_konfiguracji'], 'error', 'sesja');
								Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'index'));
							}
						}
						else
						{
							$this->komunikat($this->j->t['wczytajKonfiguracje.niepoprawny_plik'], 'error', 'sesja');
							Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'index'));
						}
					}
					else
					{
						$this->komunikat($this->j->t['wczytajKonfiguracje.niepoprawny_plik'], 'error', 'sesja');
						Router::przekierujDo(Router::urlAdmin('WidokiZarzadzanie', 'index'));
					}
				}
			}
		}

		$this->tresc .= $obiektFormularza->html();
	}



	private function budujFormularz(Widok\Obiekt $widok)
	{
		$obiektFormularza = new \Generic\Formularz\Widok\Edycja();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
				->ustawTlumaczenia($this->pobierzBlokTlumaczen('blok'))
				->ustawKonfiguracje(array('formularz.wymagane_pola' => $this->k->k['formularz.wymagane_pola']))
				->ustawObiekt($widok)
				->ustawSzablon($this->szablon);

		return $obiektFormularza->zwrocFormularz();
	}



	private function budujFormularzBlok(Blok\Obiekt $blok)
	{
		$cms = Cms::inst();

		$obiektFormularza = new \Generic\Formularz\Widok\EdycjaBlok();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
				->ustawTlumaczenia($this->pobierzBlokTlumaczen('bloki'))
				->ustawKonfiguracje(array('wymagane_pola' => $this->k->k['formularz.wymagane_pola']))
				->ustawSzablonKontenery($this->ladujSzablonZewnetrzny($this->k->k['szablon.kontenery']))
				->ustawUrlPowrotny($this->pobierzUrlPowrotny('widok'))
				->ustawObiekt($blok);

		return $obiektFormularza->zwrocFormularz();
	}



	private function tworzUprawnienia(Blok\Obiekt $blok)
	{
		// budujemy tablice z kodami uprawnien do bloku
		$uprawnienia = array();
		$modul = 'Generic\\Modul\\' . $blok->kodModulu . '\\Http';
		$modul = new $modul;
		foreach ($modul->pobierzUprawnienia() as $akcja)
		{
			$uprawnienia['Bloki_' . $blok->kodModulu . '_'.$blok->id . '_' . $akcja] = $blok->kodModulu;
		}

		// pobieramy istniejace uprawnienia z bazy i jezeli jakichs brak to tworzymy nowe
		$uprawnieniaMapper = $this->dane()->Uprawnienie();
		$dane_baza = $uprawnieniaMapper->pobierzDlaModulu($blok->kodModulu);
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[$wiersz->usluga . '_' . $wiersz->idKategorii . '_' . $wiersz->akcja] = $wiersz;
			}
		}
		foreach ($uprawnienia as $kod => $modul)
		{
			if (!array_key_exists($kod, $uprawnienia_baza))
			{

				$uprawnienie = new Uprawnienie\Obiekt();
				$uprawnienie->idProjektu = ID_PROJEKTU;
				$uprawnienie->kodJezyka = KOD_JEZYKA;
				$uprawnienie->hash = funkcjaHashujaca($kod);
                $kod = explode('_', $kod);
				$uprawnienie->usluga = $kod[0];
				$uprawnienie->idKategorii = $kod[1];
                $uprawnienie->akcja = $kod[2];
				$uprawnienie->kodModulu = $modul;
				$uprawnienie->zapisz($uprawnieniaMapper);
				$kod = implode('_', $kod);
				$uprawnienia_baza[$kod] = $uprawnienie;
			}
		}

		// sprawdzamy czy istnieja role z dostepem do modulu i jezeli sa to tworzymy powiazania z uprawnieniami
		$roleMapper = $this->dane()->Rola();
		$role = $roleMapper->zwracaTablice()->pobierzDlaDostepnegoModulu($blok->kodModulu);
		if (count($role) > 0)
		{
			foreach ($role as $rola)
			{
				foreach ($uprawnienia as $kod => $modul)
				{
					$uprawnienia_baza[$kod]->przypiszDoRoli($rola['id']);
				}
			}
		}
		// odswierzanie uprawnien uzytkownika
		Cms::inst()->profil()->odnowUprawnienia();
	}



}

