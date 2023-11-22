<?php
namespace Generic\Model\EmailSzablon;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących szablony wiadomości email.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'id' => array('id'),
		'nazwa' => array('nazwa'),
		'aktywny' => array('aktywny'),
	);


	// domyslny rodzaj sortowania
	protected $_domyslne = 'id';

}

