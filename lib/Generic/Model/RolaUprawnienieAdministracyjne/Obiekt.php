<?php
namespace Generic\Model\RolaUprawnienieAdministracyjne;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca połączenie roli z uprawnieniem administracyjnym.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property int $idRoli
 * @property int $idUprawnieniaAdministracyjnego
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
		'idRoli',
		'idUprawnieniaAdministracyjnego',
	);

}

