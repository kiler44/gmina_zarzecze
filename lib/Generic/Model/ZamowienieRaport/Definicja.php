<?php
namespace Generic\Model\ZamowienieRaport;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idParent 
 * @property int $idTeam 
 * @property string $type 
 * @property int $numberOrderGet 
 * @property int $numberOrderBkt 
 * @property int $numberCustomer 
 * @property int $numberPrivatCustomer
 * @property string $numberProjectGet
 * @property int $numberContactId 
 * @property string $chargeType
 * @property string $dateAdded
 * @property string $hoursInterval 
 * @property string $dateStart 
 * @property string $dateStop
 * @property float $totalTime 
 * @property string $status
 * @property string $statusWork
 * @property string $address 
 * @property string $city 
 * @property string $postcode
 * @property float $locationLat
 * @property float $locationLng
 * @property float $budget
 * @property string $nodeVillaCode
 * @property string $attributes
 * @property string $jobDescription
 * @property string $orderName
 * @property bool $isReclamation
 * @property int $idCoordinator
 * @property int position
 * @property bool sprawdzony
 * @property bool wyslano_do_raportu
 * @property int id_notatki_do_raportu
 * @property string data_zakonczenia
 * @property int idUserZamknijZamowienie
 * @property string kategoria
 * @property bool $notCharge
 * @property bool $blokadaEdycji
 * @property bool $blokadaPoprawiania
 * @property bool $wyslanyDoFakturowania
 * @property bool $zafakturowano
 * @property string $apartment
 * @property string $additionalData
 * @property string $idPdf
 * @property int $idUserPrzydzielApartamenty
 * @property int $drugaTuraApartament
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{
	/**
	* Przetrzymuje typy pól obiektu.
	* @var array
	*/
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'idProjektu' => self::_INTEGER,
		'idParent' => self::_INTEGER,
		'idTeam' => self::_INTEGER,
		'idType' => self::_INTEGER,
		'numberOrderGet' => self::_INTEGER,
		'numberOrderBkt' => self::_INTEGER,
		'numberCustomer' => self::_INTEGER,
		'numberPrivatCustomer' => self::_INTEGER,
		'numberProjectGet' => self::_STRING,
		'numberContactId' => self::_INTEGER,
		'chargeType' => self::_ENUM,
		'dateAdded' => self::_STRING,
		'hoursInterval' => self::_STRING,
		'totalTime' => self::_FLOAT,
		'dateStart' => self::_STRING,
		'dateStop' => self::_STRING,
		'status' => self::_ENUM,
		'statusWork' => self::_ENUM,
		'address' => self::_STRING,
		'city' => self::_STRING,
		'postcode' => self::_STRING,
		'locationLat' => self::_FLOAT,
		'locationLng' => self::_FLOAT,
		'budget' => self::_FLOAT,
		'nodeVillaCode' => self::_STRING,
		'attributes' => self::_ARRAY,
		'jobDescription' => self::_STRING,
		'orderName' => self::_STRING,
		'isReclamation' => self::_BOOLEAN,
		'idCoordinator' => self::_INTEGER,
		'idProjectLeaderGetContact' => self::_INTEGER,
		'idProjectLeaderBkt' => self::_INTEGER,
		'idPricedBy' => self::_INTEGER,
		'numberProjectInkjops' => self::_STRING,
		'reference' => self::_STRING,
		'highPriority' => self::_BOOLEAN,
		'position' => self::_INTEGER,
		'sprawdzony' => self::_BOOLEAN,
		'wyslanoDoRaportu' => self::_BOOLEAN,
		'idNotatkiDoRaportu' => self::_INTEGER,
		'dataZakonczenia' => self::_STRING,
		'idUserZamknijZamowienie' => self::_INTEGER,
		'kategoria' => self::_STRING,
		'notCharge' => self::_BOOLEAN,
		'blokadaEdycji' => self::_BOOLEAN,
		'blokadaPoprawiania' => self::_BOOLEAN,
		'wyslanyDoFakturowania' => self::_BOOLEAN,
		'zafakturowano' => self::_BOOLEAN,
		'apartment' => self::_STRING,
		'additionalData' => self::_ARRAY,
		'idPdf' => self::_STRING,
		'idUserPrzydzielApartamenty' => self::_INTEGER,
		'drugaTuraApartament' => self::_INTEGER,
		'idUserOtworzZamowienie' => self::_INTEGER,
	);


	/**
	 * Czy chronić uprawnieniami Obiekt.
	 * @var bool
	 */
	public $_ochronaUprawnieniami = false;
	
	
	/**
	 * Lista pól których uprawnienia nie będa sprawdzane - żeby było mozliwe zalogowanie i pobranie uprawnień
	 * @var array
	 */
	public $_nieSprawdzajUprawnien = array(
		'id_odczyt',
		'idProjektu_odczyt',
	);
	
	

	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'chargeType' => 'by products',
		'status' => 'active',
		'statusWork' => 'new',
		'blokadaEdycji' => FALSE,
		'blokadaPoprawiania' => FALSE,
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'chargeType' => array(
			'given price',
			'price per hour',
			'by products',
		),
		
		'status' => array(
			'open',
			'active',
			'cancelled',
			'closed',
		),

		'statusWork' => array(
			'new',
			'in progress',
			'done',
			'not done',
		),
	);

}