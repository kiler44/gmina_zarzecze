<?php
namespace Generic\Model\Obserwator;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących wiersze obserwatorow.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'id' => array('id'),
	//	'zadanie_http' => array('zadanie_http', 'czas'),
	//	'kod_modulu' => array('kod_modulu', 'zadanie_http', 'czas'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'id';

}

