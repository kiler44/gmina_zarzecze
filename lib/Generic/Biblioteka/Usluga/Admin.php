<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Router;
use Generic\Model\RegulaRoutingu;
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\SterownikWyjatek;
use Generic\Model\UkladStrony;
use Generic\Model\Projekt;


/**
 * Usluga odpowiadajaca za widok panelu admina.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Admin extends Usluga
{

	public function start()
	{
		$cms = Cms::inst();
		$this->ustawSzablony();
		$cms->ladujBazeDanych();
		$cms->rozpocznijSesje();
		$this->ustawProjekt();

		$niezalogowaniDozwoloneAkcje = array(
			'UserAccount' => array('signIn', 'reminder', 'changePassword', 'activate', 'zalogujPracownika'),
		);

		$idKategorii = Zadanie::pobierz('cat','intval','abs');
		$idBloku = Zadanie::pobierz('b','intval','abs');
		$modul = Zadanie::pobierz('m','strval','trim');
		$akcja = Zadanie::pobierz('a','strval','trim');
		$kod_jezyka_edycji = Zadanie::pobierz('cl', 'strval', 'trim');
		
		if ( ! isset($cms->sesja->kod_jezyka_edycji)) $cms->sesja->kod_jezyka_edycji = '';
		
		if ($kod_jezyka_edycji != '' && in_array($kod_jezyka_edycji, $cms->projekt->jezykiKody)
			&& ($cms->sesja->kod_jezyka_edycji == '' || $cms->sesja->kod_jezyka_edycji != $kod_jezyka_edycji))
		{
			define('KOD_JEZYKA', $kod_jezyka_edycji);
			$cms->sesja->kod_jezyka_edycji = $kod_jezyka_edycji;
			
			//$uzytkownik = $cms->profil();
			// po zmianie jezyka musimy odnowic uprawnienia dla wersji jezykowej
			//if ($uzytkownik instanceof Uzytkownik\Obiekt) $uzytkownik->odnowUprawnienia();
			
			//NEW: po zmianie języka edycji powrót skąd użytkownik przyszedł
			Router::przekierujDo(Zadanie::adresWywolujacego());
		}
		elseif ($cms->sesja->kod_jezyka_edycji != '')
		{
			define('KOD_JEZYKA', $cms->sesja->kod_jezyka_edycji);
		}
		else
		{
			define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
		}
		
		if (!isset($uzytkownik))
			$uzytkownik = $cms->profil();
		
		// ustawianie jezyka tresci i jezyka interfejsu
		if ($uzytkownik instanceof Uzytkownik\Obiekt && $uzytkownik->czyAdmin && $uzytkownik->jezyk != '')
		{
			define('KOD_JEZYKA_ITERFEJSU', $uzytkownik->jezyk);
		}
		else
		{
			define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
		}

		/*
		dump('Kod w usługa admin: '.KOD_JEZYKA);
		dump('Kod interfejsu w usługa admin: '.KOD_JEZYKA_ITERFEJSU);
		die();
		*/
		
		// znamy juz ID_PROJEKTU i KOD_JEZYKA wiec mozemy uzupelnic konfiguracje
		$cms->konfiguracjaBaza();
		$cms->tlumaczeniaBaza();
		
		$router = Router\Http::inst();
		
		$router->ustawReguly(RegulaRoutingu\Mapper::wywolaj()->pobierzWszystko());
		
		/*
		 * Struktura strony to tablica w postaci:
		 * array(
		 * 	   'numer_regionu' => array(		<- numer regionu
		 *         0 => array(					<- kolejna akcja do wywolania
		 *             'kategoria' => '1',		<- 'kategoria', 'blok' albo 'modul' musi byc ustawione
		 *             'blok' => '1',			<- 'kategoria', 'blok' albo 'modul' musi byc ustawione
		 *             'modul' => 'nazwaModulu'	<- 'idKategorii' albo 'modul' musi byc ustawione
		 * 	           'akcja' => 'index',		<- 'akcja' moze ale nie musi byc ustawiona (domyslnie ustawi sie 'index')
		 * 	           'kontener' => 'kontener'	<- opcjonalnie kontener w jaki nalezy opakowac modul
		 *         )
		 *         1 => array(
		 *             ...
		 *         )
		 *     )
		 * )
		 */
		$strukturaStrony = array();

		// budowanie struktury strony, ustawianie akcji i modulow do wykonania
		if ($uzytkownik instanceof Uzytkownik\Obiekt && $uzytkownik->status == 'aktywny' && $uzytkownik->czyAdmin)
		{
			if ($idKategorii > 0)
			{
				$mapper = Cms::inst()->dane()->Kategoria();
				$kategoria = $mapper->pobierzPoId($idKategorii);
				$blok = null;
				$modul = null;
				define('ID_KATEGORII', $idKategorii);
			}
			elseif ($idBloku > 0)
			{
				$mapper = Cms::inst()->dane()->Blok();
				$blok = $mapper->pobierzPoId($idBloku);
				$kategoria = null;
				$modul = null;
			}
			elseif ($modul != '')
			{
				$blok = null;
				$kategoria = null;
			}
			else
			{
				$blok = null;
				$kategoria = null;
				$modul = 'UserAccount';
			}

			$glownaTresc = $strukturaStrony['region_0'][] = array(
				'kategoria' => $kategoria,
				'blok' => $blok,
				'modul' => $modul,
				'akcja' => $akcja,
				'kontener' => 'kontener_podstawowy_unicorn',
			);
			$strukturaStrony['region_1'][] = array('modul' => 'UserAccountBlock', 'kategoria' => null, 'blok' => null, 'akcja' => null);
			$strukturaStrony['region_1'][] = array('modul' => 'BlokKomunikator', 'kategoria' => null, 'blok' => null, 'akcja' => null);
			$strukturaStrony['region_2'][] = array('modul' => 'MenuAplikacji', 'kategoria' => null, 'blok' => null, 'akcja' => null);
			$strukturaStrony['region_2'][] = array('modul' => 'MenuAdministracyjne', 'kategoria' => null, 'blok' => null, 'akcja' => null);
			$strukturaStrony['region_3'][] = array('modul' => 'SciezkaAdministracyjna', 'kategoria' => null, 'blok' => null, 'akcja' => null);
			

			$kategoriaBloku = Cms::inst()->dane()->Blok()->pobierzDlaModulu('BlokObecnoscUzytkownika');
			if (isset($kategoriaBloku[0]) && $kategoriaBloku[0] instanceof \Generic\Model\Blok\Obiekt)
			{
				$strukturaStrony['region_3'][] = array('modul' => 'BlokObecnoscUzytkownika', 'kategoria' => null, 'blok' => $kategoriaBloku[0], 'akcja' => null);
			}
			$aktywneRegiony = array(
				'region_0' => '',
				'region_1' => '',
				'region_2' => '',
				'region_3' => '',
			);
		}
		else
		{
			$moznaWykonac = false;
			if (array_key_exists($modul, $niezalogowaniDozwoloneAkcje))
			{
				
				if (in_array($akcja, $niezalogowaniDozwoloneAkcje[$modul]))
				{
					$moznaWykonac = true;
				}
			}
			if (!$moznaWykonac)
			{
				//nie mozna wykonać akcji - zwracamy 404. Żadna dalsza akcja nie jest wykonywana
				if (Cms::inst()->config['blokady']['blokowanie_logowania'] == true)
				{
					cms_blad_404(Cms::inst()->lang['bledy']['blad_zadania'], Cms::inst()->lang['bledy']['nie_znaleziono_stony']);
				}

				$modul = 'UserAccount';
				$akcja = 'signIn';
			}
			
			$glownaTresc = $strukturaStrony['region_0'][] = array(
				'kategoria' => null,
				'blok' => null,
				'modul' => $modul,
				'akcja' => $akcja,
				'kontener' => 'kontener_podstawowy_unicorn',
			);
			$aktywneRegiony = array('region_0' => '');
		}
		

		// przetwarzanie strony
		try
		{
			$sterownik = new Sterownik('Admin');

			$kontenery = new Szablon();
			$kontenery->ladujTresc(Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_KONTENER));
			$dostepneKontenery = $kontenery->struktura();
			$regionyTresc = array();
			$globalne = array();
			$sterownik->nastepnaAkcja($glownaTresc['blok'], $glownaTresc['kategoria'], $glownaTresc['modul'], $glownaTresc['akcja']);
			$sterownik->wykonaj();
			$glownaTresc = trim(implode('', $sterownik->pobierzTresc(true)));
			$globalne = array_merge($globalne,$sterownik->pobierzGlobalne());

			foreach ($strukturaStrony as $nrRegionu => $operacje)
			{
				$nrRegionu = $nrRegionu;
				$regionyTresc[$nrRegionu] = '';
				// wykonujemy ciag akcji w modulach dla okreslonego regionu
				foreach ($operacje as $operacja)
				{
					if ($nrRegionu == 'region_0')
					{
						$tresc = $glownaTresc;
						unset($glownaTresc);
					}
					else
					{
						$sterownik->nastepnaAkcja($operacja['blok'], $operacja['kategoria'], $operacja['modul'], $operacja['akcja']);
						$sterownik->wykonaj();
						$tresc = implode('', $sterownik->pobierzTresc(true));
					}
					//sprawdzanie czy wykonywany modul ma kontener i czy jest on dostepny w szablonie
					if (isset($operacja['kontener']) && in_array('/'.$operacja['kontener'].'/', $dostepneKontenery))
					{
						$tresc = array_merge($sterownik->pobierzGlobalne(), array('tresc' => $tresc));
						$tresc = $kontenery->parsujBlok($operacja['kontener'], $tresc);
					}
					$regionyTresc[$nrRegionu] .= $tresc;
				}
			}
		}
		catch (SterownikWyjatek $wyjatek)
		{
			cms_blad($cms->lang['bledy']['blad_aplikacji'], $cms->lang['bledy']['przerwane_przetwarzanie_strony'], 500);
		}

		// wstawianie tresci do odpowiednich regionow i budowanie strony
		$strona = new UkladStrony\Obiekt();
		$strona->nazwa = 'admin_uklad';
		$strona->katalog = CMS_KATALOG.'/' . SZABLON_SYSTEM . '/';
		$strona->plik = SZABLON_UKLADY;
		$strona->regiony = $aktywneRegiony;
		
		if ($cms->profil() !== null)
		{
			$roleUzytkownika = listaZTablicy($cms->profil()->pobierzRole(true), 'kod');
			$pracownik = (array_key_exists($cms->config['bkt_crm']['kod_podstawowej_roli'], $roleUzytkownika)) ? true : false;
		}
		else
		{
			$pracownik = true;
		}
		
		if (czyMobilnyKlient() && $pracownik)
		{
			$klasa_nadrzedna = 'tablet';
		}
		else
		{
			$klasa_nadrzedna = '';
		}
		if ($cms->profil() instanceof Uzytkownik\Obiekt && $cms->profil()->maRole(array('admin')))
			$klasa_nadrzedna = '';
		
		$katMapper = new \Generic\Model\Kategoria\Mapper();
		$kategoriaGlowna = $katMapper->pobierzGlowna();
		$stronaGlobalne = array(
			'klasa_nadrzedna' => $klasa_nadrzedna,
			'url_strona_glowna' => Router::urlAdmin($kategoriaGlowna),
			'tytul_strony' => '',
			//'opis_strony' => '',
			//'slowa_kluczowe' => '',
			'jezyk_strony' => KOD_JEZYKA,
			//'stopka_skrypt' => '',
		);

		foreach ($stronaGlobalne as $zmienna => $wartosc)
		{
			if (isset($globalne[$zmienna]))
				$strona->dodajZmienna($zmienna, $globalne[$zmienna]);
			else
				$strona->dodajZmienna($zmienna, $wartosc);
		}
		foreach ($regionyTresc as $nrRegionu => $tresc)
		{
			$strona->dodajTrescRegionu($nrRegionu, $tresc);
		}
		$strona->wyswietl();
	}



	/**
	 * Pobiera projekt i ustawia stale dotyczace projektu
	 */
	protected function ustawProjekt()
	{
		$cms = Cms::inst();
		
		
		if ($cms->sesja->projektCache instanceof Projekt\Obiekt
			&& $cms->sesja->projektCache->kod == KOD_PROJEKTU
			&& ((defined('DOMENA') && $cms->sesja->projektCache->domena == DOMENA) || ! defined('DOMENA'))
			)
		{
			$cms->projekt = $cms->sesja->projektCache;
		}
		else
		{
			$cms->projekt = Cms::inst()->dane()->Projekt()->pobierzPoKodzie(KOD_PROJEKTU);
		}

		if ($cms->projekt instanceof Projekt\Obiekt)
		{
			//wywolanie w celu pobrania deklaracji jezykow
			$cms->projekt->jezyki;
			define('ID_PROJEKTU', $cms->projekt->id);
			if ( ! defined('DOMENA')) define('DOMENA', $cms->projekt->domena);
		}
		else
		{
			cms_blad($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_projektu'], 503);
		}
		if ( ! ($cms->sesja->projektCache instanceof Projekt\Obiekt && $cms->sesja->projektCache->kod == KOD_PROJEKTU))
		{
			$cms->sesja->projektCache = $cms->projekt;
		}
		
		
	}
	
	

}