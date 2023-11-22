<?php
namespace Generic\Model\PlatnoscHistoria;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących wiersze historii dla płatności.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'data_dodania' => array('data_dodania'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_dodania';
}
