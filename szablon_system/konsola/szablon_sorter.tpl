<?php
namespace Generic\Model\{{NAZWA}};
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
{{BEGIN RODZAJE_SORTOWANIA}}
		'{{RODZAJ_SORTOWANIA}}' => array(
			'{{RODZAJ_SORTOWANIA}}',
		{{BEGIN FILTRY}}
			'{{FILTR}}' => '{{WARTOSC}}',{{KOMENTARZ}}
		{{END}}
		),{{KOMENTARZ}}
		
{{END}}
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = '{{DOMYSLNY_RODZAJ_SORTOWANIA}}';
}