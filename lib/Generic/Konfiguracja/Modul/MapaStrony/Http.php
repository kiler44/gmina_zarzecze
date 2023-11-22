<?php
namespace Generic\Konfiguracja\Modul\MapaStrony;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['wybrane_kategorie_startowe']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'wybrane_kategorie_startowe' => array(
		'opis' => 'Identyfikatory kategorii startowych. Aby wybrać przejdź do edycji treści.',
		'typ' => 'array',
		'wartosc' => array(
			),
		),

	);
}
