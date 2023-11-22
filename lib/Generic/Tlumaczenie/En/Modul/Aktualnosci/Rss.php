<?php
namespace Generic\Tlumaczenie\En\Modul\Aktualnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.info_brak_tresci']
 * @property string $t['index.opis_kanalu']
 * @property string $t['index.tytul_kanalu']
 */

class Rss extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'index.info_brak_tresci' => 'No content for this channel',
		'index.opis_kanalu' => '',
		'index.tytul_kanalu' => 'News',
		);
}
