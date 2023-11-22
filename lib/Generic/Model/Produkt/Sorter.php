<?php
namespace Generic\Model\Produkt;
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
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
			'brutto_price' => 'ASC',
		),
		'kolejnosc' => array(
			'kolejnosc',
			'id' => 'ASC',
			'data_added' => 'ASC',
		),
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
			'brutto_price' => 'ASC',
		),
		
		'name' => array(
			'name',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
			'brutto_price' => 'ASC',
		),
		
		'status' => array(
			'status',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
			'brutto_price' => 'ASC',
		),
		
		'measure_unit' => array(
			'measure_unit',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
			'brutto_price' => 'ASC',
		),
		
		'visible_in_order' => array(
			'visible_in_order',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
			'brutto_price' => 'ASC',
		),
		
		'vat' => array(
			'vat',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'netto_price' => 'ASC',
			'brutto_price' => 'ASC',
		),
		'text_do_sms' => array(
			'text_do_sms',
			'main_product' => 'DESC',
		),
		'netto_price' => array(
			'netto_price',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'brutto_price' => 'ASC',
		),
		
		'brutto_price' => array(
			'brutto_price',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
		),
		
		'main_product' => array(
			'main_product',
			'brutto_price',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
		),
		'multiplied' => array(			
			'multiplied',
			'brutto_price',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
		),
		'note_required' => array(			
			'note_required',
			'brutto_price',
			'id' => 'ASC',
			'id_projektu' => 'ASC',
			'name' => 'ASC',
			'status' => 'ASC',
			'measure_unit' => 'ASC',
			'visible_in_order' => 'ASC',
			'vat' => 'ASC',
			'netto_price' => 'ASC',
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}