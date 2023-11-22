<?php
namespace Generic\Model\Zamowienie;
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
 * @property string $typProjektu
 * @property bool $akceptacjaGet
 * $property array $akceptacjaForm
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
		'typProjektu' => self::_STRING,
		'akceptacjaGet' => self::_BOOLEAN,
		'akceptacjaForm' => self::_ARRAY,
		'importFromGetApi' => self::_BOOLEAN,
		'getApiInfo' => self::_STRING,
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
		'typProjektu' => array(
			'ftth', 'hfc'
		)
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $formularz = array(
		'podstawowe' => '_region_',
		
		'orderName' => array(
			'input' => 'Text',
			//'wymagany' => true,
			'walidatory' => array('DluzszeOd' => 3, 'KrotszeOd' => 250),
		),
		
		'numberPrivatCustomer' => array(
			'input' => 'SelectKlienci',
		),
		'numberOrderGet' => array(
			'input' => 'Text',
			'wymagany' => true,
			'walidatory' => array('LiczbaCalkowita', 'WiekszeOd' => 0),
		),
		'idPdf' => array(
					'input' => 'Text',
					'wymagany' => true,
					'walidatory' => array(),
				),
		'numberOrderBkt' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'wymagany' => true,
			'walidatory' => array(
					'NiePuste',
					'LiczbaCalkowita',
			),
		),

		'numberProjectGet' => array(
			'input' => 'Text',
			'filtry' => array('strval', 'trim', 'filtr_xss'),
			'walidatory' => array(
					'KrotszeOd' => 16,
			),
		),
		'numberProjectInkjops' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
		),
		'order_address' => '_region_',
		
		'address' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 128,
			),
			'wymagany' => true,
		),
		
		'apartment' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 128,
			),
			'wymagany' => false,
		),

		'city' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 64,
			),
			'wymagany' => true,
		),

		'postcode' => array(
			'input' => 'Text',
			'filtry' => array('strval'),
			'walidatory' => array(
					'KrotszeOd' => 5,
					'DluzszeOd' => 3,
					'MniejszeOd' => 9992,
			),
			'parametry' => array(
				'atrybuty' => array('maxlength' => 4),
			),
			'wymagany' => true,
		),
		
		'job_information' => '_region_',
		'notCharge' => array(
			'input' => 'Checkbox',
		),
		'chargeType' => array(
			'input' => 'Select',
			'wymagany' => true,
		),
		'budget' => array(
			'input' => 'Text',
			'filtry' => array(
             'floatval'
			),
			'walidatory' => array(
					'KrotszeOd' => 11,
			),
		),
		'status' => array(
			'input' => 'Select',
			'filtry' => array(
			),
			'wymagany' => true,
		),

		/*
		'statusWork' => array(
			'input' => 'Select',
			'filtry' => array(
			),
			'wymagany' => true,
		),
		 */
		
		'jobDescription' => array(
			'input' => 'TextArea',
			'filtry' => array(
             'strval', 'filtr_xss'
			),
			'parametry' => array('atrybuty' => array('class' => 'full-width')),
		),
		
		'dateStart' => array(
			'input' => 'Data',
			'walidatory' => array(
			),
		),

		'dateStop' => array(
			'input' => 'Data',
			'walidatory' => array(
			),
		),
		
		'nodeVillaCode' => array(
			'input' => 'Text',
			'filtry' => array(
             'strval'
			),
		),
		
		'hoursInterval' => array(
			'input' => 'Text',
			'filtry' => array(
             'strval', 'trim'
			),
			'walidatory' => array(
					'KrotszeOd' => 12,
			),
		),
		
		'totalTime' => array(
			'input' => 'Text',
			'filtry' => array(
             'floatval'
			),
			'walidatory' => array(
					'LiczbaZmiennoprzecinkowa',
					'MniejszeOd' => 100,
			),
		),
		
		'idCoordinator' => array(
			'input' => 'Select',
			'filtry' => array('intval', 'abs'),
			'walidatory' => array('LiczbaCalkowita'),
		),
		
		'idTeam' => array(
			'input' => 'Select',
			'filtry' => array('intval', 'abs'),
			'walidatory' => array('LiczbaCalkowita'),
		),
		
		'details' => '_region_:closed',
		
		'locationLat' => array(
			'input' => 'Text',
			'filtry' => array(
             'floatval'
			),
			'walidatory' => array(
					'KrotszeOd' => 10,
			),
		),
		
		'locationLng' => array(
			'input' => 'Text',
			'filtry' => array(
             'floatval'
			),
			'walidatory' => array(
					'KrotszeOd' => 10,
			),
		),
		
		'attributes' => array(
			'input' => 'Tablica',
         'parametry' => array(
            'dodawanie_wierszy' => true,
         ),
		
			'walidatory' => array(
			),
		),
		

		

	);
	
	public function lista_numberPrivatCustomer()
	{
		return array('');
	}
	
	public function lista_chargeType()
	{
		$obiektTypuZamowienia = Biblioteka\Cms::inst()->sesja->wybranyTypZamowienia;
		
		$tlumaczenia = $obiektTypuZamowienia->pobierzTlumaczeniaObiektu()->t['possibleChargeTypes.wartosci'];
		
		$charge_types = array();
		foreach ($obiektTypuZamowienia->possibleChargeTypes as $chargeType)
		{
			$charge_types[$chargeType] = $tlumaczenia[$chargeType];
		}
		
		return $charge_types;
	}
	
	public function lista_idCoordinator()
	{
		$konfiguracjaMapper = new \Generic\Model\WierszKonfiguracji\Mapper();
		$wiersz = $konfiguracjaMapper->pobierzWartoscWierszaKonfiguracji('orders.rola_koordynatorow', 'Orders_Admin');
		
		$uzytkownicyMapper = new \Generic\Model\Uzytkownik\Mapper();
		$lista = array();
		foreach ($uzytkownicyMapper->zwracaTablice()->pobierzDlaRoliPoKodach(array($wiersz)) as $uzytkownik)
		{
			$lista[$uzytkownik['id']] = $uzytkownik['imie'].' '.$uzytkownik['nazwisko'].' ('.$uzytkownik['login'].')';
		}
		if (count($lista) > 0)
		{
			return $lista;
		}
		else
		{
			return array('' => 'No users with coordinator role - configuration!');
		}
	}
	
	public function lista_idTeam()
	{
		$mapper = new \Generic\Model\Team\Mapper();
		
		$tlumaczeniaMapper = new \Generic\Model\WierszTlumaczen\Mapper();
		$wiersz = $tlumaczeniaMapper->pobierzWartoscWierszaTlumaczen('formularzZamowienia.etykieta_idTeam', 'Orders_Admin');
		$teamSorter = new \Generic\Model\Team\Sorter('team_number', 'ASC');
		
		$teamy = $mapper->szukaj(array('wiele_statusow' => array("active", "temporary_use"),'id_leader_wymagany' => true,), null, $teamSorter);
		$listaTeamow = array('' => $wiersz);
		
		foreach ($teamy as $team)
		{
			$listaTeamow[$team->id] = $team->teamNumber.' [';
			
			$i = 1;
			foreach ($team->pobierzPracownikowTeamu() as $pracownik)
			{
				$listaTeamow[$team->id] .= (($i > 1) ? ', ' : '').$pracownik->imie.' '.trim($pracownik->nazwisko);
				$i++;
			}
			$listaTeamow[$team->id] .= ']';
		}
		
		return $listaTeamow;
	}
}