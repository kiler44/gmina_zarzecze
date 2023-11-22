<?php
namespace Generic\Tlumaczenie\En\Modul\UserAccountBlock;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_styl']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.etykieta_styl' => 'Style:',
		'index.events_etykieta' => 'Events',
		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Signed in user and signout button',
		),
	);
}
