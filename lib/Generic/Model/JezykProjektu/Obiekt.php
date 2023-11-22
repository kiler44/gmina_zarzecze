<?php
namespace Generic\Model\JezykProjektu;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca język projektu.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kod
 * @property string $nazwa
 */

class Obiekt extends ObiektDanych
{

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'id',
		'idProjektu',
		'kod',
		'nazwa',
	);

}

