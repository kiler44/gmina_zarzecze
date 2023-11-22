<?php
/*
 * Zaladowanie podstawowych ustawien i sciezek potrzebnych do pracy:
 * - ustawienia kodowania
 * - ustawienia sciezek katalogow
 * - wyswietlanie wszystkich bledow
 */
date_default_timezone_set('Europe/Warsaw');
mb_internal_encoding('UTF-8');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

$katalogSvn = dirname(dirname(__FILE__));
$katalogPozaSvn = dirname(dirname(dirname(__FILE__)));

// katalog bibliotek cms-a
define('CMS_KATALOG', $katalogSvn);
if ( ! is_dir(CMS_KATALOG)) die('Brak katalogu CMS: '.CMS_KATALOG);

// katalog szablonu
define('SZABLON_KATALOG', $katalogSvn.'/szablon_domyslny');
if ( ! is_dir(SZABLON_KATALOG)) die('Brak katalogu SZABLON: '.SZABLON_KATALOG);

// katalog główny strony
define('HTML_KATALOG', $katalogPozaSvn);
if ( ! is_dir(HTML_KATALOG)) die('Brak katalogu HTML: '.HTML_KATALOG);

// katalog do przetrzymywania plików
define('TEMP_KATALOG', $katalogPozaSvn.'/temp');
if ( ! is_dir(TEMP_KATALOG)) die('Brak katalogu TEMP: '.TEMP_KATALOG);

// katalog z logami
define('LOGI_KATALOG', $katalogPozaSvn.'/logi');
if ( ! is_dir(LOGI_KATALOG)) die('Brak katalogu LOGI: '.LOGI_KATALOG);

// katalog cache dla cms-a
define('CACHE_KATALOG', $katalogPozaSvn.'/cache');
if ( ! is_dir(CACHE_KATALOG)) die('Brak katalogu CACHE: '.CACHE_KATALOG);

// kod projektu
define('KOD_PROJEKTU', 'projekt_domyslny');
// kod projektu
define('SZABLON_SYSTEM', '/szablon_system');

require_once CMS_KATALOG.'/lib/autoloader.php';
require_once CMS_KATALOG.'/lib.inc.php';

