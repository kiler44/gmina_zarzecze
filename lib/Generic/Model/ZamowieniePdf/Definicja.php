<?php
namespace Generic\Model\ZamowieniePdf;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property mixed $data //TODO: Nieznany typ pola.
 * @property string $godzina 
 * @property string $id_pdf 
 * @property string $data_wygenerowania 
 * @property string $data_dostarczenia 
 * @property int $id_zamowienie_projekt 
 * @property int $druga_tura_apartament
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{



	/**
	* Przetrzymuje typy pól w bazie.
	* @var array
	*/
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'idProjektu' => self::_INTEGER,
		'data' => self::_STRING,
		'godzina' => self::_STRING,
		'idPdf' => self::_STRING,
		'dataWygenerowania' => self::_STRING,
		'dataDostarczenia' => self::_STRING,
		'idZamowienieProjekt' => self::_INTEGER,
		'drugaTuraApartament' => self::_INTEGER,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
		'data' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'PeselDataUrodzenia',
			),
		),

		'godzina' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 20,
			),
		),

		'idPdf' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

	);
}