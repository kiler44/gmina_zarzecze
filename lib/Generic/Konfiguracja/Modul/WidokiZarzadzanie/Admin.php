<?php
namespace Generic\Konfiguracja\Modul\WidokiZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['bloki.domyslne_sortowanie']
 * @property int $k['bloki.wierszy_na_stronie']
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['szablon.kontenery']
 * @property array $k['wczytajKonfiguracje.dozwolone_formaty_plikow']
 * @property bool $k['wczytajKonfiguracje.kasuj_stara_konfiguracje']
 * @property bool $k['wczytajKonfiguracje.pokaz_przyciski']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'bloki.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'kod_modulu',
			2 => 'kontener',
			),
		),

	'bloki.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście bloków',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'nazwa',
			'ukladStrony',
			'kodModulu',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'uklad_strony',
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście układów stron',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'szablon.kontenery' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'kontenery.tpl',
		),

	'wczytajKonfiguracje.dozwolone_formaty_plikow' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'php',
			),
		),

	'wczytajKonfiguracje.kasuj_stara_konfiguracje' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'wczytajKonfiguracje.pokaz_przyciski' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	);
}
