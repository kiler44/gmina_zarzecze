<?php
namespace Generic\Model\MagazynWydane;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_odbiorcy 
 * @property string $obiekt_odbiorcy 
 * @property mixed $status //TODO: Nieznany typ pola.
 * @property string $podpis 
 * @property mixed $typ_podpisu //TODO: Nieznany typ pola.
 * @property int $id_osoby_akceptujacej 
 * @property int $id_osoby_wydajacej 
 * @property mixed $data //TODO: Nieznany typ pola.
 * @property string $opis 
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
		'idOdbiorcy' => self::_INTEGER,
		'obiektOdbiorcy' => self::_STRING,
		'status' => self::_STRING,
		'podpis' => self::_STRING,
		'typPodpisu' => self::_STRING,
		'idOsobyAkceptujacej' => self::_INTEGER,
		'idOsobyWydajacej' => self::_INTEGER,
		'dataDodania' => self::_DATETIME,
		'dataWydania' => self::_DATETIME,
		'opis' => self::_STRING,
		'podpisVector' => self::_STRING,
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
		'status' => array(
			'zaakceptowane',
			'anulowane',
			'oczekuje',
			'wydane',
		),

		'typ_podpisu' => array(
			'reczny',
			'haslo',
		),

	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
		'idOdbiorcy' => array(
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

		'obiektOdbiorcy' => array(
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

		'status' => array(
			'input' => 'Select',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'DozwoloneWartosci' => array('zaakceptowane','anulowane','oczekuje',),
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

		'typPodpisu' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
			),
		),

		'idOsobyAkceptujacej' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'idOsobyWydajacej' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'data' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
					'PeselDataUrodzenia',
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

	);
}