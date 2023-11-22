<?php
namespace Generic\Model\RoleUprawnieniaEvents;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idRoli 
 * @property string $szablonEventu 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\RoleUprawnieniaEvents\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\RoleUprawnieniaEvents\Obiekt
	 */
	protected $j;
}