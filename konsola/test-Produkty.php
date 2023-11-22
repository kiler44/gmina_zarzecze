<?php

//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';


/**
 * @var Generic\Model\Produkt\Obiekt
 */
$produkt = Generic\Biblioteka\Cms::inst()->dane()->Produkt()->pobierzPoId(2);

/*$produkt->ustawPrzypisanePolityki(array(
	'aktywacja' => 'Aktywacja\ST2013',
));

$produkt->idProjektu = 1;
$produkt->kodJezyka = KOD_JEZYKA;
$produkt->dataDodania = date('Y-m-d H:i:s');
$produkt->czyWSprzedazy = true;
$produkt->okresSprzedazyOd = '2012-12-30 00:00:00';
$produkt->okresSprzedazyDo = '2015-12-30 00:00:00';
$produkt->cenaBazowa = 600;
$produkt->stawkaVat = 23;
$produkt->wagaSortowania = 0;
$produkt->nazwaFaktura = 'Konto Standard Uzupełnienie F';
$produkt->nazwaAdmin = 'Konto Standard Uzupełnienie A';
$produkt->nazwaListy = 'Konto Standard Uzupełnienie L';
$produkt->nazwaPortal = 'Konto Standard Uzupełnienie P';
$produkt->typProduktu = 'upgrade';
$produkt->czasTrwania = 365;
$produkt->okresRozliczeniowy = 365;
$produkt->grupaProduktow = 'uzupelnienie_st';

$produkt->zapisz(Generic\Biblioteka\Cms::inst()->dane()->Produkt());


$powiazanie = new Generic\Model\Powiazanie\Obiekt;

$powiazanie->nazwaTypu = 'jestRodzicemProduktu';
$powiazanie->obiekt1 = $produkt;
$powiazanie->id2 = 3;

$powiazanie->zapisz(Generic\Biblioteka\Cms::inst()->dane()->Powiazanie());
*/

//var_dump($produkt->pobierzProduktyPodrzedne());


//var_dump($produkt->pobierzPrzypisanePolityki());

//var_dump($produkt->pobierzDopuszczalneParametry());

$produkt->aktywacja()->wykonaj();

$produkt->rejestracja()->wykonaj();

var_dump($produkt->pobierzProduktRodzic());

echo "DONE\n";