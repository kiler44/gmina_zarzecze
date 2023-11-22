<?php
namespace Generic\Konfiguracja\Modul\CacheZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['cacheBloki.domyslne_sortowanie']
 * @property int $k['cacheBloki.wierszy_na_stronie']
 * @property string $k['cacheStrony.domyslne_sortowanie']
 * @property int $k['cacheStrony.wierszy_na_stronie']
 * @property string $k['cacheWizytowki.domyslne_sortowanie']
 * @property int $k['cacheWizytowki.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'cacheBloki.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'kod_modulu',
			2 => 'cache',
			3 => 'cache_czas',
			),
		),

	'cacheBloki.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w bloków obsługujących cache',
		'typ' => 'int',
		'wartosc' => 20,
		),

	'cacheStrony.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'data_modyfikacji',
			),
		),

	'cacheStrony.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście statycznych stron serwisu',
		'typ' => 'int',
		'wartosc' => 20,
		),

	'cacheWizytowki.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'data_modyfikacji',
			),
		),

	'cacheWizytowki.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście statycznych stron wizytówek',
		'typ' => 'int',
		'wartosc' => 20,
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => 'Szablon formularza wyszukiwania',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	);
}
