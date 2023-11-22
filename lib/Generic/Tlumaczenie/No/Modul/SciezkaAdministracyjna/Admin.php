<?php
namespace Generic\Tlumaczenie\No\Modul\SciezkaAdministracyjna;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_bierzaca_akcja']
 * @property string $t['index.etykieta_link_edycja']
 * @property string $t['index.etykieta_link_konfiguracja']
 * @property string $t['index.etykieta_link_tlumaczenia']
 * @property string $t['index.etykieta_link_tresc']
 * @property string $t['index.etykieta_wybrany_jezyk']
 * @property string $t['index.etykieta_zmien_jezyk']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.etykieta_bierzaca_akcja' => 'this screen',
		'index.etykieta_link_edycja' => 'Edit',
		'index.etykieta_link_konfiguracja' => 'Configuration',
		'index.etykieta_link_tlumaczenia' => 'Languages',
		'index.etykieta_link_tresc' => 'Contents',
		'index.etykieta_wybrany_jezyk' => 'Interface language:',
		'index.etykieta_zmien_jezyk' => 'Change to:',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Visibility of system breadcrumb',
		),
	);
}
