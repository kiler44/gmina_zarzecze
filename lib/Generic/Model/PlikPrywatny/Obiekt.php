<?php
namespace Generic\Model\PlikPrywatny;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca plik prywatny.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $url
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
		'url',
	);

}
