<?php
namespace Generic\Model\Zalacznik;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idCategory 
 * @property string $file 
 * @property string $dateAdded 
 * @property enum $status
 * @property string $type
 * @property int $idAuthor
 * @property  string $kod
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
		'object' => self::_STRING,
		'idObject' => self::_INTEGER,
		'file' => self::_STRING,
		'dateAdded' => self::_DATETIME,
		'status' => self::_ENUM,
		'type' => self::_STRING,
		'rozmiar' => self::_STRING,
		'opis' => self::_STRING,
		'idAuthor' => self::_INTEGER,
        'kod' => self::_STRING,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'status' => 'active',
        'idProjektu' => ID_PROJEKTU
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'status' => array(
			'active',
			'delete',
		),
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
		'object' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'LiczbaCalkowita',
			),
		),


		'file' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 50,
			),
		),

		'dateAdded' => array(
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
		
		'type' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
		),
	);
}