<?php
namespace Generic\Tlumaczenie\No\Modul\UserAccountBlock;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_styl']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.etykieta_styl' => 'Stil:',
		'index.events_etykieta' => 'Events',
		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Registrert bruker og utlogging knappen',
		),
	);
}
