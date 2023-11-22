<?php
namespace Generic\Konfiguracja\Modul\BlokSciezka;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property bool $k['ostatnia_linkiem']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'ostatnia_linkiem' => array(
		'opis' => 'Czy ostatnia pozycja ma być anchorem.',
		'typ' => 'bool',
		'wartosc' => null,
		),

	);
}
