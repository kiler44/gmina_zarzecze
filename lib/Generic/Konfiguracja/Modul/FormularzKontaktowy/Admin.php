<?php
namespace Generic\Konfiguracja\Modul\FormularzKontaktowy;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['konfiguruj.domyslne_sortowanie']
 * @property int $k['konfiguruj.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property string $k['tematDomyslny.email']
 * @property string $k['tematDomyslny.temat']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_wyslania',
		'dozwolone' => array(
			'0' => 'data_wyslania',
			1 => 'email',
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście zgłoszeń',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'konfiguruj.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'temat',
		'dozwolone' => array(
			'0' => 'temat',
			1 => 'email',
			),
		),

	'konfiguruj.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie na liście tematów',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	'tematDomyslny.email' => array(
		'maks' => '50',
		'opis' => 'Adres email na który będą wysyłane zgłoszenia dla domyślnego tematu.',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'tematDomyslny.temat' => array(
		'maks' => '100',
		'opis' => 'Tytuł dla domyślnego tematu.',
		'typ' => 'varchar',
		'wartosc' => 'Temat domyślny',
		),

	);
}
