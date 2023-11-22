<?php
namespace Generic\Konfiguracja\Modul\Platnosci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property string $k['index.formularz_wyszukiwarka']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_dodania',
		'dozwolone' => array(
			'0' => 'data_dodania',
			1 => 'status',
			2 => 'typ_platnosci',
			3 => 'obiekt',
			4 => 'kwota',
			),
		),

	'index.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	'index.pager_konfiguracja' => array(
		'opis' => '',
		'typ' => 'pager',
		'wartosc' => array(
			'poprzedniaNastepna' => 1,
			'pierwszaOstatnia' => 1,
			'wyborStrony' => 'linki',
			'wyborZakresu' => 'select',
			'zakres' => 3,
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w ogłoszeń',
		'typ' => 'int',
		'wartosc' => 10,
		),

	);
}
