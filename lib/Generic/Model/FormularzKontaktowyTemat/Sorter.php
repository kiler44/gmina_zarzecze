<?php
namespace Generic\Model\FormularzKontaktowyTemat;
use Generic\Biblioteka;


/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących tematy formularza kontaktowego.
 * @author Łukasz Wrucha
 * @package dane
 */
class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
		'temat' => array('temat', 'email' => 'ASC'),
		'email' => array('email', 'temat' => 'ASC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'temat';

}

