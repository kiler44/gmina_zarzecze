<?php
namespace Generic\Konfiguracja\Modul\Platnosci;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['wykonajUsunNieprawidlowe.anuluj_niedokonczone_po']
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'wykonajUsunNieprawidlowe.anuluj_niedokonczone_po' => array(
		'opis' => 'Po ilu minutach niedokonczone płatności mają być anulowane',
		'typ' => 'int',
		'wartosc' => 60,
		),

	);
}
