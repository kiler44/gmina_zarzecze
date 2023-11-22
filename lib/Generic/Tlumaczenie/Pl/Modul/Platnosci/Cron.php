<?php
namespace Generic\Tlumaczenie\Pl\Modul\Platnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajUsunNieprawidlowe']
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['zmieniono_status_platnosci']
 */

class Cron extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
				'_akcje_etykiety_' => array(
			'wykonajUsunNieprawidlowe' => 'Usuwanie niedokończonych płatnosci',
		),

		'_zdarzenia_etykiety_' => array(
			'zmieniono_status_platnosci' => 'Zmieniono status płatności.',
		),
	);
}
