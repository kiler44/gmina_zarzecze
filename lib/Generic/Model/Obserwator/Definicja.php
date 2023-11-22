<?php
namespace Generic\Model\Obserwator;
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
		'opis' => self::_STRING,
		'typ' => self::_STRING,
		'obiekt_docelowy' => self::_STRING,
		'ustawienia' => self::_ARRAY,
		'zdarzenia' => self::_ARRAY,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
