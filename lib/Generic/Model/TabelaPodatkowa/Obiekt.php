<?php
namespace Generic\Model\TabelaPodatkowa;
use Generic\Biblioteka\Cms;

use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $nrTabeli
 * @property int $rok
 * @property int $kwotaOd
 * @property int $kwotaDo
 * @property int $podatek
 * @property string $rodzaj
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\ModulTabelaPodatkowa\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\ModulTabelaPodatkowa\Obiekt
	 */
	protected $j;
	
	
	public function obliczPodatek($przychod, $nr_tabeli, $rok = '')
	{
		$cms = Cms::inst();
		
		$mapper = new Mapper();
		$wiersz_tabeli = $mapper->pobierzKwotePodatku($przychod, $nr_tabeli, $rok);
		
		if (empty($wiersz_tabeli) || $wiersz_tabeli == '')
			return 0;
		
		if ($wiersz_tabeli->rodzaj == 'kwotowy')
		{
			return $wiersz_tabeli->podatek;
		}
		else
		{
			return $przychod * ($wiersz_tabeli->podatek / 100);
		}
	}
	
	
	public function obliczWyplateNetto($przychod, $nr_tabeli, $rok = '')
	{
		return $przychod - $this->obliczPodatek($przychod, $nr_tabeli, $rok);
	}
}