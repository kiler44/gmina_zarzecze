<?php
namespace Generic\Model\Event;
use Generic\Biblioteka;

/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących.
 */
class Sorter extends Biblioteka\Sorter
{
	/**
	* Tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny.
	* Porzadek sortowania jest dodawany tylko do pierwszej kolumny.
	* @var array
	*/
	public $_rodzaje = array(
		'id' => array(
			'id',
			'id_projektu' => 'ASC',//TODO:
			'nazwa_szablonu' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'nazwa_szablonu' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
		),
		
		'nazwa_szablonu' => array(
			'nazwa_szablonu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
		),
		
		'konfiguracja_szablon' => array(
			'konfiguracja_szablon',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa_szablonu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
		),
		
		'nazwa' => array(
			'nazwa',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa_szablonu' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}