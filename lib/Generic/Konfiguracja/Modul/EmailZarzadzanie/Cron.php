<?php
namespace Generic\Konfiguracja\Modul\EmailZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['wykonajObslugaKolejki.wiersze_do_pobrania']
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'wykonajObslugaKolejki.wiersze_do_pobrania' => array(
		'maks' => '1000',
		'opis' => 'Ilość maili do wyslania jednorazowo',
		'typ' => 'int',
		'wartosc' => 100,
		),

	);
}
