<?php
namespace Generic\Konfiguracja\Modul\Wyszukiwarka;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property array $k['upload.miniaturki_kody']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'nazwa',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			0 => 'nazwa',
			1 => 'data_dodania',
			2 => 'autor',
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście',
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
