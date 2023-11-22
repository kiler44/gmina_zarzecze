<?php
namespace Generic\Tlumaczenie\En\Modul\EmailZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajObslugaKolejki']
 */

class Cron extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
				'_akcje_etykiety_' => array(
			'wykonajObslugaKolejki' => 'Send e-mails from queue',
		),
	);
}
