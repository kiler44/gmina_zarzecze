<?php
namespace Generic\Model\EmailWpisKolejki;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących wpisy kolejki email.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'email_tytul' => array('email_tytul', 'data_dodania' => 'DESC'),
		'data_dodania' => array('data_dodania', 'email_tytul' => 'ASC'),
		'bledy' => array('bledy_licznik', 'data_dodania' => 'DESC'),
		'typ_wysylania' => array('typ_wysylania', 'data_dodania' => 'DESC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_dodania';

}

