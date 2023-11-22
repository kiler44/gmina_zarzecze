<?php
namespace Generic\Model\Reports;
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
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'obiekt' => array(
			'obiekt',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'id_obiektow' => array(
			'id_obiektow',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'kategoria' => array(
			'kategoria',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'data_od' => array(
			'data_od',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'data_do' => array(
			'data_do',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'autor' => array(
			'autor',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'data_dodania' => array(
			'data_dodania',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'data_modyfikacji' => array(
			'data_modyfikacji',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'wyslany' => 'ASC',//TODO:
		),
		
		'wyslany' => array(
			'wyslany',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt' => 'ASC',//TODO:
			'id_obiektow' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'data_od' => 'ASC',//TODO:
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
		),
		'wyslany_do_fakturowania' => array(
			'wyslany_do_fakturowania',
			'data_od' => 'DESC',
			'data_do' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
		),
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}