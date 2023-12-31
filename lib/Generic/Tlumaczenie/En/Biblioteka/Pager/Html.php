<?php
namespace Generic\Tlumaczenie\En\Biblioteka\Pager;

use Generic\Tlumaczenie\Tlumaczenie;


/**
 * @property string $t['pager_wstecz']
 * @property string $t['pager_przod']
 * @property string $t['pager_pierwsza']
 * @property string $t['pager_ostatnia']
 * @property string $t['pager_wybierz_strone']
 * @property string $t['pager_wybierz_przedzial']
 * @property string $t['pager_wybierz_zakres']
 * @property string $t['pager_pokaz_wszystko']
 * @property string $t['pager_na_stronie']
 * @property string $t['pager_ilosc']
 * @property string $t['pager_skocz_do']
 * @property string $t['pager_wartosc_skocz_do']
 *
 */
class Html extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'pager_wstecz' => '&laquo;',
		'pager_przod' => '&raquo;',
		'pager_pierwsza' => '&laquo;',
		'pager_ostatnia' => '&raquo;',
		'pager_wybierz_strone' => '',
		'pager_wybierz_przedzial' => 'Interval: ',
		'pager_wybierz_zakres' => 'On page: ',
		'pager_pokaz_wszystko' => 'All',
		'pager_na_stronie' => ' On page ',
		'pager_ilosc' => 'Results: ',
		'pager_skocz_do' => 'jump to page:',
		'pager_wartosc_skocz_do' => '#'
	);
}
