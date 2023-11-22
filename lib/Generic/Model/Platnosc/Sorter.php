<?php
namespace Generic\Model\Platnosc;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących płatności.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'status' => array('status', 'data_dodania' => 'DESC', 'kwota' => 'DESC'),
		'kwota' => array('kwota', 'status' => 'DESC', 'data_dodania' => 'DESC'),
		'opis' => array('opis', 'opis' => 'DESC', 'data_dodania' => 'DESC'),
		'data_dodania' => array('data_dodania', 'status' => 'desc', 'kwota' => 'DESC'),
		'typ_platnosci' => array('typ_platnosci', 'status' => 'DESC', 'data_dodania' => 'DESC', 'kwota' => 'DESC'),
		'obiekt' => array('nazwa_modulu', 'typ_obiektu', 'data_dodania' => 'DESC', 'kwota' => 'DESC'),
		'nazwisko' => array('nazwisko', 'data_dodania' => 'DESC', 'kwota' => 'DESC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_dodania';
}
