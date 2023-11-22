<?php
namespace Generic\Konfiguracja\Modul\ProjektyZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['dodaj.domyslnyJezyk']
 * @property array $k['dodaj.jezyki']
 * @property string $k['dodaj.nazwa_szablonu']
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'dodaj.domyslnyJezyk' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'pl',
		),

	'dodaj.jezyki' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'pl' => 'Polski',
			),
		),

	'dodaj.nazwa_szablonu' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'szablon_domyslny',
		),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'kod',
			'domena',
			'nazwa',
			'szablon',
			'jezyki',
			'domyslnyJezyk',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'data_dodania',
			),
		),

	'index.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 5,
		),

	);
}
