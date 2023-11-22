<?php
namespace Generic\Model\Reports;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property string $obiekt 
 * @property string $id_obiektow 
 * @property string $kategoria 
 * @property mixed $data_od  
 * @property mixed $data_do 
 * @property int $autor 
 * @property mixed $data_dodania
 * @property mixed $data_modyfikacji  
 * @property bool $wyslany 
 * @property string $status
 * @property string $additionalData
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
		'obiekt' => self::_STRING,
		'idObiektow' => self::_STRING,
		'kategoria' => self::_STRING,
		'dataOd' => self::_STRING,
		'dataDo' => self::_STRING,
		'autor' => self::_INTEGER,
		'dataDodania' => self::_STRING,
		'dataModyfikacji' => self::_STRING,
		'wyslany' => self::_BOOLEAN,
		'status' => self::_ENUM,
		'typZamowien' => self::_INTEGER,
		'nettoPrice' => self::_DOUBLE,
		'bruttoPrice' => self::_DOUBLE,
		'zafakturowano' => self::_BOOLEAN,
		'wyslanyDoFakturowania' => self::_BOOLEAN,
		'additionalData' => self::_ARRAY,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'status' => 'active',
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'status' => array('active', 'delete'),
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
		'obiekt' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 128,
			),
		),

		'idObiektow' => array(
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

		'kategoria' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 128,
			),
		),

		'dataOd' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'dataDo' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'autor' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'dataDodania' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'dataModyfikacji' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'wyslany' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'walidatory' => array(
			),
		),

	);
}