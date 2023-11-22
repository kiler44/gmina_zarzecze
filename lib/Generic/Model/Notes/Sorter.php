<?php
namespace Generic\Model\Notes;
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
			'object' => 'ASC',//TODO:
			'id_object' => 'ASC',//TODO:
			'description' => 'ASC',//TODO:
			'data_added' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'object' => 'ASC',//TODO:
			'id_object' => 'ASC',//TODO:
			'description' => 'ASC',//TODO:
			'data_added' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'object' => array(
			'object',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_object' => 'ASC',//TODO:
			'description' => 'ASC',//TODO:
			'data_added' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'id_object' => array(
			'id_object',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'object' => 'ASC',//TODO:
			'description' => 'ASC',//TODO:
			'data_added' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'description' => array(
			'description',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'object' => 'ASC',//TODO:
			'id_object' => 'ASC',//TODO:
			'data_added' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'data_added' => array(
			'data_added' => 'DESC',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'object' => 'ASC',//TODO:
			'id_object' => 'ASC',//TODO:
			'description' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'status' => array(
			'status',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'object' => 'ASC',//TODO:
			'id_object' => 'ASC',//TODO:
			'description' => 'ASC',//TODO:
			'data_added' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}