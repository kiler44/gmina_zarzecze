<?php
namespace Generic\Modul\UzytkownicyZarzadzanie;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Walidator;
use Generic\Model\Rola;
use Generic\Biblioteka\Pomocnik;
use Generic\Model\PlikPrywatny;
use Generic\Biblioteka\MenedzerPlikow;
use Generic\Biblioteka\Plik\MultiUpload;

/**
 * Modul administracyjny odpowiedzialny za zarzadząnie użytkownikami w cms-ie.
 *
 * @author Lukasz Wrucha
 * @package moduly
 */

class Admin extends Modul\System
{
	/**
	 * @var \Generic\Konfiguracja\Modul\UzytkownicyZarzadzanie\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\UzytkownicyZarzadzanie\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'edycjaDanychKontaktowych',
		'edycjaDanychFirmowych',
		'edycjaDanychPoczty',
		'edycjaRoli',
		'edycjaDodatkoweAkcje',
		'edycjaKolekcje',
		'edycjaPliki',
		'edycjaDaneTidsbanken',
		'edycjaStawkaUzytkownika',
		'edycjaDanychOpiekuna',
		'wykonajPrzechwyc',
		'wykonajUsun',
		'wykonajEmailAktywacyjny',
		'wykonajUsunZdjecie',
		'edycjaDanychPracowniczych',
		'wykonajZapiszPlik',
		'wykonajUsunPlik',
		'wykonajPrzypiszUprawnieniaDoPliku',
	);

	protected $zdarzenia = array(
		'usunieto_uzytkownika',
		'zablokowano_uzytkownika',
		'odblokowano_uzytkownika',
		'przechwycono_konto',
		'wyslano_email_aktywacyjny',
		'wyswietlono_formularz' => 'Generic\\Zdarzenie\\FormularzWyswietlony',
		'blad_walidacji_formularza' => 'Generic\\Zdarzenie\\FormularzBladWalidacji',
	);

	public function __construct() {
		parent::__construct();

		$this->k = new \Generic\Konfiguracja\Modul\UzytkownicyZarzadzanie\Admin();
	}


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony']
		));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('login', $this->j->t['index.etykieta_login'], 0, Router::urlAdmin('UzytkownicyZarzadzanie','edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('email', $this->j->t['index.etykieta_email'], 300);
		$grid->dodajKolumne('imie', $this->j->t['index.etykieta_imie']);
		$grid->dodajKolumne('nazwisko', $this->j->t['index.etykieta_nazwisko']);
		$grid->dodajKolumne('status', $this->j->t['index.etykieta_status'], 100);
		$grid->dodajKolumne('czy_admin', $this->j->t['index.etykieta_czy_admin'], 50);
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_data_dodania'], 150);

		$akcje = array('edytuj','usun');
		if ($this->moznaWykonacAkcje('wykonajPrzechwyc'))
		{
			$akcje[] = array(
				'akcja' => Router::urlAdmin('UzytkownicyZarzadzanie', 'przechwyc', array('{KLUCZ}' => '{WARTOSC}')),
				'ikona' => 'icon-magic',
				'etykieta' => $this->j->t['index.etykieta_button_przechwyc'],
			);
		}
		$grid->dodajPrzyciski(
			Router::urlAdmin('UzytkownicyZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			$akcje
		);

		$kryteria = $this->formularzWyszukiwania($grid);

		$mapper = $this->dane()->Uzytkownik();
		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$sorter = new Uzytkownik\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('login', 'email', 'imie', 'nazwisko', 'data_dodania'), $kolumna, $kierunek,
				Router::urlAdmin('UzytkownicyZarzadzanie', '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
			$grid->pager($pager->html(Router::urlAdmin('UzytkownicyZarzadzanie', '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach ($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $uzytkownik)
			{
				$uzytkownik['czy_admin'] = $this->j->t['uzytkownik.czyAdmin'][(bool)$uzytkownik['czy_admin']];
				$uzytkownik['status'] = $this->j->t['uzytkownik.statusy'][$uzytkownik['status']];

				$grid->dodajWiersz($uzytkownik);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
				'tabela_danych' => $grid->html(),
				'link_dodaj' => Router::urlAdmin('UzytkownicyZarzadzanie', 'dodaj'),
		));
	}


	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['dodaj.tytul_strony'],
			'tytul_modulu' => $this->j->t['dodaj.tytul_strony'],
		));

		$uzytkownik = new Uzytkownik\Obiekt();

		$dane['form'] = $this->formularz($uzytkownik);

		$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
	}



	public function wykonajEdytuj()
	{
		$mapper = $this->dane()->Uzytkownik();
		$uzytkownik = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if ($uzytkownik instanceof Uzytkownik\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony'].$uzytkownik->login));
			$dane['form'] = $this->formularz($uzytkownik);
			$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_uzytkownika'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie'));
		}
	}



	public function wykonajPrzechwyc()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Uzytkownik();
		$uzytkownik = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));
		if ( ! ($uzytkownik instanceof Uzytkownik\Obiekt))
		{
			$this->komunikat($this->j->t['przechwyc.blad_brak_uzytkownika'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie'));
		}

		$obiektFormularza = new \Generic\Formularz\Uzytkownik\Przechwycenie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('przechwyc'))
			->ustawObiekt($uzytkownik)
			->ustawUrlPowrotny(Router::urlAdmin('UzytkownicyZarzadzanie'));

		if ($obiektFormularza->wypelniony())
		{
			$this->zdarzenie('przechwycono_konto', array(
				'login_przechwycil' => $cms->profil()->login,
				'id_przechwycil' => $cms->profil()->id,
				'imie_przechwycil' => $cms->profil()->imie,
				'nazwisko_przechwycil' => $cms->profil()->nazwisko,
				'login' => $uzytkownik->login,
				'id' => $uzytkownik->id,
				'imie' => $uzytkownik->imie,
				'nazwisko' => $uzytkownik->nazwisko,
			));

			$cms->sesja->pracownikBok = $cms->profil();
			$cms->sesja->uzytkownik = $uzytkownik;
			$this->komunikat(sprintf($this->j->t['przechwyc.info_przechwycono_uzytkownika'], trim($uzytkownik->pelnaNazwa.' ('.$uzytkownik->login.')')), 'info', 'system');
			if ($cms->profil()->czyAdmin && false)
			{
				Router::przekierujDo(Router::urlAdmin('KontoAdministracyjne'));
			}
			else
			{
				Router::przekierujDo('http://'.$cms->projekt->domena);
			}
		}
		else
		{
			$this->tresc .= $obiektFormularza->html();
		}
	}



	public function wykonajUsun()
	{
		$mapper = $this->dane()->Uzytkownik();
		$uzytkownik = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		$dane_dodatkowe = array(
			'login' => $uzytkownik->login,
		);

		if ($uzytkownik instanceof Uzytkownik\Obiekt)
		{
			Cms::inst()->Baza()->transakcjaStart();

			$idUsuwanego = $uzytkownik->id;

			if ($this->usunUzytkownikaZSystemu($uzytkownik) && $uzytkownik->usun($mapper))
			{
				$kryteria = array();
				$kryteria['odbiorca'] = $idUsuwanego;

				// zamykamy transakcje - przed dokumentami dlatego, że poprawNieprzypisaneDokumenty() inicjują własną transakcję
				Cms::inst()->Baza()->transakcjaPotwierdz();

				// dokumenty
				$this->komunikat($this->j->t['usun.info_uzytkownik_usuniety'], 'info', 'sesja');
				$this->zdarzenie('usunieto_uzytkownika', $dane_dodatkowe);
			}
			else
			{
				Cms::inst()->Baza()->transakcjaCofnij();
				$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_uzytkownika'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_brak_uzytkownika'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie','index'));
	}


	protected function usunUzytkownikaZSystemu(Uzytkownik\Obiekt $uzytkownik)
	{
		return $this->usunUzytkownikaZMaili($uzytkownik);
	}


	protected function usunUzytkownikaZMaili(Uzytkownik\Obiekt $uzytkownik)
	{
		$poszukiwanaFraza = '{PRACOWNIK-' . $uzytkownik->id . '}';

		$formatki = $this->dane()->EmailFormatka()->szukaj(array('email' => $poszukiwanaFraza));

		foreach ($formatki as $formatka)
		{
			$formatka->emailOdbiorcy = $this->usunZTablicy($formatka->emailOdbiorcy, $poszukiwanaFraza);
			$formatka->emailKopie = $this->usunZTablicy($formatka->emailKopie, $poszukiwanaFraza);
			$formatka->emailKopieUkryte = $this->usunZTablicy($formatka->emailKopieUkryte, $poszukiwanaFraza);
			$formatka->emailOdpowiedzi = $this->usunZTablicy($formatka->emailOdpowiedzi, $poszukiwanaFraza);

			if ( ! $formatka->zapisz($this->dane()->EmailFormatka()))
			{
				return false;
			}
		}

		return true;
	}


	protected function usunZTablicy(Array $tablica, $wartoscUsuwana)
	{
		foreach ($tablica as $klucz => $wartosc)
		{
			if ($wartosc == $wartoscUsuwana)
			{
				unset ($tablica[$klucz]);
			}
		}

		return $tablica;
	}



	public function wykonajEmailAktywacyjny()
	{
		$mapper = $this->dane()->Uzytkownik();
		$uzytkownik = $mapper->zwracaObiekt()->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if ( ! $uzytkownik instanceof Uzytkownik\Obiekt)
		{
			$this->komunikat($this->j->t['emailAktywacyjny.blad_brak_uzytkownika'],'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie','edytuj', array('id'=>Zadanie::pobierzGet('id', 'intval','abs'))));
		}
		
		if ($uzytkownik->status != 'aktywny')
		{
			if ($this->wyslijEmailAktywacyjny($uzytkownik))
			{
				$this->komunikat($this->j->t['emailAktywacyjny.info_utworzono_konto_uzytkownika'], 'info', 'sesja');
				$this->zdarzenie('wyslano_email_aktywacyjny', array(
					'login' => $uzytkownik->login,
				));
			}
			else
			{
				$this->komunikat($this->j->t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego'],'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie','edytuj', array('id'=>Zadanie::pobierzGet('id', 'intval','abs'))));
	}


	private function formularz(Uzytkownik\Obiekt $uzytkownik)
	{
		$cms = Cms::inst();

		$obiektFormularza = new \Generic\Formularz\Uzytkownik\EdycjaAdmin();
		
		$kategorieMapper = $this->dane()->Kategoria();

		$kategoriaOrders = $kategorieMapper->pobierzDlaModulu('Tidsbanken');
        $konfiguracja = $this->k->k;
		if(isset($kategoriaOrders[0]))
        {
            $urlDodajStawke = Router::urlAjax('admin', $kategoriaOrders[0], 'dodajStawke');
            $urlUsunStawke = Router::urlAjax('admin', $kategoriaOrders[0], 'usunStawke');
            $urlAktualizujStawke = Router::urlAjax('admin', $kategoriaOrders[0], 'aktualizujStawke');
            $konfiguracja = array_merge(
                $konfiguracja,
                array('urlDodajStawke' => $urlDodajStawke, 'urlUsunStawke' => $urlUsunStawke, 'urlAktualizujStawke' => $urlAktualizujStawke)
            );
        }


		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawTlumaczenia(array(
				'plecWartosc' => $this->j->t['plec'],
				'uzytkownik.statusy' => $this->j->t['uzytkownik.statusy'],
			))
			->ustawObiekt($uzytkownik)
			->ustawUrlPowrotny(Router::urlAdmin('UzytkownicyZarzadzanie'))
			->ustawUprawnienia(array(
				'edycjaDanychKontaktowych' => $this->moznaWykonacAkcje('edycjaDanychKontaktowych'),
				'edycjaDanychFirmowych' => $this->moznaWykonacAkcje('edycjaDanychFirmowych'),
				'edycjaDanychPoczty' => $this->moznaWykonacAkcje('edycjaDanychPoczty'),
				'edycjaRoli' => $this->moznaWykonacAkcje('edycjaRoli'),
				'edycjaDaneTidsbanken' => $this->moznaWykonacAkcje('edycjaDaneTidsbanken'),
				'edycjaStawkaUzytkownika' => $this->moznaWykonacAkcje('edycjaStawkaUzytkownika'),
				'edycjaDodatkoweAkcje' => $this->moznaWykonacAkcje('edycjaDodatkoweAkcje'),
				'edycjaKolekcje' => $this->moznaWykonacAkcje('edycjaKolekcje'),
				'edycjaPliki' => $this->moznaWykonacAkcje('edycjaPliki'),
				'wykonajPrzechwyc' => $this->moznaWykonacAkcje('wykonajPrzechwyc'),
				'edycjaDanychPracowniczych' => $this->moznaWykonacAkcje('edycjaDanychPracowniczych'),
                'edycjaDanychOpiekuna' => $this->moznaWykonacAkcje('edycjaDanychOpiekuna'),
			))
			->ustawKonfiguracje( $konfiguracja );

		$nowyUzytkownik = false;
		$zalaczniki = array();
		$this->zdarzenie('wyswietlono_formularz', array(), $obiektFormularza->zwrocFormularz()->pobierzIdentyfikatorFormularza());
		if ($obiektFormularza->zwrocFormularz()->wypelniony())
		{
			
			if ($uzytkownik->id < 1)
			{
				$obiektFormularza->zwrocFormularz()->login->dodajWalidator(new Walidator\RozneOd($cms->config['superuzytkownik']['login']));

				$mapper = $this->dane()->Uzytkownik();
				$istniejacy_uzytkownik = $mapper->pobierzPoLoginie($obiektFormularza->zwrocFormularz()->login->pobierzWartosc());
				if ($istniejacy_uzytkownik instanceof Uzytkownik\Obiekt)
				{
					$obiektFormularza->zwrocFormularz()->login->dodajWalidator(new Walidator\RozneOd($istniejacy_uzytkownik->login));
				}
				$nowyUzytkownik = true;
			}
			$mapper = $this->dane()->Uzytkownik();
            if(isset($kategoriaOrders[0]))
            {
                $tidsbankenKod = $mapper->pobierzPoKodzie($obiektFormularza->zwrocFormularz()->tidsbankenKod->pobierzWartosc());
                if ($tidsbankenKod instanceof Uzytkownik\Obiekt && $uzytkownik->id != $tidsbankenKod->id)
                {
                    $obiektFormularza->zwrocFormularz()->tidsbankenKod->dodajWalidator(new Walidator\RozneOd($tidsbankenKod->tidsbankenKod));
                }
                $tidsbankenKod = $mapper->pobierzPoTidsbankenNumer($obiektFormularza->zwrocFormularz()->tidsbankenNumerPracownika->pobierzWartosc());
                if ($tidsbankenKod instanceof Uzytkownik\Obiekt && $uzytkownik->id != $tidsbankenKod->id)
                {
                    $obiektFormularza->zwrocFormularz()->tidsbankenNumerPracownika->dodajWalidator(new Walidator\RozneOd($tidsbankenKod->tidsbankenNumerPracownika));
                }
            }

			if (!$this->k->k['emailAktywacyjny.link_do_ustawienia_hasla'] && $obiektFormularza->zwrocFormularz()->haslo->pobierzWartosc() != '')
			{
				$obiektFormularza->zwrocFormularz()->hasloPowtorz->dodajWalidator(new Walidator\Rowne($obiektFormularza->zwrocFormularz()->haslo->pobierzWartosc()));
			}

			$obiektFormularza->zwrocFormularz()->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'));

			if ($obiektFormularza->zwrocFormularz()->danePoprawne())
			{
				$roleMapper = Cms::inst()->dane()->Rola();
				$przypisane = array();
				if ($uzytkownik->id > 0)
				{
					foreach ($roleMapper->pobierzPrzypisaneUzytkownikowi($uzytkownik->id) as $rola)
					{
						$przypisane[$rola->kod] = $rola;
					}
				}

				$mapper = $this->dane()->Uzytkownik();
				if ($uzytkownik->id == null)
				{
					$istniejacy_uzytkownik = $mapper->pobierzPoLoginie($obiektFormularza->zwrocFormularz()->login->pobierzWartosc());

					if ($istniejacy_uzytkownik instanceof Uzytkownik\Obiekt)
					{
						$this->komunikat($this->j->t['dodaj.blad_login_zajety'], 'warning');
						return $obiektFormularza->zwrocFormularz()->html();
					}
				}

				if ($obiektFormularza->zwrocFormularz()->zmieniony())
				{
					$role = array();
					$zdarzenie = null;
					$kolekcje = array();
					
					
					foreach ($obiektFormularza->zwrocFormularz()->pobierzZmienioneWartosci() as $klucz => $wartosc)
					{
						//Wyciagniecie danej na temat nowego statusu uzytkownika, potrzebne do logowania zdarzenia
						if ($klucz == 'status' && $wartosc == 'zablokowany')
							$zdarzenie = 'zablokowano_uzytkownika';
						elseif ($klucz == 'status' && $wartosc == 'aktywny')
							$zdarzenie = 'odblokowano_uzytkownika';
						if ($klucz == 'zdjecie')
						{
							$katalogDocelowy = $cms->katalog('zdjecia_pracownikow');
							$zdjecie = $wartosc;
							if ($uzytkownik->zdjecie != '')
							{
								foreach ($this->k->k['formularz.rozmiary_miniaturek_zdjecia'] as $prefix => $kod)
								{
									$prefix = ($prefix != '') ? $prefix.'-' : '';
									$stare_zdjecie = new Plik\Zdjecie($katalogDocelowy.$prefix.$uzytkownik->zdjecie);
									$stare_zdjecie->usun();
								}
							}
							$nazwaPliku = strtolower(hash_file('crc32', $zdjecie['tmp_name']).'.'.file_ext($zdjecie['name']));

							$zdjecie = new Plik\Zdjecie($zdjecie['tmp_name']);
							$zdjecie->przeniesDo($katalogDocelowy.$nazwaPliku);

							$usun = true;
							foreach ($this->k->k['formularz.rozmiary_miniaturek_zdjecia'] as $prefix => $kod)
							{
								$prefix = ($prefix != '') ? $prefix.'-' : '';
								if ($prefix == '') $usun = false;
								$zdjecie->tworzMiniaturke($katalogDocelowy.$prefix.$nazwaPliku, $kod);
							}
							if ($usun) $zdjecie->usun();

							$uzytkownik->zdjecie = $nazwaPliku;
							continue;
						}


						if (strpos($klucz, 'rola_') !== false)
						{
							$kod = str_replace('rola_', '', $klucz);
							$role[$kod] = $wartosc;
							continue;
						}
						
						if (strpos($klucz, 'kolekcja_') !== false)
						{
							$kod = str_replace('kolekcja_', '', $klucz);
							$kolekcje[$kod] = $wartosc;
							continue;
						}

						if($klucz == 'zalaczniki')
							$zalaczniki = $wartosc;

						if ($klucz == 'hasloPowtorz' || $klucz == 'zaloguj') continue;
						if ($this->k->k['emailAktywacyjny.link_do_ustawienia_hasla'] && $nowyUzytkownik)
						{
							$losowyKlucz = losowyKlucz(32);
							$uzytkownik->haslo = $losowyKlucz;
							$uzytkownik->token = $losowyKlucz;
						}

						$uzytkownik->$klucz = $wartosc;
					}
					if ($uzytkownik->id < 1)
					{
						$uzytkownik->idProjektu = ID_PROJEKTU;
						$uzytkownik->dataDodania = date("Y-m-d H:i:s");
					}

					if ($uzytkownik->zapisz($mapper))
					{
						Cms::inst()->Baza()->transakcjaStart();
						if ($uzytkownik->id == $cms->profil()->id)
						{
							$cms->sesja->uzytkownik = $uzytkownik;
						}

						$this->komunikat($this->j->t['formularz.info_zapisano_dane_uzytkownika'], 'info', 'sesja');
						$uzytkownikZapisany = true;

						if ($zdarzenie != null)
						{
							$this->zdarzenie($zdarzenie, array(
								'login' => $uzytkownik->login,
							), $obiektFormularza->zwrocFormularz()->pobierzIdentyfikatorFormularza());
						}
					}
					else
					{
						$this->komunikat($this->j->t['formularz.blad_zapisu_uzytkownika'], 'error');
						$uzytkownikZapisany = false;
					}
					$zmienione = 0;
					$zmienioneKolekcje = 0;
					$bledy = array();
					if(count($zalaczniki))
					{
						$this->zapiszPlikiUzytkownika($zalaczniki, $uzytkownik);
					}
					if(count($kolekcje))
					{
						$kolekcjeMapper = Cms::inst()->dane()->TidsbankenKolekcja();
						$przypisaneKolekcje = array();
						if ($uzytkownik->id > 0)
						{
							foreach ($kolekcjeMapper->pobierzPrzypisaneUzytkownikowi($uzytkownik->id, array('aktywne' => true)) as $przypisanaKolekcja)
							{
								$przypisaneKolekcje[$przypisanaKolekcja->id] = $przypisanaKolekcja;
							}
						}
						
						foreach ($kolekcje as $kolekcja => $wartosc)
						{
							if (array_key_exists($kolekcja, $przypisaneKolekcje) && $wartosc == 0)
							{
								if ($przypisaneKolekcje[$kolekcja]->usunDlaUzytkownika($uzytkownik->id))
								{
									$zmienioneKolekcje++;
								}
								else
								{
									$bledy[] = $klucz;
								}
							}
							else if (!array_key_exists($kolekcja, $przypisaneKolekcje) && $wartosc == 1)
							{
								
								$kolekcjaObiekt = $this->dane()->TidsbankenKolekcja()->pobierzPoId($kolekcja);
								if ($kolekcjaObiekt instanceof \Generic\Model\TidsbankenKolekcja\Obiekt && $kolekcjaObiekt->przypiszDoUzytkownika($uzytkownik->id))
								{
									$zmienioneKolekcje++;
								}
								else
								{
									$bledy[] = $klucz;
								}
							}
						}
					}
					if (count($role) > 0 )
					{
						foreach ($role as $kod => $wartosc)
						{
							// jeżeli uprawnienie istnieje ale zostalo odznaczone w formularzu to usuwamy
							if (array_key_exists($kod, $przypisane) && $wartosc == 0)
							{
								if ($przypisane[$kod]->usunDlaUzytkownika($uzytkownik->id))
								{
									$zmienione++;
								}
								else
								{
									$bledy[] = $klucz;
								}
							}
							// jeżeli uprawnienie nie istnieje ale zostalo zaznaczone w formularzu to dodajemy nowe
							else if (!array_key_exists($kod, $przypisane) && $wartosc == 1)
							{
								$rola = $this->dane()->Rola()->pobierzPoKodzie($kod);
								
								if ($rola instanceof Rola\Obiekt && $rola->przypiszDoUzytkownika($uzytkownik->id))
								{
									$zmienione++;
								}
								else
								{
									$bledy[] = $klucz;
								}
							}
						}
					}
					if ($zmienione == count($role) && $zmienioneKolekcje == count($kolekcje) )
					{
						Cms::inst()->Baza()->transakcjaPotwierdz();
						$this->komunikat($this->j->t['formularz.info_przypisano_role'], 'info', 'sesja');
					}
					else
					{
						Cms::inst()->Baza()->transakcjaCofnij();
						$this->komunikat($this->j->t['formularz.blad_nie_mozna_przypisac_roli'].'<br/>'.implode('<br/>', $bledy), 'error');
					}
					if ($uzytkownikZapisany && $zmienione == count($role))
					{
						if ($this->k->k['emailAktywacyjny.link_do_ustawienia_hasla'] && $nowyUzytkownik)
						{
							Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie', 'emailAktywacyjny', array('id' => $uzytkownik->id)));
						}
						Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie', 'edytuj', array('id'=>$uzytkownik->id)));
					}
					else
					{
						return $obiektFormularza->zwrocFormularz()->html();
					}
				}
				else
				{
					Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie', 'edytuj', array('id'=>$uzytkownik->id)));
				}
			}
			else
			{
				$this->komunikat($this->j->t['formularz.edycja_admin_blad_walidacji'], 'warning');
				$this->zdarzenie('blad_walidacji_formularza', array(), $obiektFormularza->zwrocFormularz()->pobierzIdentyfikatorFormularza());
				return $obiektFormularza->zwrocFormularz()->html();
			}
		}
		else
		{
			return $obiektFormularza->zwrocFormularz()->html();
		}
	}
	
	private function zapiszPlikiUzytkownika(Array $pliki, Uzytkownik\Obiekt $uzytkownik)
	{
		$katalogDocelowy = new \Generic\Biblioteka\Katalog(Cms::inst()->katalog('pliki_uzytkownika', $uzytkownik->id), true);
		
		$multiUpload = new MultiUpload($pliki['token']);
		$plikiUzytkownika = $multiUpload->przeniesPliki(listaZTablicy($pliki['pliki'], null, 'nazwa'), $pliki['pliki'], $katalogDocelowy, 1);
		
		foreach($plikiUzytkownika as $plikUzytkownika)
		{
			$plik = new PlikPrywatny\Obiekt;
			$plik->url = Cms::inst()->url('pliki_uzytkownika_baza', $uzytkownik->id).'/'.$plikUzytkownika['kod'];
			$plik->idProjektu = ID_PROJEKTU;
			if($plik->zapisz($this->dane()->PlikPrywatny()))
			{
				$rolaUprawniona = $this->dane()->Rola()->pobierzPoKodach($this->k->k['plikiUzytkownika.kod_roli']);
				foreach ($rolaUprawniona as $uprawniony)
					$uprawniony->przypiszUprawnieniaDoPliku($plik);
			}
		}
	}

	
	private function formularzWyszukiwania(TabelaDanych $grid)
	{
		$obiektFormularza = new \Generic\Formularz\Uzytkownik\Wyszukiwanie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'))
			->ustawTlumaczenia(array('uzytkownik.statusy' => $this->j->t['uzytkownik.statusy']));

		$kryteria = $obiektFormularza->pobierzWartosci();

		if (isset($kryteria['czy_admin']))
		{
			if ($kryteria['czy_admin'] >= 2)
				$kryteria['czy_admin'] = $kryteria['czy_admin'] - 2;
			else
				unset($kryteria['czy_admin']);
		}
		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		return $kryteria;
	}



	private function wyslijEmailAktywacyjny(Uzytkownik\Obiekt $uzytkownik)
	{
		$dane = array(
			'obiekt_Uzytkownik' => $uzytkownik,
			'linkAktywacyjny' => Router::urlAdmin('UserAccount', 'activate', array('token' => $uzytkownik->token)),
		);
		
		$poczta = new Pomocnik\Poczta($this->k->k['emailAktywacyjny.id_formatki_email'], $dane);
		$status = $poczta->wyslij();

		$this->zdarzenie('wyslano_email_aktywacyjny', array(
			'status' => ($status) ? true : false,
			'opis' => ($status) ? $this->j->t['emailAktywacyjny.info_utworzono_konto_uzytkownika'] : $this->j->t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego'],
		));

		return $status;
	}


	public function wykonajUsunZdjecie()
	{
		$mapper = $this->dane()->Uzytkownik();
		$uzytkownik = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if ($uzytkownik instanceof Uzytkownik\Obiekt)
		{
			$katalog = new \Generic\Biblioteka\Katalog(Cms::inst()->katalog('zdjecia_pracownikow'));

			$bledy = 0;
			foreach ($this->k->k['formularz.rozmiary_miniaturek_zdjecia'] as $prefix => $kod)
			{
				$prefix = ($prefix != '') ? $prefix.'-' : '';
				$plik = new Plik($katalog.'/'.$prefix.$uzytkownik->zdjecie);
				if (! ($plik->istnieje() && $plik->usun()))
					$bledy++;
			}

			$uzytkownik->zdjecie = '';
			if ($uzytkownik->zapisz($mapper))
			{
				if ($uzytkownik->id == Cms::inst()->profil()->id)
				{
					$this->sesja->uzytkownik = $uzytkownik;
				}
				$this->komunikat($this->j->t['usunZdjecie.info_usunieto_zdjecie'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usunZdjecie.blad_nie_mozna_usunac_zdjecia'], 'error', 'sesja');
			}
			Router::przekierujDo(Router::urlAdmin('UzytkownicyZarzadzanie', 'edytuj', array('id' => $uzytkownik->id)));
		}
		else
		{
			$this->komunikat($this->j->t['usunZdjecie.blad_nie_mozna_pobrac_uzytkownika'], 'error');
		}
	}
	
	public function wykonajPrzypiszUprawnieniaDoPliku()
	{
		$id = Zadanie::pobierz('id', 'trim', 'strtolower');
		$idUzytkownik = Zadanie::pobierz('idUzytkownik', 'intval');
		$dodaj = Zadanie::pobierz('dodaj', 'trim', 'strtolower');
		$result['success'] = false;
		$uzytkownik = $this->dane()->Uzytkownik()->pobierzPoId($idUzytkownik);
		$plik = $this->dane()->PlikPrywatny()->pobierzPoId($id);
		if($uzytkownik instanceof Uzytkownik\Obiekt && $plik instanceof PlikPrywatny\Obiekt)
		{
			if($dodaj == 'true')
				if($uzytkownik->przypiszUprawnieniaDoPliku($plik)) $result['success'] = true;
			else
				if($uzytkownik->zabierzUprawnieniaDoPliku($plik)) $result['success'] = true;
		}
		else
		{
			
		}
		return $result;
	}
	
	public function wykonajZapiszPlik()
	{
		$token = Zadanie::pobierz('token', 'trim');
		$id = Zadanie::pobierz('id', 'trim', 'intval');

		$multiupload = new MultiUpload($token);
		$plik = $multiupload->zapiszPlik($id);
		
		$return = $multiupload->pobierzWynikUploadu();
		
		if(!$wynikSkanowania  = $plik->skanuj(true) && $return['success'] == true)
		    $return['success']  = false;
		
		echo json_encode($return);
		die;
	}

	public function wykonajUsunPlik()
	{
		$ids = Zadanie::pobierz('ids', 'trim', 'strtolower');
		$token = Zadanie::pobierz('token', 'trim');
		$usunBaza = Zadanie::pobierz('usunBaza', 'trim', 'strval');
		$idUzytkownik = Zadanie::pobierz('idUzytkownik', 'intval');

		$ids = explode(',', $ids);
		
		foreach ($ids as $key => $val){if ($val < 1) unset($ids[$key]);}
		
		if (is_array($ids) && count($ids) > 0 && !empty($ids))
		{
			if($usunBaza == 'usunBaza')
			{
				$result = $this->usunPlikiPrywatne($ids, $idUzytkownik);
			}
			else
			{
				$result = multiuploadUsunPlikiTemp($ids, $token);
			}
		}
		else
		{
			$result['success'] = true;
		}

		echo json_encode($result);
		die;
	}
	
	private function usunPlikiPrywatne($ids, $idUzytkownik)
	{
		$result = array('success' => false);
		
		foreach ($ids as $x => $id)
		{
			$pliki_mapper = $this->dane()->PlikPrywatny();
			$plik = $pliki_mapper->pobierzPoId($id);
			if ($plik instanceof PlikPrywatny\Obiekt)
			{
				$menedzerPlikow = new MenedzerPlikow(Cms::inst()->katalog('pliki_uzytkownika', $idUzytkownik), $plik->url);
				$result['id'] = $plik->id;
				
				if($plik->usun($pliki_mapper)) $result['success'] = true;
			}
		}
		return $result;
	}
}
