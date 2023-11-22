<?php
namespace Generic\Model\Rola;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących role użytkowników.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	protected $_rodzaje = array(
		'kod' => array('kod'),
		'nazwa' => array('nazwa', 'kod' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'nazwa';

}

