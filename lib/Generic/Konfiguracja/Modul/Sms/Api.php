<?php
namespace Generic\Konfiguracja\Modul\Sms;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['']
 
 */

class Api extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'sendSms.' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => true
		),
	);
}
