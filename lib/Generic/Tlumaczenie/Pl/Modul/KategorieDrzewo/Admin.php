<?php
namespace Generic\Tlumaczenie\Pl\Modul\KategorieDrzewo;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.tytul_modulu']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.tytul_modulu' => 'Szybka&nbsp;edycja',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie podstron serwisu',
		),
	);
}
