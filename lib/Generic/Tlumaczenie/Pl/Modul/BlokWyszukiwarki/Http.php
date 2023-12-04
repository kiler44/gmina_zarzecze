<?php
namespace Generic\Tlumaczenie\Pl\Modul\BlokWyszukiwarki;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['czytaj_wiecej_input']
 * @property string $t['index.blad_brak_kategorii']
 * @property string $t['placeholder_gdzie_szukac']
 * @property string $t['placeholder_szukaj']
 * @property string $t['szukaj_button']
 */
class Http extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'czytaj_wiecej_input' => 'Czytaj więcej',
		'index.blad_brak_kategorii' => '[ETYKIETA:index.blad_brak_kategorii]',	//TODO
		'placeholder_gdzie_szukac' => 'Gdzie szukać?',
		'placeholder_szukaj' => 'Czego Szukasz?',
		'szukaj_button' => 'Szukaj',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}