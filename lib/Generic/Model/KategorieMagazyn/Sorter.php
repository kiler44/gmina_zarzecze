<?php
namespace Generic\Model\KategorieMagazyn;
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
			'prawy' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'prawy' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'prawy' => array(
			'prawy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'lewy' => array(
			'lewy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'prawy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'poziom' => array(
			'poziom',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'prawy' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'nazwa' => array(
			'nazwa',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'prawy' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'kategoria_glowna' => array(
			'kategoria_glowna',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'prawy' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'blokuj_wyswietlanie' => array(
			'blokuj_wyswietlanie',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'prawy' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_przypisywanie' => 'ASC',//TODO:
		),
		
		'blokuj_przypisywanie' => array(
			'blokuj_przypisywanie',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'prawy' => 'ASC',//TODO:
			'lewy' => 'ASC',//TODO:
			'poziom' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'kategoria_glowna' => 'ASC',//TODO:
			'blokuj_wyswietlanie' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}