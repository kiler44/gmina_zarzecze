<?php
namespace Generic\Tlumaczenie\Pl\Modul\RejestrowanieZdarzen;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajRejestrujZalogowany']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie treści strony',
			'wykonajRejestrujZalogowany' => 'Rejestruj informacje o tym, że użytkownik jest zalogowany.',
		),
	);

	protected $typyPolTlumaczen = array(
	);
}
