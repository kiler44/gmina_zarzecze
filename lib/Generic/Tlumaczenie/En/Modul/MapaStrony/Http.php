<?php
namespace Generic\Tlumaczenie\En\Modul\MapaStrony;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.tytul_modulu' => 'Mapa strony',
		'index.tytul_strony' => 'Mapa strony',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
		),
	);
}
