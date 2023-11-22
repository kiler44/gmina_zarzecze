<?php
namespace Generic\Model\ZadanieCykliczne;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących zadania cykliczne.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter {

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'id_kategorii' => array('id_kategorii', 'kod_modulu' => 'ASC', 'data_rozpoczecia' => 'ASC', 'data_zakonczenia' => 'ASC'),
		'kod_modulu' => array('kod_modulu', 'id_kategorii' => 'ASC', 'data_rozpoczecia' => 'ASC', 'data_zakonczenia' => 'ASC'),
		'data_rozpoczecia' => array('data_rozpoczecia', 'data_zakonczenia' => 'ASC', 'kod_modulu' => 'ASC', 'id_kategorii' => 'ASC'),
		'data_zakonczenia' => array('data_zakonczenia', 'data_rozpoczecia' => 'ASC', 'kod_modulu' => 'ASC', 'id_kategorii' => 'ASC'),
		'aktywne' => array('aktywne', 'data_rozpoczecia' => 'ASC', 'data_zakonczenia' => 'ASC', 'kod_modulu' => 'ASC', 'id_kategorii' => 'ASC'),
		'dodawane_wielokrotnie' => array('dodawane_wielokrotnie', 'data_rozpoczecia' => 'ASC', 'data_zakonczenia' => 'ASC', 'kod_modulu' => 'ASC', 'id_kategorii' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_rozpoczecia';

}


