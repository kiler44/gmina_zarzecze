<?php
namespace Generic\Model\DostepnyModul;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących moduły cms-a.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'nazwa' => array('nazwa'),
		'typ' => array('typ', 'nazwa' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'nazwa';

}

