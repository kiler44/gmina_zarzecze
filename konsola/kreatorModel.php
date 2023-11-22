<?php

/**
 * Odpowiada za tworzenie plików: definicji, obiektu, mappera, sortera, tłumaczeń i konfiguracji na rzecz modelu. 
 */
require_once 'cli.inc.php';
require_once 'cli-cms.inc.php';

use Generic\Biblioteka\Kreator\KreatorBaza;

$dostepneObiekty = array(
	'd' => 'definicja',
	'o' => 'obiekt',
	'm' => 'mapper',
	's' => 'sorter',
	't' => 'tlumaczenie',
	'k' => 'konfiguracja',
);

/**
 * Wyświetla listę tabel istniejących w bazie danych w oknie konsoli.
 */
function pokazDostepneTabele($parametry)
{
	$baza = KreatorBaza::zwrocNazweBazy($parametry);
	echo "\nLista dostępnych tabel w bazie $baza:\n";
	$i = 1;

	$definicjaTymczasowa = new KreatorBaza\Definicja($baza);
	$tabele = $definicjaTymczasowa->pobierzNazwyTabel();
	foreach ($tabele as $nazwa)
	{
		echo " $i . $nazwa \n";
		$i++;
	}
	echo "\n";
}



/**
 * Pokazuje menu pomocy w konsoli.
 */
function pokazPomoc($parametry)
{
	pokazDostepneTabele($parametry);
	$pomoc = array(
		'przed' => "\n***************************************************\n",
		'tytul' => "\nPomoc kreatora obiektów danych\n",
		'nazwa_tabeli' => "Aby wygenerować pliki PHP na podstawie tabeli bazy danych, należy podać jej nazwę jako pierwszy parametr:\nphp kreator.php NAZWA_TABELI\n",
		'definicja' => " d generuje plik definicji,\n",
		'obiekt' => " o - generuje plik obiektu danych\n",
		'mapper' => " m - generuje plik mapera,\n",
		'sorter' => " s - generuje plik sortera,\n",
		'tlumaczenia' => " t - generuje plik tłumaczeń,\n",
		'konfiguracja' => " k - generuje plik konfiguracji,\n",
		'wszystko' => " w - generuje pliki: obiektu, mapera, sortera, tłumaczeń, konfiguracji\n",
		'po' => "\n***************************************************\n",
		'inne' => "Aby skorzystać z kreatora dla modułu należy podać\nnazwę modułu oraz plik i akcję.\nnp.: php kreatorModul.php ZadaniaCykliczne Admin t\n t - dotyczy tłumaczeń,\n k - dotyczy konfiguracji\n w - generuje konfigurację i tłumaczenia\n\n",
	);

	foreach ($pomoc as $tlumaczenie)
	{
		echo $tlumaczenie;
	}
	die();
}



$parametry = $argv;

switch (count($parametry))
{
	case 1:
		{
			pokazPomoc($parametry);
		}
		break;

	default:
		{
			$nazwaBazy = KreatorBaza::zwrocNazweBazy($parametry);
			$definicjaTymczasowa = new KreatorBaza\Definicja($nazwaBazy);
			$nazwaTabeli = isset($parametry[1]) ? $parametry[1] : '';

			if ($nazwaTabeli == '')
			{
				die("Nie podano nazwy tabeli.\n");
			}

			if (!$definicjaTymczasowa->czyTabelaIstnieje($nazwaTabeli))
			{
				pokazDostepneTabele($parametry);
				die("Podana nazwa tabeli nie istnieje.\n");
			}
			unset($parametry[0]);
			$nazwaOdUzytkownika = $nazwaTabeli;
			foreach ($parametry as $parametr)
			{
				if (strlen($parametr) > 1 && $parametr != $nazwaBazy && $parametr != $nazwaTabeli)
				{
					$nazwaOdUzytkownika = $parametr;
					break;
				}
			}

			$namespaceGeneratora = 'Generic\\Biblioteka\\Kreator\\KreatorBaza\\';
			$namespaceKonfiguracjiTlumaczen = 'Generic\\Biblioteka\\Kreator\\';
			
			$i = 1;
			$generatory = array();
			foreach ($argv as $parametr)
			{
				if (strlen($parametr) == 1 && $parametr == 'w')
				{
					$generatory = $dostepneObiekty;
				}
				elseif (strlen($parametr) == 1 && isset($dostepneObiekty[$parametr]))
				{
					$generatory[$parametr] = $dostepneObiekty[$parametr];
				}
			}
			
			if(empty($generatory))
			{
				pokazPomoc($parametry);
			}
	echo "\n***************************************************\nWygenerowano następujące pliki na podstawie tabeli: \n";
			foreach ($generatory as $generator)
			{
				$namespace = ($generator == 'konfiguracja') ? $namespaceKonfiguracjiTlumaczen : $namespaceGeneratora;
				$generator = ucfirst($generator);
				$obiekt = $namespace . $generator;
				$kreator = new $obiekt($nazwaBazy);
				$linia = $i . '. ' . $generator . '.php';
				if ($kreator->generuj($nazwaTabeli, $nazwaOdUzytkownika))
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
		}
}