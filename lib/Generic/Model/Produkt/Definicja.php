<?php
namespace Generic\Model\Produkt;
use Generic\Model\Projekt;
use Generic\Tlumaczenie;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property string $code
 * @property string $name 
 * @property mixed $status //TODO: Nieznany typ pola.
 * @property string $measureUnit 
 * @property string $visibleInOrder 
 * @property int $vat 
 * @property double $nettoPrice 
 * @property double $bruttoPrice 
 * @property date $dataAdded
 * @property string $kombinacje
 * @property string $textDoSms
 * @property bool $mainProduct
 * @property bool $multiplied
 * @property integer $noteRequired
 * @property string $serial
 * @property bool $pojedynczy
 * @property bool $notDone
 * @property bool $ukryty
 * @property int $idPolaczony
 * @property string $technologia
 * @property int $photosRequired
 * @property string $photosExplanation
 * @property double $czas
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
		'code' => self ::_STRING,
		'name' => self::_STRING,
		'status' => self::_ENUM,
		'measureUnit' => self::_STRING,
		'visibleInOrder' => self::_LIST,
		'vat' => self::_INTEGER,
		'nettoPrice' => self::_DOUBLE,
		'bruttoPrice' => self::_DOUBLE,
		'dataAdded' => self::_DATETIME,
		'import' => self::_BOOLEAN,
		'kombinacje' => self::_LIST,
		'textDoSms' => self::_STRING,
		'mainProduct' => self::_BOOLEAN,
		'multiplied' => self::_BOOLEAN,
		'noteRequired' => self::_INTEGER,
		'serial' => self::_STRING,
		'pojedynczy' => self::_BOOLEAN,
		'kolejnosc' => self::_INTEGER,
		'notDone' => self::_BOOLEAN,
		'ukryty' => self::_BOOLEAN,
		'idPolaczony' => self::_STRING,
		'technologia' => self::_STRING,
		'photosRequired' => self::_INTEGER,
		'photosExplanation' => self::_STRING,
		'czas' => self::_DOUBLE,
		'dataWaznosciOd' => self::_DATETIME,
		'dataWaznosciDo' => self::_DATETIME,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'status' => 'active',
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'status' => array(
			'active',
			'delete',
		),
		'serial' => array(
			'',
			'dekoder',
			'modem',
			'ont',
			'voip',
			'h_dek',
			'h_modem',
		)
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $formularz = array(
		'name' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 128,
			),
		),
		'mainProduct' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval', 'abs'
			),
		),
		'measureUnit' => array(
			'input' => 'Select',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 12,
			),
		),

		'idPolaczony' => array(
			'input' => 'Select',
			'filtry' => array(	
			),
			'walidatory' => array(
					'LiczbaCalkowita',
			),
		),
		'technologia' => array(
			'input' => 'Select',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => false,
			'walidatory' => array(
					'KrotszeOd' => 100,
			),
		),
		'visibleInOrder' => array(
			'input' => 'AutocompleteLista',
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

		'vat' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'nettoPrice' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
			
		),

		'bruttoPrice' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),
		'multiplied' => array(
			'input' => 'CheckBox',
			'filtry' => array(
				'intval', 'abs'
			),
		),
		'textDoSms' => array(
			'input' => 'Text',
			'filtry' => array('strval', 'filtr_xss')
		),
		'serial' => array(
			'input' => 'Select',
		),
		'noteRequired' => array(
			'input' => 'Text',
			'walidatory' => array('LiczbaCalkowita'),
		),
		'pojedynczy' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval', 'abs'
			),
		),
		'notDone' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval', 'abs'
			),
		),
		'photosRequired' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval', 'abs'
			),
			'walidatory' => array('LiczbaCalkowita'),
		),
		'photosExplanation' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval', 'filtr_xss'
			),
		),
		'czas' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval', 'abs'
			),
		),
		'dataWaznosciOd' => array(
			'input' => 'Data',
			'filtry' => array(
				'strval', 'filtr_xss'
			),
		),
		'dataWaznosciDo' => array(
			'input' => 'Data',
			'filtry' => array(
				'strval', 'filtr_xss'
			),
		),
	);
	
	public function lista_visibleInOrder()
	{
		$mapper = new \Generic\Model\ZamowienieTyp\Mapper(Mapper::ZWRACA_TABLICE);
		$sorter = new \Generic\Model\ZamowienieTyp\Sorter('kolejnosc', 'ASC');
      $typyZamowien = $mapper->szukaj(array(
      //   'main_type' => true,
         'active' => true,
			'ukryty' => false,
      ), null, $sorter);
		
	
		if (count($typyZamowien) > 0)
      {
         foreach ($typyZamowien as $typ)
         {
            $lista[$typ['id']] = $typ['name'];
         }
      }
		return $lista;
	}
	
	public function lista_idPolaczony()
	{
		$mapper = new \Generic\Model\Produkt\Mapper(Mapper::ZWRACA_TABLICE);
		$sorter = new \Generic\Model\Produkt\Sorter('kolejnosc', 'ASC');
		
		$wybierz = array(0 => '- Select parent product -');
		
		$produkty = listaZTablicy($mapper->szukaj(array(
      //   'main_type' => true,
         'status' => 'active',
			'ukryty' => false,
			'import' => false,
			'visible_in' => array(1,2),
      ), null, $sorter), 'id', 'name');
		
		$produkty = $wybierz + $produkty;
		return $produkty;
	}
	
	public function lista_technologia()
	{
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$lista = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('formularz.technologia_lista', 'Products_Admin');
		
		$wybierz = array(null => '- Select technology  -');
		$lista = array_merge($wybierz, $lista);
		
		return $lista;
	}
}