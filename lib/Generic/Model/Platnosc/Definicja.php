<?php
namespace Generic\Model\Platnosc;
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
		'idUzytkownika' => self::_INTEGER,
		'dataDodania' => self::_STRING,
		'systemPlatnosci' => self::_STRING,
		'kodModulu' => self::_STRING,
		'idKategoriiModulu' => self::_INTEGER,
		'typObiektu' => self::_STRING,
		'idObiektu' => self::_INTEGER,
		'kwota' => self::_FLOAT,
		'waluta' => self::_STRING,
		'opis' => self::_STRING,
		'typPlatnosci' => self::_STRING,
		'status' => self::_STRING,
		'imie' => self::_STRING,
		'nazwisko' => self::_STRING,
		'ulica' => self::_STRING,
		'nrDomu' => self::_STRING,
		'nrLokalu' => self::_STRING,
		'kodPocztowy' => self::_STRING,
		'miasto' => self::_STRING,
		'wojewodztwo' => self::_STRING,
		'kraj' => self::_STRING,
		'email' => self::_STRING,
		'telefon' => self::_STRING,
		'daneWyslane' => self::_STRING,
		'daneOdebrane' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
