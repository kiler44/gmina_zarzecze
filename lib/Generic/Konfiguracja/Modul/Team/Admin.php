<?php
namespace Generic\Konfiguracja\Modul\Team;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property int $k['index.wyswietlaj_drzewo']
 * @property int $k['index.wyswietlaj_dzieci_nowy_widok']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
	'formularz.wymagane_pola' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('teamNumber', 'numberPlate', ),
	),
	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'team_number',
		'dozwolone' => array(
			0 => 'status',
			1 => 'number_plate',
			2 => 'team_number',
			),
		),
		
	'grid_zdjecia_przedrostek' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'xs',
	),

	'index.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania',
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
	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),
	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 5,
		),
	'formularz.input_pracownicy_kody_rol' => array(
		'opis' => 'Id ról użytkowników którzy mają być wyświetlani w inpucie',
		'typ' => 'list',
		'wartosc' => array(
			 'worker', 
			),
	),
	);
}
