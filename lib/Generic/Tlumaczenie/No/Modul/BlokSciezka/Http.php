<?php
namespace Generic\Tlumaczenie\No\Modul\BlokSciezka;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_brak_kategorii']
 * @property string $t['index.znak_rozdzielajacy']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
			'index.blad_brak_kategorii' => 'Nie można pobrać struktury strony',
		'index.znak_rozdzielajacy' => '',
		);
}
