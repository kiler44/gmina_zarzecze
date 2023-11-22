<?php
namespace Generic\Model\KategorieMagazyn;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $prawy 
 * @property int $lewy 
 * @property int $poziom 
 * @property string $nazwa 
 * @property string $kategoria_glowna 
 * @property bool $blokuj_wyswietlanie 
 * @property bool $blokuj_przypisywanie 
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
		'prawy' => self::_INTEGER,
		'lewy' => self::_INTEGER,
		'kod' => self::_STRING, 
		'poziom' => self::_INTEGER,
		'nazwa' => self::_STRING,
		'kategoriaGlowna' => self::_STRING,
		'blokujWyswietlanie' => self::_INTEGER,
		'blokujPrzypisywanie' => self::_INTEGER,
		'idRodzica' => self::_INTEGER,
		'opiekun' => self::_INTEGER,
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
		'prawy' => array(
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

		'lewy' => array(
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

		'poziom' => array(
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

		'nazwa' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 700,
			),
		),

		'kategoriaGlowna' => array(
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

		'blokujWyswietlanie' => array(
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

		'blokujPrzypisywanie' => array(
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