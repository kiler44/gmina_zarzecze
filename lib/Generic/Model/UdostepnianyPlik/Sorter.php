<?php
namespace Generic\Model\UdostepnianyPlik;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących pliki udostępniane.
 * @author Krzysztof Lesiczka, Dariusz Póltorak
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'tytul' => array('tytul','data_dodania' => 'DESC', 'autor' => 'ASC'),
		'autor' => array('autor', 'tytul' => 'ASC', 'data_dodania' => 'DESC'),
		'data_dodania' => array('data_dodania', 'tytul' => 'ASC', 'autor' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_dodania';
}
