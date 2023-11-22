<?php
namespace Generic\Model\ProduktyMagazyn;
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
			'kategoria' => 'ASC',//TODO:
			'kod' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'ilosc_wydanych' => 'ASC',//TODO:
			'wyswietlaj' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'kod' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'ilosc_wydanych' => 'ASC',//TODO:
			'wyswietlaj' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'kategoria' => array(
			'kategoria',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kod' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'ilosc_wydanych' => 'ASC',//TODO:
			'wyswietlaj' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'kod' => array(
			'kod',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'ilosc_wydanych' => 'ASC',//TODO:
			'wyswietlaj' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'nazwa_produktu' => array(
			'nazwa_produktu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',
		),
		
		'ilosc' => array(
			'ilosc',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'kod' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc_wydanych' => 'ASC',//TODO:
			'wyswietlaj' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'ilosc_wydanych' => array(
			'ilosc_wydanych',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'kod' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'wyswietlaj' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'wyswietlaj' => array(
			'wyswietlaj',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'kod' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'ilosc_wydanych' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
		),
		
		'status' => array(
			'status',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'kategoria' => 'ASC',//TODO:
			'kod' => 'ASC',//TODO:
			'nazwa_produktu' => 'ASC',//TODO:
			'ilosc' => 'ASC',//TODO:
			'ilosc_wydanych' => 'ASC',//TODO:
			'wyswietlaj' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}