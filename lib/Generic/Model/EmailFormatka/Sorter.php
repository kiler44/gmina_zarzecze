<?php
namespace Generic\Model\EmailFormatka;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących formatki wiadomości email.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'tytul' => array('tytul', 'data_dodania' => 'DESC'),
		'data_dodania' => array('data_dodania', 'tytul' => 'ASC'),
		'kategoria' => array('kategoria', 'tytul' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_dodania';

}


