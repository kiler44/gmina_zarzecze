<?php
namespace Generic\Model\RoleUprawnieniaEvents;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_roli 
 * @property string $szablon_eventu 
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
		'idRoli' => self::_INTEGER,
		'szablonEventu' => self::_STRING,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'idProjektu' => ID_PROJEKTU,
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
		'idRoli' => array(
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

		'szablonEventu' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 100,
			),
		),

	);
}