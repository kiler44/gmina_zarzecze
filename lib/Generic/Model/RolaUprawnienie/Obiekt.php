<?php
namespace Generic\Model\RolaUprawnienie;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca połączenie roli z uprawnieniem
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idRoli
 * @property int $idUprawnienia
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
		'kodJezyka',
		'idRoli',
		'idUprawnienia'
	);

}

