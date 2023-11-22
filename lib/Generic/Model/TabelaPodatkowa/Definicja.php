<?php
namespace Generic\Model\TabelaPodatkowa;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $id_projektu
 * @property string $nr_tabeli
 * @property int $rok
 * @property int $kwota_od
 * @property int $kwota_do
 * @property int $podatek
 * @property string $rodzaj
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
		'nrTabeli' => self::_STRING,
		'rok' => self::_INTEGER,
		'kwotaOd' => self::_INTEGER,
		'kwotaDo' => self::_INTEGER,
		'podatek' => self::_INTEGER,
		'rodzaj' => self::_ENUM,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'kwotaOd' => '0',
		'kwotaDo' => '0',
		'podatek' => '0',
		'rodzaj' => 'kwotowy',
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'rodzaj' => array(
			'kwotowy',
			'procentowy',
		),

	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
		'nr_tabeli' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 4,
			),
		),

		'rok' => array(
			'input' => 'Data',
			'filtry' => array(
				'intval',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'LiczbaCalkowita',
			),
		),

		'kwota_od' => array(
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

		'kwota_do' => array(
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

		'podatek' => array(
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

		'rodzaj' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'DozwoloneWartosci' => array('kwotowy','procentowy',),
			),
		),

	);
}