<?php
namespace Generic\Konfiguracja\Modul\UprawnieniaZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'kod',
			1 => 'nazwa',
			),
		),

	'index.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania na liście ról',
		'typ' => 'pager',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => 'select',
			'skoczDo' => 'form',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście ról',
		'typ' => 'int',
		'wartosc' => 20,
		),

	);
}
