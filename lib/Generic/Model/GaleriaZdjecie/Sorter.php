<?php
namespace Generic\Model\GaleriaZdjecie;
use Generic\Biblioteka;

class Sorter extends Biblioteka\Sorter
{

	// tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny
	// porzadek sortowania jest dodawany tylko do pierwszej kolumny
	public $_rodzaje = array(
	'nazwa' => array('nazwa', 'data_dodania' => 'DESC', 'autor' => 'ASC'),
	'data_dodania' => array('data_dodania', 'nazwa' => 'ASC', 'autor' => 'ASC'),
	'autor' => array('autor', 'nazwa' => 'ASC', 'data_dodania' => 'DESC'),
	'pozycja' => array('pozycja', 'tytul' => 'ASC', 'data_dodania' => 'DESC'),
	);

	// domyslny rodzaj sortowania
	protected $_domyslne = 'nazwa';
}


