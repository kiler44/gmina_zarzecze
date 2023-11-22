<?php
namespace Generic\Tlumaczenie\Pl\Modul\SciezkaAdministracyjna;

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
	
		'index.etykieta_bierzaca_akcja' => 'Bieżąca akcja',
		'index.etykieta_link_edycja' => 'Edycja',
		'index.etykieta_link_konfiguracja' => 'Konfiguracja',
		'index.etykieta_link_tlumaczenia' => 'Tłumaczenia',
		'index.etykieta_link_tresc' => 'Treść',
		'index.etykieta_wybrany_jezyk' => 'Język edycji:',
		'index.etykieta_zmien_jezyk' => 'Zmień na:',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie ścieżki',
		),
	);
}
