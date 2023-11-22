<?php
namespace Generic\Model\ZamowienieTyp;
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
      'name' => array('main_type' => 'DESC', 'name', 'active' => 'DESC'),
      'date_added' => array('date_added', 'main_type' => 'DESC', 'name' => 'DESC'),
		'main_type' => array('main_type', 'name' => 'DESC'),
		'child_orders' => array('child_orders', 'main_type' => 'DESC', 'name' => 'DESC'),
		
		'id' => array(
			'id',
			'id_projektu' => 'ASC',//TODO:
			'main_type' => 'ASC',//TODO:
			'active' => 'ASC',//TODO:
			'child_orders' => 'ASC',//TODO:
			'possible_charge_types' => 'ASC',//TODO:
			'parent_types' => 'ASC',//TODO:
		),
		'kolejnosc' => array(
			'kolejnosc',
			'id' => 'ASC',//TODO:
		),
		
		'order_group' => array(
			'order_group',
			'kolejnosc' => 'ASC',
		),
	
		'active' => array(
			'active',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'main_type' => 'ASC',//TODO:
			'child_orders' => 'ASC',//TODO:
			'possible_charge_types' => 'ASC',//TODO:
			'parent_types' => 'ASC',//TODO:
		),
		
		'possible_charge_types' => array(
			'possible_charge_types',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'main_type' => 'ASC',//TODO:
			'active' => 'ASC',//TODO:
			'child_orders' => 'ASC',//TODO:
			'parent_types' => 'ASC',//TODO:
		),
		
		'parent_types' => array(
			'parent_types',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'main_type' => 'ASC',//TODO:
			'active' => 'ASC',//TODO:
			'child_orders' => 'ASC',//TODO:
			'possible_charge_types' => 'ASC',//TODO:
		),
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}