<?php
namespace Generic\Model\MagazynPrzyjeteProdukty;
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
			'id_magazyn_przyja' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'stan' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_magazyn_przyja' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'stan' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'id_magazyn_przyja' => array(
			'id_magazyn_przyja',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'stan' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'id_produktu' => array(
			'id_produktu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_magazyn_przyja' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'stan' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'ilosc' => array(
			'ilosc',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_magazyn_przyja' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'stan' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'stan' => array(
			'stan',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_magazyn_przyja' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'opis' => array(
			'opis',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_magazyn_przyja' => 'ASC',//TODO:
			'id_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'stan' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}