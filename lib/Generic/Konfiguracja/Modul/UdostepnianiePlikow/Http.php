<?php
namespace Generic\Konfiguracja\Modul\UdostepnianiePlikow;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.format_daty']
 * @property array $k['index.pager']
 * @property string $k['index.sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['szablon.pager']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.format_daty' => array(
		'opis' => 'Format wyswietlanej daty. Aby poprawnie określić sprawdź http://www.php.net/manual/pl/function.date.php',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y @ H.i',
		),

	'index.pager' => array(
		'opis' => 'Kompletna konfiguracja pagera (stronicowanie)',
		'typ' => 'pager',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => '',
			'skoczDo' => '',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'index.sortowanie' => array(
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

	'index.wierszy_na_stronie' => array(
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
