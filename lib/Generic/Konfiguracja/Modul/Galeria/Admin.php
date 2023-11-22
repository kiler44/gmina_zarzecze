<?php
namespace Generic\Konfiguracja\Modul\Galeria;

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

	'upload.miniaturki_kody' => array(
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

	);
}
