<?php
namespace Generic\Model\UdostepnianyPlik;
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
		'tresc' => self::_STRING,
		'plik' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
