<?php
namespace Generic\Modul\UserAccount;

use Generic\Biblioteka\Modul;
use Generic\Model;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Walidator;

/**
 * Modul administracyjny odpowiedzialny edycję danych uzytkownika.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\UserAccount\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\UserAccount\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajSignIn',
		'wykonajSingOut',
		'wykonajReminder',
		'wykonajActivate',
		'wykonajChangePassword',
		'wykonajChangeEmail',
		'wykonajEditProfile',
		'wykonajRemovePhoto',
		'usuwanieWlasnegoZdjecia',
		'poprawianieWlasnejMiniaturki',
		'edycjaDanychPracowniczych',
		'wykonajZalogujPracownika',
	);

	protected $zdarzenia = array(
		'udane_logowanie',
		'wyslanie_maila',
	);

	protected $dozwoloneAkcje = array(
		'wykonajSignIn',
		'wykonajSignOut',
		'wykonajReminder',
		'wykonajActivate',
		'wykonajChangePassword',
		'wykonajZalogujPracownika',
	);


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony'],
			'tytul_modulu' => $this->j->t['index.tytul_strony'],
		));

		$this->wyswietlMenu();

		$this->wyswietlPodsumowanie();

		$this->ustawUrlPowrotny();
	}

	public function wykonajZalogujPracownika()
	{
		echo json_encode(array('test' => 'test')); die;
	}

	public function wykonajSignIn()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['zaloguj.tytul_strony'],
			'tytul_modulu' => $this->j->t['zaloguj.tytul_strony'],
		));

		$cms = Cms::inst();
		
		if ($cms->profil() instanceof Uzytkownik\Obiekt
			&& $cms->profil()->status == 'aktywny'
			&& $cms->profil()->czyAdmin == 1)
		{
			Router::przekierujDo(Router::urlAdmin('UserAccount'));
			return;
		}

		if (!isset($cms->sesja->proby_logowania)) $cms->sesja->proby_logowania = 0;
		if (!isset($cms->sesja->proby_logowania_blokada_do)) $cms->sesja->proby_logowania_blokada_do = 0;

		if ($cms->sesja->proby_logowania_blokada_do > date('U'))
		{
			$this->komunikat(sprintf($this->j->t['zaloguj.blad_przekroczono_limit'], $this->k->k['zaloguj.nieudane_proby'], $this->k->k['zaloguj.czas_blokowania']), 'error');
		}
		else
		{
			$obiektFormularza = new \Generic\Formularz\Uzytkownik\Logowanie(); //TODO: Sprawdzić czemu nie ma tłumaczeń w formularzu

			$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('zaloguj'));

			if ($obiektFormularza->wypelniony())
			{
				if ($obiektFormularza->danePoprawne())
				{
					$dane = $obiektFormularza->pobierzZmienioneWartosci();
					
					if (Uzytkownik\Obiekt::zaloguj(mb_strtolower($dane['login']), $dane['haslo']))
					{
						if ($cms->profil()->status == 'nieaktywny')
						{
							$cms->sesja->nieaktywnyUzytkownik = $cms->profil();
							unset($cms->sesja->uzytkownik);
							setcookie('zalogowany', 'true', 0, '/', DOMENA);
							$this->komunikat($this->j->t['zaloguj.blad_konto_nieaktywne'], 'warning');
							if ($this->k->k['zaloguj.ponowne_przeslanie_aktywacji'])
							{
								Router::przekierujDo(Router::urlHttp($this->kategoria, array('email_aktywacyjny')));
							}
							return;
						}
						elseif ($cms->profil()->status == 'zablokowany')
						{
							unset($cms->sesja->uzytkownik);
							$this->komunikat($this->j->t['zaloguj.blad_konto_zablokowane'], 'warning');
							return;
						}
						elseif (isset($cms->sesja->urlPoZalogowaniu) && !empty($cms->sesja->urlPoZalogowaniu))
						{
							$urlPoZalogowaniu = $cms->sesja->urlPoZalogowaniu;
							unset($cms->sesja->urlPoZalogowaniu);
						}
						else
						{
							$kategorieMapper = new \Generic\Model\Kategoria\Mapper();

							$kategoriaStartowa = $kategorieMapper->pobierzStartowaAdmin();
							$urlPoZalogowaniu = Router::urlAdmin($kategoriaStartowa);
						}

						// sprawdzenie czy użytkownik jest aktywny oraz posiada token, jeżeli tak to usuwamy token
						if ($cms->profil()->status == 'aktywny' && $cms->profil()->token != '')
						{
							$uzytkownikMapper = $cms->dane()->Uzytkownik();
							$cms->profil()->token = null;
							$cms->profil()->zapisz($uzytkownikMapper);
						}

						$this->zdarzenie('udane_logowanie', array('login' => $dane['login']));
						$cms->sesja->proby_logowania = 0;
						setcookie('zalogowany', 'true', 0, '/', DOMENA);
						Router::przekierujDo($urlPoZalogowaniu);
						return;
					}
					else
					{
						$cms->sesja->proby_logowania++;
						$this->komunikat($this->j->t['zaloguj.blad_nieprawidlowy_login_haslo'], 'warning');
					}
				}
				else
				{
					$this->komunikat($this->j->t['zaloguj.blad_nieprawidlowy_login_haslo'], 'warning');
				}
			}
			$dane['formularz'] = $obiektFormularza->html();
		}
		if ($this->k->k['zaloguj.nieudane_proby'] > 0 &&
			$cms->sesja->proby_logowania >= $this->k->k['zaloguj.nieudane_proby'])
		{
			$cms->sesja->proby_logowania = 0;
			$cms->sesja->proby_logowania_blokada_do = date('U') + ((int)$this->k->k['zaloguj.czas_blokowania'] * 60);
		}
		$dane['link_przypomnij_haslo'] = Router::urlAdmin('UserAccount', 'reminder');
		$dane['etykieta_link_przypomnij_haslo'] = $this->j->t['zaloguj.etykieta_link_przypomnij_haslo'];
		$this->ustawUrlPowrotny();
		$this->tresc .= $this->szablon->parsujBlok('zaloguj', $dane);
	}



	public function wykonajSignOut()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Kategoria();
		
		$brakLokalizacji = Zadanie::pobierz('noLocation', 'intval');
		$nieLider = Zadanie::pobierz('nieLider', 'intval');

		unset($cms->sesja->uzytkownik);
		setcookie('zalogowany', '', time()-3600, '/', DOMENA);
		unset($_COOKIE['zalogowany']);

		$kategoria = $mapper->pobierzGlowna();
		$kategoria = ($kategoria instanceof Kategoria\Obiekt) ? $kategoria : $this->kategoria;
		
		if ($brakLokalizacji)
		{
			$this->komunikat($this->j->t['signOut.brakUdostepnionejLokalizacji'], 'error', 'system', 'spacedAlert');
		}
		if ($nieLider)
		{
			$this->komunikat($this->j->t['signOut.nieLiderTeamu'], 'info', 'system', 'spacedAlert');
		}
		
		Router::przekierujDo(Router::url(Zadanie::protokol().'://'.DOMENA));
	}



	public function wykonajReminder()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['przypomnij.tytul_strony']));
		$obiektFormularza = new \Generic\Formularz\Uzytkownik\PrzypomnijHaslo();
		$obiektFormularza->ustawUrlPowrotny($this->pobierzUrlPowrotny());
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('przypomnij'));

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$uzytkownicy = $this->dane()->Uzytkownik();

			$dane = $obiektFormularza->pobierzZmienioneWartosci();
			$uzytkownik = $uzytkownicy->pobierzPoLoginie($dane['login']);
			if ($uzytkownik instanceof Uzytkownik\Obiekt && $uzytkownik->email == $dane['email'])
			{
				if($this->wyslijPrzypomnienie($uzytkownik))
				{
					$this->komunikat($this->j->t['przypomnij.info_wyslano_email'], 'info', 'sesja');
					Router::przekierujDo(Router::urlAdmin('UserAccount', 'signIn'));
				}
				else
				{
					$this->komunikat($this->j->t['przypomnij.blad_nie_mozna_wyslac_przypomnienia'], 'error');
				}
			}
			else
			{
				$this->komunikat($this->j->t['przypomnij.blad_nie_odnaleziono_uzytkownika'], 'warning');
			}
		}
		$daneSzablonu['formularz'] = $obiektFormularza->html();
		$this->tresc .= $this->szablon->parsujBlok('przypomnij', $daneSzablonu);
	}
	
	
	public function wykonajActivate()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['activate.tytul_strony'],
			'tytul_modulu' => $this->j->t['activate.tytul_modulu'],
		));
		$token = Zadanie::pobierzGet('token', 'strval', 'trim');
		
		if ($token === '' || strlen($token) > 32 || strlen($token) < 32)
		{
			$this->komunikat($this->j->t['activate.blad_tokena'], 'error');
			Router::przekierujDo(Zadanie::protokol().'://www.'.DOMENA);
		}
		
		$uzytkownik = $this->dane()->Uzytkownik()->pobierzDoAktywacji($token);
		if ($uzytkownik instanceof Model\Uzytkownik\Obiekt)
		{
			$uzytkownik->haslo = '';
			$obiektFormularza = new \Generic\Formularz\Uzytkownik\ZmianaHasla();
			$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('zmienHaslo'))
			->ustawObiekt($uzytkownik)
			->ustawToken($token)
			->ustawKonfiguracje($this->k->k);
			
			if ($obiektFormularza->wypelniony())
			{
				$walidatorIdentycznehaslo = new Walidator\Rowne($obiektFormularza->zwrocFormularz()->nowe_haslo->pobierzWartosc(), true);
				$walidatorIdentycznehaslo->ustawTlumaczenia(array('walidator_rowne_nie_jest_rowne' => $this->j->t['zmienHaslo.walidator_hasla_inne']));
				$obiektFormularza->zwrocFormularz()->nowe_haslo_powtorz->dodajWalidator($walidatorIdentycznehaslo);

				if ($obiektFormularza->danePoprawne())
				{
					$uzytkownicy = $this->dane()->Uzytkownik();

					$dane = $obiektFormularza->pobierzZmienioneWartosci();
					
					$uzytkownik->ustawHaslo($dane['nowe_haslo']);
					$uzytkownik->token = null;
					$uzytkownik->status = 'aktywny';
					$uzytkownik->czyAdmin = true;
					if ($uzytkownik->zapisz($uzytkownicy))
					{
						$this->komunikat($this->j->t['activate.sukces_uzytkownik_ustawil_haslo_aktywacja'], 'success', 'sesja');
					}
					else
					{
						$this->komunikat($this->j->t['activate.blad_zapisu_danych_uzytkownika'], 'error', 'sesja');
					}
					Router::przekierujDo(Zadanie::protokol().'://www.'.DOMENA);
				}
			}
			
			$this->tresc .= $this->szablon->parsujBlok('zmienHaslo', array(
				'formularz' => $obiektFormularza->html(),
			));
		}
		else
		{
			$this->komunikat($this->j->t['activate.blad_odczytu_uzytkownika_dla_tokenu'], 'warning', 'sesja');
			Router::przekierujDo(Zadanie::protokol().'://www.'.DOMENA);
		}
	}

			  
	public function wykonajChangePassword()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['zmienHaslo.tytul_strony']));

		$token = Zadanie::pobierz('token','trim');

		$mapper = $this->dane()->Uzytkownik();

		if ($token != '')
		{
			$uzytkownik = $mapper->pobierzDlaTokenu($token);
		}
		else
		{
			$uzytkownik = Cms::inst()->profil();
		}

		if (!($uzytkownik instanceof Uzytkownik\Obiekt))
		{
			if ($token != '')
			{
				$this->komunikat($this->j->t['zmienHaslo.blad_nieprawidlowy_token'], 'error', 'sesja');
			}
			
			Router::przekierujDo(Router::urlAdmin('UserAccount'));
			return;
		}

		$obiektFormularza = new \Generic\Formularz\Uzytkownik\ZmianaHasla();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('zmienHaslo'))
			->ustawObiekt($uzytkownik)
			->ustawToken($token)
			->ustawKonfiguracje($this->k->k);

		if ($obiektFormularza->wypelniony())
		{
			$obiektFormularza->zwrocFormularz()->nowe_haslo_powtorz->dodajWalidator(new Walidator\Rowne($obiektFormularza->zwrocFormularz()->nowe_haslo->pobierzWartosc(), true));

			if ($obiektFormularza->danePoprawne())
			{
				$dane = $obiektFormularza->pobierzWartosci();
				$uzytkownik->haslo = $dane['nowe_haslo'];
				if ($token != '')
				{
					$uzytkownik->token = null;
				}
				if ($uzytkownik->zapisz($mapper))
				{
					$this->komunikat($this->j->t['zmienHaslo.info_zmieniono_haslo'], 'info', 'sesja');
					Router::przekierujDo(Router::urlAdmin('UserAccount'));
					return;
				}
				else
				{
					$this->komunikat($this->j->t['zmienHaslo.blad_nie_mozna_zmienic_hasla'], 'error');
				}
			}
		}

		$this->wyswietlMenu();
		$this->tresc .= $this->szablon->parsujBlok('zmienHaslo', array(
			'formularz' => $obiektFormularza->html(),
		));
	}



	public function wykonajChangeEmail()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['zmienEmail.tytul_strony']));
		$uzytkownik = Cms::inst()->profil();


		$obiektFormularza = new \Generic\Formularz\Uzytkownik\ZmianaEmaila();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('zmienEmail'))
			->ustawObiekt($uzytkownik);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();
			$uzytkownik->email = $dane['email'];
			if($uzytkownik->zapisz($this->dane()->Uzytkownik()))
			{
				$this->komunikat($this->j->t['zmienEmail.info_zmieniono_adres_email'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin('UserAccount'));
			}
			else
			{
				$this->komunikat($this->j->t['zmienEmail.blad_nie_mozna_zmienic_adresu_email'], 'error');
			}
		}

		$this->wyswietlMenu();
		$this->tresc .= $this->szablon->parsujBlok('zmienEmail', array(
			'formularz' => $obiektFormularza->html(),
		));
	}



	public function wykonajEditProfile()
	{
		$cms = Cms::inst();
		$uzytkownik = $this->dane()->Uzytkownik()->pobierzPoId($cms->profil()->id);

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$obiektFormularza = new \Generic\Formularz\Uzytkownik\Edycja();

		$konfiguracjaMapper = new \Generic\Model\WierszKonfiguracji\Mapper();

		$konfiguracjaUzytkownicyZarzadzanie = $konfiguracjaMapper->pobierzDlaModuluPelna('UzytkownicyZarzadzanie\Admin');

		//dump($konfiguracjaUzytkownicyZarzadzanie);
		$skills = $konfiguracjaUzytkownicyZarzadzanie['formularz.available_skills'];
		$konfiguracjaRozmiarowMiniaturek = $konfiguracjaUzytkownicyZarzadzanie['formularz.rozmiary_miniaturek_zdjecia'];
		$prefixMiniaturyPodgladu = $konfiguracjaUzytkownicyZarzadzanie['formularz.prefix_miniatury_podgladu'];
		unset($konfiguracjaMapper, $konfiguracjaUzytkownicyZarzadzanie);

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawUrlPowrotny(Router::urlAdmin('UserAccount'))
			->ustawObiekt($uzytkownik)
			->ustawKonfiguracje(array_merge(array(
				'formularz.prefix_miniatury_podgladu' => $prefixMiniaturyPodgladu,
				'formularz.rozmiary_miniaturek_zdjecia' => $konfiguracjaRozmiarowMiniaturek,
				'formularz.available_skills' => $skills,
			), $this->k->k))
			->ustawUprawnienia(array(
				'moznaUsunacZdjecie' => $cms->profil()->maUprawnieniaDo('UserAccount_usuwanieWlasnegoZdjecia'),
				'moznaPoprawicMiniaturke' => $cms->profil()->maUprawnieniaDo('UserAccount_poprawianieWlasnejMiniaturki'),
				'edycjaDanychPracowniczych' => $cms->profil()->maUprawnieniaDo('UserAccount_edycjaDanychPracowniczych'),
			));

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			foreach ($obiektFormularza->pobierzZmienioneWartosci() as $klucz => $wartosc)
			{
				if ($klucz == 'zdjecie')
				{
					$katalogDocelowy = $cms->katalog('zdjecia_pracownikow');
					$plik = $wartosc;
					if ($uzytkownik->zdjecie != '')
					{
						foreach ($konfiguracjaRozmiarowMiniaturek as $prefix => $kod)
						{
							$prefix = ($prefix != '') ? $prefix.'-' : '';
							$stare_zdjecie = new Plik\Zdjecie($katalogDocelowy.$prefix.$uzytkownik->zdjecie);
							$stare_zdjecie->usun();
						}
					}
					$nazwaPliku = strtolower(hash_file('crc32', $plik['tmp_name']).'.'.file_ext($plik['name']));

					$zdjecie = new Plik\Zdjecie($plik['tmp_name']);
					$zdjecie->przeniesDo($katalogDocelowy.$nazwaPliku);

					$usun = true;
					foreach ($konfiguracjaRozmiarowMiniaturek as $prefix => $kod)
					{
						$prefix = ($prefix != '') ? $prefix.'-' : '';
						if ($prefix == '') $usun = false;
						$zdjecie->tworzMiniaturke($katalogDocelowy.$prefix.$nazwaPliku, $kod);
					}
					if ($usun) $zdjecie->usun();

					$uzytkownik->zdjecie = $nazwaPliku;
					continue;
				}
				if ($klucz == 'umiejetnosci' || $klucz == 'tabelaPodatkowa' || $klucz == 'stawkaGodzinowa')
				{
					continue;
				}
				$uzytkownik->$klucz = $wartosc;
			}

			if ($uzytkownik->zapisz($this->dane()->Uzytkownik()))
			{
				$cms->sesja->uzytkownik = $uzytkownik;
				$this->komunikat($this->j->t['edytuj.zapisano_dane'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin('UserAccount'));
			}
			else
			{
				$this->komunikat($this->j->t['edytuj.blad_nie_mozna_zapisac_danych'], 'error');
			}
		}

		$this->wyswietlMenu();
		$this->tresc .= $this->szablon->parsujBlok('edytuj', array(
			'formularz' => $obiektFormularza->html(),
		));
	}



	protected function wyslijPrzypomnienie(Uzytkownik\Obiekt $uzytkownik)
	{
		$token = losowyKlucz(32);
		$uzytkownik->token = $token;
		//if ($uzytkownik->zapisz($this->dane()->Uzytkownik()))
		if ($uzytkownik->zapisz(Cms::inst()->dane()->Uzytkownik()))
		{
			$dane = array(
				'obiekt_Uzytkownik' => $uzytkownik,
				'linkPrzypomnienie' => Router::urlAdmin('UserAccount', 'changePassword', array('token' => $token)),
			);

			$poczta = new Pomocnik\Poczta($this->k->k['przypomnij.id_formatki_email'], $dane);
			$status = $poczta->wyslij();

			$this->zdarzenie('wyslanie_maila', array(
				'status' => ($status) ? true : false,
				'opis' => ($status) ? $this->j->t['przypomnij.info_wyslano_email'] : $this->j->t['przypomnij.blad_nie_mozna_wyslac_przypomnienia'],
			));

			return $status;
		}
		else
		{
			return false;
		}
	}


	protected function wyswietlPodsumowanie()
	{
		$dane=array();

		//$dane['wiadomosci'] =				$this->tabelaWiadomosci();
		//$dane['wiadomosciKontakt'] =		$this->tabelaWiadomosciKontakt();
		//$dane['wizytowki'] =				$this->tabelaWizytowki();
		//$dane['wizytowkiOpublikowane'] =	$this->tabelaWizytowkiOpublikowane();
		//$dane['ogloszenia'] =				$this->tabelaOgloszenia();
		$dane['linki'] =					$this->tabelaLinki();

		$this->tresc .= $this->szablon->parsujBlok('podsumowanie', $dane);
	}


	protected function tabelaLinki()
	{

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['linki.tytul'], 0);

		$grid->naglowek('<span class="icon"><i class="icon-link"></i></span><h5>'.$this->j->t['linki.tytul'].'</h5>');

		foreach($this->k->k['szybkie_linki.lista'] as $klucz => $wartosc)
		{

			$wiersz = array(
				'id' => 0,
				'nazwa' => '<a href="'.$wartosc.'">'.$klucz.'</a>',
			);
			$grid->dodajWiersz($wiersz);
		}

		return $grid->html(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_TABELA_DANYCH2);

	}


	protected function wyswietlMenu()
	{
		$dane = array();
		$dane['link_zmien_dane'] = Router::urlAdmin('UserAccount', 'editProfile');
		$dane['link_zmien_haslo'] = Router::urlAdmin('UserAccount', 'changePassword');
		$dane['link_zmien_email'] = Router::urlAdmin('UserAccount', 'changeEmail');

		$this->tresc .= $this->szablon->parsujBlok('menu', $dane);
	}



	protected function moznaWykonacAkcje($metoda, $wlasnyKod = false, $obiektKontekstu = null)
	{
		if (in_array($metoda, $this->dozwoloneAkcje))
		{
			return true;
		}
		return parent::moznaWykonacAkcje($metoda, $wlasnyKod, $obiektKontekstu);
	}


	public function wykonajRemovePhoto()
	{
		$mapper = $this->dane()->Uzytkownik();
		$uzytkownik = Cms::inst()->profil();

		if ($uzytkownik instanceof Uzytkownik\Obiekt)
		{
			$katalog = new \Generic\Biblioteka\Katalog(Cms::inst()->katalog('zdjecia_pracownikow'));

			$bledy = 0;

			$konfiguracjaMapper = new \Generic\Model\WierszKonfiguracji\Mapper();
			$konfiguracjaUzytkownicyZarzadzanie = array_merge($konfiguracjaMapper->pobierzDlaModuluDomyslna('UzytkownicyZarzadzanie\Admin', $konfiguracjaMapper->pobierzDlaModulu('UzytkownicyZarzadzanie')));
			$konfiguracjaRozmiarowMiniaturek = $konfiguracjaUzytkownicyZarzadzanie['formularz.rozmiary_miniaturek_zdjecia'];

			unset($konfiguracjaUzytkownicyZarzadzanie);

			foreach ($konfiguracjaRozmiarowMiniaturek as $prefix => $kod)
			{
				$prefix = ($prefix != '') ? $prefix.'-' : '';
				$plik = new Plik($katalog.'/'.$prefix.$uzytkownik->zdjecie);
				if (! ($plik->istnieje() && $plik->usun()))
					$bledy++;
			}

			$uzytkownik->zdjecie = '';

			if ($uzytkownik->zapisz($mapper))
			{
				$this->komunikat($this->j->t['usunZdjecie.info_usunieto_zdjecie'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usunZdjecie.blad_nie_mozna_usunac_zdjecia'], 'error', 'sesja');
			}
			Router::przekierujDo(Router::urlAdmin('UserAccount', 'editProfile'));
		}
		else
		{
			$this->komunikat($this->j->t['usunZdjecie.blad_nie_mozna_pobrac_uzytkownika'], 'error');
		}
	}

}
