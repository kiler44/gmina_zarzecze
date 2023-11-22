<?php
namespace Generic\Model\RaportEdytowalny;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property string $kod_jezyka 
 * @property string $nazwa 
 * @property string $opis 
 * @property int $grupa 
 * @property string $kod_sql 
 * @property string $nazwy_pol 
 * @property string $uprawnieni_uzytkownicy 
 * @property string $filtry 
 * @property mixed $data_dodania //TODO: Nieznany typ pola.
 * @property int $cache 
 * @property mixed $data_modyfikacji //TODO: Nieznany typ pola.
 * @property int $zezwol_zaawansowany 
 * @property string $typ_wykresu 
 * @property string $kolumny_wykresu 
 * @property string $typy_kolumn_tabeli 
 * @property string $kolumna_wykresu_daty 
 * @property int $typ_wykresu_modyfikowalny 
 * @property string $sub_zapytania 
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
		'nazwa' => self::_STRING,
		'opis' => self::_STRING,
		'grupa' => self::_INTEGER,
		'kodSql' => self::_STRING,
		'nazwyPol' => self::_ARRAY,
		'uprawnieniUzytkownicy' => self::_LIST,
		'filtry' => self::_ARRAY,
		'dataDodania' => self::_STRING,
		'dataModyfikacji' => self::_STRING,
		'cache' => self::_INTEGER,
		'zezwolZaawansowany' => self::_BOOLEAN,
		'typWykresu' => self::_STRING,
		'kolumnyWykresu' => self::_LIST,
		'typyKolumnTabeli' => self::_ARRAY,
		'kolumnaWykresuDaty' =>  self::_STRING,
		'typWykresuModyfikowalny' => self::_BOOLEAN,
		'subZapytania' => self::_ARRAY,
		'filtryPoczatkowe' => self::_ARRAY,
		'filtryPoczatkoweWartosci' => self::_ARRAY,
		'filtryPoczatkoweEtykiety' => self::_ARRAY,
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
					'KrotszeOd' => 255,
			),
		),

		'opis' => array(
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

		'grupa' => array(
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

		'kodSql' => array(
			'input' => 'KodPocztowy',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'KodPocztowy',
					'NiePuste',
			),
		),

		'nazwyPol' => array(
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

		'uprawnieniUzytkownicy' => array(
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

		'filtry' => array(
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

		'dataDodania' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

		'cache' => array(
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

		'dataModyfikacji' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

		'zezwolZaawansowany' => array(
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

		'typWykresu' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 32,
			),
		),

		'kolumnyWykresu' => array(
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

		'typyKolumnTabeli' => array(
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

		'kolumnaWykresuDaty' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 120,
			),
		),

		'typWykresuModyfikowalny' => array(
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

		'subZapytania' => array(
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

	);
}