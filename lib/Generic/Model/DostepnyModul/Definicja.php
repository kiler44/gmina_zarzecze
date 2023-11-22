<?php
namespace Generic\Model\DostepnyModul;
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
		'opis' => self::_STRING,
		'typ' => self::_STRING,
		'wymagane' => self::_MIXED,
		'dlaZalogowanych' => self::_BOOLEAN,
		'uslugi' => self::_MIXED,
		'cache' => self::_BOOLEAN,
		'katalogSzablon' => self::_STRING,
	);
}
