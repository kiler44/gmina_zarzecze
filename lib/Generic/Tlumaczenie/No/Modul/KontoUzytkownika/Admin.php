<?php
namespace Generic\Tlumaczenie\No\Modul\KontoUzytkownika;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.info_brak_mozliwosci_zarzadzania_modulem']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.info_brak_mozliwosci_zarzadzania_modulem' => 'There is no content management in this module.',
		'index.tytul_strony' => 'User account',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Index',
		),
	);
}
