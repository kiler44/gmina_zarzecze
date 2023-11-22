<?php
/**
 * Skrypt odpowiada za automatyczne wygenerowanie klas tłumaczeń dla wszystkich
 * modułów.
 *
 * Skrypt wymaga aby w module znajdowała sie tablica $tlumaczeniaDomyslne.
 *
 * Wykonywać tylko na niezmigrowanym kodzie.
 */

$blokadaGenerowaniaPliku = true;

require_once 'creatorTlumaczenia.php';

$pliki = glob_recur('*.php', 0, CMS_KATALOG.'/lib/Generic/Modul/');

foreach ($pliki as $sciezka)
{
	echo "Sprawdzam plik $sciezka\n";

	$sciezkaRozbita = explode('/', str_replace('.php', '', $sciezka));

	$modul = $sciezkaRozbita[count($sciezkaRozbita) - 2] . '\\' . $sciezkaRozbita[count($sciezkaRozbita) - 1];
	$typ = 'Modul';

	$creator->generujPlik($modul, $typ, 'migracja');
}