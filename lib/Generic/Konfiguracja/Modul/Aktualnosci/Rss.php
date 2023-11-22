<?php
namespace Generic\Konfiguracja\Modul\Aktualnosci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['index.dlugosc_opisu']
 * @property int $k['index.ilosc_na_liscie']
 * @property int $k['index.odswierzanie_minut']
 * @property bool $k['index.pokazuj_autora']
 * @property bool $k['index.pokazuj_date_dodania']
 * @property bool $k['index.respektuj_date_waznosci']
 * @property string $k['index.sortuj_po_kolumnie']
 */

class Rss extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.dlugosc_opisu' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 200,
		),

	'index.ilosc_na_liscie' => array(
		'maks' => '50',
		'opis' => 'Ilość elementów na liście kanału rss',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'index.odswierzanie_minut' => array(
		'opis' => 'Co ile minut ma być odświeżany kanał rss',
		'typ' => 'int',
		'wartosc' => 1440,
		),

	'index.pokazuj_autora' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.pokazuj_date_dodania' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
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

	);
}
