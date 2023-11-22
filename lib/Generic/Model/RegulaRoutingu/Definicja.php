<?php
namespace Generic\Model\RegulaRoutingu;
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
		'idKategorii' => self::_INTEGER,
		'kodModulu' => self::_STRING,
		'nazwaAkcji' => self::_STRING,
		'typReguly' => self::_STRING,
		'wartosc' => self::_STRING,
		'szablonUrl' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
