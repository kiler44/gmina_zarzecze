<?php
namespace Generic\Model\WierszKonfiguracji;
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
		'idProjektu' => self::_INTEGER,
		'kodModulu' => self::_STRING,
		'idKategorii' => self::_INTEGER,
		'idBloku' => self::_INTEGER,
		'nazwa' => self::_STRING,
		'typ' => self::_STRING,
		'wartosc' => self::_STRING,
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