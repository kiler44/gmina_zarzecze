<?php
namespace Generic\Tlumaczenie\No\Modul\BlokSciezka;

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
	
		'index.info_brak_mozliwosci_zarzadzania_modulem' => 'This block has no content management. Try edit configuration, languages for this block',
		'index.tytul_strony' => 'Edit breadcrumb block',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edit breadcrumb block',
		),
	);
}
