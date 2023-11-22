<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Router;
use Generic\Model\RegulaRoutingu;
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\SterownikWyjatek;
use Generic\Model\Projekt;


/**
 * Usluga odpowiadajaca za komunikacje ajax ze stroną.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Ajax extends Usluga
{

	public function start()
	{
		$cms = Cms::inst();
		$this->ustawSzablony();
		$cms->ladujBazeDanych();
		$cms->rozpocznijSesje();
		$this->ustawProjekt();

		$usluga = Zadanie::pobierz('usluga','strval','strtolower');
		$idKategorii = Zadanie::pobierz('cat','intval','abs');
		$idBloku = Zadanie::pobierz('b','intval','abs');
		$modul = Zadanie::pobierz('m','strval');
		$akcja = Zadanie::pobierz('a','strval');

		if ($usluga == 'admin')
		{
			$uzytkownik = $cms->profil();
			
			// ustawianie jezyka tresci i jezyka interfejsu
			if ($uzytkownik instanceof Uzytkownik\Obiekt /* && $uzytkownik->czyAdmin*/)
			{
				if ($uzytkownik->jezyk != '')
					define('KOD_JEZYKA_ITERFEJSU', $uzytkownik->jezyk);
				else
					define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
			}
			else
			{
				$dane = array(
					'status' => 0,
					'error' => 'niezalogowany',
				);
				
				// Sprawdzić czy to nie robi lipy
				echo json_encode($dane);
				die;
				trigger_error('Niezalogowany uzytkownik próbuje uzyc uslugi Ajax');
				cms_blad($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['brak_uprawnien_do_zasobu'], 503);
			}

			if (isset($cms->sesja->kod_jezyka_edycji) && $cms->sesja->kod_jezyka_edycji != '')
			{
				define('KOD_JEZYKA', $cms->sesja->kod_jezyka_edycji);
			}
			else
			{
				define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
			}
		}
		elseif ($usluga == 'http')
		{
			if (isset($cms->sesja->kod_jezyka) && $cms->sesja->kod_jezyka != '')
			{
				define('KOD_JEZYKA_ITERFEJSU', $cms->sesja->kod_jezyka);
				define('KOD_JEZYKA', $cms->sesja->kod_jezyka);
			}
			else
			{
				define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
				define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
			}
		}
		else
		{
			trigger_error('Nieprawidlowa wartosc parametru usluga dla uslugi Ajax');
			cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_stony']);
		}
		
		$cms->konfiguracjaBaza();
		$cms->tlumaczeniaBaza();
		
		$router = Router\Http::inst();
		/*
		if ($cms->config['router']['wlacz_filtr_url'])
		{
			$router->filtr(new Router\FiltrParametry(
				$cms->config['router']['parametry_slownik'],
				$cms->config['router']['parametry_url']
			));
		}
		*/
		$router->ustawReguly(RegulaRoutingu\Mapper::wywolaj()->pobierzWszystko());

		if ($idKategorii > 0)
		{
			$mapper = Cms::inst()->dane()->Kategoria();
			$kategoria = $mapper->pobierzPoId($idKategorii);
			$blok = null;
			$modul = null;
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
			trigger_error('Nie okreslono prawidlowo celu dla uslugi Ajax');
			cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_stony']);
		}

		// przetwarzanie strony
		try
		{
			$kodyUslug = Cms::inst()->pobierzUslugi();

			$sterownik = new Sterownik($kodyUslug[$usluga]);
			$sterownik->nastepnaAkcja($blok, $kategoria, $modul, $akcja);
			$sterownik->wykonaj();

			echo implode('', $sterownik->pobierzTresc(true));
		}
		catch (SterownikWyjatek $wyjatek)
		{
			cms_blad($cms->lang['bledy']['blad_aplikacji'], $cms->lang['bledy']['przerwane_przetwarzanie_strony'], 503);
		}

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


