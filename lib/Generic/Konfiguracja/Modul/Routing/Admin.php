<?php
namespace Generic\Konfiguracja\Modul\Routing;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.wymagane_pola']
 * @property int $k['index.wierszy_na_stronie']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'routing_nazwa',
			'routing_kategoria',
			'routing_nazwaAkcji',
			'routing_typReguly',
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście zadań',
		'typ' => 'int',
		'wartosc' => 50,
		),

	);
}
