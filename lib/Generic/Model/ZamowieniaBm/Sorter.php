<?php
namespace Generic\Model\ZamowieniaBm;
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
	    'data_dodania' => array('data_dodania'),
        'rodzaj' => array(
            'rodzaj',
        ),
        'termin' => array(
            'termin',
        ),
		'id' => array(
			'id',
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'id_klienta' => array(
			'id_klienta',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'model' => array(
			'model',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'id_model' => array(
			'id_model',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'zloto' => array(
			'zloto',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'platyna' => array(
			'platyna',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'srebro' => array(
			'srebro',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'kamienie' => array(
			'kamienie',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'cena' => array(
			'cena',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'grawer' => array(
			'grawer',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'rabat' => array(
			'rabat',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'opis' => array(
			'opis',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'status' => array(
			'status',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'autor' => array(
			'autor',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'wykonawca' => 'ASC',//TODO:
		),
		
		'wykonawca' => array(
			'wykonawca',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'id_klienta' => 'ASC',//TODO:
			'model' => 'ASC',//TODO:
			'id_model' => 'ASC',//TODO:
			'zloto' => 'ASC',//TODO:
			'platyna' => 'ASC',//TODO:
			'srebro' => 'ASC',//TODO:
			'kamienie' => 'ASC',//TODO:
			'cena' => 'ASC',//TODO:
			'grawer' => 'ASC',//TODO:
			'rabat' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'autor' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}