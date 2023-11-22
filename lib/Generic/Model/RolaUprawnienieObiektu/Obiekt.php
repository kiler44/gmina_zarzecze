<?php
namespace Generic\Model\RolaUprawnienieObiektu;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
* @property int $id
* @property int $idProjektu
* @property string $kodJezyka
* @property int $idRoli
* @property int $idUprawnieniaObiektu
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
		'idUprawnieniaObiektu',
	);
	/**
	 * @var \Generic\Konfiguracja\Model\RolaUprawnienieObiektu\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\RolaUprawnienieObiektu\Obiekt
	 */
	protected $j;
}