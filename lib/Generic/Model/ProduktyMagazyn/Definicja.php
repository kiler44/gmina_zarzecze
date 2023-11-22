<?php
namespace Generic\Model\ProduktyMagazyn;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $id_projektu 
 * @property int $kategoria 
 * @property string $kod 
 * @property string $nazwa_produktu 
 * @property int $ilosc  
 * @property int $ilosc_wydanych 
 * @property bool $wyswietlaj  
 * @property mixed $status  
 * @property string $zdjecie
 * @property bool $grupa
 * @property string $produktyGrupy
 * @property string $atrybuty
 * @property float $cena
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
		'kategoria' => self::_INTEGER,
		'kod' => self::_STRING,
		'nazwaProduktu' => self::_STRING,
		'ilosc' => self::_INTEGER,
		'iloscWydanych' => self::_INTEGER,
		'wyswietlaj' => self::_BOOLEAN,
		'status' => self::_STRING,
		'zdjecie' => self::_STRING,
		'grupa' => self::_BOOLEAN,
		'produktyGrupy' => self::_JSON,
		'atrybuty' => self::_ARRAY,
		'idOsobyDodajacej' => self::_INTEGER,
		'opis' => self::_STRING,
		'cena' => self::_FLOAT,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'status' => 'active',
		'idProjektu' => ID_PROJEKTU,
		'grupa' => false,
		'wyswietlaj' => false,
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'status' => array(
			'delete',
			'active',
		),

	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $formularz = array(
		'kategoria' => array(
			'input' => 'SelectDrzewo2',
			'filtry' => array(
				'intval',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'LiczbaCalkowita',
			),
			'parametry' => array(
				'cfg' => array(
						'empty_value' => 0,
						'select_class' => 'selectDrzewo',
						'rozmiar' => 8,
					),
			),
		),

		'kod' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
		),

		'nazwaProduktu' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 1000,
			),
		),
		'cena' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => false,
		),
		'opis' => array(
			'input' => 'TextArea',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => false,
		),
		/*
		'atrybuty' => array(
			'input' => 'Atrybuty',
			'filtry' => array(
			),
			'wymagane' => false,
		),

		'ilosc' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'grupa' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'wymagane' => false,
		),
		'produktyGrupy' => array(
			'input' => 'SelectProduktyMagazyn',
			'filtry' => array(
				'intval',
				'abs',
			),
			'wymagane' => false,
		),
		'iloscWydanych' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'wyswietlaj' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'wymagane' => false,
			'walidatory' => array(
					'NiePuste',
			),
		),
		*/


		'status' => array(
			'input' => 'Select',
			'filtry' => array(
			),
			'wymagane' => false,
			'walidatory' => array(
					'DozwoloneWartosci' => array('delete','active',),
			),
		),
		'zdjecie' => array(
			'input' => 'ZdjecieCropowane',
			'filtry' => array(
			),
			'wymagane' => false,
			'walidatory' => array(
					
			),
		),

	);
	
	public function lista_status()
	{
		return array('active' => 'active', 'delete' => 'delete');
	}
}