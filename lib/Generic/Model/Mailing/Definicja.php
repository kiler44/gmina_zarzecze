<?php
namespace Generic\Model\Mailing;
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
		'dataDodania' => self::_STRING,
		'nazwa' => self::_STRING,
		'tytul' => self::_STRING,
		'tresc' => self::_STRING,
		'trescHtml' => self::_STRING,
		'plikZLista' => self::_STRING,
		'dataWysylki' => self::_STRING,
		'ileAdresow' => self::_INTEGER,
		'ileWyslano' => self::_INTEGER,
		'ileBledow' => self::_INTEGER,
		'idZadaniaCron' => self::_INTEGER,
		'dataZakonczenia' => self::_STRING,
		'nazwaNadawcy' => self::_STRING,
		'emailNadawcy' => self::_STRING,
		'zaladujSzablon' => self::_INTEGER,
		'pominSprawdzanieZgody' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
