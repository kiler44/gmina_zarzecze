<?php
namespace Generic\Model\FormularzKontaktowyWiadomosc;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących wiadomości z formularza kontaktowego.
 * @author Łukasz Wrucha
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'data_wyslania' => array('data_wyslania', 'email' => 'ASC'),
		'email' => array('email', 'data_wyslania' => 'DESC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'data_wyslania';

}

