<?php
namespace Generic\Model\EventMetody;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_event 
 * @property string $akcja 
 * @property string $opis 
 * @property mixed $data_wykonania //TODO: Nieznany typ pola.
 * @property mixed $dane_wejsciowe //TODO: Nieznany typ pola.
 * @property mixed $dane_wyjsciowe //TODO: Nieznany typ pola.
 * @property string $id_wymagane 
 * @property string $konfiguracja_szablon 
 * @property string $konfiguracja 
 * @property string $kod
 * @property string $szablon
 * @property bool $wykonany
 * @property string $errors
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
		'idEvent' => self::_INTEGER,
		'akcja' => self::_STRING,
		'opis' => self::_STRING,
		'dataWykonania' => self::_DATETIME,
		'daneWejsciowe' => self::_JSON,
		'daneWyjsciowe' => self::_JSON,
		'idWymagane' => self::_STRING,
		'konfiguracjaSzablon' => self::_ARRAY,
		'konfiguracja' => self::_JSON,
		'kod' => self::_INTEGER,
		'szablon' => self::_STRING,
		'wykonany' => self::_BOOLEAN,
		'errors' =>  self::_ARRAY,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'idProjektu' => ID_PROJEKTU,
		'wykonany' => false,
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
		'idEvent' => array(
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

		'akcja' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 300,
			),
		),

		'opis' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 1000,
			),
		),

		'dataWykonania' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'daneWejsciowe' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'daneWyjsciowe' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),
		'errors' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),
		'idWymagane' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'konfiguracjaSzablon' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'konfiguracja' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

	);
}