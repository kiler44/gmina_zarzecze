<?php
namespace Generic\Model\StawkaUzytkownika;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_uzytkownika 
 * @property double $stawka 
 * @property mixed $data_start //TODO: Nieznany typ pola.
 * @property mixed $data_stop //TODO: Nieznany typ pola.
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
		'idUzytkownika' => self::_INTEGER,
		'stawka' => self::_DOUBLE,
		'dataStart' => self::_DATETIME,//TODO: Poprawić nierozpoznany typ pola
		'dataStop' => self::_DATETIME,//TODO: Poprawić nierozpoznany typ pola
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
		'idUzytkownika' => array(
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

		'stawka' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'LiczbaZmiennoprzecinkowa',
			),
		),

		'dataStart' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

		'dataStop' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

	);
}