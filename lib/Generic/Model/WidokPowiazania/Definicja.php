<?php
namespace Generic\Model\WidokPowiazania;
use Generic\Biblioteka;

/**
 * Klasa definiujaca (opisujaca) obiekt
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
		'id_projektu' => self::_INTEGER,
		'id_widoku' => self::_INTEGER,
		'kod_jezyka' => self::_STRING,
		'uzytkownik' => self::_STRING,
		'grupa' => self::_STRING,
		'akcja' => self::_STRING,
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
