<?php
namespace Generic\Model\MagazynPrzyjeteProdukty;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idMagazynPrzyja 
 * @property int $idProduktu 
 * @property int $ilosc 
 * @property mixed $stan 
 * @property string $opis 
 * @property int $idMagazynWydaneProdukty 
 * @property mixed $produktyGrupy 
 * @property int $produktZGrupy 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\MagazynPrzyjeteProdukty\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\MagazynPrzyjeteProdukty\Obiekt
	 */
	protected $j;
}