<?php
namespace Generic\Model\Event;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property string $nazwaSzablonu 
 * @property string $konfiguracjaSzablon 
 * @property string $nazwa 
 * @property int $idObiekt
 * @property string $obiekt
 * @property bool $wykonany
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\Event\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\Event\Obiekt
	 */
	protected $j;
	
	public function pobierzMetody($kryteriaDodatkowe = array(), $zwracaTablice = false)
	{
		if ( ! isset($this->_cache['metody']))
		{
			if($zwracaTablice)
			{
				$mapperMetody = $this->dane()->EventMetody()->zwracaTablice();
			}
			else 
			{
				$mapperMetody = $this->dane()->EventMetody();
			}
			
			$kryteria = array(
				'id_event' => $this->id,
			);
			$kryteria = array_merge($kryteria, $kryteriaDodatkowe);
			$sortert = new \Generic\Model\EventMetody\Sorter('id');
			$listaMetod = $mapperMetody->szukaj($kryteria, null, $sortert);
			$this->_cache['metody'] = (!empty($listaMetod)) ? $listaMetod : array();
			
		}
		return $this->_cache['metody'];
	}
	
	public function pobierzDateStart()
	{
		if( ! isset($this->_cache['dataStart']))
		{
			$this->_cache['dataStart'] = $this->dane()->Kalendarz()->pobierzDateStarEventu($this->id)->data; 
		}
		return $this->_cache['dataStart'];
	}
	
	public function pobierzDateStop()
	{
		if( ! isset($this->_cache['dataStop']))
		{
			$this->_cache['dataStop'] = $this->dane()->Kalendarz()->pobierzDateStopEventu($this->id)->data;
		}
		return $this->_cache['dataStop'];
	}

	public function pobierzIdTeamu()
	{
		if( ! isset($this->_cache['idTeam']))
		{
			$this->_cache['idTeam'] = $this->dane()->Kalendarz()->pobierzPojedynczyWpisEventu($this->id)->idTeam;
		}
		return $this->_cache['idTeam'];
	}
	
	public function pobierzIdUser()
	{
		if( ! isset($this->_cache['idUser']))
		{
			$this->_cache['idUser'] = $this->dane()->Kalendarz()->pobierzPojedynczyWpisEventu($this->id)->idUser;
		}
		return $this->_cache['idUser'];
	}

	public function pobierzObiektGlowny()
	{
		$obiektNazwa = $this->obiekt;
		$obiektGlowny = $this->dane()->$obiektNazwa()->pobierzPoId($this->idObiekt);
		
		return $obiektGlowny;
	}
	
	
}