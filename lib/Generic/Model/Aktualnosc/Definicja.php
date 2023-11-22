<?php
namespace Generic\Model\Aktualnosc;
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
		'idUzytkownika' => self::_INTEGER,
		'dataDodania' => self::_STRING,
		'dataWaznosci' => self::_STRING,
		'autor' => self::_STRING,
		'tytul' => self::_STRING,
		'zajawka' => self::_STRING,
		'tresc' => self::_STRING,
		'zdjecieGlowne' => self::_STRING,
		'priorytetowa' => self::_BOOLEAN,
		'publikuj' => self::_BOOLEAN,
		'idGalerii' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
