<?php
namespace Generic\Model\MagazynWydane;
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
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'id_odbiorcy' => array(
			'id_odbiorcy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'obiekt_odbiorcy' => array(
			'obiekt_odbiorcy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'status' => array(
			'status',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'podpis' => array(
			'podpis',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'typ_podpisu' => array(
			'typ_podpisu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'id_osoby_akceptujacej' => array(
			'id_osoby_akceptujacej',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'id_osoby_wydajacej' => array(
			'id_osoby_wydajacej',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'data' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'data_dodania' => array(
			'data',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		'data_wydania' => array(
			'data',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
		),
		
		'opis' => array(
			'opis',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_odbiorcy' => 'ASC',//TODO:
			'obiekt_odbiorcy' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'podpis' => 'ASC',//TODO:
			'typ_podpisu' => 'ASC',//TODO:
			'id_osoby_akceptujacej' => 'ASC',//TODO:
			'id_osoby_wydajacej' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}