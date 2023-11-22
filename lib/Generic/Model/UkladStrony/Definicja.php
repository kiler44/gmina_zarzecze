<?php
namespace Generic\Model\UkladStrony;
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
		'kod' => self::_STRING,
		'nazwa' => self::_STRING,
		'plik' => self::_STRING,
		'regiony' => self::_MIXED,
		'struktura' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
