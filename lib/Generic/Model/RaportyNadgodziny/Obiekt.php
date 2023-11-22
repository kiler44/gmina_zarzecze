<?php
namespace Generic\Model\RaportyNadgodziny;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idUser 
 * @property int $idTeam 
 * @property string $data 
 * @property double $godziny 
 * @property double $nadgodziny 
 * @property double $pauza
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\RaportyNadgodziny\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\RaportyNadgodziny\Obiekt
	 */
	protected $j;
}