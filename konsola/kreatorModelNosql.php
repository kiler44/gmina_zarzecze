<?php

/**
 * Odpowiada za tworzenie plików: definicji, obiektu, mappera, sortera, tłumaczeń i konfiguracji na rzecz modelu.
 */
require_once 'cli.inc.php';
//require_once 'cli-cms.inc.php';

use Generic\Biblioteka\Kreator\BazaMongo;


/**
 * Pokazuje menu pomocy w konsoli.
 */
function pokazPomoc()
{
	$pomoc = array(
		'przed' => "\n***************************************************\n",
		'tytul' => "\nPomoc kreatora obiektów danych NoSQL\n",
		'nazwa_tabeli' => "Aby wygenerować pliki PHP na podstawie struktury bazy NoSQL należy podać jako jedyny parametr scieżkę do pliku PHP zawierającego jej definicję, jako drugi parametr nazwę bazy z pliku baza.ini.\n",
		'nazwa_tabeli2' => "\nPrzykład użycia: kreatorModelNosql.php ../strukturaNosql.php mongo\n\n",
		'nazwa_tabeli3' => "Struktura modelu zostanie wygenerowana automatycznie. Kontener mapperów zostanie uaktualniony.\n",
		'nazwa_tabeli4' => "Jeżeli mappery nie zostały zdefiniowane w pliku struktury, a znajdują się w katalogu docelowym mogą zostać usuniete!\n",
		'po' => "\n***************************************************\n",
		);

	foreach ($pomoc as $tlumaczenie)
	{
		echo $tlumaczenie;
	}

	exit(0);
}



if  ($argc == 3)
{
	if (is_file($argv[1]) && is_readable($argv[1]))
	{
		$kreator = new BazaMongo($argv[1]);

		$kreator->generuj($argv[2], '');

		include(CMS_KATALOG.'/konsola/creatorKontener.php');

	}
	else
	{
		echo "\nŚcieżka pliku struktury nie została podana prawidłowo! Procedura nie powidła się.\n\n";
	}
}
else
{
	pokazPomoc();
}

