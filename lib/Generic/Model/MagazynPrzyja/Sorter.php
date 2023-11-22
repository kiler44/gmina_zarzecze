<?php
namespace Generic\Model\MagazynPrzyja;
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
		'id' => array(
			'id',
			'id_projektu' => 'ASC',//TODO:
			'id_oddajacego' => 'ASC',//TODO:
			'id_przyjmujacego' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'podpis_vector' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_oddajacego' => 'ASC',//TODO:
			'id_przyjmujacego' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'podpis_vector' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'id_oddajacego' => array(
			'id_oddajacego',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_przyjmujacego' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'podpis_vector' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'id_przyjmujacego' => array(
			'id_przyjmujacego',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_oddajacego' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'podpis_vector' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'data_dodania' => array(
			'data_dodania',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_oddajacego' => 'ASC',//TODO:
			'id_przyjmujacego' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'podpis_vector' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'podpis' => array(
			'podpis',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_oddajacego' => 'ASC',//TODO:
			'id_przyjmujacego' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'podpis_vector' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'podpis_vector' => array(
			'podpis_vector',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_oddajacego' => 'ASC',//TODO:
			'id_przyjmujacego' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'zwrot' => 'ASC',//TODO:
		),
		
		'zwrot' => array(
			'zwrot',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_oddajacego' => 'ASC',//TODO:
			'id_przyjmujacego' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'podpis_vector' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}