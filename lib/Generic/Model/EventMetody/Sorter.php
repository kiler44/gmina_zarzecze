<?php
namespace Generic\Model\EventMetody;
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
			'id_event' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
		),
		'id_event' => array(
			'id_event',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
		),
		
		'akcja' => array(
			'akcja',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
		),
		
		'opis' => array(
			'opis',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
		),
		
		'data_wykonania' => array(
			'data_wykonania',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
		),
		'mem_data_wykonania' => array(
			'mem.data_wykonania',
		),
		'dane_wejsciowe' => array(
			'dane_wejsciowe',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'dane_wyjsciowe' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
			'konfiguracja' => 'ASC',//TODO:
		),
		
		'dane_wyjsciowe' => array(
			'dane_wyjsciowe',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'dane_wejsciowe' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
			'konfiguracja' => 'ASC',//TODO:
		),
		
		'id_wymagane' => array(
			'id_wymagane',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'dane_wejsciowe' => 'ASC',//TODO:
			'dane_wyjsciowe' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
			'konfiguracja' => 'ASC',//TODO:
		),
		
		'konfiguracja_szablon' => array(
			'konfiguracja_szablon',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'dane_wejsciowe' => 'ASC',//TODO:
			'dane_wyjsciowe' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
			'konfiguracja' => 'ASC',//TODO:
		),
		
		'konfiguracja' => array(
			'konfiguracja',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_event' => 'ASC',//TODO:
			'akcja' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'data_wykonania' => 'ASC',//TODO:
			'dane_wejsciowe' => 'ASC',//TODO:
			'dane_wyjsciowe' => 'ASC',//TODO:
			'id_wymagane' => 'ASC',//TODO:
			'konfiguracja_szablon' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}