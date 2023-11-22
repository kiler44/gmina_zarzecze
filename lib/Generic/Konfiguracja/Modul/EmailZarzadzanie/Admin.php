<?php
namespace Generic\Konfiguracja\Modul\EmailZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['formularz.ilosc_zalacznikow']
 * @property array $k['formularz.pracownicy_role']
 * @property array $k['formularz.wymagane_pola']
 * @property array $k['formularzSzablon.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['kolejka.domyslne_sortowanie']
 * @property array $k['kolejka.pager_konfiguracja']
 * @property int $k['kolejka.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property string $k['szablony.domyslne_sortowanie']
 * @property array $k['szablony.pager_konfiguracja']
 * @property int $k['szablony.wierszy_na_stronie']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.ilosc_zalacznikow' => array(
		'maks' => '10',
		'opis' => 'Ilość załączników dla formatki',
		'typ' => 'int',
		'wartosc' => 3,
		),

	'formularz.pracownicy_role' => array(
		'opis' => 'Identyfikatory ról pracowników',
		'typ' => 'list',
		'wartosc' => array(
			'administrator',
			'user',
			),
		),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza formatki',
		'typ' => 'list',
		'wartosc' => array(
			'tytul',
			'kategoria',
			'typWysylania',
			'typAlgorytmu',
			'emailTytul',
			'emailTrescTxt',
			'emailOdbiorcy',
			),
		),

	'formularzSzablon.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza szablonu',
		'typ' => 'list',
		'wartosc' => array(
			'nazwa',
			'trescHtml',
			'trescTxt',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => 'Domyślne sortowanie w liście formatek',
		'typ' => 'select',
		'wartosc' => 'tytul',
		'dozwolone' => array(
			'0' => 'tytul',
			1 => 'kategoria',
			2 => 'data_dodania',
			),
		),

	'index.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania w liście formatek',
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

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście formatek',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'kolejka.domyslne_sortowanie' => array(
		'opis' => 'Domyślne sortowanie na stronie kolejki email',
		'typ' => 'select',
		'wartosc' => 'data_dodania',
		'dozwolone' => array(
			'0' => 'email_tytul',
			1 => 'bledy',
			2 => 'data_dodania',
			),
		),

	'kolejka.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania na stronie kolejki email',
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

	'kolejka.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie kolejki email',
		'typ' => 'int',
		'wartosc' => 100,
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	'szablony.domyslne_sortowanie' => array(
		'opis' => 'Domyślne sortowanie w liście szablonów',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			'0' => 'tytul',
			1 => 'kategoria',
			2 => 'data_dodania',
			),
		),

	'szablony.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania w liście szablonów',
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

	'szablony.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście szablonów',
		'typ' => 'int',
		'wartosc' => 10,
		),

	);
}
