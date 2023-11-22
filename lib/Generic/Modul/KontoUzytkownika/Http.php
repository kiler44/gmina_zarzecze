<?php
namespace Generic\Modul\KontoUzytkownika;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Model\Wizytowka;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Okruszki;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Model\Wiadomosc;
use Generic\Biblioteka\Pomocnik;


/**
 * Modul odpowiedzialny za zarzadząnie kontem użytkownika.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\KontoUzytkownika\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\KontoUzytkownika\Http
	 */
	protected $j;

	protected $szablonFormularz;
	protected $szablonFormularzZwykly;

	protected $obserwatorzy = array();

	protected $zdarzenia = array(
		'udane_logowanie',
		'nieudane_logowanie',
		'wyslanie_maila',
	);

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajGlowna',
		'wykonajZaloguj',
		'wykonajWyloguj',
		'wykonajPrzypomnij',
		'wykonajZmienHaslo',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajEmailAktywacyjny',
		'kontoSerwisowe',
		'kontoSerwisowePh',
		'urlopy',
		'raporty',
		'raportyBok',
		'raportyEdytowalne',
		'kategorieZarzadzanie',
		'rejestracja',
		'wykonajOdnowienie',
		'wykonajOdrzucenie',
		'rejestracjaSuperads',
		'rejestracjaSuperwebsite',
		'serwisoweSuperwebsite',
		'weryfikacjaMaterialow',
		'kontoKorektora',
		'firmyPozyskane',
	);



	public function wykonajIndex()
	{
		$akcja = Zadanie::pobierz('url_parametr_0', 'strval');

		$cms = Cms::inst();

		$cms->temp('uzytkownikKonto_aktywnaZakladka', 'glowna');

		$this->szablonFormularz = $this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_konto_uzytkownika']);
		$this->szablonFormularzZwykly = $this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz']);

		if ($cms->profil() instanceof Uzytkownik\Obiekt)
		{

			switch($akcja)
			{
				case 'wyloguj':
					$this->wykonajAkcje('wyloguj');
				break;

				default:
					$this->wykonajAkcje('glowna');
				break;
			}
		}
		else if ($akcja == 'przypomnij_haslo')
		{
			$this->wykonajAkcje('przypomnij');
		}
		else if ($akcja == 'email_aktywacyjny')
		{
			$this->wykonajAkcje('emailAktywacyjny');
		}
		else
		{
			$this->wykonajAkcje('zaloguj');
		}
	}



	public function wykonajGlowna()
	{
		$cms = Cms::inst();

		if ( ! $cms->profil()->czyAdmin)
		{
			return false;
		}

		$this->ustawGlobalne(array(
			'tytul_strony' => sprintf($this->j->t['glowna.tytul_strony'], $cms->profil()->pelnaNazwa.' ('.$cms->profil()->login.')'),
			'tytul_modulu' => sprintf($this->j->t['glowna.tytul_modulu'], $cms->profil()->pelnaNazwa.' ('.$cms->profil()->login.')'),
		));

		$dane = array();

		$dane['link_admin'] = Router::urlAdmin('UserAccount', 'index');
		$this->szablon->ustawBlok('glowna/admin', $dane);

		Router::przekierujDo(Router::urlAdmin('UserAccount', 'index'));

		$this->tresc .= $this->szablon->parsujBlok('glowna', $dane);
	}



	public function wykonajZaloguj()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['zaloguj.tytul_strony'],
			'tytul_modulu' => $this->j->t['zaloguj.tytul_modulu'],
		));

		$cms = Cms::inst();
		$dane = array();

		$glowna = $this->dane()->Kategoria()->pobierzGlowna();
		Okruszki::wywolaj()->resetujSciezkeSerwisu()
			->dodaj($this->urlHttp($glowna, 'index'), $glowna->nazwa)
			->dodaj(Router::urlHttp('KontoUzytkownika',array('zaloguj')), $this->j->t['zaloguj.tytul_okruszki']);

		//Sprawdzenie czy nie zostalo zablokowane logowanie uzytkownikow do portalu
		if($cms->config['blokady']['blokowanie_logowania'])
		{
			$this->komunikat($this->j->t['zaloguj.blad_zablokowano_logowanie'], 'warning');
			return;
		}

		if ($cms->profil() instanceof Uzytkownik\Obiekt
			&& $cms->profil()->status == 'aktywny'
			&& $cms->profil()->czyAdmin == 1)
		{
			Router::przekierujDo(Router::urlHttp($this->kategoria));
			return;
		}

		if (!isset($cms->sesja->proby_logowania)) $cms->sesja->proby_logowania = 0;
		if (!isset($cms->sesja->proby_logowania_blokada_do)) $cms->sesja->proby_logowania_blokada_do = 0;

		if ($cms->sesja->proby_logowania_blokada_do > time())
		{
			$this->komunikat(sprintf($this->j->t['zaloguj.blad_przekroczono_limit'], $this->k->k['zaloguj.nieudane_proby'], $this->k->k['zaloguj.czas_blokowania']), 'error');
			$this->zdarzenie('nieudane_logowanie', array('login' => Zadanie::PobierzPost('login', 'trim', 'addslashes')));
		}
		else
		{
			$form = new Formularz('', 'logForm', null, 'post', false);

			$form->otworzZbiorowyInput('field', '', '', true);

				$form->input(new Input\Text('login'))
					->dodajFiltr('strip_tags', 'trim');

				$form->input(new Input\Password('haslo'))
					->dodajFiltr('strip_tags', 'trim');

				$form->input(new Input\Html('przypomnijHaslo', array(
					'wartosc' => $this->szablon->parsujBlok('/zaloguj/linkPrzypomnienie', array(
						 'link_przypomnienie' => Router::urlHttp($this->kategoria, array('przypomnij_haslo'))
					)),
				)));

			$form->zamknijZbiorowyInput('field');

			$form->stopka(new Input\SubmitOpakowany('wyslij', array(
				'klasa' => 'btn btn-inverse'
			)));

			$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('zaloguj'));

			foreach ($form as $nazwaInputa => $input)
			{
				if (in_array($nazwaInputa, $this->k->k['zaloguj.wymagane_pola']))
				{
					$form->$nazwaInputa->wymagany = true;
					$form->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
				}
			}

			if ($form->wypelniony())
			{
				if ($form->danePoprawne())
				{
					$dane = $form->pobierzZmienioneWartosci();

					if (Uzytkownik\Obiekt::zaloguj($dane['login'], $dane['haslo']))
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
							$urlPoZalogowaniu = Router::urlHttp($this->kategoria);
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
					$this->komunikat($this->j->t['zaloguj.blad_nie_wypelniono_formularza'], 'warning');
				}
			}
			$dane['formularz'] = $form->html($this->szablonFormularzZwykly, true);
		}
		if ($this->k->k['zaloguj.nieudane_proby'] > 0 &&
			$cms->sesja->proby_logowania >= $this->k->k['zaloguj.nieudane_proby'])
		{
			$cms->sesja->proby_logowania = 0;
			$cms->sesja->proby_logowania_blokada_do = time() + ((int)$this->k->k['zaloguj.czas_blokowania'] * 60);
			Router::przekierujDo(Router::urlHttp($this->kategoria, array('zaloguj')));
		}
		$kategorie = $this->dane()->Kategoria();
		$kategorie = $kategorie->pobierzDlaModulu('RejestracjaNowa');
		if (isset($kategorie[0]) && $kategorie[0] instanceof Kategoria\Obiekt)
		{
			$dane['link_rejestracja'] = Router::urlHttp($kategorie[0], array('firma'));
		}
		$this->tresc .= $this->szablon->parsujBlok('zaloguj', $dane);
	}



	public function wykonajWyloguj()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Kategoria();
		if ($cms->profil('pracownikBok') instanceof Uzytkownik\Obiekt
			&& $cms->profil('pracownikBok')->id != $cms->profil()->id)
		{
			$cms->sesja->uzytkownik = $cms->profil('pracownikBok');
			unset($cms->sesja->pracownikBok);

			$urlKorektor = $this->pobierzUrlPowrotny('korektor', true);
			if ($cms->sesja->przechwycilKorektor && $urlKorektor != Zadanie::wywolanyUrl())
			{
				unset($cms->sesja->przechwycilKorektor);
				Router::przekierujDo($urlKorektor);
			}
			else
			{
				$kategoria = $mapper->pobierzDlaModulu('KontoSerwisowe');
				Router::przekierujDo(Router::urlHttp($kategoria[0]));
			}
		}
		else
		{
			if ($cms->profil('pracownikBok') instanceof Uzytkownik\Obiekt)
			{
				unset($cms->sesja->pracownikBok);
			}
			unset($cms->sesja->uzytkownik);
			setcookie('zalogowany', '', time()-3600, '/', DOMENA);
			unset($_COOKIE['zalogowany']);
		}
		$kategoria = $mapper->pobierzGlowna();
		$kategoria = ($kategoria instanceof Kategoria\Obiekt) ? $kategoria : $this->kategoria;
		Router::przekierujDo(Router::urlHttp($kategoria));
	}



	public function wykonajPrzypomnij()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['przypomnij.tytul_strony'],
			'tytul_modulu' => $this->j->t['przypomnij.tytul_modulu'],
		));

		$glowna = $this->dane()->Kategoria()->pobierzGlowna();
		Okruszki::wywolaj()->resetujSciezkeSerwisu()
			->dodaj($this->urlHttp($glowna, 'index'), $glowna->nazwa)
			->dodaj(Router::urlHttp('KontoUzytkownika',array('przypomnij_haslo')), $this->j->t['przypomnij.tytul_okruszki']);

		$cms = Cms::inst();

		$form = new Formularz('', 'logForm');

		$form->input(new Input\Html('info'));

		$form->otworzZbiorowyInput('field', '', '', true);

			$form->input(new Input\Text('login'))
				->dodajFiltr('strip_tags', 'strtolower', 'trim');

			$form->input(new Input\Text('email'))
				->dodajFiltr('strip_tags', 'strtolower', 'trim')
				->dodajWalidator(new Walidator\Email());

		$form->zamknijZbiorowyInput('field');

		$form->stopka(new Input\SubmitOpakowany('wyslij', array(
			'klasa' => 'btn btn-primary'
		)));
		$form->stopka(new Input\ButtonOpakowany('wstecz', array(
			'atrybuty' => array('onclick' => 'history.back(); return false;' ),
			'klasa' => 'btn btn-danger'
		)));

		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('przypomnij'));

		foreach ($form as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->k->k['przypomnij.wymagane_pola']))
			{
				$form->$nazwaInputa->wymagany = true;
				$form->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
		}

		if ($form->wypelniony())
		{
			if($form->danePoprawne())
			{
				$uzytkownicy = $this->dane()->Uzytkownik();

				$dane = $form->pobierzZmienioneWartosci();
				$uzytkownik = $uzytkownicy->pobierzPoLoginie($dane['login']);
				if ($uzytkownik instanceof Uzytkownik\Obiekt && strtolower($uzytkownik->email) == $dane['email'])
				{
					if ($this->wyslijPrzypomnienie($uzytkownik))
					{
						$this->komunikat($this->j->t['przypomnij.info_wyslano_email'], 'info', 'sesja');
						Router::przekierujDo(Router::urlHttp($this->kategoria, array('zaloguj')));
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
			else
			{
				$this->komunikat($this->j->t['przypomnij.blad_nie_wypelniono_formularza'], 'warning');
			}
		}
		$daneSzablonu['formularz'] = $form->html($this->szablonFormularzZwykly, true);
		$this->tresc .= $this->szablon->parsujBlok('przypomnij', $daneSzablonu);
	}



	public function wykonajEmailAktywacyjny()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['emailAktywacyjny.tytul_strony'],
			'tytul_modulu' => $this->j->t['emailAktywacyjny.tytul_modulu'],
		));

		$cms = Cms::inst();

		if ($cms->sesja->nieaktywnyUzytkownik->status != 'nieaktywny')
		{
			Router::przekierujDo(Router::urlHttp($this->kategoria));
			return;
		}

		$form = new Formularz('', 'logForm');

		if ( ! $form->wypelniony())
			$this->komunikat($this->j->t['zaloguj.blad_konto_nieaktywne'], 'warning');

		$form->otworzZbiorowyInput('field', '', '', true);

			$form->input(new Input\Html('info'));

			$form->input(new Input\Html('emailOld', array(
				'wartosc' => $cms->sesja->nieaktywnyUzytkownik->email
			)));

			$form->input(new Input\Text('email'));
			$form->email->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
			if ($form->wypelniony() && $form->email->pobierzWartosc() != '')
			{
				$form->email->dodajWalidator(new Walidator\Email());
				$form->email->dodajWalidator(new Walidator\RozneOd($cms->sesja->nieaktywnyUzytkownik->email));
			}

		$form->zamknijZbiorowyInput('field');

		$form->stopka(new Input\SubmitOpakowany('wyslij'));
		$form->stopka(new Input\SubmitOpakowany('wstecz', array(
			'atrybuty' => array('onclick' => 'history.back(); return false' ),
			'klasa' => 'buttonSet buttonLight',
		)));

		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('emailAktywacyjny'));

		foreach ($form as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->k->k['emailAktywacyjny.wymagane_pola']))
			{
				$form->$nazwaInputa->wymagany = true;
				$form->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
		}

		$wyslanoEmailAktywacyjny = false;

		if ($form->wypelniony() && $form->danePoprawne())
		{
			$uzytkownicy = $this->dane()->Uzytkownik();
			$wizytowki = $this->dane()->Wizytowka();

			$dane = $form->pobierzZmienioneWartosci();
			$uzytkownik = $cms->sesja->nieaktywnyUzytkownik;
			$wizytowka = $wizytowki->pobierzPoIdUzytkownika($uzytkownik->id);

			if (isset($dane['email']))
			{
				$uzytkownik->email=$dane['email'];

				Cms::inst()->Baza()->transakcjaStart();
				if ($uzytkownik->zapisz($uzytkownicy))
				{
					Cms::inst()->Baza()->transakcjaPotwierdz();

					if ($this->wyslijEmailAktywacyjny($uzytkownik, $wizytowka))
					{
						$this->komunikat($this->j->t['emailAktywacyjny.info_wyslano_email_aktywacyjny'], 'info');
						$wyslanoEmailAktywacyjny = true;
						unset($cms->sesja->nieaktywnyUzytkownik);
					}
					else
					{
						$this->komunikat($this->j->t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego'],'error');
					}
				}
				else
				{
					Cms::inst()->Baza()->transakcjaCofnij();
					$this->komunikat($this->j->t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego'],'error');
				}
			}
			else
			{
				if ($this->wyslijEmailAktywacyjny($uzytkownik, $wizytowka))
				{
					$this->komunikat($this->j->t['emailAktywacyjny.info_wyslano_email_aktywacyjny'], 'info');
					$wyslanoEmailAktywacyjny = true;
					unset($cms->sesja->nieaktywnyUzytkownik);
				}
				else
				{
					$this->komunikat($this->j->t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego'],'error');
				}
			}
		}
		if ( ! $wyslanoEmailAktywacyjny)
		{
			$this->tresc .= $this->szablon->parsujBlok('emailAktywacyjny', array(
				'formularz' => $form->html($this->szablonFormularzZwykly, true),
			));
		}
	}



	protected function formularzZmienHaslo()
	{
		$cms = Cms::inst();

		if($cms->config['blokady']['blokowanie_logowania'])
		{
			$this->komunikat($this->j->t['zmienHaslo.blokowanie_zmiany_hasla'], 'warning');
			return;
		}

		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['zmienHaslo.tytul_strony'],
			'tytul_modulu' => $this->j->t['zmienHaslo.tytul_modulu'],
		));

		$uzytkownik = $cms->profil();

		$mapper = $this->dane()->Uzytkownik();

		$token = Zadanie::pobierz('url_parametr_1','trim');
		if ($token != '')
		{
			$uzytkownik = $mapper->pobierzDlaTokenu($token);
		}

		if ( ! $uzytkownik instanceof Uzytkownik\Obiekt)
		{
			if ($token != '')
			{
				$this->komunikat($this->j->t['zmienHaslo.blad_nieprawidlowy_token'], 'error', 'sesja');
			}
			Router::przekierujDo(Router::urlHttp($this->kategoria));
			return;
		}

		$form = new Formularz('#haslo', 'zmiana_hasla');

		$form->input(new Input\Password('noweHaslo'))
			->dodajAtrybuty(array(
				'class' => 'long'
			));

		$form->input(new Input\Password('noweHasloPowtorz'))
			->dodajAtrybuty(array(
				'class' => 'long'
			));

		if ($token == '')
		{
			$form->input(new Input\Password('haslo'))
			->dodajAtrybuty(array(
				'class' => 'long'
			));
			$form->haslo->dodajFiltr('md5');
			$form->haslo->dodajWalidator(new Walidator\Rowne($uzytkownik->haslo, true));

			$form->input(new Input\Password('hasloPowtorz'))
			->dodajAtrybuty(array(
				'class' => 'long'
			));
			$form->hasloPowtorz->dodajFiltr('md5');
			$form->hasloPowtorz->dodajWalidator(new Walidator\Rowne($uzytkownik->haslo, true));
		}

		$form->stopka(new Input\SubmitOpakowany('potwierdz', array(
			'klasa' => 'buttonSet buttonRed2'
		)));

		if ($form->wypelniony())
		{
			$wReg = new Walidator\WyrazenieRegularne($this->k->k['formularz.walidacja_hasla']);
			$wLog = new Walidator\RozneOd($uzytkownik->login);
			$form->noweHaslo->dodajWalidator($wLog);
			$form->noweHaslo->dodajWalidator($wReg);
			$form->noweHasloPowtorz->dodajWalidator(new Walidator\Rowne($form->noweHaslo->pobierzWartosc()));
			$form->noweHasloPowtorz->dodajWalidator($wLog);
			$form->noweHasloPowtorz->dodajWalidator($wReg);
		}

		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('zmienHaslo'));

		foreach ($form as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->k->k['zmienHaslo.wymagane_pola']))
			{
				$form->$nazwaInputa->wymagany = true;
				$form->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
		}

		if ($form->wypelniony())
		{

			if ($form->danePoprawne())
			{
				$dane = $form->pobierzWartosci();
				$uzytkownik->haslo = $dane['noweHaslo'];
				if ($token != '')
				{
					$uzytkownik->token = null;
				}
				if ($uzytkownik->zapisz($this->dane()->Uzytkownik()))
				{
					$this->komunikat($this->j->t['zmienHaslo.info_zmieniono_haslo'], 'success', 'system');
					Router::przekierujDo(Router::urlHttp($this->kategoria, array('zmien_dane')));
					return;
				}
				else
				{
					$this->komunikat($this->j->t['zmienHaslo.blad_nie_mozna_zmienic_hasla'], 'error');
				}
			}
			else
			{
				$this->komunikat($this->j->t['zmienEmail.blad_formularz_nie_wypelniony'], 'warning');
			}
		}
		return $form->html($this->szablonFormularz, true);
	}



	protected function formularzZmienEmail()
	{
		$uzytkownik = Cms::inst()->profil();
		$form = new Formularz('#email', 'zmiana_email');

		$form->input(new Input\Text('email'))
			->dodajFiltr('trim')
			->dodajWalidator(new Walidator\Email(true))
			->dodajAtrybuty(array(
				'class' => 'long'
			));

		$form->input(new Input\Text('emailPowtorz'))
			->dodajFiltr('trim')
			->dodajWalidator(new Walidator\Email(true))
			->dodajAtrybuty(array(
				'class' => 'long'
			));;

		$form->input(new Input\Password('haslo'))
			->dodajFiltr('md5')
			->dodajWalidator(new Walidator\Rowne($uzytkownik->haslo, true))
			->dodajAtrybuty(array(
				'class' => 'long'
			));

		$form->input(new Input\Password('hasloPowtorz'))
			->dodajFiltr('md5')
			->dodajWalidator(new Walidator\Rowne($uzytkownik->haslo, true))
			->dodajAtrybuty(array(
				'class' => 'long'
			));

		$form->stopka(new Input\SubmitOpakowany('potwierdz', array(
			'klasa' => 'buttonSet buttonRed2'
		)));

		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('zmienEmail'));

		foreach ($form as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->k->k['zmienEmail.wymagane_pola']))
			{
				$form->$nazwaInputa->wymagany = true;
				$form->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}

			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc) || $nazwaInputa == 'emailPowtorz' || $nazwaInputa == 'hasloPowtorz') continue;
			$form->$nazwaInputa->ustawWartosc($uzytkownik->$nazwaInputa);
		}

		if ($form->wypelniony())
		{
			$form->emailPowtorz->dodajWalidator(new Walidator\Rowne($form->email->pobierzWartosc()));

			if ($form->danePoprawne())
			{
				$dane = $form->pobierzWartosci();
				$uzytkownik->email = $dane['email'];
				if($uzytkownik->zapisz($this->dane()->Uzytkownik()))
				{
					$this->komunikat($this->j->t['zmienEmail.info_zmieniono_adres_email'], 'success', 'system');
					Router::przekierujDo(Router::urlHttp($this->kategoria, array('zmien_dane')));
				}
				else
				{
					$this->komunikat($this->j->t['zmienEmail.blad_nie_mozna_zmienic_adresu_email'], 'error');
				}
			}
			else
			{
				$this->komunikat($this->j->t['zmienEmail.blad_formularz_nie_wypelniony'], 'warning');
			}
		}
		return $form->html($this->szablonFormularz, true);
	}



	public function wykonajEdytuj()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['edytuj.tytul_strony'],
			'tytul_modulu' => $this->j->t['edytuj.tytul_modulu'],
		));

		Cms::inst()->temp('uzytkownikKonto_aktywnaZakladka', 'ustawienia');

		$this->tresc .= $this->szablon->parsujBlok('edytuj', array(
			'formularz_dane' => $this->formularzEdytujDane(),
			'formularz_haslo' => $this->formularzZmienHaslo(),
			'formularz_email' => $this->formularzZmienEmail(),
		));
	}



	public function wykonajZmienHaslo()
	{
		$cms = Cms::inst();

		$uzytkownik = $cms->profil();

		$mapper = new Uzytkownik\Mapper();

		$token = Zadanie::pobierz('url_parametr_1','trim');
		if ($token != '')
		{
			$uzytkownik = $mapper->pobierzDlaTokenu($token);
		}

		if($cms->config['blokady']['blokowanie_logowania'])
		{
			$this->komunikat($this->j->t['zmienHaslo.blokowanie_zmiany_hasla'], 'warning');
			return;
		}

		if ($token != '')
		{
			$this->ustawGlobalne(array(
				'tytul_strony' => $this->j->t['zmienHaslo.tytul_strony_token'],
				'tytul_modulu' => $this->j->t['zmienHaslo.tytul_modulu_token'],
			));

		}
		else
		{
			$this->ustawGlobalne(array(
				'tytul_strony' => $this->j->t['zmienHaslo.tytul_strony'],
				'tytul_modulu' => $this->j->t['zmienHaslo.tytul_modulu'],
			));
		}


		if (!($uzytkownik instanceof Uzytkownik\Obiekt))
		{
			if ($token != '')
			{
				$this->komunikat($this->j->t['zmienHaslo.blad_nieprawidlowy_token'], 'error', 'sesja');
			}
			Router::przekierujDo(Router::urlHttp($this->kategoria));
			return;
		}

		$form = new Formularz('', 'logForm');

		if ($token == '')
		{
			$form->input(new Input\Password('haslo'));
			$form->haslo->dodajFiltr('md5');
			$form->haslo->dodajWalidator(new Walidator\Rowne($uzytkownik->haslo, true));
		}

		$form->otworzZbiorowyInput('field', '', '', true);

			$form->input(new Input\Password('noweHaslo'));

			$form->input(new Input\Password('noweHasloPowtorz'));

		$form->zamknijZbiorowyInput('field');

		$form->stopka(new Input\SubmitOpakowany('potwierdz', array(
			'klasa' => 'buttonSet buttonRed',
		)));

		$form->stopka(new Input\SubmitOpakowany('wstecz', array(
			'atrybuty' => array('onclick' => 'history.back(); return false' ),
			'klasa' => 'buttonSet buttonLight',
		)));

		if ($form->wypelniony())
		{
			$wReg = new Walidator\WyrazenieRegularne($this->k->k['formularz.walidacja_hasla']);
			$wLog = new Walidator\RozneOd($uzytkownik->login);
			$form->noweHaslo->dodajWalidator($wLog);
			$form->noweHaslo->dodajWalidator($wReg);
			$form->noweHasloPowtorz->dodajWalidator(new Walidator\Rowne($form->noweHaslo->pobierzWartosc()));
			$form->noweHasloPowtorz->dodajWalidator($wLog);
			$form->noweHasloPowtorz->dodajWalidator($wReg);
		}

		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('zmienHaslo'));

		foreach ($form as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->k->k['zmienHaslo.wymagane_pola']))
			{
				$form->$nazwaInputa->wymagany = true;
				$form->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
		}

		if ($form->wypelniony() && $form->danePoprawne())
		{
			$dane = $form->pobierzWartosci();
			$uzytkownik->haslo = $dane['noweHaslo'];
			if ($token != '')
			{
				$uzytkownik->token = null;
			}
			if ($uzytkownik->zapisz(new Uzytkownik\Mapper))
			{
				$this->komunikat($this->j->t['zmienHaslo.info_zmieniono_haslo'], 'info', 'system');

				if ($token != '')
				{
					Router::przekierujDo(Router::urlHttp($this->kategoria));
				}
				else
				{
					Router::przekierujDo(Router::urlHttp($this->kategoria, array('zmien_dane')));
				}

				return;
			}
			else
			{
				$this->komunikat($this->j->t['zmienHaslo.blad_nie_mozna_zmienic_hasla'], 'error');
			}
		}
		$this->tresc .= $this->szablon->parsujBlok('zmienHaslo', array('formularz' => $form->html($this->szablonFormularzZwykly, true)));
	}



	protected function formularzEdytujDane()
	{
		$uzytkownik = Cms::inst()->profil();
		$form = new Formularz('#edytujDane', 'zmiana_danych');

		$form->input(new Input\Html('info'));

		$form->input(new Input\Text('imie'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$form->input(new Input\Text('nazwisko'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$form->input(new Input\Radio('plec', array(
			'lista' => $this->j->t['plec'],
			'inline' => true,
		)));

		$form->input(new Input\Text('kontaktTelefon'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
			->dodajWalidator(new Walidator\Telefon);


		$form->input(new Input\Text('kontaktKomorka'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
			->dodajWalidator(new Walidator\Telefon);

		$form->input(new Input\Text('kontaktFax'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
			->dodajWalidator(new Walidator\Telefon);

		$wizytowka = $this->dane()->Wizytowka();
		$wizytowka = $wizytowka->pobierzPoIdUzytkownika(Cms::inst()->profil()->id);

		$form->input(new Input\Text('firmaNazwa'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$form->input(new Input\Text('firmaNip'))
			->dodajFiltr('trim','tylkoCyfry')
			->dodajWalidator(new Walidator\Nip);

		$form->input(new Input\Text('firmaAdres'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$form->input(new Input\KodPocztowy('firmaKodPocztowy'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
			->dodajWalidator(new Walidator\KodPocztowy);

		$form->input(new Input\Text('firmaMiasto'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$form->stopka(new Input\SubmitOpakowany('zapisz', array(

		)));
		$form->stopka(new Input\ButtonOpakowany('wstecz', array(
			'atrybuty' => array('onclick' => 'history.back(); return false' ),
			'klasa' => 'buttonSet buttonLight',
		)));

		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'));

		foreach($form as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->k->k['formularz.wymagane_pola']))
			{
				$form->$nazwaInputa->wymagany = true;
				$form->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}

			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc)) continue;
			$form->$nazwaInputa->ustawWartosc($uzytkownik->$nazwaInputa);
		}

		if ($form->wypelniony())
		{
			if ($form->danePoprawne())
			{
				$dane = array();
				foreach ($form->pobierzZmienioneWartosci() as $klucz => $wartosc)
				{
					if ($klucz == 'info') continue;
					$uzytkownik->$klucz = $wartosc;
				}

				if ($uzytkownik->zapisz($this->dane()->Uzytkownik()))
				{
					$this->komunikat($this->j->t['edytuj.info_zapisano_dane'], 'success', 'system');
					Router::przekierujDo(Router::urlHttp($this->kategoria, array('zmien_dane')));
				}
				else
				{
					$this->komunikat($this->j->t['edytuj.blad_nie_mozna_zapisac_danych'], 'error');
				}
			}
			else
			{
				$this->komunikat($this->j->t['edytuj.blad_formularz_nie_wypelniony'], 'warning');
			}
		}

		return $form->html($this->szablonFormularz, true);
	}



	protected function formularzUsunKonto()
	{
		if (Zadanie::pobierzPost('wstecz', 'trim'))
		{
			Router::przekierujDo(Router::urlHttp($this->kategoria, array('')));
		}
		if (Zadanie::pobierzPost('usun', 'trim'))
		{
			Router::przekierujDo(Router::urlHttp($this->kategoria, array('usun')));
		}
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['usunKonto.tytul_strony'],
			'tytul_modulu' => $this->j->t['usunKonto.tytul_modulu'],
		));

		$form = new Formularz('', 'usuwanie konta');

		$form->input(new Input\Html('info'));

		$form->stopka(new Input\SubmitOpakowany('wstecz', array(
			'klasa' => 'buttonSet buttonLight',
		)));

		$form->stopka(new Input\SubmitOpakowany('usun', array(
			'klasa' => 'buttonSet buttonRed r_right',
		)));

		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('usunKonto'));

		return $form->html($this->szablonFormularz, true);
	}



	public function wykonajUsun()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Wizytowka();
		$wizytowka = $mapper->pobierzPoIdUzytkownika($cms->profil()->id);

		if ($wizytowka instanceof Wizytowka\Obiekt && $wizytowka->id > 0)
		{
			$wiadomosc = new Wiadomosc\Obiekt();
			$wiadomosc->idProjektu = ID_PROJEKTU;
			$wiadomosc->kodJezyka = KOD_JEZYKA;
			$wiadomosc->status = 'wyslana';
			$wiadomosc->czasWyslania = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			$wiadomosc->typ = 'administracyjna';
			$wiadomosc->idNadawcy = $cms->profil()->id;
			$wiadomosc->idWizytowkiNadawcy = $wizytowka->id;

			$tytul = $this->j->t['usun.wiadomosc_usuniecie_wizytowki_tytul'];
			$wiadomosc->tytul = str_replace('{wizytowkaNazwa}', $wizytowka->pelnaNazwa, $tytul);

			$tresc = $this->j->t['usun.wiadomosc_usuniecie_wizytowki_tresc'];
			$zmienne = array(
				'{uzytkownikNazwa}' => $cms->profil()->pelnaNazwa,
				'{uzytkownikId}' => $cms->profil()->id,
				'{wizytowkaNazwa}' => '<a href="'.$wizytowka->url.'" rel="podglad_strony">'.$wizytowka->pelnaNazwa.'</a>',
				'{wizytowkaId}'  => $wizytowka->id,
				'{wizytowkaTyp}'  => $wizytowka->typ,
			);
			foreach ($zmienne as $klucz => $wartosc)
			{
				$tresc = str_replace($klucz, $wartosc, $tresc);
			}
			$wiadomosc->tresc = $tresc;

			if ($wiadomosc->zapisz($this->dane()->Wiadomosc()))
			{
				$this->komunikat($this->j->t['usun.info_usunieto_wizytowke'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usun.error_nie_mozna_usunac_wizytowki'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usun.error_nie_mozna_pobrac_wizytowki'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlHttp($this->kategoria, array('zmien_dane')));
	}



	protected function wyswietlMenu()
	{
		$cms = Cms::inst();

		$akcja = Zadanie::pobierz('url_parametr_0', 'strval');

		$this->wstawDoSzablonuBlokTlumaczen('menu');

		$this->ustawGlobalne(array(
			'tytul_strony' => sprintf($this->j->t['menu.tytul_strony'], $cms->profil()->pelnaNazwa),
			'tytul_modulu' => sprintf($this->j->t['menu.tytul_modulu'], $cms->profil()->pelnaNazwa),
		));

		$dane['link_zmien_dane'] = Router::urlHttp($this->kategoria, array('zmien_dane'));
		$dane['active_zmien_dane'] = ($akcja == 'zmien_dane') ? 'active' : '';
		$dane['link_zmien_haslo'] = Router::urlHttp($this->kategoria, array('zmien_haslo'));
		$dane['active_zmien_haslo'] = ($akcja == 'zmien_haslo') ? 'active' : '';
		$dane['link_zmien_email'] = Router::urlHttp($this->kategoria, array('zmien_email'));
		$dane['active_zmien_email'] = ($akcja == 'zmien_email') ? 'active' : '';
		$dane['link_usun_konto'] = Router::urlHttp($this->kategoria, array('usun_konto'));
		$dane['active_usun_konto'] = ($akcja == 'usun_konto') ? 'active' : '';
		$dane['link_wyloguj'] = Router::urlHttp($this->kategoria, array('wyloguj'));

		$this->tresc .= $this->szablon->parsujBlok('menu', $dane);
	}



	protected function wyslijPrzypomnienie(Uzytkownik\Obiekt $uzytkownik)
	{
		$token = losowyKlucz(32);
		$uzytkownik->token = $token;
		if ($uzytkownik->zapisz($this->dane()->Uzytkownik()))
		{
			$dane = array(
				'obiekt_Uzytkownik' => $uzytkownik,
				'linkPrzypomnienie' => Router::urlHttp($this->kategoria, array('zmien_haslo', $token)),
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



	/**
	 *  Przeciazona metoda z klasy Modul. Zwraca true jezeli chcemy sie wylogowac
	 *
	 * @param string $metoda Nazwa wywolywanej akcji (tekst albo null).
	 *
	 * @return bool
	 */
	protected function moznaWykonacAkcje($metoda, $wlasnyKod = false, $obiektKontekstu = null)
	{
		if (in_array($metoda, array('wykonajIndex', 'wykonajWyloguj', 'wykonajZaloguj', 'wykonajPrzypomnij', 'wykonajEmailAktywacyjny', 'wykonajZmienHaslo'))) return true;
		return parent::moznaWykonacAkcje($metoda, $wlasnyKod, $obiektKontekstu);
	}



	protected function wyslijEmailAktywacyjny(Uzytkownik\Obiekt $uzytkownik, Wizytowka\Obiekt $wizytowka)
	{
		$kategoriaRejestracja = $this->dane()->Kategoria()->pobierzDlaModulu('RejestracjaNowa');
		if (isset($kategoriaRejestracja[0]) && $kategoriaRejestracja[0] instanceof Kategoria\Obiekt)
		{
			$dane = array(
				'obiekt_Wizytowka' => $wizytowka,
				'obiekt_Uzytkownik' => $uzytkownik,
				'linkAktywacyjny' => Router::urlHttp($kategoriaRejestracja[0]->id, array('aktywuj', $uzytkownik->token)),
			);

			$poczta = new Pomocnik\Poczta($this->k->k['emailAktywacyjny.id_formatki_email'], $dane);
			$status = $poczta->wyslij();

			$this->zdarzenie('wyslanie_maila', array(
				'status' => ($status) ? true : false,
				'opis' => ($status) ? $this->j->t['emailAktywacyjny.info_wyslano_email_aktywacyjny'] : $this->j->t['emailAktywacyjny.blad_nie_mozna_wyslac_emaila_aktywacyjnego'],
			));

			return $status;
		}
		trigger_error('Brak Kategorii Rejestracji', E_USER_ERROR);
		return false;
	}
}
