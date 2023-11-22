<?php
namespace Generic\Model\RaportyExcelDane;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idOrder 
 * @property int $idTeam 
 * @property string $data 
 * @property string $fromAddress
 * @property string $toAddress
 * @property double $kilometry 
 * @property double $minutyJazdy 
 * @property double $minutyJazdyTraffik
 * @property string $dayOfSimulation
 * @property string $hourOfSimulation
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\RaportyExcelDane\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\RaportyExcelDane\Obiekt
	 */
	protected $j;
}