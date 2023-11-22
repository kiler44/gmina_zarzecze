<?php
namespace Generic\Model\Projekt;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących projekty.
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
		'domena' => array('domena', 'nazwa' => 'ASC', 'kod' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'nazwa';

}