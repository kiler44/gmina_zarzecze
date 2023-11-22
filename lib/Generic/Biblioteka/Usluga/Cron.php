<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Bledy;
use Generic\Model\Projekt;
use Generic\Biblioteka\Router;
use Generic\Model\RegulaRoutingu;
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\Plik;


/**
 * Usluga odpowiadajaca za wykonywanie zadań cyklicznych
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Cron extends Usluga
{

	public function start()
	{
		$cms = Cms::inst();

		$bledy = new Bledy();
		$bledy->dodajMechanizm(new Bledy\Logowanie\Plik($cms->config['bledy']['logowanie_plik'], LOGI_KATALOG.'/'.date("Y-m-d", $_SERVER['REQUEST_TIME']).'-php-error-cron.log'));
		$bledy->rejestruj();
		$cms->bledy = $bledy;
		$cms->ladujBazeDanych();

		$projekty = Cms::inst()->dane()->Projekt();
		$cms->projekt = $projekty->pobierzPoKodzie(KOD_PROJEKTU);
		if ($cms->projekt instanceof Projekt\Obiekt)
		{
			define('ID_PROJEKTU', $cms->projekt->id);
			if ( ! defined('DOMENA')) define('DOMENA', $cms->projekt->domena);
		}
		else
		{
			die('Nie znaleziono projektu o kodzie '.KOD_PROJEKTU."\n");
		}

		define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
		define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);

		// znamy juz ID_PROJEKTU i KOD_JEZYKA wiec mozemy uzupelnic konfiguracje
		$cms->konfiguracjaBaza();
		$cms->tlumaczeniaBaza();

		$_SERVER['SERVER_NAME'] = 'www.'.$cms->projekt->domena;
		$router = Router\Http::inst();
		if ($cms->config['router']['wlacz_filtr_url'])
		{
			$router->filtr(new Router\FiltrParametry(
				$cms->config['router']['parametry_slownik'],
				$cms->config['router']['parametry_url']
			));
		}
		$router->ustawReguly(RegulaRoutingu\Mapper::wywolaj()->pobierzWszystko());

		$sterownik = new Sterownik('Cron');
		$kategorie = Cms::inst()->dane()->Kategoria();

		$logWykonywania = new Plik(LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-cron.log', true);

		$zadania = Cms::inst()->dane()->ZadanieCykliczne();
		$zadania = $zadania->pobierzDoWykonania();
		
		foreach ($zadania as $zadanie)
		{
			echo date("Y-m-d H:i").' '.$zadanie->opisZadania;
			$logWiersz = date('Y-m-d H:i:s').' Rozpoczęto wykonywanie zadania '.$zadanie->kodZadania.' (ID: '.$zadanie->id.")\n";
			$logWykonywania->ustawZawartosc($logWiersz, true);

			Cms::inst()->temp('zadanie', $zadanie);
			$kategoria = ($zadanie->idKategorii > 1) ? $kategorie->pobierzPoId($zadanie->idKategorii) : null;
			$sterownik->nastepnaAkcja(null, $kategoria, $zadanie->kodModulu, str_replace('wykonaj', '', $zadanie->akcja));
			$sterownik->wykonaj();

			$logWiersz = date('Y-m-d H:i:s').' Zakończono wykonywanie zadania '.$zadanie->kodZadania.' (ID: '.$zadanie->id.")\n";
			$logWykonywania->ustawZawartosc($logWiersz, true);
		}
	}
}

