<?php
namespace Generic\Konfiguracja\Modul\Tidsbanken;

use Generic\Konfiguracja\Konfiguracja;

/**
 * Zawiera konfigurację dla Generic\Modul\Tidsbanken\Admin
 *
 */
class Api extends Konfiguracja
{
	/**
	* Domyślna konfiguracja
	* @var array
	*/
	protected $konfiguracjaDomyslna = array(
		'getKey.klucz' => array(
			'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'bkttidsbanken' => 'Sup3rTajnyK1ucz',
				),
		),
		'getKey.ip_klienta' => array(
			'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'bkttidsbanken' => '10.0.2.2',
				),
		),
		'getKey.sprawdzaj_ip' => array(
			'opis' => '',
			'typ' => 'bool',
			'wartosc' => false,
		)
	);
}