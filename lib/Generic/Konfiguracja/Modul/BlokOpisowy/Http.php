<?php
namespace Generic\Konfiguracja\Modul\BlokOpisowy;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['wyswietlaj_dla_akcji_modulu']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'wyswietlaj_dla_akcji_modulu' => array(
		'opis' => 'Lista kodów akcji dla których blok ma być wyświetlany

			np.: Wiztowki_Http_index
 oznacza że blok będzie wyświetlany tylko i wyłącznie dla akcji wykonajIndex w module Wizytowki',
		'typ' => 'list',
		'wartosc' => array(
			),
		),

	);
}
