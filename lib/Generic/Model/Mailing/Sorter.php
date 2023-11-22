<?php
namespace Generic\Model\Mailing;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących dokumenty.
 * @author Konrad Rudowski
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'tytul' => array('tytul', 'data_dodania' => 'DESC'),
		'nazwa' => array('nazwa', 'data_dodania' => 'DESC'),
		'data_dodania' => array('data_dodania', 'tytul' => 'ASC'),
		'data_wysylki' => array('data_wysylki', 'tytul' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_dodania';
}
