<?php
namespace Generic\Konfiguracja\Modul\BlokOpisowy;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property bool $k['formularz.wlacz_ckeditor']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.wlacz_ckeditor' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	);
}
