<?php
namespace Generic\Model\CmsUprawnieniaObiektow;
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
			'kod_jezyka' => 'ASC',//TODO:
			'kod_obiektu' => 'ASC',//TODO:
			'pole' => 'ASC',//TODO:
			'hash' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'kod_jezyka' => 'ASC',//TODO:
			'kod_obiektu' => 'ASC',//TODO:
			'pole' => 'ASC',//TODO:
			'hash' => 'ASC',//TODO:
		),
		
		'kod_jezyka' => array(
			'kod_jezyka',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kod_obiektu' => 'ASC',//TODO:
			'pole' => 'ASC',//TODO:
			'hash' => 'ASC',//TODO:
		),
		
		'kod_obiektu' => array(
			'kod_obiektu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kod_jezyka' => 'ASC',//TODO:
			'pole' => 'ASC',//TODO:
			'hash' => 'ASC',//TODO:
		),
		
		'pole' => array(
			'pole',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kod_jezyka' => 'ASC',//TODO:
			'kod_obiektu' => 'ASC',//TODO:
			'hash' => 'ASC',//TODO:
		),
		
		'hash' => array(
			'hash',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kod_jezyka' => 'ASC',//TODO:
			'kod_obiektu' => 'ASC',//TODO:
			'pole' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}