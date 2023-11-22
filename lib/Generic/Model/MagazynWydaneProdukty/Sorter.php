<?php
namespace Generic\Model\MagazynWydaneProdukty;
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
			'id_zamowienia' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_zamowienia' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'id_zamowienia' => array(
			'id_zamowienia',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'id_produktu' => array(
			'id_produktu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_zamowienia' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'ilosc' => array(
			'ilosc',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_zamowienia' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'zwrot' => array(
			'zwrot',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_zamowienia' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}