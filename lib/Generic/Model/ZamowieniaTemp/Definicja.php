<?php
namespace Generic\Model\ZamowieniaTemp;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $number_order_get 
 * @property string $note 
 * @property double $time_spent 
 * @property double $lopendetimer 
 * @property string $product_list 
 * @property string $problem 
 * @property int $bkt_id 
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{



	/**
	* Przetrzymuje typy pól w bazie.
	* @var array
	*/
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'numberOrderGet' => self::_INTEGER,
		'note' => self::_STRING,
		'timeSpent' => self::_DOUBLE,
		'timeLopendetimer' => self::_DOUBLE,
		'products' => self::_STRING,
		'problem' => self::_STRING,
		'bktId' => self::_INTEGER,
		'idProjektu' => self::_INTEGER,
		'productsIds' => self::_ARRAY,
		'nettoPrice' => self::_FLOAT,
		'nettoPriceWithoutLopendetimer' => self::_FLOAT,
		'fromAddress' => self::_STRING,
		'toAddress' => self::_STRING,
		'km' => self::_DOUBLE,
		'czas' => self::_DOUBLE,
		'czasTrafic' => self::_DOUBLE,
		'bezLopende' => self::_BOOLEAN,
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
		'numberOrderGet' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'note' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 1000,
			),
		),

		'timeSpent' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

		'lopendetimer' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

		'productList' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'problem' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'bktId' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

	);
}