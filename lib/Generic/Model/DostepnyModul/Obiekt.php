<?php
namespace Generic\Model\DostepnyModul;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\ObiektDanychWyjatek;


/**
 * Klasa odwzorowująca moduł cms-a.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property string $kod
 * @property string $nazwa
 * @property string $opis
 * @property string $typ
 * @property array $wymagane
 * @property boolean dlaZalogowanych,
 * @property array $uslugi
 * @property boolean cache,
 * @property string $katalogSzablon,
 */

class Obiekt extends ObiektDanych
{

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'kod',
		'nazwa',
		'opis',
		'typ',
		'wymagane',
		'dlaZalogowanych',
		'uslugi',
		'cache',
		'katalogSzablon'
	);


	// dozwolone typy kategorii
	static protected $_typy = array(
		'zwykly',
		'administracyjny',
		'jednorazowy',
		'blok',
	);



	static function pobierzDostepneTypy()
	{
		return self::$_typy;
	}



	/*
	 * Blokuje ustawianie parametru w wewnetrznej tablicy obiektu
	 *
	 * @param string $parametr nazwa pobieranego parametru
	 * @param mixed $wartosc wartosc pobieranego parametru
	 */
	function __set($parametr, $wartosc)
	{
		throw new ObiektDanychWyjatek('Nie mozna ustwic parametru \''.$parametr.'\' dla obiektu '.get_class($this), E_USER_WARNING);
	}

}

