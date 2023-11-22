<?php
namespace Generic\Konfiguracja\Modul\KonfiguracjaSystemu;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property string $k['tabela.domyslne_sortowanie']
 * @property int $k['tabela.wierszy_na_stronie']
 * @property array $k['wczytajKonfiguracje.dozwolone_formaty_plikow']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	'tabela.domyslne_sortowanie' => array(
		'etykieta' => 'Sposób sortowania listy modułów',
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'typ',
			),
		),

	'tabela.wierszy_na_stronie' => array(
		'etykieta' => 'Ilość wierszy w liście modułów',
		'maks' => '100',
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'wczytajKonfiguracje.dozwolone_formaty_plikow' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'csv',
			),
		),

	);
}
