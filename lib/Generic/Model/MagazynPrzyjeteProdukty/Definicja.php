<?php
namespace Generic\Model\MagazynPrzyjeteProdukty;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: int 
 * @property int $id_projektu 
 * @property int $id_magazyn_przyja 
 * @property int $id_produktu 
 * @property int $ilosc //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: int 
 * @property mixed $stan //TODO: Nieznany typ pola.
 * @property string $opis 
 * @property int $id_magazyn_wydane_produkty //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: int 
 * @property mixed $produkty_grupy //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: mixed Nieznany typ pola.
 * @property int $produkt_z_grupy //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: int 
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
		'idMagazynPrzyja' => self::_INTEGER,
		'idProduktu' => self::_INTEGER,
		'ilosc' => self::_INTEGER,
		'stan' => self::_STRING,
		'opis' => self::_STRING,
		'idMagazynWydaneProdukty' => self::_INTEGER,
		'produktyGrupy' => self::_JSON,
		'produktZGrupy' => self::_INTEGER,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'idProjektu' => ID_PROJEKTU
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'stan' => array(
			'zgubiony',
			'kosz',
			'zniszczone_uzytkownik',
			'uzywany',
			'nowy',
		),

	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
		'idMagazynPrzyja' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'wymagane' => false,//TODO: false - pozostawiono, true - proponowana zmiana
			'walidatory' => array(
					'NiePuste',
					'LiczbaCalkowita',
			),
		),

		'idProduktu' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'wymagane' => false,//TODO: false - pozostawiono, true - proponowana zmiana
			'walidatory' => array(
					'NiePuste',
					'LiczbaCalkowita',
			),
		),

		'ilosc' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'stan' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
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
			),
		),

		'idMagazynWydaneProdukty' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'produktyGrupy' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'produktZGrupy' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

	);
}