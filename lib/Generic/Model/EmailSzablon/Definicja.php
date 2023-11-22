<?php
namespace Generic\Model\EmailSzablon;
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
		'nazwa' => self::_STRING,
		'trescHtml' => self::_STRING,
		'trescTxt' => self::_STRING,
		'aktywny' => self::_BOOLEAN,
	);


	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $formularz = array();

}
