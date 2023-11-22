<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Model\Projekt;
use Generic\Biblioteka\Router;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Zadanie;


/**
 * Usluga http odpowiadajaca za pobranie polecenia z zadania, pobranie danych z bazy
 * i zbudowanie strony na podstawie wybranego widoku.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Download extends Usluga
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
		$parametryZadania = Router::analizujUrl();

		$kod_jezyka = $parametryZadania['jezyk'];
		if ($kod_jezyka != '' && in_array($kod_jezyka, $cms->projekt->jezykiKody))
		{
			define('KOD_JEZYKA_ITERFEJSU', $kod_jezyka);
			define('KOD_JEZYKA', $kod_jezyka);
			$cms->sesja->kod_jezyka = $kod_jezyka;
		}
		elseif (isset($cms->sesja->kod_jezyka) && $cms->sesja->kod_jezyka != '')
		{
			define('KOD_JEZYKA_ITERFEJSU', $cms->sesja->kod_jezyka);
			define('KOD_JEZYKA', $cms->sesja->kod_jezyka);
		}
		else
		{
			define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
			define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
		}

		// znamy juz ID_PROJEKTU i KOD_JEZYKA wiec mozemy uzupelnic konfiguracje
		$cms->konfiguracjaBaza();
		$cms->tlumaczeniaBaza();

		if ( ! $cms->profil() instanceof Uzytkownik\Obiekt)
		{
			$urlPowrotny = Zadanie::adresWywolujacego();
			if (stripos(getClearDomain($urlPowrotny), $cms->projekt->domena) !== false)
			{
				if (!isset($cms->sesja->komunikaty)) $cms->sesja->komunikaty = array();

				$cms->sesja->komunikaty[] = array('tresc' => $cms->lang['bledy']['nie_zalogowany_uzytkownik'], 'typ' => 'error', 'klasa' => '');
				Router::przekierujDo(Zadanie::adresWywolujacego());
			}
			else
			{
				cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_zalogowany_uzytkownik']);
				die();
			}
		}

		$urlPliku = trim(str_replace('_private', '', trim($_SERVER['ST_URL'])), '/');
		$plikiPrywatne = Cms::inst()->dane()->PlikPrywatny();

		if ( ! $plikiPrywatne->sprawdzUprawnienia($urlPliku, $cms->profil()))
		{
			$urlPowrotny = Zadanie::adresWywolujacego();
			if (stripos(getClearDomain($urlPowrotny), $cms->projekt->domena) !== false)
			{
				if (!isset($cms->sesja->komunikaty)) $cms->sesja->komunikaty = array();

				$cms->sesja->komunikaty[] = array('tresc' => $cms->lang['bledy']['brak_uprawnien_do_zasobu'], 'typ' => 'error', 'klasa' => '');
				Router::przekierujDo(Zadanie::adresWywolujacego());
			}
			else
			{
				cms_blad($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['brak_uprawnien_do_zasobu'], 403);
			}
		}

		ob_end_clean(); // czyszczenie buforowania z index.php

		if (zwrocPlikDoPrzegladarki(TEMP_KATALOG.'/private/'.$urlPliku) === false)
		{
			cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_pliku']);
		}

	}
}

