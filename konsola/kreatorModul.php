<?php

/**
 * Odpowiada za tworzenie plików tłumaczeń i konfiguracji na rzecz danego modułu.
 * @author Marek Bar
 */
require_once 'cli.inc.php';
require_once 'cli-cms.inc.php';

use Generic\Biblioteka\Kreator\KreatorBaza;

$dostepneObiekty = array(
	't' => 'tlumaczenie',
	'k' => 'konfiguracja',
);

$parametry = $argv;
$definicjaTymczasowa = new KreatorBaza\Definicja(KreatorBaza::zwrocNazweBazy($parametry));
$nazwaTabeli = isset($parametry[1]) ? $parametry[1] : '';
$nazwaPlikuModulu = isset($parametry[2]) ? $parametry[2] : '';

if (count($parametry) == 3 || $nazwaTabeli == '' && $nazwaPlikuModulu == '')
{
	die("\nPodaj nazwę modułu oraz plik i akcję.\nnp.: php kreatorModul.php ZadaniaCykliczne Admin t\n t - dotyczy tłumaczeń,\n k - dotyczy konfiguracji\n w - generuje konfigurację i tłumaczenia\n\n");
}

$namespace = 'Generic\\Biblioteka\\Kreator\\';
echo "\n***************************************************\nWygenerowano następujące pliki dla $nazwaTabeli\\$nazwaPlikuModulu: \n";

$i = 1;
unset($parametry[0]);
$nazwaBazy = 'crm';
$generatory = array();
foreach ($parametry as $parametr)
{
	if (strlen($parametr) > 1)
	{
		if ($definicjaTymczasowa->czyBazaIstnieje($parametr) === true)
		{
			$nazwaBazy = $parametr;
			continue;
		}
	}
	elseif (strlen($parametr) == 1 && $parametr == 'w')
	{
		$generatory = $dostepneObiekty;
	}
	elseif (strlen($parametr) == 1 && isset($dostepneObiekty[$parametr]))
	{
		$generatory[$parametr] = $dostepneObiekty[$parametr];
	}
}

if (empty($generatory))
{
	pokazPomoc($parametry);
}
foreach ($generatory as $generator)
{
	$generator = ucfirst($generator);
	$obiekt = $namespace . $generator;
	$kreator = new $obiekt($nazwaBazy);
	$linia = $i . '. ' . $generator;
	$kreator->ustawPrzetwarzanyTyp('Modul');
	$kreator->ustawNazwePlikuModulu($nazwaPlikuModulu);
	if ($kreator->generuj($nazwaTabeli, $nazwaTabeli))
	{
		echo $linia . " - OK\n";
	}
	else
	{
		echo $linia . " - BŁĄD\n";
	}
	$kreator->pokazPodsumowanie();

	$i++;
}

echo "\n***************************************************\n";