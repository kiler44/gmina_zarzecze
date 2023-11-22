<?php
//require 'xhprof-header.php';
$start = microtime(true);
date_default_timezone_set('Europe/Oslo');
mb_internal_encoding('UTF-8');

// katalog bibliotek cms-a
define('CMS_KATALOG', $_SERVER['ST_SYS_DIR']);

// katalog główny strony
define('HTML_KATALOG', $_SERVER['ST_WWW_DIR']);

// katalog do przetrzymywania plików
define('TEMP_KATALOG', $_SERVER['ST_TMP_DIR']);

// katalog szablonu
define('SZABLON_KATALOG', $_SERVER['ST_TPL_DIR']);

// katalog z logami
define('LOGI_KATALOG', $_SERVER['ST_LOG_DIR']);

// katalog cache dla cms-a
define('CACHE_KATALOG', $_SERVER['ST_CACHE_DIR']);

// kod projektu
define('KOD_PROJEKTU', $_SERVER['ST_PROJEKT']);

// nazwa szablonu systemowego
define('SZABLON_SYSTEM', 'szablon_system');

define('DOMENA_Z_WWW', false);

// domena
if ( isset($_SERVER['ST_DOMENA'])) define('DOMENA', $_SERVER['ST_DOMENA']);

$local_include = CMS_KATALOG . '/lib/';
ini_set('include_path', $local_include.':/usr/share/pear');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', false);
ini_set('display_startup_errors', false);
ini_set('error_log', LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-php-error.log');

ob_start();

require_once CMS_KATALOG.'/lib.inc.php';
require_once CMS_KATALOG.'/lib/vendor/autoload.php';
use Generic\Biblioteka\Cms;

if (PHP_SAPI != 'cli')
{
	Cms::start();
}

//$pay = new Payum\Core\Payum();
//Cms::start();
ob_end_flush();
$stop = microtime(true);
$czas = $stop - $start;

if (!Generic\Biblioteka\Zadanie::czyAjax() && !Generic\Biblioteka\Zadanie::czyApi())
{
	echo '<p style="color: white; font-size: 10px; float: right; padding: 5px">Generated in: '.round($czas,3).'s';
	//require 'xhprof-footer.php';
	echo '</p>';
}
?>
