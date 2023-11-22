<?php
//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

echo "parametry:
all - pełny raport z nazwami ogloszen
produkt, usluga, ogloszenie - drukuje raport tylko dla jednego typu
\n";

$glowna = (isset($argv[2]) && in_array($argv[2], array('produkt', 'usluga', 'ogloszenie'))) ? $argv[2] : '';

if (isset($argv[1]) && $argv[1] == 'all')
{
	$sql = '
SELECT id, id_kategorii_ogloszen, tytul, status, publikuj
FROM modul_ogloszenia
WHERE id_projektu = ' . ID_PROJEKTU. '
AND kod_jezyka = \'' . KOD_JEZYKA .'\'
ORDER BY id_kategorii_ogloszen ASC, id ASC
	';
	$cms->baza->zapytanie($sql);
	$ogloszenia = array();
	while ($w = $cms->baza->pobierzWynik())
	{
		$ogloszenia[] = $w;
	}

	$kategorie = $cms->dane()->KategorieOgloszen();

	foreach ($ogloszenia as $ogloszenie)
	{
		$sciezka = array();
		foreach ($kategorie
				->zwracaTablice('id', 'nazwa', 'kategoria_glowna')
				->pobierzSciezke($ogloszenie['id_kategorii_ogloszen']) as $kategoria)
		{
			if ($kategoria['id'] == 1) continue;
			if ($glowna != '' && $glowna != $kategoria['kategoria_glowna']) continue;
			$sciezka[] = $kategoria['nazwa'];
		}
		$sciezka = implode(' > ', $sciezka);

		if ($sciezka != '') echo "{$sciezka} | {$ogloszenie['tytul']} ({$ogloszenie['id']}, {$ogloszenie['status']}, {$ogloszenie['publikuj']})\n";
	}
}
else
{
	$sql = '
SELECT id_kategorii_ogloszen, COUNT(id) as ilosc
FROM modul_ogloszenia
WHERE id_projektu = ' . ID_PROJEKTU. '
AND kod_jezyka = \'' . KOD_JEZYKA .'\'
GROUP BY id_kategorii_ogloszen
	';
	$kategorie = $cms->dane()->KategorieOgloszen();

	$cms->baza->zapytanie($sql);
	$ogloszenia = array();
	while ($w = $cms->baza->pobierzWynik())
	{
		$ogloszenia[$w['id_kategorii_ogloszen']] = $w['ilosc'];
	}

	foreach ($ogloszenia as $idKategorii => $iloscOgloszen)
	{
		$sciezka = array();
		foreach ($kategorie->zwracaTablice()->pobierzSciezke($idKategorii) as $kategoria)
		{
			if ($kategoria['id'] == 1) continue;
			if ($glowna != '' && $glowna != $kategoria['kategoria_glowna']) continue;
			$sciezka[] = $kategoria['nazwa'];
		}

		if (count($sciezka) > 0) echo implode(' > ', $sciezka).' | '.$iloscOgloszen."\n";
	}
}
