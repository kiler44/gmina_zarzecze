<?php
namespace Generic\Model\TabelaPodatkowa;
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
		
		'nr_tabeli' => array(
			'nr_tabeli',
			'rok' => 'DESC',
			'podatek' => 'ASC',
			'kwota_od' => 'ASC',
			'kwota_do' => 'ASC',
		),
		
		'rok' => array(
			'rok',
			'podatek' => 'ASC',
			'nr_tabeli' => 'ASC',
			'kwota_od' => 'ASC',
			'kwota_do' => 'ASC',
		),
		
		'kwota_od' => array(
			'kwota_od',
			'rok' => 'DESC',
			'nr_tabeli' => 'ASC',
			'kwota_do' => 'ASC',
			'podatek' => 'ASC',
		),
		
		'kwota_do' => array(
			'kwota_do',
			'rok' => 'DESC',
			'nr_tabeli' => 'ASC',
			'kwota_od' => 'ASC',
			'podatek' => 'ASC',
		),
		
		'podatek' => array(
			'podatek',
			'rok' => 'DESC',
			'nr_tabeli' => 'ASC',
			'kwota_od' => 'ASC',
			'kwota_do' => 'ASC',
		),
		
	);



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'nr_tabeli';
}