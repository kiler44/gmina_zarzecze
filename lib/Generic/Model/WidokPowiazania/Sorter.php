<?php
namespace Generic\Model\WidokPowiazania;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących widoki z układem treści.
 * @author Marek Bar
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	protected $_rodzaje = array(
		'uzytkownik' => array('uzytkownik', 'grupa' => 'ASC', 'akcja' => 'ASC'),
		'grupa' => array('grupa', 'uzytkownik' => 'ASC', 'akcja' => 'ASC'),
		'akcja' => array('akcja', 'uzytkownik' => 'ASC', 'grupa' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'uzytkownik';

}

