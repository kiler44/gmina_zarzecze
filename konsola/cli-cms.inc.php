<?php
/*
 * Inicjowanie cms-a dla konsoli:
 * - zaladowanie pelnej obslugi bledow (konsola +plik)
 * - zaladowanie tlumaczen i konfiguracji
 * - ustawienie projektu
 */
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Bledy;
use Generic\Model\Projekt;

require_once CMS_KATALOG.'/lib.inc.php';

$cms = Cms::inst();
$cms->konfiguracjaPlik();
$cms->tlumaczeniaPlik();
$bledy = new Bledy();
$bledy->dodajMechanizm(new Bledy\Logowanie\Konsola(E_ALL));
$bledy->dodajMechanizm(new Bledy\Logowanie\Plik($cms->config['bledy']['logowanie_plik'], LOGI_KATALOG.'/'.date ("Y-m-d").'-php-error.log'));
$bledy->rejestruj();
$cms->bledy = $bledy;
$cms->ladujBazeDanych();

$cms->projekt = $cms->dane()->Projekt()->pobierzPoKodzie(KOD_PROJEKTU);

if ($cms->projekt instanceof Projekt\Obiekt)
{
	define('ID_PROJEKTU', $cms->projekt->id);
	if ( ! defined('KOD_JEZYKA_ITERFEJSU')) define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
	if ( ! defined('KOD_JEZYKA')) define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
	if ( ! defined('DOMENA')) define('DOMENA', $cms->projekt->domena);
	$_SERVER['USER'] = 'apache';
}
else
{
	die("Nie znaleziono projektu o kodzie '".KOD_PROJEKTU."' \n");
}

$cms->konfiguracjaBaza();
$cms->tlumaczeniaBaza();
