<?php
namespace Generic\Model\ZamowieniaTemp;
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
			'number_order_get' => 'ASC',//TODO:
			'note' => 'ASC',//TODO:
			'time_spent' => 'ASC',//TODO:
			'lopendetimer' => 'ASC',//TODO:
			'product_list' => 'ASC',//TODO:
			'problem' => 'ASC',//TODO:
			'bkt_id' => 'ASC',//TODO:
		),
		
		'number_order_get' => array(
			'number_order_get',
			'id' => 'ASC',//TODO:
			'note' => 'ASC',//TODO:
			'time_spent' => 'ASC',//TODO:
			'lopendetimer' => 'ASC',//TODO:
			'product_list' => 'ASC',//TODO:
			'problem' => 'ASC',//TODO:
			'bkt_id' => 'ASC',//TODO:
		),
		
		'note' => array(
			'note',
			'id' => 'ASC',//TODO:
			'number_order_get' => 'ASC',//TODO:
			'time_spent' => 'ASC',//TODO:
			'lopendetimer' => 'ASC',//TODO:
			'product_list' => 'ASC',//TODO:
			'problem' => 'ASC',//TODO:
			'bkt_id' => 'ASC',//TODO:
		),
		
		'time_spent' => array(
			'time_spent',
			'id' => 'ASC',//TODO:
			'number_order_get' => 'ASC',//TODO:
			'note' => 'ASC',//TODO:
			'lopendetimer' => 'ASC',//TODO:
			'product_list' => 'ASC',//TODO:
			'problem' => 'ASC',//TODO:
			'bkt_id' => 'ASC',//TODO:
		),
		
		'lopendetimer' => array(
			'lopendetimer',
			'id' => 'ASC',//TODO:
			'number_order_get' => 'ASC',//TODO:
			'note' => 'ASC',//TODO:
			'time_spent' => 'ASC',//TODO:
			'product_list' => 'ASC',//TODO:
			'problem' => 'ASC',//TODO:
			'bkt_id' => 'ASC',//TODO:
		),
		
		'product_list' => array(
			'product_list',
			'id' => 'ASC',//TODO:
			'number_order_get' => 'ASC',//TODO:
			'note' => 'ASC',//TODO:
			'time_spent' => 'ASC',//TODO:
			'lopendetimer' => 'ASC',//TODO:
			'problem' => 'ASC',//TODO:
			'bkt_id' => 'ASC',//TODO:
		),
		
		'problem' => array(
			'problem',
			'id' => 'ASC',//TODO:
			'number_order_get' => 'ASC',//TODO:
			'note' => 'ASC',//TODO:
			'time_spent' => 'ASC',//TODO:
			'lopendetimer' => 'ASC',//TODO:
			'product_list' => 'ASC',//TODO:
			'bkt_id' => 'ASC',//TODO:
		),
		
		'bkt_id' => array(
			'bkt_id',
			'id' => 'ASC',//TODO:
			
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}