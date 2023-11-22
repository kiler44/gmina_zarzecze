<?php
namespace Generic\Tlumaczenie\No\Modul\CropperZdjec;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.info_brak_mozliwosci_zarzadzania_modulem']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property array $t['_zdarzenia_etykiety_']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.info_brak_mozliwosci_zarzadzania_modulem' => 'This module doesn\'t support content management',
		'index.tytul_strony' => 'Cropper',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edit settings',
		),

		'_zdarzenia_etykiety_' => array(
		),
	);
}
