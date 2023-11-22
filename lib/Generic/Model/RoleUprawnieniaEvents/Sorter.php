<?php
namespace Generic\Model\RoleUprawnieniaEvents;
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
			'id_roli' => 'ASC',//TODO:
			'szablon_eventu' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_roli' => 'ASC',//TODO:
			'szablon_eventu' => 'ASC',//TODO:
		),
		
		'id_roli' => array(
			'id_roli',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'szablon_eventu' => 'ASC',//TODO:
		),
		
		'szablon_eventu' => array(
			'szablon_eventu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_roli' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}