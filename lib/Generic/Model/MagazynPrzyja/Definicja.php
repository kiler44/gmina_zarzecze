<?php
namespace Generic\Model\MagazynPrzyja;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_oddajacego 
 * @property int $id_przyjmujacego 
 * @property string $data_dodania 
 * @property string $podpis 
 * @property string $podpis_vector 
 * @property bool $zwrot 
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
		'idOddajacego' => self::_INTEGER,
		'idPrzyjmujacego' => self::_INTEGER,
		'dataDodania' => self::_DATETIME,
		'podpis' => self::_STRING,
		'podpisVector' => self::_STRING,
		'obiektOddajacy' => self::_STRING,
		'idOsobyAkceptujacej' => self::_STRING,
		'zwrot' => self::_BOOLEAN,
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
		'idOddajacego' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'idPrzyjmujacego' => array(
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

		'dataDodania' => array(
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

		'podpis' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'podpisVector' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'zwrot' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

	);
}