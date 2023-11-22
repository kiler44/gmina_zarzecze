<?php
namespace Generic\Model\ZamowieniePdf;
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
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'godzina' => 'ASC',//TODO:
			'id_pdf' => 'ASC',//TODO:
		),
		
		'data' => array(
			'data',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'godzina' => 'ASC',//TODO:
			'id_pdf' => 'ASC',//TODO:
		),
		
		'godzina' => array(
			'godzina',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'id_pdf' => 'ASC',//TODO:
		),
		
		'id_pdf' => array(
			'id_pdf',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'godzina' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}