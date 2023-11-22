<?php
namespace Generic\Konfiguracja\Modul\Products;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['formularz.brutto_wartosc_domyslna']
 * @property string $k['formularz.netto_wartosc_domyslna']
 * @property int $k['formularz.vat_wartosc_domyslna']
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property string $k['index.pager_konfiguracja']
 * @property string $k['index.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.brutto_wartosc_domyslna' => array(
		'opis' => 'Domyślna wartość pola cena brutto',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'formularz.netto_wartosc_domyslna' => array(
		'opis' => 'Domyślna wartość pola cena netto',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'formularz.vat_wartosc_domyslna' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'int',
		'wartosc' => 25,
		),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'name',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'kolejnosc',
		),

	'index.pager_konfiguracja' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'index.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),
	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza ajaxowego',
		'typ' => 'array',
		'wartosc' => array(
			'productName',
			),
		),
	'formularz.technologia_lista' => array(
		'opis' => 'Lista technologii do produktów',
		'typ' => 'lista',
		'wartosc' => array(
			'ftth' => 'ftth',
			'hfc' => 'hfc',
			),
		),
	);
}
