<?php
namespace Generic\Konfiguracja\Modul\Mailing;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 * @property int $k['mailing.ilosc_wysylanych_jednorazowo']
 * @property int $k['raport.id_formatki_email']
 * @property bool $k['raport.wysylaj']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.domyslne_sortowanie' => array(
		'opis' => 'Domyślne pole sortowania',
		'typ' => 'select',
		'wartosc' => 'data_wysylki',
		'dozwolone' => array(
			'0' => 'nazwa',
			1 => 'data_wysylki',
			2 => 'data_dodania',
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście modułów',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'mailing.ilosc_wysylanych_jednorazowo' => array(
		'maks' => '1000',
		'min' => '1',
		'opis' => 'Ilość maili wysyłanych w pojedyńczej partii',
		'typ' => 'int',
		'wartosc' => 100,
		),

	'raport.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 51,
		),

	'raport.wysylaj' => array(
		'opis' => 'Czy wysylać raport?',
		'typ' => 'bool',
		'wartosc' => null,
		),

	);
}
