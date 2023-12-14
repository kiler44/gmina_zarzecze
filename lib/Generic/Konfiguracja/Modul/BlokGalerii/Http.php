<?php
namespace Generic\Konfiguracja\Modul\BlokGalerii;

use Generic\Konfiguracja\Konfiguracja;

/**
 * Zawiera konfigurację dla Generic\Modul\BlokGalerii\Http
 *
 */
class Http extends Konfiguracja
{
	/**
	* Domyślna konfiguracja
	* @var array
	*/
	protected $konfiguracjaDomyslna = array(
        'listaGalerii.prefix_miniaturki' => array(
            'opis' => '',
            'typ' => 'varchar',
            'wartosc' => 'miniaturka-podglad',
        ),
        'max_ilosc_galerii' => [
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 12,
        ],
        'max_ilosc_wyswietlaj' => [
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 6,
        ],

	);
}