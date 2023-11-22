<?php
namespace Generic\Model\Projekt;
use Generic\Model\Projekt;

use Generic\Biblioteka;


/**
 * Klasa definiujaca (opisujaca) obiekt uzytkownika
 * @author Łukasz Wrucha
 * @package dane
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{
	/**
	 * typy pol obiektu
	 * @var array
	 */
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'kod' => self::_STRING,
		'domena' => self::_STRING,
		'nazwa' => self::_STRING,
		'opis' => self::_STRING,
		'szablon' => self::_STRING,
		'domyslnyJezyk' => self::_STRING,
		'przypisaneModuly' => self::_STRING,
		'modulyRss' => self::_STRING,
		'modulyCron' => self::_STRING,
		'modulyApi' => self::_STRING,
	);


	/**
	 * domyślne wartości
	 * @var array
	 */
	public $domyslneWartosci = array();


	/**
	 * dopuszczalne wartości dla pól enum w bazie ()
	 * @var array
	 */
	public $dopuszczalneWartosci = array();



	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $formularz = array();
}