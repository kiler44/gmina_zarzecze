<?php
namespace Generic\Model\ZamowienieTyp;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu
 * @property int $idConfigTemplate
 * @property bool $mainType 
 * @property bool $active 
 * @property bool $childOrders
 * @property datetime $dateAdded
 * @property string $name
 * @property string $possibleChargeTypes 
 * @property string $parentTypes 
 * @property string $requiredSkills
 * @property string $previewTemplate
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\ZamowienieTyp\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\ZamowienieTyp\Obiekt
	 */
	protected $j;
	
	
	private $konfiguracjaTypow;
	
	
	public function __construct($dane = array())
	{
		$plik = TEMP_KATALOG.'/OrderTypesConfigtemplates.inc.php';
		if (file_exists($plik) && is_file($plik))
		{
			$this->konfiguracjaTypow = include($plik);
		}
		else
		{
			trigger_error('Brak pliku konfiguracyjnego dla typów zamówień: "'.$plik.'"', E_USER_WARNING);
		}
		parent::__construct($dane);
	}
	
	
	public function pobierzKonfiguracjeTypu()
	{
		return $this->konfiguracjaTypow[$this->idConfigTemplate];
	}
	
	public function pobierzPelnaKonfiguracjeTypow()
	{
		return $this->konfiguracjaTypow;
	}
}