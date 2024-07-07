<?php
namespace Generic\Konfiguracja\Modul\Aktualnosci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property boolean $k['modul_admin.czy_kategoria_wydarzen']
 * @property array $k['formularz.dozwolone_formaty_zdjec']
 * @property string $k['formularz.prefix_miniaturki_zdjecia']
 * @property string $k['formularz.prefix_zdjecia']
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property array $k['rozmiary_miniaturek']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

    'modul_admin.czy_kategoria_wydarzen' => array(
        'opis' => 'Czy dana kategoria jest wydarzeniem w przyszłości zamiast standardowej aktualności',
        'typ' => 'bool',
        'wartosc' => false,
    ),

	'formularz.dozwolone_formaty_zdjec' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'jpg',
			'png',
			'jpeg',
			'gif',
			'jpe',
			),
		),

	'formularz.prefix_miniaturki_zdjecia' => array(
		'opis' => 'Rozmiar pełnego zdjęcia. Wartość musi się znajdować w określonych w polu [rozmiary_miniaturek]',
		'typ' => 'varchar',
		'wartosc' => 'miniaturka-podglad',
		),

	'formularz.prefix_zdjecia' => array(
		'opis' => 'Rozmiar zdjęcia wyświetlany w podglądzie. Wartość musi się znajdować w określonych w polu [rozmiary_miniaturek]',
		'typ' => 'varchar',
		'wartosc' => 'mid',
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_dodania',
		'dozwolone' => array(
			0 => 'tytul',
			1 => 'autor',
			2 => 'data_dodania',
			3 => 'priorytetowa',
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
		'maks' => '1000',
		'opis' => 'Ilość wierszy na stronie w liście aktualności',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'rozmiary_miniaturek' => array(
        'opis' => 'Rozmiary tworzonych miniaturek w formacie:
                    kod => szerokosc.wysokosc.akcja
    				gdzie akcja:
                    crop - przytnij,
                    scale - skaluj,
                    resize - zmien rozmiar,
    				np. full => 800.600.scale',
        'typ' => 'array',
        'wartosc' => array(
            '' => '800.600.scale',
            'miniaturka-podglad' => '200.200.crop',
            'mid' => '200.200.crop',
            'min' => '120.120.crop',
            'xs' => '30.30.crop',
        ),
	),

	'szablon.formularz_wyszukiwarka' => array(
            'opis' => '',
            'typ' => 'varchar',
            'wartosc' => 'formularz_grid.tpl',
		),
	);
}
