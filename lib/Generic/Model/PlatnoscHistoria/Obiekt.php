<?php
namespace Generic\Model\PlatnoscHistoria;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca wiersz historii płatności.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property integer $id
 * @property integer $idProjektu
 * @property integer $idPlatnosci
 * @property string $dataDodania
 * @property string $operacja
 * @property string $daneWyslane
 * @property string $daneOdebrane
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
		'idPlatnosci',
		'dataDodania',
		'operacja',
		'daneWyslane',
		'daneOdebrane',
	);

}
