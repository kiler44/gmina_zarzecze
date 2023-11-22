<?php
namespace Generic\Model\StawkaUzytkownika;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idUzytkownika 
 * @property double $stawka 
 * @property mixed $dataStart 
 * @property mixed $dataStop 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\StawkaUzytkownika\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\StawkaUzytkownika\Obiekt
	 */
	protected $j;
}