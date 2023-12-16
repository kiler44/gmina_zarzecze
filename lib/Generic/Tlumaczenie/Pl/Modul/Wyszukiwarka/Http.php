<?php
namespace Generic\Tlumaczenie\Pl\Modul\Wyszukiwarka;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['brak_wynikow']
 * @property string $t['index.brak_frazy']
 * @property string $t['index.kategoria_stron_opisowa']
 * @property string $t['index.tag_wyniki_wyszukiwania']
 * @property string $t['listaWynikow.pager']
 * @property string $t['lista_wynikow']
 * @property string $t['wyniki_kategoria']
 */
class Http extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'brak_wynikow' => '[ETYKIETA:brak_wynikow]',	//TODO
		'index.brak_frazy' => 'Nie wprowadziłęś żadnej frazy wyszukiwania.',
		'index.kategoria_stron_opisowa' => 'Strona opisowa',
		'index.tag_wyniki_wyszukiwania' => 'Wyniki wyszukiwania',
		'listaWynikow.pager' => '[ETYKIETA:listaWynikow.pager]',	//TODO
		'lista_wynikow' => '[ETYKIETA:lista_wynikow]',	//TODO
		'wyniki_kategoria' => '[ETYKIETA:wyniki_kategoria]',	//TODO

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}