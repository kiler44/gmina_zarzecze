<?php
namespace Generic\Model\Blok;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	protected $_rodzaje = array(
		'nazwa' => array('nazwa'),
		'kod_modulu' => array('kod_modulu', 'nazwa' => 'ASC'),
		'kontener' => array('kontener', 'nazwa' => 'ASC'),
		'cache' => array('cache', 'nazwa' => 'ASC'),
		'cache_czas' => array('cache_czas', 'cache' => 'ASC', 'nazwa' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'nazwa';

}

