<?php
namespace Generic\Model\StawkaUzytkownika;
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
			'id_uzytkownika' => 'ASC',//TODO:
			'stawka' => 'ASC',//TODO:
			'data_start' => 'ASC',//TODO:
			'data_stop' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_uzytkownika' => 'ASC',//TODO:
			'stawka' => 'ASC',//TODO:
			'data_start' => 'ASC',//TODO:
			'data_stop' => 'ASC',//TODO:
		),
		
		'id_uzytkownika' => array(
			'id_uzytkownika',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'stawka' => 'ASC',//TODO:
			'data_start' => 'ASC',//TODO:
			'data_stop' => 'ASC',//TODO:
		),
		
		'stawka' => array(
			'stawka',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_uzytkownika' => 'ASC',//TODO:
			'data_start' => 'ASC',//TODO:
			'data_stop' => 'ASC',//TODO:
		),
		
		'data_start' => array(
			'data_start',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_uzytkownika' => 'ASC',//TODO:
			'stawka' => 'ASC',//TODO:
			'data_stop' => 'ASC',//TODO:
		),
		
		'data_stop' => array(
			'data_stop',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_uzytkownika' => 'ASC',//TODO:
			'stawka' => 'ASC',//TODO:
			'data_start' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}