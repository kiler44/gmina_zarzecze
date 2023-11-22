<?php
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Plik;
use Generic\Model\ZadanieCykliczne;
//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

//--------------------------------
// domyslne wartosci parametrow
$idZadania = null;
//--------------------------------

$idZadania = (isset($argv[1]) && $argv[1] != '') ? $argv[1] : $idZadania;

$sterownik = new Sterownik('Cron');
$kategorie = Cms::inst()->dane()->Kategoria();

$logWykonywania = new Plik(LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-cron.log', true);

$idZadania = 1;

$zadaniaMapper = Cms::inst()->dane()->ZadanieCykliczne();
$zadanie = $zadaniaMapper->pobierzPoId($idZadania);
if ($zadanie instanceof ZadanieCykliczne)
{
	$kategorie = Cms::inst()->dane()->Kategoria();

	$logWiersz = date('Y-m-d H:i:s').' Rozpoczęto testowanie zadania '.$zadanie->kodZadania.' (ID: '.$zadanie->id.")\n";
	$logWykonywania->ustawZawartosc($logWiersz, true);

	Cms::inst()->temp('zadanie', $zadanie);
	$sterownik = new Sterownik('Cron');
	$kategoria = ($zadanie->idKategorii > 1) ? $kategorie->pobierzPoId($zadanie->idKategorii) : null;
	$sterownik->nastepnaAkcja(null, $kategoria, $zadanie->kodModulu, str_replace('wykonaj', '', $zadanie->akcja));
	$sterownik->wykonaj();

	$logWiersz = date('Y-m-d H:i:s').' Zakończono testowanie zadania '.$zadanie->kodZadania.' (ID: '.$zadanie->id.")\n";
	$logWykonywania->ustawZawartosc($logWiersz, true);
}
else
{
	die("Nie znaleziono zadania\n");
}


