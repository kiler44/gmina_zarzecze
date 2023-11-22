<?php
namespace Generic\Model\Widok;
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
		'idProjektu' => self::_INTEGER,
		'nazwa' => self::_STRING,
		'ukladStrony' => self::_STRING,
		'struktura' => self::_STRING,
		'jsonUkladu' => self::_STRING,
		'htmlUkladu' => self::_STRING,
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
