<?php
namespace Generic\Model\Reports;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property string $obiekt 
 * @property string $idObiektow 
 * @property string $kategoria 
 * @property mixed $dataOd 
 * @property mixed $dataDo 
 * @property int $autor 
 * @property mixed $dataDodania 
 * @property mixed $dataModyfikacji 
 * @property bool $wyslany 
 * @property string $status
 * @property array $typyZamowien
 * @property double $nettoPrice 
 * @property double $bruttoPrice
 * @property bool $zafakturowano
 * @property bool $wyslanyDoFakturowania
  * @property string $additionalData
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\Reports\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\Reports\Obiekt
	 */
	protected $j;
	
	public function dodajDoAdditionalData($parametr, $wartosc)
	{
		if(is_array($this->additionalData) && count($this->additionalData))
			$this->additionalData = array_merge($this->additionalData, array($parametr => $wartosc));
		else
			$this->additionalData = array($parametr => $wartosc);
	}
	
}