<?php
namespace Generic\Konfiguracja\Modul\BlokAktualnosci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['idKategorii']
 * @property int $k['index.dlugosc_zajawki']
 * @property bool $k['index.format_daty_po_polsku']
 * @property string $k['index.format_daty']
 * @property int $k['index.ilosc_na_liscie']
 * @property string $k['index.klasa_nadrzedna_listy']
 * @property bool $k['index.pokazuj_autora']
 * @property bool $k['index.pokazuj_link_wiecej']
 * @property bool $k['index.pokazuj_link_wiecej_przy_aktualnosci']
 * @property bool $k['index.pokazuj_zajawke']
 * @property bool $k['index.pokazuj_zdjecie']
 * @property string $k['index.prefix_miniaturki']
 * @property bool $k['index.respektuj_date_waznosci']
 * @property string $k['index.sortuj_po_kolumnie']
 * @property int $k['index.znakow_w_tytule']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'idKategorii' => array(
		'opis' => 'Powinno być ustawione przez panel administracyjny',
		'systemowy' => '1',
		'typ' => 'varchar',
		'wartosc' => '17',
		),

	'index.dlugosc_zajawki' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 200,
		),
    'index.format_daty_po_polsku' => array(
        'opis' => 'Jeśli zaznaczone data będzie się wyświetlała gramatycznie np. 10 września 2022',
        'typ' => 'bool',
        'wartosc' => false,
    ),
	'index.format_daty' => array(
		'opis' => 'Format wyswietlanej daty. Aby poprawnie określić sprawdź http://www.php.net/manual/pl/function.date.php',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y @ H:i',
		),

	'index.ilosc_na_liscie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'index.klasa_nadrzedna_listy' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'listaAktualnosci',
		),

	'index.pokazuj_autora' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.pokazuj_link_wiecej' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.pokazuj_link_wiecej_przy_aktualnosci' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.pokazuj_zajawke' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.pokazuj_zdjecie' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.prefix_miniaturki' => array(
		'opis' => 'Rozmiar zdjęcia wyświetlany na liscie. Wartość musi się pokrywać z określonychmi w polu [rozmiary_miniaturek] w Module Aktualności w zakladce Admin',
		'typ' => 'varchar',
		'wartosc' => 'min',
		),

	'index.respektuj_date_waznosci' => array(
		'opis' => 'Czy ukrywać aktualności które mają ustawioną datę ważności na miejszą od teraz?',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'index.sortuj_po_kolumnie' => array(
		'opis' => 'Sortowanie listyw formacie: kolumna.kierunek',
		'typ' => 'select',
		'wartosc' => 'data_dodania.desc',
		'dozwolone' => array(
			'0' => 'priorytetowa.desc',
			1 => 'priorytetowa.asc',
			2 => 'tytul.desc',
			3 => 'tytul.asc',
			4 => 'autor.desc',
			5 => 'autor.asc',
			6 => 'data_dodania.desc',
			7 => 'data_dodania.asc',
			),
		),

	'index.znakow_w_tytule' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 120,
		),

	);
}
