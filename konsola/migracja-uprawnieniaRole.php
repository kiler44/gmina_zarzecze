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

foreach ($cms->dane()->Uzytkownik()->pobierzWszystko() as $uzytkownik)
{
	echo "Tworzę rolę dla użytkownika o ID=" . $uzytkownik->id . "\n";

	$rola = new \Generic\Model\Rola\Obiekt();
	$rola->idProjektu = ID_PROJEKTU;
	$rola->kod = 'uzytkownik_' . $uzytkownik->id;
	$rola->nazwa = 'Uzytkownik ' . $uzytkownik->id;
	$rola->opis = 'Rola użytkownika o ID=' . $uzytkownik->id;

	if ( ! $rola->zapisz($cms->dane()->Rola()) || ! $rola->przypiszDoUzytkownika($uzytkownik->id))
	{
		$wystapilBlad = true;
		break;
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

