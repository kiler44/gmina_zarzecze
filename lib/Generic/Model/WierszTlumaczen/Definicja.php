<?php
namespace Generic\Model\WierszTlumaczen;
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
		'kodJezyka' => self::_STRING,
		'kodModulu' => self::_STRING,
		'idKategorii' => self::_INTEGER,
		'idBloku' => self::_INTEGER,
		'nazwa' => self::_STRING,
		'typ' => self::_STRING,
		'wartosc' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
