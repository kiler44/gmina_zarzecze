<?php
namespace Generic\Model\CennikMiejscowosci;
use Generic\Biblioteka;

/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących.
 */
class Sorter extends Biblioteka\Sorter
{
	/**
	* Tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny.
	* Porzadek sortowania jest dodawany tylko do pierwszej kolumny.
	* @var array
	*/
	public $_rodzaje = array(
		'cena' => array(
			'cena',
		),
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'cena';
}