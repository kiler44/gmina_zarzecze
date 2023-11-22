<?php

//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

/**
 * Skrypt dodaje role dla każdego istniejącego w systemie użytkownika.
 */



$cms = \Generic\Biblioteka\Cms::inst();

echo "Rozpoczynam pracę\n";

$cms->transakcjaSystemowaStart();

$wystapilBlad = false;

echo "Aktualizuję uprawnienia zwykłe \n";
foreach ($cms->dane()->Uprawnienie()->pobierzWszystko() as $uprawnienie)
{
	$uprawnienie->hash = funkcjaHashujaca($uprawnienie->usluga . '_' . $uprawnienie->idKategorii . '_' . $uprawnienie->akcja);


	echo $uprawnienie->usluga . '_' . $uprawnienie->idKategorii . '_' . $uprawnienie->akcja . ' ';
	echo funkcjaHashujaca($uprawnienie->usluga . '_' . $uprawnienie->idKategorii . '_' . $uprawnienie->akcja) . "\n";

	if ( ! $uprawnienie->zapisz($cms->dane()->Uprawnienie()))
	{
		$wystapilBlad = true;
		break;
		echo "Błąd zapisu prawnienia zwykłego o ID=$uprawnienie->id\n";
	}
}

echo "Aktualizuję uprawnienia administracyjne \n";
foreach ($cms->dane()->UprawnienieAdministracyjne()->pobierzWszystko() as $uprawnienie)
{
	$uprawnienie->hash = funkcjaHashujaca($uprawnienie->kodModulu . '_' . $uprawnienie->akcja);
	if ( ! $uprawnienie->zapisz($cms->dane()->UprawnienieAdministracyjne()))
	{
		$wystapilBlad = true;
		break;
		echo "Błąd zapisu prawnienia administracyjnego o ID=$uprawnienie->id\n";
	}
}

if ($wystapilBlad)
{
	$cms->transakcjaSystemowaCofnij();
	echo "Dane nie zostały zapisane.\n";
}
 else
{
	$cms->transakcjaSystemowaPotwierdz();
	echo "Dane zapisane poprawnie.\n";
}

