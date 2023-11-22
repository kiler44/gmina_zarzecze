<?php
namespace Generic\Model\Widok;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących widoki z układem treści.
 * @author Łukasz Wrucha
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	protected $_rodzaje = array(
		'nazwa' => array('nazwa', 'uklad_strony' => 'ASC'),
		'uklad_strony' => array('uklad_strony', 'nazwa' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'nazwa';

}

