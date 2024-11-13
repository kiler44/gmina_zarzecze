<?php
namespace Generic\Tlumaczenie\Pl\Modul\StronaOpisowa;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_brak_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
        'stronaOpisowa.autor_zdjec_nieznany' => 'nieznany',
		'index.blad_brak_strony' => 'Nie dysponujemy treścią dla tej kategorii',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie treści strony',
		),
	);
}
