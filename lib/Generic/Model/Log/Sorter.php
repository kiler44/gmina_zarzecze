<?php
namespace Generic\Model\Log;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących wiersze logów.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'czas' => array('czas'),
		'zadanie_http' => array('zadanie_http', 'czas'),
		'kod_modulu' => array('kod_modulu', 'zadanie_http', 'czas'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'czas';

}

