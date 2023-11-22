<?php
namespace Generic\Model\RaportyExcelDane;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_order 
 * @property int $id_team 
 * @property string $data
 * @property string $fromAddress
 * @property string $toAddress
 * @property double $kilometry 
 * @property double $minutyJazdy 
 * @property double $minutyJazdyTraffik
 * @property string $dayOfSimulation
 * @property string $hourOfSimulation
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
		'idOrder' => self::_INTEGER,
		'idTeam' => self::_INTEGER,
		'data' => self::_STRING,
		'fromAddress' => self::_STRING,
		'toAddress' => self::_STRING,
		'kilometry' => self::_DOUBLE,
		'minutyJazdy' => self::_DOUBLE,
		'minutyJazdyTraffik' => self::_DOUBLE,
		'dayOfSimulation' => self::_STRING,
		'hourOfSimulation' =>  self::_STRING,
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
		'idOrder' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'idTeam' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'data' => array(
			'input' => 'Data',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'PeselDataUrodzenia',
			),
		),

		'kilometry' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

		'minutyJazdy' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

	);
}