<?php
namespace Generic\Konfiguracja\Modul\Timelist;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['getDaysInfo.limit_instalacji_na_dzien']
 
 */

class Api extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'getDaysInfo.limit_instalacji_na_dzien' => array(
		'opis' => 'Mnożnik czasu pracy',
		'typ' => 'integer',
		'wartosc' => 4
		),
	);
}
