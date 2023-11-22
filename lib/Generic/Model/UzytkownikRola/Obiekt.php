<?php
namespace Generic\Model\UzytkownikRola;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca powiązanie roli z użytkownikiem.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property int $idRoli
 * @property int $idUzytkownika
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
		'idUzytkownika',
	);

}

