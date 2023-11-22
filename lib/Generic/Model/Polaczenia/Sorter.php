<?php
namespace Generic\Model\Polaczenia;
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
			'id_object_1' => 'ASC',//TODO:
			'id_object_2' => 'ASC',//TODO:
			'typ_object_1' => 'ASC',//TODO:
			'typ_object_2' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_object_1' => 'ASC',//TODO:
			'id_object_2' => 'ASC',//TODO:
			'typ_object_1' => 'ASC',//TODO:
			'typ_object_2' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
		),
		
		'id_object_1' => array(
			'id_object_1',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_object_2' => 'ASC',//TODO:
			'typ_object_1' => 'ASC',//TODO:
			'typ_object_2' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
		),
		
		'id_object_2' => array(
			'id_object_2',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_object_1' => 'ASC',//TODO:
			'typ_object_1' => 'ASC',//TODO:
			'typ_object_2' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
		),
		
		'typ_object_1' => array(
			'typ_object_1',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_object_1' => 'ASC',//TODO:
			'id_object_2' => 'ASC',//TODO:
			'typ_object_2' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
		),
		
		'typ_object_2' => array(
			'typ_object_2',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_object_1' => 'ASC',//TODO:
			'id_object_2' => 'ASC',//TODO:
			'typ_object_1' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
		),
		
		'data_dodania' => array(
			'data_dodania',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_object_1' => 'ASC',//TODO:
			'id_object_2' => 'ASC',//TODO:
			'typ_object_1' => 'ASC',//TODO:
			'typ_object_2' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}