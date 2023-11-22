<?php
namespace Generic\Konfiguracja\Modul\ZadaniaCykliczne;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 * @property int $k['sprawdz.zakres_godzin']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'zadanie',
			'zapisCron',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_rozpoczecia',
		'dozwolone' => array(
			'0' => 'kod_modulu',
			1 => 'id_kategorii',
			2 => 'data_rozpoczecia',
			3 => 'data_zakonczenia',
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście zadań',
		'typ' => 'int',
		'wartosc' => 30,
		),

	'sprawdz.zakres_godzin' => array(
		'maks' => '72',
		'min' => '1',
		'opis' => 'Ilość godzin +/-, dla których zostaną sprawdzone najbliższe zadania cykliczne ',
		'typ' => 'int',
		'wartosc' => 4,
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	);
}
