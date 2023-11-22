<?php
namespace Generic\Tlumaczenie\No\Modul\BlokJezyki;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_wybrany_jezyk']
 * @property string $t['index.etykieta_zmien_jezyk']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
			'index.etykieta_wybrany_jezyk' => 'Wybrany język:',
		'index.etykieta_zmien_jezyk' => 'Nowy język:',
		);
}
