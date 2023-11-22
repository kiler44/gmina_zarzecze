<?php
namespace Generic\Konfiguracja\Modul\UstawieniaJezykowe;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property string $k['tabela.domyslne_sortowanie']
 * @property int $k['tabela.wierszy_na_stronie']
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
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'typ',
			),
		),

	'tabela.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście modułów',
		'typ' => 'int',
		'wartosc' => 10,
		),

	);
}
