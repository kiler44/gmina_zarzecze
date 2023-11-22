<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Model\Projekt;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\SterownikWyjatek;


/**
 * Usluga odpowiadajaca za wyswietlanie okna Popup.
 *
 * @author Półtorak Dariusz
 * @package biblioteki
 */

class Popup extends Usluga
{

	public function start()
	{
		$cms = Cms::inst();
		$cms->ladujBazeDanych();
		$cms->rozpocznijSesje();
		$projekty = Cms::inst()->dane()->Projekt();
		$cms->projekt = $projekty->pobierzPoKodzie(KOD_PROJEKTU);

		if ($cms->projekt instanceof Projekt\Obiekt)
		{
			define('ID_PROJEKTU', $cms->projekt->id);
			if ( ! defined('DOMENA')) define('DOMENA', $cms->projekt->domena);
		}
		else
		{
			cms_blad($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_projektu'], 503);
		}

		$niezalogowaniDozwoloneAkcje = array(
			'UserAccount' => array('signIn', 'reminder', 'changePassword'),
		);

		$usluga = Zadanie::pobierz('usluga','strval','strtolower');
		$idKategorii = Zadanie::pobierz('cat','intval','abs');
		$idBloku = Zadanie::pobierz('blok','intval','abs');
		$modul = Zadanie::pobierz('m','strval');
		$akcja = Zadanie::pobierz('a','strval');
		if ($usluga == 'admin')
		{
			$uzytkownik = $cms->profil();

			// ustawianie jezyka tresci i jezyka interfejsu
			if ($uzytkownik instanceof Uzytkownik\Obiekt && $uzytkownik->czyAdmin)
			{
				if ($uzytkownik->jezyk != '')
					define('KOD_JEZYKA_ITERFEJSU', $uzytkownik->jezyk);
				else
					define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
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
					$modul = 'UserAccount';
					$akcja = 'signIn';
				}
				//trigger_error('Niezalogowany uzytkownik próbuje uzyc uslugi Ajax');
				//die();
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
			trigger_error('Nieprawidlowa wartosc parametru usluga dla uslugi Popup');
			die();
		}

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
			trigger_error('Nie okreslono prawidlowo celu dla uslugi Popup');
			die();
		}

		// przetwarzanie strony
		try
		{
			if ( ! file_exists(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/popup.tpl'))
			{
				trigger_error('Nie można załadować szablonu dla usługi pop-up');
				die();
			}
			$kodyUslug = Cms::inst()->pobierzUslugi();

			$sterownik = new Sterownik($kodyUslug[$usluga]);
			$sterownik->nastepnaAkcja($blok, $kategoria, $modul, $akcja);
			$sterownik->wykonaj();

			$tresc = implode('', $sterownik->pobierzTresc(true));
			$szablon = new Szablon();
			$szablon->ladujTresc(Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/popup.tpl'));

			echo $szablon->parsujBlok('/', array('tresc' => $tresc));
		}
		catch (SterownikWyjatek $wyjatek)
		{
			cms_blad($cms->lang['bledy']['blad_aplikacji'], $cms->lang['bledy']['przerwane_przetwarzanie_strony'], 500);
		}
	}

}

