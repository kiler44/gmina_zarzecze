<?php
namespace Generic\Model\Kategoria;
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
		//'kodJezyka' => self::_STRING,
		'prawy' => self::_INTEGER,
		'lewy' => self::_INTEGER,
		'poziom' => self::_INTEGER,
		'czyWidoczna' => self::_BOOLEAN,
		'dlaZalogowanych' => self::_BOOLEAN,
		'wymagaHttps' => self::_BOOLEAN,
		'typ' => self::_STRING,
		'kodModulu' => self::_STRING,
		'idWidoku' => self::_STRING,
		'kontener' => self::_STRING,
		'akcjaKontener' => self::_STRING,
		'akcjaUkladStrony' => self::_STRING,
		'akcjaSzablon' => self::_STRING,
		'akcjaKlasa' => self::_STRING,
		'staryUrl' => self::_STRING,
		'blokada' => self::_INTEGER,
		'nazwa' => self::_STRING,
		'nazwaPrzyjazna' => self::_ARRAY,
		'kod' => self::_STRING,
		'pelnyLink' => self::_STRING,
		'tytulStrony' => self::_STRING,
		'opis' => self::_STRING,
		'slowaKluczowe' => self::_STRING,
		'idKategorii' => self::_INTEGER,
		'adresZewnetrzny' => self::_STRING,
		'cache' => self::_BOOLEAN,
		'czasCache' => self::_INTEGER,
		'skrypt' => self::_STRING,
		'rssWlaczony' => self::_BOOLEAN,
		'szablon' => self::_STRING,
		'klasa' => self::_STRING,
		'naglowekHtml' => self::_STRING,
		'naglowekHttp' => self::_STRING,
		'ikona' => self::_STRING,
		'szablonKatalog' => self::_STRING,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
