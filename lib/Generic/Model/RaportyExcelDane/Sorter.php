<?php
namespace Generic\Model\RaportyExcelDane;
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
			'id_order' => 'ASC',//TODO:
			'id_team' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'kilometry' => 'ASC',//TODO:
			'minuty_jazdy' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_order' => 'ASC',//TODO:
			'id_team' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'kilometry' => 'ASC',//TODO:
			'minuty_jazdy' => 'ASC',//TODO:
		),
		
		'id_order' => array(
			'id_order',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_team' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'kilometry' => 'ASC',//TODO:
			'minuty_jazdy' => 'ASC',//TODO:
		),
		
		'id_team' => array(
			'id_team',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_order' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'kilometry' => 'ASC',//TODO:
			'minuty_jazdy' => 'ASC',//TODO:
		),
		
		'data' => array(
			'data',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_order' => 'ASC',//TODO:
			'id_team' => 'ASC',//TODO:
			'kilometry' => 'ASC',//TODO:
			'minuty_jazdy' => 'ASC',//TODO:
		),
		
		'kilometry' => array(
			'kilometry',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_order' => 'ASC',//TODO:
			'id_team' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'minuty_jazdy' => 'ASC',//TODO:
		),
		
		'minuty_jazdy' => array(
			'minuty_jazdy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_order' => 'ASC',//TODO:
			'id_team' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'kilometry' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}