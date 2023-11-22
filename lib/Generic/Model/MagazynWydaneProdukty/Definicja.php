<?php
namespace Generic\Model\MagazynWydaneProdukty;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: int 
 * @property int $id_projektu 
 * @property int $id_zamowienia 
 * @property int $id_produktu 
 * @property int $ilosc //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: int 
 * @property int $zwrot //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: int 
 * @property bool $grupa //TODO: Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: bool 
 * @property mixed $produkty_grupy //TODO: Nieznany typ pola.
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
		'idZamowienia' => self::_INTEGER,
		'idProduktu' => self::_INTEGER,
		'ilosc' => self::_INTEGER,
		'zwrot' => self::_INTEGER,
		'grupa' => self::_BOOLEAN,
		'produktyGrupy' => self::_JSON,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'ilosc' => 1,
		'idProjektu' => ID_PROJEKTU,
		'zwrot' => 0,
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
		'idZamowienia' => array(
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
			'wymagane' => false,//TODO: false - pozostawiono, true - proponowana zmiana
			'walidatory' => array(
					'NiePuste',
					'LiczbaCalkowita',
			),
		),

		'zwrot' => array(
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
			'wymagane' => false,//TODO: false - pozostawiono, true - proponowana zmiana
			'walidatory' => array(
					'NiePuste',
			),
		),

		'produktyGrupy' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

	);
}