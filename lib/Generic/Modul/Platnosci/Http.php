<?php
namespace Generic\Modul\Platnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Sterownik;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka\Platnosc as Platnosci;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Model\Wizytowka;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Platnosc;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Katalog;


/**
 * Moduł obsługujący płatności online.
 *
 * @author Półtorak Dariusz, Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	protected $systemPlatnosci = null;


	/**
	 * @var \Generic\Konfiguracja\Modul\Platnosci\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Platnosci\Http
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajNowa',
		'wykonajSukces',
		'wykonajBlad',
		'wykonajStatus',
		'wykonajAnuluj',
	);


	protected $zdarzenia = array(
		'wykonano_platnosc',
		'przerwano_platnosc',
		'anulowano_platnosc',
		'zmieniono_status_platnosci',
	);



	public function inicjuj(Sterownik $sterownik, Kategoria\Obiekt $kategoria = null, Blok\Obiekt $blok = null)
	{
		parent::inicjuj($sterownik, $kategoria, $blok);

		$this->systemPlatnosci = new Platnosci\PlatnosciPl();
		$this->systemPlatnosci->ustawKonfiguracje(Cms::inst()->config['platnosci']);
	}



	public function wykonajIndex()
	{
		$cms = Cms::inst();

		if ($cms->profil() instanceof Uzytkownik\Obiekt)
		{
			$wizytowka = $this->dane()->Wizytowka()
				->pobierzPoIdUzytkownika($cms->profil()->id);

			if ($wizytowka instanceof Wizytowka\Obiekt)
				$cms->temp('przegladana_wizytowka', $wizytowka);
		}
		$cms->temp('uzytkownikKonto_aktywnaZakladka', 'otrzymane_dokumenty');

		$akcja = Zadanie::pobierz('url_parametr_0', 'strval', 'strtolower');

		switch ($akcja)
		{
			case 'nowa':
				$this->wykonajAkcje('nowa');
			break;

			case 'sukces':
				$this->wykonajAkcje('sukces');
			break;

			case 'blad':
				$this->wykonajAkcje('blad');
			break;

			case 'status':
				$this->wykonajAkcje('status');
			break;

			case 'anuluj':
				$this->wykonajAkcje('anuluj');
			break;
		}
	}



	public function wykonajNowa()
	{
		if ( ! Cms::inst()->sesja->nowaPlatnosc instanceof Platnosc\Obiekt)
		{
			$this->komunikat($this->j->t['index.blad_brak_danych_dla_platnosci'], 'error', 'modul');
			return;
		}
		$platnosc = Cms::inst()->sesja->nowaPlatnosc;

		$typyPlatnosci = array();
		$wyborTypu = false;
		if ($this->k->k['nowa.wybor_typu_platnosci'] || Zadanie::pobierz('wyborTypuPlatnosci', 'trim') != null)
		{
			$wyborTypu = true;
			$typyPlatnosci = $this->pobierzTypyPlatnosci();
		}


		// formularz do ustalania sposobu zapłaty
		if ($wyborTypu && $platnosc->typPlatnosci == '' && is_array($typyPlatnosci) && count($typyPlatnosci) > 0)
		{
			$formularz = new Formularz('', $this->wykonywanaAkcja);

			$formularz->input(new Input\Html('informacja'));

			$lista = array();
			foreach ($typyPlatnosci as $typ)
			{
				if (strtolower($typ['enable']) != 'true') continue;
				$lista[$typ['type']] = $typ['name'].' <img src="'.$typ['img'].'" alt="'.$typ['name'].'" style="vertical-align: middle;"/>';
			}
			asort($lista);
			$formularz->input(new Input\Radio('typPlatnosciPl', array(
				'lista' => $lista,
				'inline' => true
			), null, null, 'f_platnosci.tpl'));

			$formularz->stopka(new Input\SubmitOpakowany('dalej'));
			$formularz->stopka(new Input\ButtonOpakowany('wstecz', array(
				'klasa' => 'buttonSet buttonLight',
				'atrybuty' => array('onclick' => 'window.location = \''.Router::urlHttp($this->kategoria, array('anuluj', $platnosc->id)).'\'' )
			)));

			$formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzZaplata'));

			if ($formularz->wypelniony())
			{
				$wybrane = $formularz->pobierzWartosci();
				if (isset($wybrane['typPlatnosciPl']) && array_key_exists($wybrane['typPlatnosciPl'], $lista))
				{
					$platnosc->typPlatnosci = $wybrane['typPlatnosciPl'];
				}
				else
				{
					$this->komunikat($this->j->t['index.blad_nie_wybrano_typu_platnosci'], 'warning');
					$this->tresc .= $formularz->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz']), true);
					return;
				}
			}
			else
			{
				$this->tresc .= $formularz->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz']), true);
				return;
			}
		}

		$dane = $this->systemPlatnosci->przygotuj($platnosc);

		// formularz do wysyłania płatności
		if (is_array($dane))
		{
			$platnosc->daneWyslane = $dane;
			$platnosc->zapisz($this->dane()->Platnosc());

			$formularz = new Formularz($this->systemPlatnosci->url('nowa'), 'payform');

			$formularz->input(new Input\Html('opis', array(
				'wartosc' => $platnosc->opis,
			)));

			$formularz->input(new Input\Html('kwota', array(
				'wartosc' => number_format($platnosc->kwota, 2,',','').' '.$platnosc->waluta,
			)));

			$typyPlatnosci = listaZTablicy($typyPlatnosci, 'type');

			if ($platnosc->typPlatnosci != '' && isset($typyPlatnosci[$platnosc->typPlatnosci]))
			{
				$typ = $typyPlatnosci[$platnosc->typPlatnosci];
				$typ = $typ['name'].' <img src="'.$typ['img'].'" alt="'.$typ['name'].'" style="vertical-align: middle;"/>';
				$formularz->input(new Input\Html('typPlatnosci', array(
					'wartosc' => $typ,
				)));
			}

			foreach ($dane as $nazwa => $wartosc)
			{
				$formularz->input(new Input\Hidden($nazwa, $wartosc));
			}

			$formularz->stopka(new Input\SubmitOpakowany('wyslij', array(
			)));
			$formularz->stopka(new Input\ButtonOpakowany('wstecz', array(
				'klasa' => 'buttonSet buttonLight',
				'atrybuty' => array('onclick' => 'window.location = \''.Router::urlHttp($this->kategoria, array('anuluj', $platnosc->id)).'\'' )
			)));

			$formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzPlatnosci'));

			$this->tresc .= $this->szablon->parsujBlok('platnoscPotwierdzenie', array(
				'form' => $formularz->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz']), true),
			));
		}
		else
		{
			$platnosc->aktualizujPowiazanyObiekt(Platnosc\Obiekt::DO_USUNIECIA);
			$platnosc->usun($this->dane()->Platnosc());
			$this->komunikat($this->j->t['index.blad_nieprawidlowe_dane_platnosci'], 'error', 'modul');
		}
	}



	public function wykonajSukces()
	{
		$cms = Cms::inst();

		$dane = Platnosc\Obiekt::odbierzSukces();

		if ( ! is_array($dane)) return;

		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId($dane['session_id']);

		if (isset($cms->sesja->nowaPlatnosc)) unset($cms->sesja->nowaPlatnosc);

		if ($platnosc instanceof Platnosc\Obiekt)
		{
			$this->zdarzenie('wykonano_platnosc', array(
				'uzytkownik' => ($cms->profil() instanceof Uzytkownik\Obiekt) ? $cms->profil()->nazwaOrazLogin : 'Serwis Platnosci.pl',
				'opis' => $platnosc->opis,
				'kwota' => $platnosc->kwota.' '.$platnosc->waluta,
			));

			$baza = Cms::inst()->Baza();
			$baza->transakcjaStart();

			if ($platnosc->aktualizujStatus() && $platnosc->aktualizujPowiazanyObiekt())
			{
				$baza->transakcjaPotwierdz();

				$zasieg = ($platnosc->urlObiektu != '') ? 'system' : 'modul';
				$this->komunikat($this->j->t['sukces.serwis_odpowiedzial'], 'info', $zasieg);
				if ($platnosc->urlObiektu != '') Router::przekierujDo($platnosc->urlObiektu);
			}
			else
			{
				$baza->transakcjaCofnij();

				trigger_error('Problem z zapisem platnosci '.$platnosc->id, E_USER_WARNING);
			}
		}
		else
		{
			trigger_error('Nie znaleziono platnosci o identyfikatorze '.$dane['session_id'], E_USER_WARNING);
		}
	}



	public function wykonajBlad()
	{
		$cms = Cms::inst();

		$dane = Platnosc\Obiekt::odbierzBlad();

		if ( ! is_array($dane)) return;

		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId($dane['session_id']);

		if (isset($cms->sesja->nowaPlatnosc)) unset($cms->sesja->nowaPlatnosc);

		if ($platnosc instanceof Platnosc\Obiekt)
		{
			if ($dane['error_nr'] != '')
			{
				trigger_error('Problem z platnoscia '.$platnosc->id.': '.$dane['error_nr'], E_USER_WARNING);
			}

			$this->zdarzenie('przerwano_platnosc', array(
				'uzytkownik' => ($cms->profil() instanceof Uzytkownik\Obiekt) ? $cms->profil()->nazwaOrazLogin : 'Serwis Platnosci.pl',
				'opis' => $platnosc->opis,
				'kwota' => $platnosc->kwota.' '.$platnosc->waluta,
				'blad' => $dane['error_nr'],
			));

			$baza = Cms::inst()->Baza();
			$baza->transakcjaStart();

			if ($platnosc->aktualizujStatus() && $platnosc->aktualizujPowiazanyObiekt())
			{
				$baza->transakcjaPotwierdz();

				$zasieg = ($platnosc->urlObiektu != '') ? 'system' : 'modul';
				$this->komunikat(sprintf($this->j->t['blad.serwis_odpowiedzial'], $dane['error_nr']), 'warning', $zasieg);
				if ($platnosc->urlObiektu != '') Router::przekierujDo($platnosc->urlObiektu);
			}
			else
			{
				$baza->transakcjaCofnij();

				trigger_error('Problem z zapisem platnosci '.$platnosc->id, E_USER_WARNING);
			}
		}
		else
		{
			trigger_error('Nie znaleziono platnosci o identyfikatorze '.$dane['session_id'], E_USER_WARNING);
		}
	}



	public function wykonajStatus()
	{
		//trigger_error('Odbior statusu platnosci '.print_r($_POST, true), E_USER_NOTICE);
		if ($powiadomienie = $this->systemPlatnosci->odbierzPowiadomienie())
		{
			$mapper = $this->dane()->Platnosc();
			$platnosc = $mapper->pobierzPoId($powiadomienie['id']);

			if ($platnosc instanceof Platnosc\Obiekt)
			{
				$baza = Cms::inst()->Baza();
				$baza->transakcjaStart();

				if ($platnosc->aktualizujStatus() && $platnosc->aktualizujPowiazanyObiekt())
				{
					$baza->transakcjaPotwierdz();

					$this->zdarzenie('zmieniono_status_platnosci', array(
						'uzytkownik' => 'Serwis Platnosci.pl',
						'opis' => $platnosc->opis,
						'kwota' => $platnosc->kwota.' '.$platnosc->waluta,
						'status' => $platnosc->status,
					));
				}
				else
				{
					$baza->transakcjaCofnij();

					trigger_error('Problem z zapisem platnosci '.$platnosc->id, E_USER_WARNING);
				}
			}
			else
			{
				trigger_error('Nie mozna pobrac platnosci: '.$powiadomienie['id'], E_USER_WARNING);
			}
		}
		// system platnosci oczekuje potwierdzenia w postaci ciagu znakow 'OK'
		ob_end_clean();
		exit('OK');
	}



	public function wykonajAnuluj()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId(Zadanie::pobierz('url_parametr_1', 'intval', 'abs'));

		if ( ! $platnosc instanceof Platnosc\Obiekt)
		{
			$this->komunikat($this->j->t['anuluj.blad_nie_mozna_pobrac_platnosci'], 'error');
			return;
		}
		if ( ! $cms->profil() instanceof Uzytkownik\Obiekt
			|| $platnosc->idUzytkownika != $cms->profil()->id)
		{
			$this->komunikat($this->j->t['anuluj.blad_brak_uprawnien_do_platnosci'], 'error');
			return;
		}

		$urlPlatnosci = $platnosc->urlObiektu;

		$platnosc->aktualizujStatus();

		if ($platnosc->status != 'nierozpoczeta' && $platnosc->status != 'nowa')
		{
			$zasieg = ($urlPlatnosci != '') ? 'system' : 'modul';
			$this->komunikat($this->j->t['anuluj.blad_platnosc_w_realizacji'], 'warning', $zasieg);
			if ($urlPlatnosci != '') Router::przekierujDo($urlPlatnosci);
		}

		$opis = $platnosc->opis;
		$kwota = $platnosc->kwota.' '.$platnosc->waluta;

		$cms->Baza()->transakcjaStart();
		if ($platnosc->aktualizujPowiazanyObiekt(Platnosc\Obiekt::DO_USUNIECIA) && $platnosc->usun($mapper))
		{
			$cms->Baza()->transakcjaPotwierdz();
			$this->zdarzenie('anulowano_platnosc', array(
				'uzytkownik' => $cms->profil()->nazwaOrazLogin,
				'opis' => $opis,
				'kwota' => $kwota,
			));

			$zasieg = ($urlPlatnosci != '') ? 'system' : 'modul';
			$this->komunikat($this->j->t['anuluj.info_usunieto_platnosc'], 'info', $zasieg);
			if ($urlPlatnosci != '') Router::przekierujDo($urlPlatnosci);
		}
		else
		{
			$cms->Baza()->transakcjaCofnij();

			$zasieg = ($urlPlatnosci != '') ? 'system' : 'modul';
			$this->komunikat($this->j->t['anuluj.blad_nie_mozna_usunac_platnosci'], 'error', $zasieg);
			if ($urlPlatnosci != '') Router::przekierujDo($urlPlatnosci);
		}
	}



	protected function pobierzTypyPlatnosci()
	{
		$katalogCache = new Katalog(Cms::inst()->katalog('platnosci'), true);
		$plikCache = $katalogCache.'/lista.php';

		$dane = (is_file($plikCache)) ? include($plikCache) : null;

		if ( ! is_array($dane) || count($dane) < 1)
		{
			$dane = $this->systemPlatnosci->pobierzTypyPlatnosci();

			if (is_array($dane) && count($dane) > 0 && $katalogCache->istnieje() && $katalogCache->doZapisu())
			{
				file_put_contents($plikCache, "<?php
namespace Generic\Modul\Platnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Sterownik;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka\Platnosc as Platnosci;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Model\Wizytowka;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Platnosc;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Katalog;
\nreturn ".var_export($dane, true)."\n;\n");
			}
			else
				$dane = array();
		}
		return $dane;
	}

}
