<?php
namespace Generic\Tlumaczenie\No\Modul\StronaOpisowa;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_brak_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.blad_brak_strony' => 'No content for this category',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Index',
		),
	);
}
