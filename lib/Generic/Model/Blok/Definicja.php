<?php
namespace Generic\Model\Blok;
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
		'kontener' => self::_STRING,
		'klasa' => self::_STRING,
		'nazwa' => self::_STRING,
		'szablon' => self::_STRING,
		'cache' => self::_BOOLEAN,
		'cacheCzas' => self::_INTEGER,
		'szablonKatalog' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
