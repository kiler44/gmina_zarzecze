<?php
namespace Generic\Tlumaczenie\Pl\Modul\BlokCzytnikRss;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_link_wiecej']
 * @property string $t['index.info_nie_znaleziono_wpisow']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
			'index.etykieta_link_wiecej' => 'Więcej',
		'index.info_nie_znaleziono_wpisow' => 'Nie dysponujemy żadnymi informacjami w tym momencie',
		);
}
