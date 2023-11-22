<?php
namespace Generic\Konfiguracja\Modul\PlikiPrywatne;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.szablon_managera']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.szablon_managera' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'szablon_manager_plikow.tpl',
		),

	);
}
