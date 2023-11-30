<?php
namespace Generic\Konfiguracja\Modul\Aktualnosci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['aktualnosc.format_daty']
 * @property string $k['aktualnosc.prefix_miniaturki']
 * @property string $k['aktualnosc.prefix_pelne_zdjecie']
 * @property bool $k['aktualnosc.uzyj_lightbox']
 * @property string $k['dolaczonaGaleria.prefix_miniaturki']
 * @property bool $k['dolaczonaGaleria.uzyj_lightbox']
 * @property string $k['listaAktualnosci.format_daty']
 * @property array $k['listaAktualnosci.pager']
 * @property string $k['listaAktualnosci.prefix_miniaturki']
 * @property bool $k['listaAktualnosci.respektuj_date_waznosci']
 * @property string $k['listaAktualnosci.sortowanie']
 * @property int $k['listaAktualnosci.wierszy_na_stronie']
 * @property string $k['szablon.pager']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

    'aktualnosci.czy_kategoria_wydarzen' => array(
        'opis' => 'Czy dana kategoria jest wydarzeniem w przyszłości (zapowiedzią czegoś co się wydarzy) zamiast standardowej aktualności',
        'typ' => 'bool',
        'wartosc' => false,
    ),

	'aktualnosc.format_daty' => array(
		'opis' => 'Format wyswietlanej daty. Aby poprawnie określić sprawdź http://www.php.net/manual/pl/function.date.php',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y @ H.i',
		),

	'aktualnosc.prefix_miniaturki' => array(
		'opis' => 'Rozmiar zdjęcia wyświetlany w widoku aktualności. Wartość musi się pokrywać z określonychmi w polu [rozmiary_miniaturek] w zakladce Admin',
		'systemowy' => '1',
		'typ' => 'varchar',
		'wartosc' => 'mid',
		),

	'aktualnosc.prefix_pelne_zdjecie' => array(
		'opis' => 'Rozmiar pełnego zdjęcia. Wartość musi się pokrywać z określonychmi w polu [rozmiary_miniaturek] w zakladce Admin',
		'systemowy' => '1',
		'typ' => 'varchar',
		'wartosc' => 'full',
		),

	'aktualnosc.uzyj_lightbox' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'dolaczonaGaleria.prefix_miniaturki' => array(
		'opis' => 'Rozmiar zdjęć wyświetlanych pod aktualnością. Wartość musi się pokrywać z określonychmi w module Galeria w zakladce Admin',
		'systemowy' => '1',
		'typ' => 'varchar',
		'wartosc' => 'small',
		),

	'dolaczonaGaleria.uzyj_lightbox' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

    'listaAktualnosci.format_daty_po_polsku' => array(
        'opis' => 'Czy data ma być wyświetlana po polsku np 1 stycznia 2000',
        'typ' => 'bool',
        'wartosc' => 0,
    ),
	'listaAktualnosci.format_daty' => array(
		'opis' => 'Format wyswietlanej daty. Aby poprawnie określić sprawdź http://www.php.net/manual/pl/function.date.php',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y @ H.i',
		),
    'listaAktualnosci.format_daty_datetime' => array(
        'opis' => 'Format daty w znaczniku "datetime". Aby poprawnie określić sprawdź http://www.php.net/manual/pl/function.date.php',
        'typ' => 'varchar',
        'wartosc' => 'Y-m-d',
    ),

	'listaAktualnosci.pager' => array(
		'opis' => 'Kompletna konfiguracja pagera (stronicowanie)',
		'typ' => 'array',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => '',
			'skoczDo' => '',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'listaAktualnosci.prefix_miniaturki' => array(
		'opis' => 'Rozmiar zdjęcia wyświetlany na liscie. Wartość musi się pokrywać z określonymi w polu [rozmiary_miniaturek] w zakladce Admin',
		'systemowy' => '1',
		'typ' => 'varchar',
		'wartosc' => 'min',
		),

	'listaAktualnosci.respektuj_date_waznosci' => array(//TODO
		'opis' => 'Czy ukrywać aktualności które mają ustawioną datę ważności na miejszą od teraz?',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'listaAktualnosci.sortowanie' => array(
		'opis' => 'Sortowanie listyw formacie: kolumna.kierunek',
		'typ' => 'select',
		'wartosc' => 'priorytetowa.desc',
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

	'listaAktualnosci.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 3,
		),

	'szablon.pager' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'pager.tpl',
		),

	);
}
