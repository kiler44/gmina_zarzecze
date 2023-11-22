<?php
namespace Generic\Model\ZadanieCykliczne;
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
		'aktywne' => self::_BOOLEAN,
		'dataRozpoczecia' => self::_STRING,
		'dataZakonczenia' => self::_STRING,
		'minuty' => self::_STRING,
		'godziny' => self::_STRING,
		'dni' => self::_STRING,
		'miesiace' => self::_STRING,
		'dniTygodnia' => self::_STRING,
		'idKategorii' => self::_INTEGER,
		'kodModulu' => self::_STRING,
		'akcja' => self::_STRING,
		'opisZadania' => self::_STRING,
		'dodawaneWielokrotnie' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
