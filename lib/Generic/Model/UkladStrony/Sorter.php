<?php
namespace Generic\Model\UkladStrony;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących układów stron(z regionami).
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'nazwa' => array('nazwa'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'nazwa';

}

