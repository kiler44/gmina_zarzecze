<?php
namespace Generic\Model\RaportyNadgodziny;
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
			'id_user' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'godziny' => 'ASC',//TODO:
			'nadgodziny' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_user' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'godziny' => 'ASC',//TODO:
			'nadgodziny' => 'ASC',//TODO:
		),
		
		'id_user' => array(
			'id_user',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'godziny' => 'ASC',//TODO:
			'nadgodziny' => 'ASC',//TODO:
		),
		
		'data' => array(
			'data',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_user' => 'ASC',//TODO:
			'godziny' => 'ASC',//TODO:
			'nadgodziny' => 'ASC',//TODO:
		),
		
		'godziny' => array(
			'godziny',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_user' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'nadgodziny' => 'ASC',//TODO:
		),
		
		'nadgodziny' => array(
			'nadgodziny',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_user' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'godziny' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}