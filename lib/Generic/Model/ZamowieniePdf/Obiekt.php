<?php
namespace Generic\Model\ZamowieniePdf;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property mixed $data 
 * @property string $godzina 
 * @property string $idPdf 
 * @property string $dataWygenerowania 
 * @property string $dataDostarczenia 
 * @property int $idZamowienieProjekt 
 * @property int $drugaTuraApartament
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\ZamowieniePdf\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\ZamowieniePdf\Obiekt
	 */
	protected $j;
}