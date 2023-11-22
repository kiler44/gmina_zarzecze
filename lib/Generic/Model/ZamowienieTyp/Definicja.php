<?php
namespace Generic\Model\ZamowienieTyp;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $id_projektu 
 * @property int $idConfigTemplate
 * @property bool $main_type 
 * @property bool $active
 * @property bool $child_orders 
 * @property string $possible_charge_types 
 * @property string $parent_types
 * @property string $requiredSkills
 * @property string $orderGroup
 * @property bool $isReclamation 
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
		'idConfigTemplate' => self::_INTEGER,
		'mainType' => self::_BOOLEAN,
		'active' => self::_BOOLEAN,
		'childOrders' => self::_BOOLEAN,
		'dateAdded' => self::_DATETIME,
      'name' => self::_STRING,
		'possibleChargeTypes' => self::_LIST,
		'parentTypes' => self::_LIST,
		'requiredSkills' => self::_LIST,
		'previewTemplate' => self::_STRING,
		'orderGroup' => self::_STRING,
		'isReclamation' => self::_BOOLEAN,
		'kolejnosc' => self::_INTEGER,
		'directAssignment' => self::_BOOLEAN,
		'requireAppointment' => self::_BOOLEAN,
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
      'possibleChargeTypes' => array(
			'given price',
			'price per hour',
			'by products',
		),
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
			'walidatory' => array(
					'KrotszeOd' => 128,
			),
      ),
		'mainType' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'walidatory' => array(
			),
		),

		'active' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'walidatory' => array(
			),
		),

		/*
		'childOrders' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'walidatory' => array(
			),
		),
		 */

		'possibleChargeTypes' => array(
			'input' => 'AutocompleteLista',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
		),

		/*
		'parentTypes' => array(
			'input' => 'AutocompleteLista',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
		), 
		 */
		'idConfigTemplate' => array(
			'input' => 'Select',
			'filtry' => array(
				'intval', 'abs',
			),
			'walidatory' => array(
				'LiczbaCalkowita',
				'WiekszeOd' => 0,
				'NiePuste',
			),
			'wymagany' => true,
		),
		'requiredSkills' => array(
			'input' => 'AutocompleteLista',
			'filtry' => array('intval'),
		),
		'previewTemplate' => array(
			'input' => 'TextArea',
			'filtry' => array('strval', 'filtr_xss'),
			'wymagany' => true,
			'walidatory' => array(),
			'parametry' => array('atrybuty' => array(
				'cols' => 240,
				'rows' => 15,
			)),
			//'parametry' => array('ckeditor' => true)
		),
		'orderGroup' => array(
			'input' => 'Select',
			'filtry' => array(
				'strval', 'filtr_xss',
			),
			'walidatory' => array(
				'NiePuste',
			),
			'wymagany' => true,
		),
		'isReclamation' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
		),
		'directAssignment' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
		),
		'requireAppointment' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
		),
 	);
   
   
   public function lista_parentTypes()
   {
      $mapper = new \Generic\Model\ZamowienieTyp\Mapper(Mapper::ZWRACA_TABLICE);
      $typyRodzicow = $mapper->szukaj(array(
         'child_orders' => true,
         'active' => true,
      ));
      
      $lista = array();
      if (count($typyRodzicow) > 0)
      {
         foreach ($typyRodzicow as $typ)
         {
            $lista[$typ['id']] = $typ['name'];
         }
      }

      return $lista;
   }
	
	public function allParentTypes()
   {
      $mapper = new \Generic\Model\ZamowienieTyp\Mapper(Mapper::ZWRACA_TABLICE);
      $typyRodzicow = $mapper->szukaj(array(
         'child_orders' => true,
      ));
      
      $lista = array();
      if (count($typyRodzicow) > 0)
      {
         foreach ($typyRodzicow as $typ)
         {
            $lista[$typ['id']] = $typ['name'];
         }
      }

      return $lista;
   }
	
	public function lista_idConfigTemplate()
	{
		$typyZamowien = new \Generic\Model\ZamowienieTyp\Obiekt();
		$config = array_combine(array_keys($typyZamowien->pobierzPelnaKonfiguracjeTypow()), listaZTablicy($typyZamowien->pobierzPelnaKonfiguracjeTypow(), null, 'nazwa'));
		unset($typyZamowien);
		return $config;
	}
	
	
	public function lista_requiredSkills()
	{
		$mapper = new \Generic\Model\WierszKonfiguracji\Mapper();
		$wiersz = $mapper->pobierzWartoscWierszaKonfiguracji('formularz.available_skills', 'UzytkownicyZarzadzanie_Admin');
		return $wiersz;
	}
	
	public function lista_orderGroup()
	{
		$mapper = new \Generic\Model\WierszKonfiguracji\Mapper();
		$wiersz = $mapper->pobierzWartoscWierszaKonfiguracji('orders.grupy_zamowien', 'Orders_Admin');
		$lista = array();
		foreach ($wiersz as $grupa) {$lista[$grupa] = $grupa;}
		return $lista;
	}
}