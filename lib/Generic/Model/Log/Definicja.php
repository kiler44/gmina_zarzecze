<?php
namespace Generic\Model\Log;
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
		'czas' => self::_STRING,
		'adresIp' => self::_STRING,
		'przegladarka' => self::_STRING,
		'zadanieHttp' => self::_STRING,
		'idUzytkownika' => self::_INTEGER,
		'idKategorii' => self::_INTEGER,
		'usluga' => self::_STRING,
		'kodModulu' => self::_STRING,
		'akcja' => self::_STRING,
		'daneDodatkowe' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
