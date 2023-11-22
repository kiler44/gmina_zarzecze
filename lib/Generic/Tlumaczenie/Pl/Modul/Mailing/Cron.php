<?php
namespace Generic\Tlumaczenie\Pl\Modul\Mailing;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_mailing']
 */

class Cron extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
				'_zdarzenia_etykiety_' => array(
			'wyslano_mailing' => 'Wyslano wiadomości e-mail',
		),
	);
}
