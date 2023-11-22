<?php
namespace Generic\Konfiguracja\Modul\BlokCzytnikRss;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['index.cache_rss_czas']
 * @property int $k['index.dlugosc_opisu']
 * @property string $k['index.format_daty']
 * @property int $k['index.ilosc_na_liscie']
 * @property array $k['index.obslugiwane_kanaly']
 * @property bool $k['index.pokazuj_link_wiecej_przy_opisie']
 * @property bool $k['index.pokazuj_opis']
 * @property string $k['index.sortuj_po_kolumnie']
 * @property int $k['index.znakow_w_tytule']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.cache_rss_czas' => array(
		'opis' => 'Co jaki czas pobierać kanały rss (minuty)',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'index.dlugosc_opisu' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 200,
		),

	'index.format_daty' => array(
		'opis' => 'Format wyswietlanej daty. Aby poprawnie określić sprawdź http://www.php.net/manual/pl/function.date.php',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y @ H:i',
		),

	'index.ilosc_na_liscie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'index.obslugiwane_kanaly' => array(
		'opis' => 'Lista adresów url kanałów rss',
		'typ' => 'list',
		'wartosc' => array(
			),
		),

	'index.pokazuj_link_wiecej_przy_opisie' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.pokazuj_opis' => array(//TODO
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'index.sortuj_po_kolumnie' => array(
		'opis' => 'Sortowanie listyw formacie: kolumna.kierunek',
		'typ' => 'select',
		'wartosc' => 'data_dodania.desc',
		'dozwolone' => array(
			'0' => 'tytul.desc',
			1 => 'tytul.asc',
			2 => 'data_dodania.desc',
			3 => 'data_dodania.asc',
			),
		),

	'index.znakow_w_tytule' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 120,
		),

	);
}
