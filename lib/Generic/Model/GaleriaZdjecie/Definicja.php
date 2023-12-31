<?php
namespace Generic\Model\GaleriaZdjecie;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property string $nazwa_szablonu 
 * @property string $konfiguracja_szablon 
 * @property string $nazwa 
 * @property int $idObiekt 
 * @property string $obiekt
 * @property bool $wykonany
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{



	/**
	* Przetrzymuje typy pól w bazie.
	* @var array
	*/
	public $polaObiektuTypy = array(
        'id' => self::_INTEGER,
        'idProjektu' => self::_INTEGER,
        'kodJezyka' => self::_STRING,
        'idGalerii' => self::_INTEGER,
        'nazwaPliku' => self::_STRING,
        'tytul' => self::_STRING,
        'opis' => self::_STRING,
        'dataDodania' => self::_DATETIME,
        'autor' => self::_STRING,
        'publikuj' => self::_STRING,
        'pozycja' => self::_INTEGER,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'idProjektu' => ID_PROJEKTU,
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
	);




}