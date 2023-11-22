<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Model\Projekt;
use Generic\Biblioteka\Router;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\Zadanie;


/**
 * Usluga odpowiadajaca za wyswietlanie kanalow Rss.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Rss extends Usluga
{

	public function start()
	{
		$cms = Cms::inst();
		$cms->ladujBazeDanych();
		//$cms->rozpocznijSesje();

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
		$parametryZadania = Router::analizujUrl('', array(',','.xml'));

		$kod_jezyka = $parametryZadania['jezyk'];
		if ($kod_jezyka != '' && in_array($kod_jezyka, $cms->projekt->jezykiKody))
		{
			define('KOD_JEZYKA_ITERFEJSU', $kod_jezyka);
			define('KOD_JEZYKA', $kod_jezyka);
			$cms->sesja->kod_jezyka = $kod_jezyka;
		}
		else
		{
			define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
			define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
		}

		// znamy juz ID_PROJEKTU i KOD_JEZYKA wiec mozemy uzupelnic konfiguracje
		$cms->konfiguracjaBaza();
		$cms->tlumaczeniaBaza();

		$kategorieMapper = Cms::inst()->dane()->Kategoria();
		$kategoria = null;
		if ($parametryZadania['sciezka'] != '')
		{
			$kategoria = $kategorieMapper->pobierzPoLinku($parametryZadania['sciezka']);
		}

		if ($kategoria instanceof Kategoria\Obiekt && $kategoria->rssWlaczony)
		{
			$sterownik = new Sterownik('Rss');
			$sterownik->nastepnaAkcja(null, $kategoria);
			$sterownik->wykonaj();
			echo trim(implode('', $sterownik->pobierzTresc(true)));
		}
		else
		{
			$urlPowrotny = getClearDomain(Zadanie::adresWywolujacego());
			if (stripos($urlPowrotny, $cms->projekt->domena) !== false)
			{
				if (!isset($cms->sesja->komunikaty))
				{
					$cms->sesja->komunikaty = array();
				}
				$cms->sesja->komunikaty[] = array('tresc' => $cms->lang['bledy']['nie_znaleziono_stony'], 'typ' => 'error', 'klasa' => '');
				Router::przekierujDo(Zadanie::adresWywolujacego());
				die();
			}
			else
			{
				cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_stony']);
			}
		}
	}
}

