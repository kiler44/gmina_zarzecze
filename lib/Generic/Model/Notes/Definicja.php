<?php
namespace Generic\Model\Notes;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property string $object 
 * @property int $id_object 
 * @property string $description 
 * @property mixed $data_added 
 * @property mixed $status 
 * @property int $author 

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
		'description' => self::_STRING,
		'dataAdded' => self::_STRING,
		'status' => self::_STRING,
		'author' => self::_STRING,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'status' => 'active',
		'idProjektu' => ID_PROJEKTU,
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
	public $formularz = array(
		'object' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 126,
			),
		),

		'idObject' => array(
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

		'description' => array(
			'input' => 'TextArea',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
				'strip_tags',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

		'dataAdded' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

		'status' => array(
			'input' => 'Select',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'DozwoloneWartosci' => array('active','delete',),
			),
		),

	);
}