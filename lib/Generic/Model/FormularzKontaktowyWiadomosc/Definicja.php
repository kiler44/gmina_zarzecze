<?php
namespace Generic\Model\FormularzKontaktowyWiadomosc;
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
		'idKategorii' => self::_INTEGER,
		'idTematu' => self::_INTEGER,
		'tresc' => self::_STRING,
		'dataWyslania' => self::_STRING,
		'imie' => self::_STRING,
		'nazwisko' => self::_STRING,
		'email' => self::_STRING,
		'firmaNazwa' => self::_STRING,
		'stronaWww' => self::_STRING,
		'gg' => self::_STRING,
		'skype' => self::_STRING,
		'telefon' => self::_STRING,
		'komorka' => self::_STRING,
		'fax' => self::_STRING,
		'idUzytkownika' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
