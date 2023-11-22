<?php
namespace Generic\Model\Zalacznik;
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
			'id_projektu' => 'ASC', 
			'object' => 'ASC',  
			'file' => 'ASC', 
			'date_added' => 'ASC', 
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC', 
			'object' => 'ASC', 
			'file' => 'ASC', 
			'date_added' => 'ASC', 
		),
		'date_added' => array(
			'date_added',
			'id' => 'ASC', 
			'id_projektu' => 'ASC', 
			'object' => 'ASC', 
			'file' => 'ASC', 
		),
		'object' => array(
			'object',
			'id' => 'ASC', 
			'id_projektu' => 'ASC', 
			'object' => 'ASC', 
			'file' => 'ASC', 
			'date_added' => 'ASC', 
		),
		'id_object' => array(
			'object' => 'ASC', 
			'file' => 'ASC', 
			'date_added' => 'ASC', 
		),
		'file' => array(
			'file',
			'id' => 'ASC', 
			'id_projektu' => 'ASC', 
			'object' => 'ASC', 
			'date_added' => 'ASC', 
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'object';
}