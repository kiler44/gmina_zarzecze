<?php
namespace Generic\Konfiguracja\Modul\SciezkaAdministracyjna;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.znak_rozdzielajacy']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.znak_rozdzielajacy' => array(
		'maks' => '100',
		'opis' => 'Znak rozdzielający linki w ścieżce',
		'typ' => 'varchar',
		'wartosc' => '&raquo;',
		),

	);
}
