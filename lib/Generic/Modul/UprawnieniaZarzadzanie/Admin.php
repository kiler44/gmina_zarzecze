<?php
namespace Generic\Modul\UprawnieniaZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Model\Rola;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Uprawnienie;
use Generic\Model\UprawnienieAdministracyjne;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Katalog;
use Generic\Model\UprawnienieObiektu;
use Generic\Biblioteka\Events\Szablon as EventSzablon;


/**
 * Modul administracyjny odpowiedzialny za zarządzanie uprawnieniami.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\UprawnieniaZarzadzanie\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\UprawnieniaZarzadzanie\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajPodglad',
		'wykonajUprawnieniaTresci',
		'wykonajUprawnieniaAdministracyjne',
		'wykonajUprawnieniaEventow',
		'wykonajUprawnieniaObiektow',
		'wykonajUsun',
	);



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('kod', $this->j->t['index.etykieta_kod'], null, Router::urlAdmin('UprawnieniaZarzadzanie','podglad', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], null, Router::urlAdmin('UprawnieniaZarzadzanie','podglad', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('opis', $this->j->t['index.etykieta_opis']);

		$grid->dodajPrzyciski(
			Router::urlAdmin('UprawnieniaZarzadzanie','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('podglad','edytuj','usun')
		);

		$mapper = $this->dane()->Rola();

		$kryteria = array('tylko_zwykle_role' => true);

		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$sorter = new Rola\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('kod', 'nazwa'), $kolumna, $kierunek,
				Router::urlAdmin('UprawnieniaZarzadzanie', 'index', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
			$grid->pager($pager->html(Router::urlAdmin('UprawnieniaZarzadzanie', 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach ($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $rola)
			{
				$grid->dodajWiersz($rola);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/index', array(
				'tabela_danych' => $grid->html(),
				'link_dodaj' => Router::urlAdmin('UprawnieniaZarzadzanie', 'dodaj'),
		));

		$this->naprawUprawnieniaTresci();
		$this->naprawUprawnieniaAdministracyjne();
	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$rola = new Rola\Obiekt();
		$rola->idProjektu = ID_PROJEKTU;
		$dane['form'] = $this->formularz($rola);

		$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
	}



	public function wykonajEdytuj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$mapper = $this->dane()->Rola();
		$rola = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));
		if ($rola instanceof Rola\Obiekt)
		{
			$dane['form'] = $this->formularz($rola);
			$this->tresc .= $this->szablon->parsujBlok('edytuj', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac_roli'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'index'));
		}
	}



	public function wykonajPodglad()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['podglad.tytul_strony']));

		$mapper = $this->dane()->Rola();
		$rola = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));
		if ($rola instanceof Rola\Obiekt)
		{
			$dane['kod'] = $rola->kod;
			$dane['nazwa'] = $rola->nazwa;
			$dane['opis'] = $rola->opis;

			$dane['link_edytuj'] = Router::urlAdmin('UprawnieniaZarzadzanie', 'edytuj', array('id' => $rola->id));
			$dane['link_uprawnienia_tresci'] = Router::urlAdmin('UprawnieniaZarzadzanie', 'uprawnieniaTresci', array('id' => $rola->id));
			$dane['link_uprawnienia_administracyjne'] = Router::urlAdmin('UprawnieniaZarzadzanie', 'uprawnieniaAdministracyjne', array('id' => $rola->id));
			$dane['link_uprawnienia_obiektow'] = Router::urlAdmin('UprawnieniaZarzadzanie', 'uprawnieniaObiektow', array('id' => $rola->id));
			$dane['link_uprawnienia_do_eventow'] = Router::urlAdmin('UprawnieniaZarzadzanie', 'uprawnieniaEventow', array('id' => $rola->id));

			$this->tresc .= $this->szablon->parsujBlok('podglad', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac_roli'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'index'));
		}
	}



	public function wykonajUprawnieniaTresci()
	{
		$mapper = $this->dane()->Rola();
		$rola = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));
		if ($rola instanceof Rola\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['uprawnieniaTresci.tytul_strony'], $rola->nazwa)));

			$uprawnienia = $this->pobierzUprawnieniaTresci();

			$zapisaneUprawnieniaRoli = $this->pobierzUprawnieniaTresciRoli($rola->id);

			$obiektFormularza = new \Generic\Formularz\Uprawnienie\EdycjaTresc();

			$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
				->ustawUrlPowrotny(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)))
				->ustawUprawnienia($uprawnienia)
				->ustawSzablon($this->szablon)
				->ustawZapisaneUprawnienia($zapisaneUprawnieniaRoli);

			if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
			{
				$pola = $obiektFormularza->pobierzZmienioneWartosci();

				if (count($pola) > 0)
				{
					$this->naprawUprawnieniaTresci();

					Cms::inst()->Baza()->transakcjaStart();
					$uprwanienia_mapper = $this->dane()->Uprawnienie();
					$zmienione = 0;
					$bledy = array();
					foreach ($pola as $klucz => $wartosc)
					{
						// jeżeli uprawnienie jest przypisane ale zostalo odznaczone w formularzu to usuwamy
						if (array_key_exists($klucz, $zapisaneUprawnieniaRoli) && $wartosc == 0)
						{
							if ($zapisaneUprawnieniaRoli[$klucz]->usunDlaRoli($rola->id))
							{
								$zmienione++;
							}
							else
							{
								$bledy[] = $klucz;
							}
						}
						// jeżeli uprawnienie nie jest przypisane ale zostalo zaznaczone w formularzu to dodajemy nowe
						else if (!array_key_exists($klucz, $zapisaneUprawnieniaRoli) && $wartosc == 1)
						{
							$uprawnienie = $uprwanienia_mapper->pobierzPoKodzie($klucz);

							if ($uprawnienie instanceof Uprawnienie\Obiekt && $uprawnienie->przypiszDoRoli($rola->id))
							{
								$zmienione++;
							}
							else
							{
								$bledy[] = $klucz;
							}
						}
					}

					if ($zmienione == count($pola))
					{
						Cms::inst()->Baza()->transakcjaPotwierdz();
						Cms::inst()->profil()->odnowUprawnienia();
						$this->komunikat($this->j->t['uprawnieniaTresci.info_zapisano_uprawnienia'], 'info', 'sesja');
						Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)));
					}
					else
					{
						Cms::inst()->Baza()->transakcjaCofnij();
						$this->komunikat($this->j->t['uprawnieniaTresci.blad_nie_mozna_zapisac_uprawnien'].'<br/>'.implode('<br/>', $bledy), 'error');
					}
				}
			}
			$dane['form'] = $obiektFormularza->html();
			$this->tresc .= $this->szablon->parsujBlok('zaznacz_skrypt');
			$this->tresc .= $this->szablon->parsujBlok('uprawnieniaTresci', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['uprawnieniaTresci.blad_nie_mozna_pobrac_roli'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'index'));
		}
	}

	public function wykonajUprawnieniaEventow()
	{
		$mapper = $this->dane()->Rola();
		$rola = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));
		$blad = 0;
		if ($rola instanceof Rola\Obiekt)
		{
			$kategoria = $this->dane()->Kategoria()->pobierzDlaModulu('Kalendarz');
			if(!$rola->maUprawnieniaDo('Admin_'.$kategoria[0]->id.'_wykonajIndex'))
			{
				$this->komunikat($this->j->t['uprawnieniaEventow.brak_uprawnien_do_kalendarza'], 'warning');
			}
			$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['uprawnieniaEventow.tytul_strony'], $rola->nazwa)));
			
			$uprawnienia = $this->pobierzUprawnieniaEventow();
			$uprawnienia_baza = $this->pobierzUprawnieniaEventowDlaRoli($rola->id);
			
			$obiektFormularza = new \Generic\Formularz\Uprawnienie\EdycjaEventy();
			$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
				->ustawSzablon($this->szablon)
				->ustawUprawnienia($uprawnienia)
				->ustawZapisaneUprawnienia($uprawnienia_baza)
				->ustawUrlPowrotny(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)));
			
			$cms = Cms::inst();
			$cms->Baza()->transakcjaStart();
			if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
			{
				if ($obiektFormularza->zmieniony())
				{
					$uprwanienia_mapper = $this->dane()->RoleUprawnieniaEvents();
					$pola = $obiektFormularza->pobierzZmienioneWartosci();

					foreach ($pola as $klucz => $wartosc)
					{
						$uprawnienieBaza = $uprwanienia_mapper->pobierzPoRolaEvent($rola->id, $klucz);
						
						if(in_array($klucz, $uprawnienia_baza) && $wartosc == 0)
						{
							$uprawnienieBaza = $uprwanienia_mapper->pobierzPoRolaEvent($rola->id, $klucz);
							if($uprawnienieBaza instanceof \Generic\Model\RoleUprawnieniaEvents\Obiekt)
							{
								($uprawnienieBaza->usun($uprwanienia_mapper)) ? : $blad++;
							}
						}
						else if($wartosc == 1 && $uprawnienieBaza == false)
						{
							$uprawnienieEvent = new \Generic\Model\RoleUprawnieniaEvents\Obiekt();
							$uprawnienieEvent->idRoli = $rola->id;
							$uprawnienieEvent->szablonEventu = $klucz;
							($uprawnienieEvent->zapisz($uprwanienia_mapper)) ? : $blad++;
						}
					}
					
				}
				if($blad)
				{
					$cms->Baza()->transakcjaCofnij();
					$this->komunikat($this->j->t['uprawnieniaAdministracyjne.blad_nie_mozna_zapisac_uprawnien'].'<br/>'.implode('<br/>', $bledy), 'error');
				}
				else
				{
					$cms->Baza()->transakcjaPotwierdz();
					$cms->profil()->odnowUprawnienia();
					$this->komunikat($this->j->t['uprawnieniaAdministracyjne.info_zapisano_uprawnienia'], 'info', 'sesja');
					Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)));
				}
			}
		}
		else
		{
			$this->komunikat($this->j->t['uprawnieniaAdministracyjne.blad_nie_mozna_pobrac_roli'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'index'));
		}
		
		$dane['form'] = $obiektFormularza->html();
		$dane['skrypt'] = $this->szablon->parsujBlok('zaznacz_skrypt');
		$this->tresc .= $this->szablon->parsujBlok('uprawnieniaAdministracyjne', $dane);
		
	}
	
	private function pobierzUprawnieniaEventow()
	{
		
		$listaSzablonow = EventSzablon::pobierzSzablony();
		$uprawnienia = array();
		
		foreach ($listaSzablonow as $szablon)
		{
			$szablonO = new EventSzablon($szablon);
			$uprawnienia[$szablon]['nazwa'] = $szablonO->pobierzNazweSzablonu();
			$uprawnienia[$szablon]['opis'] = $szablonO->pobierzOpisSzablonu();
		}
		
		return $uprawnienia;
	}
	
	private function pobierzUprawnieniaEventowDlaRoli($idRoli)
	{
		$mapper = $this->dane()->RoleUprawnieniaEvents();
		$dane_baza = $mapper->pobierzDlaRoli($idRoli);
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				array_push($uprawnienia_baza, $wiersz->szablonEventu);
			}
		}
		return $uprawnienia_baza;
	}

	public function wykonajUprawnieniaAdministracyjne()
	{
		$mapper = $this->dane()->Rola();
		$rola = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));
		if ($rola instanceof Rola\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['uprawnieniaAdministracyjne.tytul_strony'], $rola->nazwa)));

			$uprawnienia = $this->pobierzUprawnieniaAdministracyjne();

			$uprawnienia_baza = $this->pobierzUprawnieniaAdministracyjneRoli($rola->id);

			$obiektFormularza = new \Generic\Formularz\Uprawnienie\EdycjaAdministracyjne();
			$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
				->ustawSzablon($this->szablon)
				->ustawUprawnienia($uprawnienia)
				->ustawZapisaneUprawnienia($uprawnienia_baza)
				->ustawUrlPowrotny(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)));

			if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
			{
				if ($obiektFormularza->zmieniony())
				{
					$this->naprawUprawnieniaAdministracyjne();

					Cms::inst()->Baza()->transakcjaStart();
					$uprwanienia_mapper = $this->dane()->UprawnienieAdministracyjne();
					$pola = $obiektFormularza->pobierzZmienioneWartosci();
					$zmienione = 0;
					$bledy = array();
					
					foreach ($pola as $klucz => $wartosc)
					{
						// jeżeli uprawnienie istnieje ale zostalo odznaczone w formularzu to usuwamy
						if (array_key_exists($klucz, $uprawnienia_baza) && $wartosc == 0)
						{
							if ($uprawnienia_baza[$klucz]->usunDlaRoli($rola->id))
							{
								$zmienione++;
							}
							else
							{
								$bledy[] = $klucz;
							}
						}
						// jeżeli uprawnienie nie istnieje ale zostalo zaznaczone w formularzu to dodajemy nowe
						else if (!array_key_exists($klucz, $uprawnienia_baza) && $wartosc == 1)
						{
							$uprawnienie = $uprwanienia_mapper->pobierzPoKodzie($klucz);
							if ($uprawnienie instanceof UprawnienieAdministracyjne\Obiekt && $uprawnienie->przypiszDoRoli($rola->id))
							{
								$zmienione++;
							}
							else
							{
								$bledy[] = $klucz;
							}
						}
					}
					if ($zmienione == count($pola))
					{
						Cms::inst()->Baza()->transakcjaPotwierdz();
						Cms::inst()->profil()->odnowUprawnienia();
						$this->komunikat($this->j->t['uprawnieniaAdministracyjne.info_zapisano_uprawnienia'], 'info', 'sesja');
						Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)));
					}
					else
					{
						Cms::inst()->Baza()->transakcjaCofnij();
						$this->komunikat($this->j->t['uprawnieniaAdministracyjne.blad_nie_mozna_zapisac_uprawnien'].'<br/>'.implode('<br/>', $bledy), 'error');
					}
				}
			}

			$dane['form'] = $obiektFormularza->html();
			$dane['skrypt'] = $this->szablon->parsujBlok('zaznacz_skrypt');
			$this->tresc .= $this->szablon->parsujBlok('uprawnieniaAdministracyjne', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['uprawnieniaAdministracyjne.blad_nie_mozna_pobrac_roli'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'index'));
		}
	}



	public function wykonajUprawnieniaObiektow()
	{
		$mapper = $this->dane()->Rola();
		$rola = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));
		if ($rola instanceof Rola\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['uprawnieniaObiektow.tytul_strony'], $rola->nazwa)));

			$uprawnienia = $this->pobierzUprawnieniaObiektow();

			$uprawnienia_baza = $this->pobierzUprawnieniaObiektowRoli($rola->id);

			$obiektFormularza = new \Generic\Formularz\Uprawnienie\EdycjaObiektow();
			$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
				->ustawSzablon($this->szablon)
				->ustawUprawnienia($uprawnienia)
				->ustawZapisaneUprawnienia($uprawnienia_baza)
				->ustawUrlPowrotny(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)));

			if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
			{
				if ($obiektFormularza->zmieniony())
				{
					$this->naprawUprawnieniaObiektow();

					Cms::inst()->Baza()->transakcjaStart();
					$uprwanienia_mapper = $this->dane()->UprawnienieObiektu();
					$pola = $obiektFormularza->pobierzZmienioneWartosci();
					$zmienione = 0;
					$bledy = array();
					foreach ($pola as $klucz => $wartosc)
					{
						// jeżeli uprawnienie istnieje ale zostalo odznaczone w formularzu to usuwamy
						if (array_key_exists($klucz, $uprawnienia_baza) && $wartosc == 0)
						{
							if ($uprawnienia_baza[$klucz]->usunDlaRoli($rola->id))
							{
								$zmienione++;
							}
							else
							{
								$bledy[] = $klucz;
							}
						}
						// jeżeli uprawnienie nie istnieje ale zostalo zaznaczone w formularzu to dodajemy nowe
						else if (!array_key_exists($klucz, $uprawnienia_baza) && $wartosc == 1)
						{
							$uprawnienie = $uprwanienia_mapper->pobierzPoHashu(funkcjaHashujaca($klucz));
							if ($uprawnienie instanceof UprawnienieObiektu\Obiekt && $uprawnienie->przypiszDoRoli($rola->id))
							{
								$zmienione++;
							}
							else
							{
								$bledy[] = $klucz;
							}
						}
					}
					if ($zmienione == count($pola))
					{
						Cms::inst()->Baza()->transakcjaPotwierdz();
						Cms::inst()->profil()->odnowUprawnienia();
						$this->komunikat($this->j->t['uprawnieniaObiektow.info_zapisano_uprawnienia'], 'info', 'sesja');
						Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rola->id)));
					}
					else
					{
						Cms::inst()->Baza()->transakcjaCofnij();
						$this->komunikat($this->j->t['uprawnieniaObiektow.blad_nie_mozna_zapisac_uprawnien'].'<br/>'.implode('<br/>', $bledy), 'error');
					}
				}
			}

			$dane['form'] = $obiektFormularza->html();
			$dane['skrypt'] = $this->szablon->parsujBlok('zaznacz_skrypt');
			$this->tresc .= $this->szablon->parsujBlok('uprawnieniaAdministracyjne', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['uprawnieniaAdministracyjne.blad_nie_mozna_pobrac_roli'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'index'));
		}
	}



	public function wykonajUsun()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Rola();
		$rola = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));
		if ($rola instanceof Rola\Obiekt)
		{
			if ($rola->usun($mapper))
			{
				$this->komunikat($this->j->t['usun.info_rola_usunieta'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_roli'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_brak_roli'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie','index'));
	}



	private function formularz(Rola\Obiekt $rola)
	{
		$obiektFormularza = new \Generic\Formularz\Uprawnienie\Edycja();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawSzablon($this->szablon)
			->ustawUrlPowrotny(Router::urlAdmin('UzytkownicyZarzadzanie','index'))
			->ustawObiekt($rola);

		if ($obiektFormularza->wypelniony() && Zadanie::pobierzPost('czyZapisac') > 0)
		{
			if ($obiektFormularza->danePoprawne())
			{
				$moduly = array();
				foreach ($obiektFormularza->pobierzWartosci() as $klucz => $wartosc)
				{
					if ($klucz == 'kontekstowa')
					{
						$wartosc -= 1;
					}

					if (strpos($klucz, 'modul_') === false)
					{
						$rola->$klucz = $wartosc;
					}
					else
					{
						if ($wartosc == 1) $moduly[] = str_replace('modul_', '', $klucz);
					}
				}

				if ($rola->kontekstowa == 0)
				{
					$rola->kontekstObiekt = '';
					$rola->kontekstPole = '';
					$rola->kontekstPowiazanie = 0;
					$rola->kontekstPowiazanieKtoreId = 0;
				}

				$rola->modulyDostep = ','.implode(',', $moduly).',';

				if ($rola->zapisz($this->dane()->Rola()))
				{
					$this->komunikat($this->j->t['formularz.zapisano_dane_roli'], 'info', 'sesja');
					Cms::inst()->profil()->odnowUprawnienia();
					Router::przekierujDo(Router::urlAdmin('UprawnieniaZarzadzanie', 'index'));
				}
				else
				{
					$this->komunikat($this->j->t['formularz.blad_nie_mozna_zapisac_roli'], 'error');
				}
			}
		}
		$skrypt = $this->szablon->parsujBlok('zaznacz_skrypt');
		return $obiektFormularza->html().$skrypt;
	}



	protected function pobierzUprawnieniaTresci()
	{
		$kategorie = $this->dane()->Kategoria()->zwracaTablice()->pobierzWszystko();
		$uprawnienia = array();
		foreach ($kategorie as $kategoria)
		{
			if (!in_array($kategoria['typ'], array('kategoria', 'glowna'))) continue;
			if ($kategoria['kod_modulu'] == '') continue;
			$uprawnienia['Http'][$kategoria['id']]['nazwa'] = $kategoria['nazwa'];
			$uprawnienia['Http'][$kategoria['id']]['kod_modulu'] = $kategoria['kod_modulu'];
			$uprawnienia['Http'][$kategoria['id']]['poziom'] = $kategoria['poziom'];
			$uprawnienia['Admin'][$kategoria['id']]['nazwa'] = $kategoria['nazwa'];
			$uprawnienia['Admin'][$kategoria['id']]['kod_modulu'] = $kategoria['kod_modulu'];
			$uprawnienia['Admin'][$kategoria['id']]['poziom'] = $kategoria['poziom'];

			$klasa = 'Generic\\Modul\\'.$kategoria['kod_modulu'].'\\Admin';
			$instancja = new $klasa;
			$tlumaczenia = $instancja->pobierzTlumaczenia();
			$tlumaczenia = (isset($tlumaczenia['_akcje_etykiety_'])) ? $tlumaczenia['_akcje_etykiety_'] : array();
			foreach ($instancja->pobierzUprawnienia() as $metoda)
			{
				$uprawnienia['Admin'][$kategoria['id']][$metoda] = (isset($tlumaczenia[$metoda])) ? $tlumaczenia[$metoda] : '';
			}

			
			if ($kategoria['dla_zalogowanych'] == 1 && in_array($kategoria['typ'], array('kategoria', 'glowna')))
			{
				$klasa = 'Generic\\Modul\\'.$kategoria['kod_modulu'].'\\Http';
				if (class_exists($klasa, true))
				{
					$instancja = new $klasa;
					$tlumaczenia = $instancja->pobierzTlumaczenia();
					$tlumaczenia = (isset($tlumaczenia['_akcje_etykiety_'])) ? $tlumaczenia['_akcje_etykiety_'] : array();
					foreach ($instancja->pobierzUprawnienia() as $metoda)
					{
						$uprawnienia['Http'][$kategoria['id']][$metoda] = (isset($tlumaczenia[$metoda])) ? $tlumaczenia[$metoda] : '';
					}
				}
			}
			
		}
		$bloki = $this->dane()->Blok()->zwracaTablice()->pobierzWszystko();

		foreach ($bloki as $blok)
		{
			$uprawnienia['Bloki'][$blok['id']]['nazwa'] = $blok['nazwa'];
			$uprawnienia['Bloki'][$blok['id']]['kod_modulu'] = $blok['kod_modulu'];
			$uprawnienia['Bloki'][$blok['id']]['poziom'] = '';

			$klasa = 'Generic\\Modul\\'.$blok['kod_modulu'].'\\Admin';
			$instancja = new $klasa;
			$tlumaczenia = $instancja->pobierzTlumaczenia();
			$tlumaczenia = (isset($tlumaczenia['_akcje_etykiety_'])) ? $tlumaczenia['_akcje_etykiety_'] : array();
			foreach ($instancja->pobierzUprawnienia() as $metoda)
			{
				$uprawnienia['Bloki'][$blok['id']][$metoda] = (isset($tlumaczenia[$metoda])) ? $tlumaczenia[$metoda] : '';
			}
		}

		return $uprawnienia;
	}



	protected function pobierzUprawnieniaTresciRoli($id)
	{
		$mapper = $this->dane()->Uprawnienie();
		$dane_baza = $mapper->pobierzDlaRoli($id);
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[$wiersz->usluga.'_'.$wiersz->kodModulu.'_'.$wiersz->idKategorii.'_'.$wiersz->akcja] = $wiersz;
			}
		}

		return $uprawnienia_baza;
	}



	protected function naprawUprawnieniaTresci()
	{
		$kategorie = $this->dane()->Kategoria()->zwracaTablice()->pobierzWszystko();
		$uprawnienia = array();

		foreach ($kategorie as $kategoria)
		{
			if (!in_array($kategoria['typ'], array('kategoria', 'glowna'))) continue;
			if (empty($kategoria['kod_modulu'])) continue;

			$klasa = 'Generic\\Modul\\'.$kategoria['kod_modulu'].'\\Admin';

			$instancja = new $klasa;
			foreach ($instancja->pobierzUprawnienia() as $metoda)
			{
				$uprawnienia['Admin_'.$kategoria['id'].'_'.$metoda] = $kategoria['kod_modulu'];
			}
			$moduly = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
			$modul = $moduly->pobierzPoKodzie($kategoria['kod_modulu']);
			
			if (in_array('Http', $modul['uslugi']) && $kategoria['dla_zalogowanych'] == 1 && in_array($kategoria['typ'], array('kategoria', 'glowna')))
			{
				$klasa = 'Generic\\Modul\\'.$kategoria['kod_modulu'].'\\Http';
				$instancja = new $klasa;
				foreach ($instancja->pobierzUprawnienia() as $metoda)
				{
					$uprawnienia['Http_'.$kategoria['id'].'_'.$metoda] = $kategoria['kod_modulu'];
				}
			}
		}
		$bloki = $this->dane()->Blok()->zwracaTablice()->pobierzWszystko();
		foreach ($bloki as $blok)
		{
			$klasa = 'Generic\\Modul\\'.$blok['kod_modulu'].'\\Admin';
			$instancja = new $klasa;
			foreach ($instancja->pobierzUprawnienia() as $metoda)
			{
				$uprawnienia['Bloki_'.$blok['id'].'_'.$metoda] = $blok['kod_modulu'];
			}
		}
		$mapper = $this->dane()->Uprawnienie();
		$dane_baza = $mapper->zwracaTablice()->pobierzWszystko();
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[] = $wiersz['usluga'].'_'.$wiersz['id_kategorii'].'_'.$wiersz['akcja'];
			}
		}

         
		foreach ($uprawnienia as $kod => $modul)
		{
			if ($kod != '' && !in_array($kod, $uprawnienia_baza))
			{
				$kod = explode('_', $kod);
				
				$uprawnienie = new Uprawnienie\Obiekt();
				$uprawnienie->idProjektu = ID_PROJEKTU;
				$uprawnienie->kodJezyka = KOD_JEZYKA;
				$uprawnienie->usluga = $kod[0];
				$uprawnienie->idKategorii = $kod[1];
				$uprawnienie->kodModulu = $modul;
				$uprawnienie->akcja = $kod[2];
				$uprawnienie->hash = funkcjaHashujaca($kod[0].'_'.$kod[1].'_'.$kod[2]);
				$uprawnienie->zapisz($mapper);
			}
		}
	}



	protected function pobierzUprawnieniaAdministracyjne()
	{
		$mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		$moduly = $mapper->pobierzPoTypie('administracyjny', null, new DostepnyModul\Sorter('nazwa', 'asc'));
		$uprawnienia = array();
		foreach ($moduly as $modul)
		{
			$uprawnienia[$modul['kod']]['nazwa'] = $modul['nazwa'];

			$klasa = 'Generic\\Modul\\'.$modul['kod'].'\\Admin';
			$instancja = new $klasa;
			$tlumaczenia = $instancja->pobierzTlumaczenia();
			$tlumaczenia = (isset($tlumaczenia['_akcje_etykiety_'])) ? $tlumaczenia['_akcje_etykiety_'] : array();

			foreach ($instancja->pobierzUprawnienia() as $akcja)
			{
				$uprawnienia[$modul['kod']][$akcja] = (isset($tlumaczenia[$akcja])) ? $tlumaczenia[$akcja] : '';
			}
		}
		return $uprawnienia;
	}



	protected function pobierzUprawnieniaObiektow()
	{
		$katalogMappery = new Katalog(CMS_KATALOG.'/lib/Generic/Model/');
		$uprawnienia = array();

		foreach ($katalogMappery->pobierzZawartosc(1) as $klucz => $wartosc)
		{
			if ( !is_array($wartosc)
					|| strpos($klucz, '.') === 0
					|| ! is_file(CMS_KATALOG.'/lib/Generic/Model/' . $klucz . '/Obiekt.php')
					|| $klucz == 'Drzewo'
				)
			{
				continue;
			}

			$klasa = 'Generic\\Model\\' . $klucz . '\\Definicja';
			$instancja = new $klasa();

			if ( ! $instancja->_ochronaUprawnieniami)
			{
				continue;
			}

			$uprawnienia[$klucz]['nazwa'] = $klucz;

			$uprawnienia[$klucz]['wszystko_odczyt'] = sprintf($this->j->t['uprawnieniaObiektow.odczyt'], 'wszystko');
			$uprawnienia[$klucz]['wszystko_zapis'] = sprintf($this->j->t['uprawnieniaObiektow.zapis'], 'wszystko');
			foreach ($instancja->obslugiwanePola() as $pole)
			{
				$uprawnienia[$klucz][$pole . '_odczyt'] = sprintf($this->j->t['uprawnieniaObiektow.odczyt'], $pole);
				$uprawnienia[$klucz][$pole . '_zapis'] = sprintf($this->j->t['uprawnieniaObiektow.zapis'], $pole);
			}
		}

		return $uprawnienia;
	}



	protected function pobierzUprawnieniaAdministracyjneRoli($id)
	{
		$admnistracyjne_mapper = $this->dane()->UprawnienieAdministracyjne();
		$dane_baza = $admnistracyjne_mapper->pobierzDlaRoli($id);
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[$wiersz->kodModulu.'_'.$wiersz->akcja] = $wiersz;
			}
		}
		return $uprawnienia_baza;
	}



	protected function pobierzUprawnieniaObiektowRoli($id)
	{
		$admnistracyjne_mapper = $this->dane()->UprawnienieObiektu();
		$dane_baza = $admnistracyjne_mapper->pobierzDlaRoli($id);
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[$wiersz->kodObiektu.'_'.$wiersz->pole] = $wiersz;
			}
		}
		return $uprawnienia_baza;
	}



	protected function naprawUprawnieniaAdministracyjne()
	{
		$mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		$moduly = $mapper->pobierzPoTypie('administracyjny');
		$uprawnienia = array();
		foreach ($moduly as $modul)
		{
			$klasa = 'Generic\\Modul\\'.$modul['kod'].'\\Admin';
			$instancja = new $klasa;
			foreach ($instancja->pobierzUprawnienia() as $metoda)
			{
				$uprawnienia[] = $modul['kod'].'_'.$metoda;
			}
		}

		$mapper = $this->dane()->UprawnienieAdministracyjne();
		$dane_baza = $mapper->zwracaTablice()->pobierzWszystko();
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[] = $wiersz['kod_modulu'].'_'.$wiersz['akcja'];
			}
		}

		foreach ($uprawnienia as $kod)
		{
			if ($kod != '' && !in_array($kod, $uprawnienia_baza))
			{
				$kod = explode('_', $kod);
				$uprawnienie = new UprawnienieAdministracyjne\Obiekt();
				$uprawnienie->idProjektu = ID_PROJEKTU;
				$uprawnienie->kodJezyka = KOD_JEZYKA;
				$uprawnienie->kodModulu = $kod[0];
				$uprawnienie->akcja = $kod[1];
				$uprawnienie->hash = funkcjaHashujaca($kod[0].'_'.$kod[1]);
				$uprawnienie->zapisz($mapper);
			}
		}
	}



	protected function naprawUprawnieniaObiektow()
	{

		$uprawnieniaObiektow = array();

		foreach ($this->pobierzUprawnieniaObiektow() as $obiekt => $uprawnienia)
		{
			foreach ($uprawnienia as $kod => $opis)
			{
				$uprawnieniaObiektow[] = array(
					0 => $obiekt,
					1 => $kod,
				);
			}
		}

		$uprawnienia_baza = array();
		$mapper = $this->dane()->UprawnienieObiektu();

		foreach ($this->dane()->UprawnienieObiektu()->ZwracaTablice()->pobierzWszystko() as $uprawnienie)
		{
			$uprawnienia_baza[] = $uprawnienie['kod_obiektu'] . '_' . $uprawnienie['pole'];
		}

		foreach ($uprawnieniaObiektow as $kod)
		{
			if ($kod[1] == 'nazwa')
			{
				continue;
			}

			if ($kod[0] != '' && !in_array($kod[0] . '_' . $kod[1], $uprawnienia_baza))
			{
				$uprawnienie = new UprawnienieObiektu\Obiekt();
				$uprawnienie->idProjektu = ID_PROJEKTU;
				$uprawnienie->kodJezyka = KOD_JEZYKA;
				$uprawnienie->kodObiektu = $kod[0];
				$uprawnienie->pole = $kod[1];
				$uprawnienie->hash = funkcjaHashujaca($kod[0] . '_' . $kod[1]);
				$uprawnienie->zapisz($mapper);
			}
		}
	}

}
