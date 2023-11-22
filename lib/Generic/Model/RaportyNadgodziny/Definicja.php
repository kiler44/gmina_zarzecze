<?php
namespace Generic\Model\RaportyNadgodziny;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_user 
 * @property string $data 
 * @property double $godziny 
 * @property double $nadgodziny
 * @property double $pauza
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
		'idUser' => self::_INTEGER,
		'idTeam' => self::_INTEGER,
		'data' => self::_STRING,
		'godziny' => self::_DOUBLE,
		'nadgodziny' => self::_DOUBLE,
		'pauza' => self::_DOUBLE,
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
		'idUser' => array(
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

		'godziny' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

		'nadgodziny' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

		'pauza' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),
	);
}