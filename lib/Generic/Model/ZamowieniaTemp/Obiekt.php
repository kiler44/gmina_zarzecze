<?php
namespace Generic\Model\ZamowieniaTemp;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $numberOrderGet 
 * @property string $note 
 * @property double $timeSpent 
 * @property double $lopendetimer 
 * @property string $productList 
 * @property string $problem 
 * @property int $bktId 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\ZamowieniaTemp\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\ZamowieniaTemp\Obiekt
	 */
	protected $j;
}