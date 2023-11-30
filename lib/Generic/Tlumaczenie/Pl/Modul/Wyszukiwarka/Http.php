<?php
namespace Generic\Tlumaczenie\Pl\Modul\Wyszukiwarka;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['index.brak_frazy']
 * @property string $t['index.kategoria_stron_opisowa']
 * @property string $t['index.tag_wyniki_wyszukiwania']
 * @property string $t['listaWynikow.pager']
 */
class Http extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'index.brak_frazy' => 'Nie wprowadziłęś żadnej frazy wyszukiwania.',	//TODO
		'index.kategoria_stron_opisowa' => 'Strona opisowa',
		'index.tag_wyniki_wyszukiwania' => 'Wyniki wyszukiwania dla frazy : ',
		'listaWynikow.pager' => '[ETYKIETA:listaWynikow.pager]',	//TODO

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}