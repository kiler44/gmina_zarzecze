<?php
namespace Generic\Konfiguracja\Modul\UdostepnianiePlikow;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_dodania',
		'dozwolone' => array(
			'0' => 'tytul',
			1 => 'autor',
			2 => 'plik',
			3 => 'data_dodania',
			4 => 'priorytetowa',
			),
		),

	'index.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania',
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
		'opis' => 'Ilość plików na stronie w liście plików',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	);
}
