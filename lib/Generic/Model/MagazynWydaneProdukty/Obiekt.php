<?php
namespace Generic\Model\MagazynWydaneProdukty;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idZamowienia 
 * @property int $idProduktu 
 * @property int $ilosc 
 * @property int $zwrot 
 * @property bool $grupa 
 * @property mixed $produktyGrupy 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\MagazynWydaneProdukty\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\MagazynWydaneProdukty\Obiekt
	 */
	protected $j;
}