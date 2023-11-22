<?php
namespace Generic\Model\Notes;
use Generic\Biblioteka\ObiektDanych;
use Generic\Model\Uzytkownik;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property string $object 
 * @property int $idObject 
 * @property string $description 
 * @property mixed $dataAdded 
 * @property mixed $status 
 * @property int $author 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\Notes\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\Notes\Obiekt
	 */
	protected $j;


}