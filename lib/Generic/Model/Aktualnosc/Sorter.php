<?php
namespace Generic\Model\Aktualnosc;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących aktualności.
 *
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	public $_rodzaje = array(
		'tytul' => array('tytul','data_dodania' => 'DESC', 'autor' => 'ASC'),
		'autor' => array('autor', 'tytul' => 'ASC', 'data_dodania' => 'DESC'),
		'data_dodania' => array('data_dodania', 'tytul' => 'ASC', 'autor' => 'ASC'),
        'data_waznosci' => array('data_waznosci', 'tytul' => 'ASC', 'autor' => 'ASC'),
		'priorytetowa' => array('priorytetowa', 'data_dodania' => 'DESC', 'tytul' => 'ASC', 'autor' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_dodania';
}
